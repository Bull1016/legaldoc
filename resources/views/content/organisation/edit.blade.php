@extends('layouts/layoutMaster')

@section('title', __('Organisation Edit'))

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/quill/typography.scss', 'resources/assets/vendor/libs/quill/katex.scss', 'resources/assets/vendor/libs/quill/editor.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/dropzone/dropzone.scss', 'resources/assets/vendor/libs/flatpickr/flatpickr.scss', 'resources/assets/vendor/libs/tagify/tagify.scss'])
    @vite(['resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss', 'resources/assets/vendor/libs/typeahead-js/typeahead.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss'])
    @vite(['resources/assets/vendor/libs/leaflet/leaflet.scss'])
    @vite(['resources/assets/vendor/libs/highlight/highlight.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/quill/katex.js', 'resources/assets/vendor/libs/quill/quill.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/dropzone/dropzone.js', 'resources/assets/vendor/libs/jquery-repeater/jquery-repeater.js', 'resources/assets/vendor/libs/flatpickr/flatpickr.js', 'resources/assets/vendor/libs/tagify/tagify.js'])
    @vite(['resources/assets/vendor/libs/bootstrap-select/bootstrap-select.js', 'resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/typeahead-js/typeahead.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js'])
    @vite(['resources/assets/vendor/libs/leaflet/leaflet.js'])
    @vite(['resources/assets/vendor/libs/highlight/highlight.js'])
@endsection

@section('page-script')
    <script>
        window.routes = {
            organisationsIndex: "{{ route('organisations.index') }}",
            organisationsStore: "{{ route('organisations.store') }}",
            organisationsUpdate: "{{ route('organisations.update', ['organisation' => ':id']) }}"
        };

        window.translations = {
            org_name_required: "{{ __('Organisation name is required') }}",
            org_email_required: "{{ __('Organisation email is required') }}",
            org_email_invalid: "{{ __('Organisation email is invalid') }}",
            org_phone_required: "{{ __('Organisation phone is required') }}",
            org_phone_invalid: "{{ __('Organisation phone is invalid') }}",
            org_region_required: "{{ __('Organisation region is required') }}",
            org_state_required: "{{ __('Organisation state is required') }}",
            org_pic_required: "{{ __('Organisation picture is required') }}",
            org_pic_invalid: "{{ __('Please select a valid image (JPG, PNG, GIF, WEBP, max 2MB)') }}",
            org_description_required: "{{ __('Organisation description is required') }}",
            org_whatsapp_required: "{{ __('Organisation whatsapp is required') }}",
            org_description: "{{ __('Organisation description') }}",
            no_results: "{{ __('No results') }}",
            success_create: "{{ __('Organisation created successfully') }}",
            error_map: "{{ __('Error has occured while trying to get the adresse. Retry Later !') }}",
            retriving_map: "{{ __('We are retriving this adresse') }}",
            submitting: "{{ __('Submitting...') }}"
        };
    </script>
    @vite(['resources/assets/js/organisation/form.js'])
    @vite(['resources/assets/js/map-modal.js'])
    @vite(['resources/assets/js/form-validation.js'])
@endsection


@section('content')
    <div
        class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 row-gap-4">
        <div class="d-flex flex-column justify-content-center">
            <h4 class="mb-1">{{ __('Organisation Edit') }}</h4>
            <p class="mb-0">
                {!! __('Fields with :asterix are required', ['asterix' => showAsterix('*')]) !!}
            </p>
        </div>
    </div>

    <form id="organisationForm" class="needs-validation" enctype="multipart/form-data" novalidate>
        @include('content.organisation.partials.form')

        <hr>

        <div class="row">
            <div class="row col-12 text-center">
                <div class="col-md-4 mb-6">
                    <button id="submitBtn" type="button" class="btn btn-primary">
                        <i class="menu-icon icon-base ti tabler-send"></i> {{ __('Submit') }}
                    </button>
                </div>
                <div class="col-md-4 mb-6">
                    <button id="resetBtn" type="reset" class="btn btn-label-warning">
                        <i class="menu-icon icon-base ti tabler-refresh"></i> {{ __('Reset') }}
                    </button>
                </div>
                <div class="col-md-4 mb-6">
                    <button id="cancelBtn" type="button" class="btn btn-label-danger">
                        <i class="menu-icon icon-base ti tabler-x"></i> {{ __('Cancel') }}
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection
