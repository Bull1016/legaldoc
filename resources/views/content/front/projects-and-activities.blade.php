@extends('layouts.front.layout')

@section('title', __('Projects & Activities'))

@section('content')
    <section id="subheader" class="bg-color-op-1">
        <div class="container relative z-2">
            <div class="row gy-4 gx-5 align-items-center">
                <div class="col-lg-12">
                    <h1 class="split">{{ __('Projects & Activities') }}</h1>
                    <ul class="crumb wow fadeInUp">
                        <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                        <li class="active">{{ __('Projects & Activities') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="relative">
        <div class="container relative z-2">
            <div class="row g-4">
                @forelse ($activities as $index => $item)
                    <div class="col-lg-4 col-sm-6 wow fadeInUp" data-wow-delay="{{ $index * 0.2 }}s">
                        <div class="hover">
                            <div class="relative overflow-hidden rounded-1">
                                <a href="#" class="d-block hover activity-link" data-bs-toggle="modal"
                                    data-bs-target="#activityModal" data-name="{{ $item->name }}"
                                    data-banner="{{ asset('storage/' . $item->banner) }}" data-place="{{ $item->place }}"
                                    data-description="{{ $item->description }}"
                                    data-images="{{ json_encode($item->images->map(fn($img) => asset('storage/' . $img->image_path))) }}">
                                    <div class="relative overflow-hidden rounded-1">
                                        <img src="{{ asset('storage/' . $item->banner) }}" class="w-100 hover-scale-1-2"
                                            alt="{{ $item->name }}">
                                        <div class="gradient-edge-bottom color h-90 op-8"></div>
                                    </div>

                                    <div class="p-4 relative bg-white rounded-1 mx-4 mt-min-100 z-2">
                                        <div class="abs top-0 end-0 mt-min-30 me-4 circle bg-color w-60px h-60px">
                                            <img src="{{ asset('front/assets/images/misc/up-right-arrow.webp') }}"
                                                class="w-60px p-20" alt="">
                                        </div>
                                        <h4>{{ $item->name }}</h4>
                                        <p class="mb-0">{!! Illuminate\Support\Str::limit(strip_tags($item->description), 100) !!}</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse
            </div>
        </div>
    </section>

    <!-- Activity Modal -->
    <div class="modal fade" id="activityModal" tabindex="-1" aria-labelledby="activityModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-1 overflow-hidden border-0">
                <div class="modal-header border-0 p-0 relative">
                    <img id="modalBanner" src="" class="w-100" alt=""
                        style="max-height: 300px; object-fit: cover;">
                    <div class="gradient-edge-bottom color h-100 op-8"></div>
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3 z-3"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="position-absolute bottom-0 start-0 p-4 z-2 text-white">
                        <h2 id="modalName" class="mb-1"></h2>
                        <p id="modalPlace" class="mb-0 opacity-75"><i class="fa fa-map-marker-alt me-2"></i><span></span>
                        </p>
                    </div>
                </div>
                <div class="modal-body p-4 bg-white">
                    <div class="mb-4">
                        <h5 class="fw-bold mb-3">{{ __('Description') }}</h5>
                        <div id="modalDescription" class="text-secondary"></div>
                    </div>

                    <div id="modalImagesContainer" style="display: none;">
                        <h5 class="fw-bold mb-3">{{ __('Photos') }}</h5>
                        <div class="row g-3" id="modalImages">
                            <!-- Images will be injected here -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 bg-light">
                    <button type="button" class="btn-main" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const activityModal = document.getElementById('activityModal');
            if (activityModal) {
                activityModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const name = button.getAttribute('data-name');
                    const banner = button.getAttribute('data-banner');
                    const place = button.getAttribute('data-place');
                    const description = button.getAttribute('data-description');
                    const images = JSON.parse(button.getAttribute('data-images'));

                    const modalName = activityModal.querySelector('#modalName');
                    const modalBanner = activityModal.querySelector('#modalBanner');
                    const modalPlace = activityModal.querySelector('#modalPlace span');
                    const modalDescription = activityModal.querySelector('#modalDescription');
                    const modalImages = activityModal.querySelector('#modalImages');
                    const modalImagesContainer = activityModal.querySelector('#modalImagesContainer');

                    modalName.textContent = name;
                    modalBanner.src = banner;
                    modalPlace.textContent = place || '{{ __('Not specified') }}';
                    modalDescription.innerHTML = description;

                    // Clear previous images
                    modalImages.innerHTML = '';
                    if (images && images.length > 0) {
                        modalImagesContainer.style.display = 'block';
                        images.forEach(imgUrl => {
                            const col = document.createElement('div');
                            col.className = 'col-md-4 col-6';
                            col.innerHTML = `
                                <div class="rounded-1 overflow-hidden" style="height: 150px;">
                                    <img src="${imgUrl}" class="w-100 h-100 object-fit-cover hover-scale-1-1 transition" alt="Activity Image">
                                </div>
                            `;
                            modalImages.appendChild(col);
                        });
                    } else {
                        modalImagesContainer.style.display = 'none';
                    }
                });
            }
        });
    </script>
@endsection
