@extends('layouts/layoutMaster')

@section('title', __('Areas & Region'))

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
            data: "{{ route('countries.data') }}",
            store: "{{ route('areas-region.store') }}",
            update: "{{ route('areas-region.update', ['areas_region' => ':id']) }}",
            destroy: "{{ route('areas-region.destroy', ['areas_region' => ':id']) }}",
            store_region: "{{ route('towns.store', ['area' => ':area']) }}",
            update_region: "{{ route('towns.update', ['area' => ':area', 'region' => ':region']) }}",
            destroy_region: "{{ route('towns.destroy', ['area' => ':area', 'region' => ':region']) }}",
        }
        window.translations = {
            area_name_required: "{{ __('Area name is required') }}",
            add_new_area: "{{ __('Add New Area') }}",
            edit_area: "{{ __('Edit Area') }}",
            error_occurred: "{{ __('An error occurred') }}",
            submitting: "{{ __('Submitting...') }}",
            area_delete_title: "{{ __('Area delete title') }}",
            area_delete_text: "{{ __('Area delete text') }}",
            manage_regions: "{{ __('Manage Regions') }}",
            add_new_region: "{{ __('Add New Region') }}",
            region_name_required: "{{ __('Region name is required') }}",
            edit_region: "{{ __('Edit Region') }}",
            region_delete_title: "{{ __('Region delete title') }}",
            region_delete_text: "{{ __('Region delete text') }}",
        }
    </script>
    @vite(['resources/assets/js/country/index.js'])
    @vite(['resources/assets/js/town/index.js'])
    @vite(['resources/assets/js/extended-ui-sweetalert2.js'])
@endsection

@section('content')
    <!-- DataTable with Buttons -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ __('Area List') }}</h5>
            @can('areas-region.create')
                <button type="button" class="btn btn-primary create-new">
                    <i class="menu-icon icon-base ti tabler-map-plus"></i> {{ __('Add New Area') }}
                </button>
            @endcan
        </div>
        <div class="card-datatable table-responsive pt-0">
            <table class="datatables-basic table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('Area Name') }}</th>
                        <th>{{ __('Number of regions') }}</th>
                        <th>{{ __('Created at') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Modal to add new record -->
    <div class="offcanvas offcanvas-end" id="add-new-record">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="exampleModalLabel"></h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body flex-grow-1">
            <form class="add-new-record pt-0 row g-2" id="areaForm">
                @csrf
                <input type="hidden" id="area_id" name="area_id" value="{{ old('area_id', $area->string_id ?? 0) }}">
                <div class="col-sm-12 mb-6">
                    <label class="form-label" for="nameCountry">{!! showAsterix('nameCountry') !!} {{ __('Area Name') }}</label>
                    <input type="text" id="nameCountry" class="form-control dt-area-name" name="nameCountry"
                        placeholder="{{ __('Area Name') }}" aria-label="{{ __('Area Name') }}"
                        aria-describedby="nameCountry" value="{{ old('nameCountry', $area->nameCountry ?? '') }}" required
                        autofocus />
                </div>

                <hr>

                <div class="row">
                    <div class="row col-12 text-center">
                        <div class="col-md-6 mb-6">
                            <button id="submitBtn" type="submit" class="btn btn-primary">
                                <i class="menu-icon icon-base ti tabler-send"></i> {{ __('Submit') }}
                            </button>
                        </div>
                        <div class="col-md-6 mb-6">
                            <button id="cancelBtn" type="button" class="btn btn-label-danger">
                                <i class="menu-icon icon-base ti tabler-x"></i> {{ __('Cancel') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal to manage regions -->
    <div class="offcanvas offcanvas-end" id="manage-regions" style="width: 900px;">
        <div class="offcanvas-header border-bottom">
            <h5>
                <span class="offcanvas-region-title"></span> : <span class="offcanvas-region-title-countryName"></span>
            </h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body flex-grow-1">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Regions List') }}</h5>
                    <button type="button" class="btn btn-primary create-new-region">
                        <i class="menu-icon icon-base ti tabler-map-pin-plus"></i> {{ __('Add New Region') }}
                    </button>
                </div>
                <div class="card-datatable table-responsive pt-0">
                    <table class="datatables-regions table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('Region Name') }}</th>
                                <th>{{ __('Created at') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal to manage add/edit regions -->
    <div class="offcanvas offcanvas-end" id="add-new-record-region-form">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title-region-form"></h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body flex-grow-1">
            <form class="add-new-record pt-0 row g-2" id="regionForm">
                @csrf
                <input type="hidden" id="area_id" name="area_id" value="0">
                <input type="hidden" id="region_id" name="region_id" value="0">
                <div class="col-sm-12 mb-6">
                    <label class="form-label" for="nameTown">{!! showAsterix('nameTown') !!} {{ __('Region Name') }}</label>
                    <input type="text" id="nameTown" class="form-control dt-region-name" name="nameTown"
                        placeholder="{{ __('Region Name') }}" aria-label="{{ __('Region Name') }}"
                        aria-describedby="nameTown" value="{{ old('nameTown', $area->nameTown ?? '') }}" required
                        autofocus />
                </div>

                <hr>

                <div class="row">
                    <div class="row col-12 text-center">
                        <div class="col-md-6 mb-6">
                            <button id="submitBtnRegion" type="submit" class="btn btn-primary">
                                <i class="menu-icon icon-base ti tabler-send"></i> {{ __('Submit') }}
                            </button>
                        </div>
                        <div class="col-md-6 mb-6">
                            <button id="cancelBtnRegion" type="button" class="btn btn-label-danger">
                                <i class="menu-icon icon-base ti tabler-x"></i> {{ __('Cancel') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
