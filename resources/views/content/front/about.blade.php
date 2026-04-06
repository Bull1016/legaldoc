@extends('layouts.front.layout')

@section('title', __('About'))

@section('content')
    <section id="subheader" class="bg-color-op-1">
        <div class="container relative z-2">
            <div class="row gy-4 gx-5 align-items-center">
                <div class="col-lg-12">
                    <h1 class="split">{{ __('About') }}</h1>
                    <ul class="crumb wow fadeInUp">
                        <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                        <li class="active">{{ __('About') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-lg-6">
                    <div class="ps-lg-3">
                        <h2 class="split">{{ __('History of :organisation', ['organisation' => optional($organisation)->nameOr]) }}</h2>
                        <p class="mb-0 wow fadeInUp" data-wow-delay=".6s">
                            {{ __('The History of :organisation', ['organisation' => optional($organisation)->nameOr]) }}
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="ps-lg-3">
                        <h2 class="split">{{ __('History of :organisation', ['organisation' => optional($organisation)->nameOr]) }}</h2>
                        <p class="mb-0 wow fadeInUp" data-wow-delay=".6s">
                            {{ __('The History of :organisation', ['organisation' => optional($organisation)->nameOr]) }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="spacer-double"></div>
            <div class="spacer-double"></div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="bg-color-op-1 rounded-1">
                        <div class="p-30 bg-color-op-2 text-center">
                            <h4 class="mb-0 lh-1 fs-40">
                                {{ __('Creed') }}
                            </h4>
                        </div>
                        <div class="p-30">
                            <ul class="ul-check">
                                <p>{{ __('We believe') }} : </p>
                                <li>{{ __('Faith in God gives life its true meaning') }},</li>
                                <li>{{ __('Human fraternity transcends the sovereignty of nations') }},</li>
                                <li>{{ __('Individual freedom and enterprise ensure better economic justice') }},</li>
                                <li>{{ __('Authority must rely on the law and not on arbitrariness') }},</li>
                                <li>{{ __('Humanity is the most precious of riches') }},</li>
                                <li>{{ __('Serving humanity constitutes the noblest work of a life') }}.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="bg-color-op-1 rounded-1">
                        <div class="p-30 bg-color-op-2 text-center">
                            <h4 class="mb-0 lh-1 fs-40">
                                {{ __('Our vision') }}
                            </h4>
                        </div>
                        <div class="p-30">
                            <p>
                                {{ __('The vision of the :organisation is to be the principal global network of young leaders', ['organisation' => optional($organisation)->nameOr]) }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="bg-color-op-1 rounded-1">
                        <div class="p-30 bg-color-op-2 text-center">
                            <h4 class="mb-0 lh-1 fs-40">
                                {{ __('Our mission') }}
                            </h4>
                        </div>
                        <div class="p-30">
                            <p>{{ __('Provide leadership development opportunities for young people by empowering them to create positive change') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
