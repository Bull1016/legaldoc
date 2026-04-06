@extends('layouts/layoutMaster')

@section('title', 'Organisations')

<!-- Vendor Styles -->
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/flatpickr/flatpickr.scss', 'resources/assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss'])
    @vite(['resources/assets/vendor/libs/animate-css/animate.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/flatpickr/flatpickr.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js'])
    @vite(['resources/assets/vendor/libs/sweetalert2/sweetalert2.js'])
@endsection

<!-- Page Scripts -->
@section('page-script')
    <script>
        window.routes = {
            organisationsData: "{{ route('organisations.data') }}",
            organisationsCount: "{{ route('organisations.count') }}"
        };

        window.translations = {
            org_delete_title: "{{ __('Organisation delete title') }}",
            org_delete_text: "{{ __('Organisation delete text') }}",
        };
    </script>
    @vite(['resources/assets/js/organisation/index.js'])
    @vite(['resources/assets/js/extended-ui-sweetalert2.js'])
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <h3 class="fs-22 font-weight-semi-bold">{{ __('Organisations') }}</h3>
                @can('organisations.create')
                    <a href="{{ route('organisations.create') }}" class="btn btn-primary" id="add-btn">
                        @include('components.add-btn')
                    </a>
                @endcan
            </div>
        </div>
        <div class="card-datatable text-nowrap px-5">
            <table class="datatables-basic table text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>
                            {{ __('Organisation Pic') }} <br>
                            <hr>
                            <small class="text-muted">{{ __('Organisation name') }}</small>
                        </th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>{{ __('Organisation contacts') }}</th>
                        <th>{{ __('Created at') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
