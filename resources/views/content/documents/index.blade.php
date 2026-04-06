@extends('layouts/layoutMaster')

@section('title', __('Partners'))

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
            data: "{{ route('partners.data') }}",
            store: "{{ route('partners.store') }}",
            update: "{{ route('partners.update', ['partner' => ':id']) }}",
            destroy: "{{ route('partners.destroy', ['partner' => ':id']) }}",
        }
        window.translations = {
            partner_name_required: "{{ __('Partner name is required') }}",
            partner_pic_required: "{{ __('Partner pic is required') }}",
            partner_location_required: "{{ __('Partner location is required') }}",
            add_new_partner: "{{ __('Add New Partner') }}",
            edit_partner: "{{ __('Edit Partner') }}",
            error_occurred: "{{ __('An error occurred') }}",
            submitting: "{{ __('Submitting...') }}",
            partner_delete_title: "{{ __('Partner delete title') }}",
            partner_delete_text: "{{ __('Partner delete text') }}",
            error_map: "{{ __('Error has occured while trying to get the adresse. Retry Later !') }}",
            retriving_map: "{{ __('We are retriving this adresse') }}"
        }
    </script>
    @vite(['resources/assets/js/partners/index.js'])
    @vite(['resources/assets/js/map-modal.js'])
    @vite(['resources/assets/js/extended-ui-sweetalert2.js'])
@endsection

@section('content')
    <!-- DataTable with Buttons -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ __('Partner List') }}</h5>
            @can('partners.create')
                <button type="button" class="btn btn-primary create-new">
                    <i class="menu-icon icon-base ti tabler-library-plus"></i> {{ __('Add New Partner') }}
                </button>
            @endcan
        </div>
        <div class="card-datatable table-responsive pt-0">
            <table class="datatables-basic table">
                <thead>
                    <tr>
                        <th style="padding-bottom: 40px">#</th>
                        <th>
                            {{ __('Partner Pic') }} <br>
                            <hr>
                            <small class="text-muted">{{ __('Partner Location') }}</small>
                        </th>
                        <th style="padding-bottom: 40px">{{ __('Partner Name') }}</th>
                        <th style="padding-bottom: 40px">{{ __('Created at') }}</th>
                        <th style="padding-bottom: 40px">{{ __('Actions') }}</th>
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
            <form class="add-new-record pt-0 row g-2" id="partnerForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="partner_id" name="partner_id"
                    value="{{ old('partner_id', $partner->string_id ?? 0) }}">
                <div class="col-sm-12 mb-6">
                    <label class="form-label" for="name">{!! showAsterix('name') !!} {{ __('Partner Name') }}</label>
                    <input type="text" id="name" class="form-control dt-role-name" name="name"
                        placeholder="{{ __('Partner Name') }}" aria-label="{{ __('Partner Name') }}"
                        aria-describedby="name" value="{{ old('name', $partner->name ?? '') }}" required autofocus />
                </div>

                <div class="col-sm-12 mb-6">
                    <label class="form-label" for="location">{!! showAsterix('location') !!}
                        {{ __('Partner Location') }}</label>
                    <div class="input-group">
                        <input type="hidden" id="latitude" name="latitude"
                            value="{{ old('latitude', $organisation->latitude ?? '') }}">
                        <input type="hidden" id="longitude" name="longitude"
                            value="{{ old('longitude', $organisation->longitude ?? '') }}">
                        <input type="text" class="form-control" id="location"
                            placeholder="{{ __('Partner Location') }}" name="location"
                            value="{{ old('location', $organisation->location ?? '') }}" required />
                        <button type="button" id="btnLocate" class="btn btn-outline-secondary" title="Localiser">
                            <i class="menu-icon icon-base ti tabler-map-pin"></i>
                        </button>
                    </div>
                </div>

                <div class="col-sm-12 mb-6">
                    <label for="pic" class="form-label"><span id="pic_required_span">{!! showAsterix('pic') !!}
                        </span>{{ __('Partner Pic') }}</label>
                    <input type="file" class="form-control" id="pic" name="pic" accept="image/*" />
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

    <x-map-modal></x-map-modal>
@endsection
