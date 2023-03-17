/**
 * Library to communicate with client-portal iframe trough window.postMessage events
 */
(() => {
    /**
     * Library to load/save data to local storage from child client portal iframe
     *
     * MOTIVATION:
     * Google Chrome and other popular browsers blocked cookies, local storage, session storage in private mode for
     * third-party sites (cross-site). If iframe rendered with different host the browsers decided that is
     * third-party resource and blocked usage any persistent storages.
     * Link: https://blog.chromium.org/2019/10/developers-get-ready-for-new.html
     *
     * This library listen events from child iframe on parent original window and load or store data from local storage
     * on real original window, so in such case we avoid blocking storages in private mode in iframe for third-party sites
     *
     * USAGE:
     * Include
     * <script src="https://client-portal.domain/js/parent-iframe-window.js"></script>
     * to your page with client-portal iframe.
     *
     * And add id 'client-portal-iframe' to
     * <iframe id="client-portal-iframe" src="https://client-portal.domain"></iframe>
     */
    const iframeParentWindowStorage = (iframe) => {
        const STORAGE_KEY = '@storage';

        // Waiting for post message events
        window.addEventListener('message', (e) => {
            // Skip events if data inside isn't an object
            if (typeof e.data !== 'object') {
            return;
            }

            switch (e.data.cmd) {
                // Listen request to load state from local storage
                case 'client-portal:storage:load': {
                    const value = window.localStorage.getItem(STORAGE_KEY);
                    // Send response to child iframe with loaded state
                    iframe.contentWindow.postMessage({
                    cmd: 'client-portal:storage:loaded',
                    value,
                    }, '*');

                    break;
                }

                // Listen request to save state to local storage
                case 'client-portal:storage:save': {
                    const { value } = e.data;
                    window.localStorage.setItem(STORAGE_KEY, value);

                    break;
                }

            default:
                break;
            }
        });

      // Waiting for local storage events
      window.addEventListener('storage', (e) => {
        if (e.key === STORAGE_KEY) {
          const { newValue, oldValue } = e;

          // Send response to child iframe with updated state
          iframe.contentWindow.postMessage({
            cmd: 'client-portal:storage:updated',
            oldValue,
            newValue,
          }, '*');
        }
      });
    };

    /**
     * Library to control navigation outside of iframe from original parent window
     *
     * MOTIVATION:
     * Application who serve client-portal in iframe should have ability to change navigation outside of iframe
     * also original parent window should know about navigation changes inside the iframe to save navigation state on
     * own level to open right client-portal link on page reload, etc...
     *
     * SIMPLE DESCRIPTION:
     *  1. Original parent window set 'iframe.src' from own 'location.hash' only first time on window load to open
     *     right iframe page.
     *
     *  2. Original parent window listen own `window.onpopstate` (browser back button, manual hash changing, dom links)
     *     to notify about changes to iframe only if iframe has different location.
     *
     *  3. Original parent window listen post messages from iframe about inside navigation changes and save location
     *     to own `location.hash`.
     *
     * @param iframe DOM element
     * @param iframeUrl Base iframe domain without path
     * @param currentLocation Current window location
     */
    const iframeNavigation = (iframe, iframeUrl, currentLocation) => {
      let iframeLocation = currentLocation;
      let windowLocation = currentLocation;
      let external = false;



      // Listen original parent window history changes
      window.addEventListener('hashchange', () => {
        windowLocation = document.location.hash.replace('#', '');

        // If an iframe location was changed to external url --> do re-init iframe with current window location
        // To make external navigation works correctly
        if (external) {
          iframe.setAttribute('src', iframeUrl + windowLocation);

          external = false;
        }

        // Notify iframe about new location only if iframe has different location to prevent location change loop
        if (iframeLocation !== windowLocation) {
          iframe.contentWindow.postMessage({
            cmd: 'client-portal:navigation:replace',
            to: windowLocation,
          }, '*');
        }

      });

      // Waiting for post message events
      window.addEventListener('message', (e) => {
        // Skip events if data inside isn't an object
        if (typeof e.data !== 'object') {
          return;
        }

        switch (e.data.cmd) {
          // Listen event about inside iframe location changing and save it to original parent window navigation
          case 'client-portal:navigation:updated': {
            const { value } = e.data;

            iframeLocation = value;

            // Change original history only if window has different location to prevent location change loop
            if (iframeLocation !== windowLocation) {
              window.history.replaceState(null, null, `#${iframeLocation}`);
              window.dispatchEvent(new window.HashChangeEvent('hashchange'));
            }

            break;
          }

          // Listen when opened another url inside iframe to hard reload the page when hash changed
          case 'client-portal:navigation:external': {
            external = true;

            // Scroll to top while client go to external resource
            window.scrollTo(0, 0);

            break;
          }

          // Listen when client portal iframe initiated and can accept internal navigation
          case 'client-portal:navigation:internal': {
            external = false;

            break;
          }

          case 'client-portal:navigation:scrollTop': {
            window.scrollTo(0, 0);

            break;
          }

          default:
            break;
        }
      });
    };

    /**
     * Init iframe resizer automatically
     *
     * @param iframe iFrame DOM element
     * @param iframeUrl Root URL of iframe
     */
    const iframeResizer = (iframe, iframeUrl) => {
      const script = document.createElement('script');

      script.src = `${iframeUrl}/js/iframe-resizer.js`;

      // change heightCalculation method of CP Select component in cWU and handleClose method
      // if you are going to change it from this config
      script.onload = () => window.iFrameResize({
        checkOrigin: false,
        heightCalculationMethod: 'lowestElement',
        scrolling: 'omit',
        onInit: () => window.scroll(0, 0),
        // We need add 1px to iframe to prevent scrolling inside with iframe.scrolling=auto
        onResized: ({ height }) => {
          iframe.style.height = `${Number(height) + 1}px`;
        },
      }, iframe);

      document.head.appendChild(script);
    };

    // Check if parent window opened as iframe then redirect original window to current location inside iframe
    if (window.self !== window.top) {
      window.self.document.body.style.opacity = 0;
      window.top.location.replace(document.location.href);
      window.top.location.reload();
    }

    // Waiting while original window content loaded
    window.addEventListener('load', () => {

        // Get root element and data attributes to render iframe inside
        const root = document.getElementById('client-portal-iframe');
        const iframeUrl = root.getAttribute('data-url').replace(/\/$/, '');
        const currentLocation = document.location.hash.replace('#', '');


        // Create iframe DOM element inside root element
        const iframe = document.createElement('iframe');


        iframe.setAttribute('src', iframeUrl + currentLocation);
        iframe.setAttribute('frameBorder', '0');
        iframe.setAttribute('width', '100%');
        iframe.setAttribute('sandbox', 'allow-same-origin allow-top-navigation allow-scripts allow-forms');

        root.appendChild(iframe);

        // Init iframe logic
        iframeParentWindowStorage(iframe);
        iframeNavigation(iframe, iframeUrl, currentLocation);
        iframeResizer(iframe, iframeUrl);
    });

  })();
