@extends('layouts.app-master')
@section('content')

    <div data-elementor-type="wp-page" data-elementor-id="3476" class="elementor elementor-3476" data-elementor-settings="[]">
        <div class="elementor-inner">
            <div class="elementor-section-wrap">
                <section class="elementor-element elementor-element-2a0fd77 elementor-section-stretched elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section" data-id="2a0fd77" data-element_type="section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;,&quot;stretch_section&quot;:&quot;section-stretched&quot;}">
                    <div class="elementor-container elementor-column-gap-default">
                        <div class="elementor-row">
                            <div class="elementor-element elementor-element-73e02d6 elementor-column elementor-col-100 elementor-top-column" data-id="73e02d6" data-element_type="column" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                                <div class="elementor-column-wrap  elementor-element-populated">
                                    <div class="elementor-widget-wrap">
                                        <div class="elementor-element elementor-element-81680a7 elementor-widget elementor-widget-restly_title" data-id="81680a7" data-element_type="widget" data-widget_type="restly_title.default">
                                            <div class="elementor-widget-container">
                                                <div class="restly-section-title-wrapper">
                                                    <div class="restly-section-title">
                                                        <h2 class="restly-section-title">Sign in</h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="elementor-element elementor-element-51444b60 elementor-button-align-center elementor-widget elementor-widget-form" data-id="51444b60" data-element_type="widget" data-settings="{&quot;step_next_label&quot;:&quot;Next&quot;,&quot;step_previous_label&quot;:&quot;Previous&quot;,&quot;button_width&quot;:&quot;100&quot;,&quot;step_type&quot;:&quot;number_text&quot;,&quot;step_icon_shape&quot;:&quot;circle&quot;}" data-widget_type="form.default">
                                            <div class="elementor-widget-container">

                                                @if (session('status'))
                                                    <div class="alert alert-success">
                                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                            <strong>{{ session('status') }}</strong>
                                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                        </div>
                                                    </div>
                                                @endif

                                                <form method="POST" action="{{ route('users.index') }}">
                                                    @csrf

                                                    <x-jet-label value="{{ __('email') }}" />
                                                    <x-jet-input class="block mt-1 w-full" type="text" name="contacts__email" :value="old('contacts__email')"  autofocus autocomplete="contacts__email" placeholder="email" />
                                                    @if ($errors->has('contacts__email'))
                                                        <span class="text-danger">{{ $errors->first('contacts__email') }}</span>
                                                    @endif

                                                    <x-jet-label value="{{ __('password') }}" />
                                                    <x-jet-input class="block mt-1 w-full" type="password" name="password" :value="old('password')"  autofocus autocomplete="password" placeholder="password" />
                                                    @if ($errors->has('password'))
                                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                                    @endif

                                                    <br>
                                                        <x-jet-button class="ml-4 btn btn-dark">
                                                            {{ __('Login') }}
                                                        </x-jet-button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="elementor-element elementor-element-7826909d elementor-widget elementor-widget-text-editor" data-id="7826909d" data-element_type="widget" data-widget_type="text-editor.default">
                                            <div class="elementor-widget-container">
                                                <div class="elementor-text-editor elementor-clearfix"><p style="font-size: 1.35em; text-align: center; color: #fff;">Don’t have an account yet?
                                                    <a style="color: #6AC3FF;" href="{{ route('register') }}">Register</a></p></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

@endsection


