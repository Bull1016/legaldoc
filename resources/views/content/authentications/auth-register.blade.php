@php
    $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Register')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/@form-validation/form-validation.scss'])
@endsection

@section('page-style')
    @vite(['resources/assets/vendor/scss/pages/page-auth.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js'])
@endsection

@section('page-script')
    @vite(['resources/assets/js/pages-auth.js'])
@endsection

@section('content')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-6">
                <!-- Register Card -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-6">
                            <a href="{{ url('/') }}" class="app-brand-link">
                                <span class="app-brand-logo demo">@include('_partials.macros')</span>
                                <span
                                    class="app-brand-text demo text-heading fw-bold">{{ config('variables.templateName') }}</span>
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-1">Adventure starts here 🚀</h4>

                        <form id="formAuthentication" class="mb-6" action="{{ route('register.store') }}" method="POST">
                            @csrf
                            <div class="mb-5 form-control-validation">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name"
                                    placeholder="Enter your first name" autofocus required />
                            </div>

                            <div class="mb-5 form-control-validation">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name"
                                    placeholder="Enter your last name" required />
                            </div>

                            <div class="mb-5 form-control-validation">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" name="email"
                                    placeholder="Enter your email" required />
                            </div>

                            <div class="mb-5 form-control-validation">
                                <label for="telephone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="telephone" name="telephone"
                                    placeholder="Enter your phone number" />
                            </div>

                            <div class="mb-5 form-control-validation">
                                <label for="adresse" class="form-label">Address</label>
                                <input type="text" class="form-control" id="adresse" name="adresse"
                                    placeholder="Enter your address" />
                            </div>

                            <div class="mb-5 form-password-toggle form-control-validation">
                                <label class="form-label" for="password">Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" required />
                                    <span class="input-group-text cursor-pointer"><i
                                            class="icon-base ti tabler-eye-off"></i></span>
                                </div>
                            </div>

                            <div class="mb-5 form-password-toggle form-control-validation">
                                <label class="form-label" for="confirm-password">Confirm Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="confirm-password" class="form-control"
                                        name="confirm-password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="confirm-password" required />
                                    <span class="input-group-text cursor-pointer"><i
                                            class="icon-base ti tabler-eye-off"></i></span>
                                </div>
                            </div>

                            <div class="my-8 form-control-validation">
                                <div class="form-check mb-0 ms-2">
                                    <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms" />
                                    <label class="form-check-label" for="terms-conditions">
                                        I agree to
                                        <a href="javascript:void(0);">privacy policy & terms</a>
                                    </label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary d-grid w-100">Sign up</button>
                        </form>

                        <p class="text-center">
                            <span>Already have an account?</span>
                            <a href="{{ route('login') }}">
                                <span>Sign in instead</span>
                            </a>
                        </p>

                        <div class="divider my-6">
                            <div class="divider-text">or</div>
                        </div>

                        <div class="d-flex justify-content-center">
                            <a href="javascript:;" class="btn btn-icon rounded-circle btn-text-facebook me-1_5">
                                <i class="icon-base ti tabler-brand-facebook-filled icon-20px"></i>
                            </a>

                            <a href="javascript:;" class="btn btn-icon rounded-circle btn-text-twitter me-1_5">
                                <i class="icon-base ti tabler-brand-twitter-filled icon-20px"></i>
                            </a>

                            <a href="javascript:;" class="btn btn-icon rounded-circle btn-text-github me-1_5">
                                <i class="icon-base ti tabler-brand-github-filled icon-20px"></i>
                            </a>

                            <a href="javascript:;" class="btn btn-icon rounded-circle btn-text-google-plus">
                                <i class="icon-base ti tabler-brand-google-filled icon-20px"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Register Card -->
            </div>
        </div>
    </div>
@endsection
