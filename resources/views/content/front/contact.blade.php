@extends('layouts.front.layout')

@section('title', __('Contact Us'))

@section('content')
    <section id="subheader" class="bg-color-op-1">
        <div class="container relative z-2">
            <div class="row gy-4 gx-5 align-items-center">
                <div class="col-lg-12">
                    <h1 class="split">{{ __('Contact Us') }}</h1>
                    <ul class="crumb wow fadeInUp">
                        <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                        <li class="active">{{ __('Contact Us') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">

            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <img src="{{ asset('storage/' . optional($organisation)->picOr) }}" class="logo-footer"
                                alt="logo" style="width: 100px;">
                        </div>

                        <div class="col-md-6">
                            <h4 class="mb-0">{{ optional($organisation)->stateOr }}</h4>
                            {{ optional($organisation)->numberOr }}<br>
                            {{ optional($organisation)->emailOr }}<br>
                        </div>
                    </div>

                </div>

                <div class="col-lg-6">
                    <div class="relative">
                        <form name="contactForm" id="contact_form" method="post" action="{{ route('contact') }}">
                            @csrf
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="field-set">
                                        <input type="text" name="name" id="name" class="form-control mb-4"
                                            placeholder="Your Name" required>
                                    </div>
                                    <div class="field-set">
                                        <input type="text" name="email" id="email" class="form-control mb-4"
                                            placeholder="Your Email" required>
                                    </div>
                                    <div class="field-set">
                                        <input type="text" name="phone" id="phone" class="form-control mb-4"
                                            placeholder="Your Phone" required>
                                    </div>
                                    <div class="field-set">
                                        <textarea name="message" id="message" class="form-control mb-4 h-100px" placeholder="Your Message" required></textarea>
                                    </div>
                                </div>
                            </div>

                            <div id='submit'>
                                <input type='submit' id='send_message' value='Send Message' class="btn-main w-100">
                            </div>

                            <div id="success_message" class='success'>
                                Your message has been sent successfully. Refresh this page if you want to send more
                                messages.
                            </div>
                            <div id="error_message" class='error'>
                                Sorry there was an error sending your form.
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
