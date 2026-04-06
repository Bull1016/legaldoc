@extends('layouts/layoutMaster')

@section('title', __('Dashboard'))

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/apex-charts/apex-charts.scss', 'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss'])
@endsection

@section('page-style')
    @vite('resources/assets/vendor/scss/pages/app-logistics-dashboard.scss')
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/apex-charts/apexcharts.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js'])
@endsection

@section('page-script')
    @vite('resources/assets/js/app-dashboard.js')
@endsection

@section('content')
    <div class="row g-6">
        <!-- Card Border Shadow -->
        @can('members.index')
            <div class="col-lg-6 col-sm-12">
                <div class="card card-border-shadow-primary h-100">
                    <div class="card-body">
                        {{-- <a href="{{ route('members.index') }}"> --}}
                            <div class="d-flex align-items-center mb-2">
                                <div class="avatar me-4">
                                    <span class="avatar-initial rounded bg-label-primary">
                                        <i class="icon-base ti tabler-users-group"></i>
                                    </span>
                                </div>
                                <h4 class="mb-0">{{ $nbUsers }}</h4>
                            </div>
                            <p class="mb-1">{{ __('Users') }}</p>
                        {{-- </a> --}}
                    </div>
                </div>
            </div>
        @endcan

        {{-- @can('partners.index')
        <div class="col-lg-6 col-sm-12">
            <div class="card card-border-shadow-warning h-100">
                <div class="card-body">
                  <a href="{{ route('partners.index') }}">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded bg-label-warning">
                                <i class="icon-base ti tabler-cap-straight"></i>
                            </span>
                        </div>
                        <h4 class="mb-0">{{ $nbPartners }}</h4>
                    </div>
                    <p class="mb-1">{{ __('Partners') }}</p>
                  </a>
                </div>
            </div>
        </div>
        @endcan --}}
        <!--/ Card Border Shadow -->


        <!-- Shipment statistics-->
        {{-- <div class="col-xxl-6 col-lg-7">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between">
        <div class="card-title mb-0">
          <h5 class="mb-1">Shipment statistics</h5>
          <p class="card-subtitle">Total number of deliveries 23.8k</p>
        </div>
        <div class="btn-group">
          <button type="button" class="btn btn-label-primary">January</button>
          <button type="button" class="btn btn-label-primary dropdown-toggle dropdown-toggle-split"
            data-bs-toggle="dropdown" aria-expanded="false">
            <span class="visually-hidden">Toggle Dropdown</span>
          </button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="javascript:void(0);">January</a></li>
            <li><a class="dropdown-item" href="javascript:void(0);">February</a></li>
            <li><a class="dropdown-item" href="javascript:void(0);">March</a></li>
            <li><a class="dropdown-item" href="javascript:void(0);">April</a></li>
            <li><a class="dropdown-item" href="javascript:void(0);">May</a></li>
            <li><a class="dropdown-item" href="javascript:void(0);">June</a></li>
            <li><a class="dropdown-item" href="javascript:void(0);">July</a></li>
            <li><a class="dropdown-item" href="javascript:void(0);">August</a></li>
            <li><a class="dropdown-item" href="javascript:void(0);">September</a></li>
            <li><a class="dropdown-item" href="javascript:void(0);">October</a></li>
            <li><a class="dropdown-item" href="javascript:void(0);">November</a></li>
            <li><a class="dropdown-item" href="javascript:void(0);">December</a></li>
          </ul>
        </div>
      </div>
      <div class="card-body">
        <div id="shipmentStatisticsChart"></div>
      </div>
    </div>
  </div> --}}
        <!--/ Shipment statistics -->

        <!-- Delivery Performance -->
        {{-- <div class="col-xxl-4 col-lg-5">
    <div class="card h-100">
      <div class="card-header d-flex justify-content-between">
        <div class="card-title mb-0">
          <h5 class="mb-1 me-2">Delivery Performance</h5>
          <p class="card-subtitle">12% increase in this month</p>
        </div>
        <div class="dropdown">
          <button class="btn btn-text-secondary rounded-pill p-2 me-n1" type="button" id="deliveryPerformance"
            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="icon-base ti tabler-dots-vertical icon-md"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="deliveryPerformance">
            <a class="dropdown-item" href="javascript:void(0);">Select All</a>
            <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
            <a class="dropdown-item" href="javascript:void(0);">Share</a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <ul class="p-0 m-0">
          <li class="d-flex mb-6 align-items-center">
            <div class="avatar flex-shrink-0 me-4">
              <span class="avatar-initial rounded bg-label-primary"><i
                  class="icon-base ti tabler-package icon-26px"></i></span>
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <h6 class="mb-1 fw-normal">Packages in transit</h6>
                <small class="text-success mb-0">
                  <i class="icon-base ti tabler-chevron-up me-1"></i>
                  25.8%
                </small>
              </div>
              <div class="user-progress">
                <h6 class="text-body mb-0">10k</h6>
              </div>
            </div>
          </li>
          <li class="d-flex mb-6 align-items-center">
            <div class="avatar flex-shrink-0 me-4">
              <span class="avatar-initial rounded bg-label-info"><i
                  class="icon-base ti tabler-truck icon-28px"></i></span>
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <h6 class="mb-1 fw-normal">Packages out for delivery</h6>
                <small class="text-success mb-0">
                  <i class="icon-base ti tabler-chevron-up me-1"></i>
                  4.3%
                </small>
              </div>
              <div class="user-progress">
                <h6 class="text-body mb-0">5k</h6>
              </div>
            </div>
          </li>
          <li class="d-flex mb-6 align-items-center">
            <div class="avatar flex-shrink-0 me-4">
              <span class="avatar-initial rounded bg-label-success"><i
                  class="icon-base ti tabler-circle-check icon-26px"></i></span>
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <h6 class="mb-1 fw-normal">Packages delivered</h6>
                <small class="text-danger mb-0">
                  <i class="icon-base ti tabler-chevron-down me-1"></i>
                  12.5
                </small>
              </div>
              <div class="user-progress">
                <h6 class="text-body mb-0">15k</h6>
              </div>
            </div>
          </li>
          <li class="d-flex mb-6 align-items-center">
            <div class="avatar flex-shrink-0 me-4">
              <span class="avatar-initial rounded bg-label-warning"><i
                  class="icon-base ti tabler-percentage icon-26px"></i></span>
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <h6 class="mb-1 fw-normal">Delivery success rate</h6>
                <small class="text-success mb-0">
                  <i class="icon-base ti tabler-chevron-up me-1"></i>
                  35.6%
                </small>
              </div>
              <div class="user-progress">
                <h6 class="text-body mb-0">95%</h6>
              </div>
            </div>
          </li>
          <li class="d-flex mb-6 align-items-center">
            <div class="avatar flex-shrink-0 me-4">
              <span class="avatar-initial rounded bg-label-secondary"><i
                  class="icon-base ti tabler-clock icon-26px"></i></span>
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <h6 class="mb-1 fw-normal">Average delivery time</h6>
                <small class="text-danger mb-0">
                  <i class="icon-base ti tabler-chevron-down me-1"></i>
                  2.15
                </small>
              </div>
              <div class="user-progress">
                <h6 class="text-body mb-0">2.5 Days</h6>
              </div>
            </div>
          </li>
          <li class="d-flex align-items-center">
            <div class="avatar flex-shrink-0 me-4">
              <span class="avatar-initial rounded bg-label-danger"><i
                  class="icon-base ti tabler-users icon-26px"></i></span>
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <h6 class="mb-1 fw-normal">Customer satisfaction</h6>
                <small class="text-success mb-0">
                  <i class="icon-base ti tabler-chevron-up me-1"></i>
                  5.7%
                </small>
              </div>
              <div class="user-progress">
                <h6 class="text-body mb-0">4.5/5</h6>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div> --}}
        <!--/ Delivery Performance -->

        <!-- Reasons for delivery exceptions -->
        {{-- <div class="col-xxl-4 col-lg-6">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between">
        <div class="card-title mb-0">
          <h5 class="m-0 me-2">Reasons for delivery exceptions</h5>
        </div>
        <div class="dropdown">
          <button class="btn btn-text-secondary rounded-pill  p-2 me-n1" type="button" id="deliveryExceptions"
            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="icon-base ti tabler-dots-vertical icon-md text-body-secondary"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="deliveryExceptions">
            <a class="dropdown-item" href="javascript:void(0);">Select All</a>
            <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
            <a class="dropdown-item" href="javascript:void(0);">Share</a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div id="deliveryExceptionsChart"></div>
      </div>
    </div>
  </div> --}}
        <!--/ Reasons for delivery exceptions -->
    </div>

@endsection
