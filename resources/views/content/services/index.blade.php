@extends('layouts/layoutMaster')

@section('title', __('Services'))

<!-- Vendor Styles -->
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/flatpickr/flatpickr.scss', 'resources/assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss'])
    @vite(['resources/assets/vendor/libs/animate-css/animate.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'])
    @vite(['resources/assets/vendor/libs/leaflet/leaflet.scss'])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/flatpickr/flatpickr.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js'])
    @vite(['resources/assets/vendor/libs/sweetalert2/sweetalert2.js'])
    @vite(['resources/assets/vendor/libs/leaflet/leaflet.js'])
@endsection

<!-- Page Scripts -->
@section('page-script')
    <script>
        window.routes = {
            data: "{{ route('services.data') }}",
            destroy: "{{ route('services.destroy', ['service' => ':id']) }}",
        }
        window.translations = {
            add_new_service: "{{ __('Add New Service') }}",
            edit_service: "{{ __('Edit Service') }}",
            error_occurred: "{{ __('An error occurred') }}",
            submitting: "{{ __('Submitting...') }}",
            service_delete_title: "{{ __('Service delete title') }}",
            service_delete_text: "{{ __('Service delete text') }}",
        }
    </script>
    @vite(['resources/assets/js/services/index.js'])
    @vite(['resources/assets/js/extended-ui-sweetalert2.js'])
@endsection

@section('content')
    <!-- DataTable with Buttons -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ __('Service List') }}</h5>
            @can('services.create')
                <button type="button" class="btn btn-primary create-new">
                    <i class="menu-icon icon-base ti tabler-library-plus"></i> {{ __('Add New Service') }}
                </button>
            @endcan
        </div>
        <div class="card-datatable table-responsive pt-0">
            <table class="datatables-basic table">
                <thead>
                    <tr>
                        <th style="padding-bottom: 40px">#</th>
                        <th style="padding-bottom: 40px">{{ __('Service Name') }}</th>
                        <th style="padding-bottom: 40px">{{ __('Created at') }}</th>
                        <th style="padding-bottom: 40px">{{ __('Actions') }}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
