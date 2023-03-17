
@extends('layouts.app-master')
@section('content')

    <link rel='stylesheet' id='elementor-post-3480-css' href='https://importcapital.cc/media/elementor/css/post-3480.css?ver=1655282398' media='all' />

    <div class="container ">
        <div class="page-layout">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="all-posts-wrapper">
                    <div class="restly-page-content">
                        <article id="post-3480" class="post-3480 page type-page status-publish hentry">
                            <div class="entry-content">
                                <div data-elementor-type="wp-page" data-elementor-id="3480" class="elementor elementor-3480" data-elementor-settings="[]">
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
                                                                                    <h2 class="restly-section-title">Registration</h2>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="elementor-element elementor-element-62551d87 elementor-button-align-center elementor-widget elementor-widget-form" data-id="62551d87" data-element_type="widget" data-settings="{&quot;step_next_label&quot;:&quot;Next&quot;,&quot;step_previous_label&quot;:&quot;Previous&quot;,&quot;button_width&quot;:&quot;100&quot;,&quot;step_type&quot;:&quot;number_text&quot;,&quot;step_icon_shape&quot;:&quot;circle&quot;}" data-widget_type="form.default">
                                                                        <div class="elementor-widget-container">

                                                                            @if (session('status'))
                                                                                <div class="alert alert-success">
                                                                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                                                        <strong>{{ session('status') }}</strong>
                                                                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                                                    </div>
                                                                                </div>
                                                                            @endif


                                                                            <form method="POST" action="{{ route('users.store') }}">
                                                                                @csrf

                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="mb-3">
                                                                                            <x-jet-label value="{{ __('first name') }}" />
                                                                                            <x-jet-input class="block mt-1 w-full" type="text" name="firstname" :value="old('firstname')"  autofocus autocomplete="firstname" placeholder="first name" />
                                                                                            @if ($errors->has('firstname'))
                                                                                                <span class="text-danger">{{ $errors->first('firstname') }}</span>
                                                                                            @endif
                                                                                        </div>
                                                                                        <div class="mb-3">
                                                                                            <x-jet-label value="{{ __('email') }}" />
                                                                                            <x-jet-input class="block mt-1 w-full" type="text" name="contacts__email" :value="old('contacts__email')"  autofocus autocomplete="contacts__email" placeholder="email" />
                                                                                            @if ($errors->has('contacts__email'))
                                                                                                <span class="text-danger">{{ $errors->first('contacts__email') }}</span>
                                                                                            @endif
                                                                                        </div>
                                                                                        <div class="mb-3">
                                                                                            <x-jet-label value="{{ __('country') }}" />
                                                                                            <x-jet-input class="block mt-1 w-full" type="text" name="address__countryCode" :value="old('address__countryCode')"  autofocus autocomplete="address__countryCode" placeholder="country" />
                                                                                            @if ($errors->has('address__countryCode'))
                                                                                                <span class="text-danger">{{ $errors->first('address__countryCode') }}</span>
                                                                                            @endif
                                                                                        </div>
                                                                                        <div class="mb-3">
                                                                                            <x-jet-label value="{{ __('confirm password') }}" />
                                                                                            <x-jet-input class="block mt-1 w-full" type="password" name="cpassword" :value="old('cpassword')"  autofocus autocomplete="cpassword" placeholder="confirm password" />
                                                                                            @if ($errors->has('cpassword'))
                                                                                                <span class="text-danger">{{ $errors->first('cpassword') }}</span>
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="mb-3">
                                                                                            <x-jet-label value="{{ __('lastName') }}" />
                                                                                            <x-jet-input class="block mt-1 w-full" type="text" name="lastName" :value="old('lastName')"  autofocus autocomplete="lastName" placeholder="last Name" />
                                                                                            @if ($errors->has('lastName'))
                                                                                                <span class="text-danger">{{ $errors->first('lastName') }}</span>
                                                                                            @endif
                                                                                        </div>
                                                                                        <div class="mb-3">
                                                                                            <x-jet-label value="{{ __('phone') }}" />
                                                                                            <x-jet-input class="block mt-1 w-full" type="text" name="contacts__phone" :value="old('contacts__phone')"  autofocus autocomplete="contacts__phone" placeholder="phone ex: +144..." />
                                                                                            @if ($errors->has('contacts__phone'))
                                                                                                <span class="text-danger">{{ $errors->first('contacts__phone') }}</span>
                                                                                            @endif
                                                                                        </div>
                                                                                        <div class="mb-3">
                                                                                            <x-jet-label value="{{ __('password') }}" />
                                                                                            <x-jet-input class="block mt-1 w-full" type="password" name="password" :value="old('password')"  autofocus autocomplete="password" placeholder="password" />
                                                                                            @if ($errors->has('password'))
                                                                                                <span class="text-danger">{{ $errors->first('password') }}</span>
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                </div>



                                                                                    <x-jet-button class="ml-4 btn btn-dark">
                                                                                        {{ __('Register') }}
                                                                                    </x-jet-button>
                                                                                </div>
                                                                            </form>




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
                            </div><!-- .entry-content -->
                        </article><!-- #post-3480 -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
