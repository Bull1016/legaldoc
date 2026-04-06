@extends('layouts.front.layout')

@section('title', __('Pasts President'))

@section('content')
    <section id="subheader" class="bg-color-op-1">
        <div class="container relative z-2">
            <div class="row gy-4 gx-5 align-items-center">
                <div class="col-lg-12">
                    <h1 class="split">{{ __('Pasts President') }}</h1>
                    <ul class="crumb wow fadeInUp">
                        <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                        <li class="active">{{ __('Pasts President') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>


    <section class="bg-color-op-1 relative">
        <div class="owl-custom-nav menu-float" data-target="#carousel-1">
            <a class="btn-next"></a>
            <a class="btn-prev"></a>
            <div id="carousel-1" class="owl-2-cols-center owl-carousel owl-theme">
              @forelse ($pastPresidents as $pp)
                <div class="item">
                    <a href="{{ route('cdl') }}">
                        <div class="hover rounded-1 relative overflow-hidden text-light">
                            <div class="abs p-40 bottom-0 z-3">
                                <h3>{{ $pp->member->full_name }}</h3>
                                <p class="mb-0 hover-mh-60">{{ $pp->exercice->year }}</p>
                            </div>
                            <div class="hover-op-05 bg-dark abs w-100 h-100 top-0 start-0 z-2"></div>
                            <img src="{{ asset('storage/' . $pp->member->photo) }}" class="w-100 hover-scale-1-2" alt="{{ $pp->member->full_name }}">
                            <div class="gradient-edge-bottom color h-50"></div>
                        </div>
                    </a>
                </div>
              @empty
              @endforelse
            </div>
        </div>
    </section>
@endsection
