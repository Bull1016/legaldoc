@extends('layouts/layoutMaster')

@section('title', __('Positions'))

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
            data: "{{ route('positions.data') }}",
            store: "{{ route('positions.store') }}",
            update: "{{ route('positions.update', ['position' => ':id']) }}",
            destroy: "{{ route('positions.destroy', ['position' => ':id']) }}",
            get_permissions: "{{ route('permissions.getPositionPermissions', ['position' => ':id']) }}",
            update_permission: "{{ route('permissions.updatePermission', ['position' => ':id']) }}",
        }
        window.translations = {
            position_name_required: "{{ __('Position name is required') }}",
            add_new_position: "{{ __('Add New Position') }}",
            edit_position: "{{ __('Edit Position') }}",
            error_occurred: "{{ __('An error occurred') }}",
            submitting: "{{ __('Submitting...') }}",
            position_delete_title: "{{ __('Position delete title') }}",
            position_delete_text: "{{ __('Position delete text') }}",
            manage_permissions: "{{ __('Manage Permissions') }}",
            failed_to_fetch_permissions: "{{ __('Failed to fetch permissions') }}",
        }
    </script>
    @vite(['resources/assets/js/positions/index.js'])
    @vite(['resources/assets/js/permissions/index.js'])
    @vite(['resources/assets/js/extended-ui-sweetalert2.js'])
@endsection

@section('content')
    <!-- DataTable with Buttons -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ __('Position List') }}</h5>
            @can('positions.create')
                <button type="button" class="btn btn-primary create-new">
                    <i class="menu-icon icon-base ti tabler-library-plus"></i> {{ __('Add New Position') }}
                </button>
            @endcan
        </div>
        <div class="card-datatable table-responsive pt-0">
            <table class="datatables-basic table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('Position Name') }}</th>
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
            <form class="add-new-record pt-0 row g-2" id="positionForm">
                @csrf
                <input type="hidden" id="position_id" name="position_id"
                    value="{{ old('position_id', $position->string_id ?? 0) }}">
                <div class="col-sm-12 mb-6">
                    <label class="form-label" for="name">{!! showAsterix('name') !!} {{ __('Position Name') }}</label>
                    <input type="text" id="name" class="form-control dt-role-name" name="name"
                        placeholder="{{ __('Position Name') }}" aria-label="{{ __('Position Name') }}"
                        aria-describedby="name" value="{{ old('name', $position->name ?? '') }}" required autofocus />
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

    <!-- Modal to manage permissions -->
    <div class="offcanvas offcanvas-end" id="manage-permissions" style="width: 900px;">
        <div class="offcanvas-header border-bottom">
            <h5>
                <span class="offcanvas-permission-title"></span> : <span
                    class="offcanvas-permission-title-positionName"></span>
            </h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body flex-grow-1">
            <form class="pt-0" id="permissionForm">
                @csrf
                <input type="hidden" id="position_id" name="position_id">

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ __('Permissions List') }}</h5>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="select-all-permissions">
                            <label class="form-check-label" for="select-all-permissions">
                                {{ __('Select All') }}
                            </label>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    @php
                                        // Chunk (Grouper) permissions into groups of 3
                                        $chunkedPermissions = $permissions->chunk(3);
                                    @endphp
                                    @foreach ($chunkedPermissions as $chunk)
                                        <tr>
                                            @foreach ($chunk as $permission)
                                                <td style="width: 33.33%;">
                                                    <div class="form-check">
                                                        <input class="form-check-input permission-checkbox" type="checkbox"
                                                            name="permissions[]" value="{{ $permission->id }}"
                                                            id="permission-{{ $permission->id }}" />
                                                        <label class="form-check-label"
                                                            for="permission-{{ $permission->id }}">
                                                            {{ $permission->name }}
                                                        </label>
                                                    </div>
                                                </td>
                                            @endforeach
                                            @for ($i = $chunk->count(); $i < 3; $i++)
                                                <td style="width: 33.33%;"></td>
                                            @endfor
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-12 text-center">
                                <button id="submitBtnPermission" type="submit" class="btn btn-primary me-2">
                                    <i class="menu-icon icon-base ti tabler-send"></i> {{ __('Submit') }}
                                </button>
                                <button id="cancelBtnPermission" type="button" class="btn btn-label-danger">
                                    <i class="menu-icon icon-base ti tabler-x"></i> {{ __('Cancel') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
