@extends('layouts/layoutMaster')

@section('title', __('Users'))

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
            data: "{{ route('users.data') }}",
            store: "{{ route('users.store') }}",
            update: "{{ route('users.update', ['user' => ':id']) }}",
            destroy: "{{ route('users.destroy', ['user' => ':id']) }}",
        }
        window.translations = {
            user_name_required: "{{ __('User name is required') }}",
            user_email_required: "{{ __('User email is required') }}",
            user_role_required: "{{ __('User role is required') }}",
            user_email_invalid: "{{ __('User email is invalid') }}",
            add_new_user: "{{ __('Add New User') }}",
            edit_user: "{{ __('Edit User') }}",
            error_occurred: "{{ __('An error occurred') }}",
            submitting: "{{ __('Submitting...') }}",
            user_delete_title: "{{ __('User delete title') }}",
            user_delete_text: "{{ __('User delete text') }}",
            user_role_required: "{{ __('User role is required') }}",
        }
    </script>
    @vite(['resources/assets/js/users/index.js'])
    @vite(['resources/assets/js/extended-ui-sweetalert2.js'])
@endsection

@section('content')
    <!-- DataTable with Buttons -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ __('User List') }}</h5>
            @can('users.create')
                <button type="button" class="btn btn-primary create-new">
                    <i class="menu-icon icon-base ti tabler-library-plus"></i> {{ __('Add New User') }}
                </button>
            @endcan
        </div>
        <div class="card-datatable table-responsive pt-0">
            <table class="datatables-basic table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>
                            {{ __('User Name') }} <br>
                            <hr>
                            <small class="text-muted">{{ __('User Role') }}</small>
                        </th>
                        <th>{{ __('Email') }}</th>
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
            <form class="add-new-record pt-0 row g-2" id="userForm">
                @csrf
                <input type="hidden" id="user_id" name="user_id" value="{{ old('user_id', $user->string_id ?? 0) }}">
                <div class="col-sm-12 mb-6">
                    <label class="form-label" for="name">{!! showAsterix('name') !!} {{ __('User Name') }}</label>
                    <input type="text" id="name" class="form-control dt-user-name" name="name"
                        placeholder="{{ __('User Name') }}" aria-label="{{ __('User Name') }}" aria-describedby="name"
                        value="{{ old('name', $user->name ?? '') }}" required autofocus />
                </div>

                <div class="col-sm-12 mb-6">
                    <label class="form-label" for="email">{!! showAsterix('email') !!} {{ __('User Email') }}</label>
                    <input type="email" id="email" class="form-control dt-user-email" name="email"
                        placeholder="{{ __('User Email') }}" aria-label="{{ __('User Email') }}" aria-describedby="email"
                        value="{{ old('email', $user->email ?? '') }}" required />
                </div>

                <div class="col-sm-12 mb-6">
                    <label class="form-label" for="password"><span
                            id="password_required_span">{!! showAsterix('password') !!}</span>{{ __('User Password') }}</label>
                    <input type="password" id="password" class="form-control dt-user-password" name="password"
                        placeholder="{{ __('User Password') }}" aria-label="{{ __('User Password') }}"
                        aria-describedby="password" value="{{ old('password', $user->password ?? '') }}" />
                </div>

                <div class="col-sm-12 mb-6">
                    <label class="form-label" for="role">{{ __('User Role') }}</label>
                    <select id="role" class="select2 form-select dt-user-role" name="role"
                        aria-label="{{ __('User Role') }}" aria-describedby="role">
                        <option value="">{{ __('Select Role') }}</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}"
                                {{ old('role', $user->role_id ?? '') == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
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
@endsection
