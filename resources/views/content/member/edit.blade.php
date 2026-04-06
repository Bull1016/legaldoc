@extends('layouts/layoutMaster')

@section('title', __('Member Edit'))

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
            membersIndex: "{{ route('members.index') }}",
            membersStore: "{{ route('members.store') }}",
            membersUpdate: "{{ route('members.update', ['member' => ':id']) }}"
        };

        window.translations = {
            member_name_required: "{{ __('Member name is required') }}",
            member_email_required: "{{ __('Member email is required') }}",
            member_email_invalid: "{{ __('Member email is invalid') }}",
            member_phone_required: "{{ __('Member phone is required') }}",
            member_phone_invalid: "{{ __('Member phone is invalid') }}",
            member_job_required: "{{ __('Member job is required') }}",
            member_birth_required: "{{ __('Member birth is required') }}",
            member_sex_required: "{{ __('Member sex is required') }}",
            member_photo_required: "{{ __('Member photo is required') }}",
            member_photo_invalid: "{{ __('Member photo is invalid') }}",
            success_create: "{{ __('Member created successfully') }}",
            submitting: "{{ __('Submitting...') }}",
            member_delete_title: "{{ __('Member delete title') }}",
            member_delete_text: "{{ __('Member delete text') }}"
        };
    </script>
    @vite(['resources/assets/js/member/form.js'])
    @vite(['resources/assets/js/form-validation.js'])
@endsection


@section('content')
    <div
        class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 row-gap-4">
        <div class="d-flex flex-column justify-content-center">
            <h4 class="mb-1">{{ __('Member Edit') }}</h4>
            <p class="mb-0">
                {!! __('Fields with :asterix are required', ['asterix' => showAsterix('*')]) !!}
            </p>
        </div>
    </div>

    <form id="memberForm" class="needs-validation" enctype="multipart/form-data" novalidate>
        @include('content.member.partials.form')

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
