@extends('layouts.front.layout')

@section('title', __('CDL'))

@section('content')
    <section id="subheader" class="bg-color-op-1">
        <div class="container relative z-2">
            <div class="row gy-4 gx-5 align-items-center">
                <div class="col-lg-12">
                    <h1 class="split">{{ __('CDL description') }} {{ optional($exercice)->year }}</h1>
                    <ul class="crumb wow fadeInUp">
                        <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                        <li class="active">{{ __('CDL') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row g-4">
              @forelse ($exerciceTeam as $team)
                <div class="col-lg-4">
                    <div class="relative">
                        <img src="{{ asset('storage/' . $team->member->photo) }}" class="w-100 relative z-2" alt="{{ $team->member->full_name }}">
                        <div class="abs w-100 h-80 bottom-0 bg-color-op-3 rounded-1"></div>
                    </div>
                    <div class="p-3 text-center">
                        <h4 class="mb-0">{{ $team->member->full_name }}</h4>
                        <p class="mb-2">{{ $team->role->name }}</p>
                        <div class="social-icons">
                            <a href="https://wa.me/{{ $team->member->phone }}" target="_blank"><i
                                    class="bg-white id-color bg-hover-2 text-hover-white fa-brands fa-whatsapp"></i></a>
                        </div>
                    </div>
                </div>
              @empty
              @endforelse
            </div>
        </div>
    </section>
@endsection
