<!-- Modal de localisation -->
<div class="modal fade" id="mapModal" tabindex="-1" aria-labelledby="mapModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mapModalLabel">{{ __('Select location') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div id="mapContainer" style="height: 400px; width: 100%;"></div>
            </div>
            <div class="modal-footer d-flex justify-content-between mt-5">
                <button type="button" class="btn btn-secondary"
                    data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="button" id="confirmLocation"
                    class="btn btn-primary">{{ __('Confirm location') }}</button>
            </div>
        </div>
    </div>
</div>

