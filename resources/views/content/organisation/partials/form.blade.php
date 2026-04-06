@csrf
<div class="row">
    <!-- First column-->
    <div class="col-12 col-lg-8 mb-6">
        <!-- Organisation Information -->
        <div class="card mb-1">
            <div class="card-header">
                <h5 class="card-title mb-0">{{ __('Main information') }}</h5>
            </div>
            <div class="card-body">
                <input type="hidden" name="organisation_id" value="{{ $organisation->string_id ?? null }}">
                <div class="mb-6">
                    <label class="form-label" for="nameOr">{!! showAsterix('nameOr') !!}
                        {{ __('Organisation name') }}</label>
                    <input type="text" class="form-control" id="nameOr"
                        placeholder="{{ __('Organisation name') }}" name="nameOr"
                        value="{{ old('nameOr', $organisation->nameOr ?? '') }}" autofocus required />
                </div>

                <div class="row">
                    <div class="col-6 mb-6">
                        <label class="form-label" for="mailOr">{!! showAsterix('mailOr') !!}
                            {{ __('Organisation email') }}</label>
                        <input type="email" class="form-control" id="mailOr"
                            placeholder="{{ __('Organisation email') }}" name="mailOr"
                            value="{{ old('mailOr', $organisation->mailOr ?? '') }}" required />
                    </div>
                    <div class="col-6">
                        <div class="mb-6">
                            <label class="form-label" for="numberOr">{!! showAsterix('numberOr') !!}
                                {{ __('Organisation phone') }}</label>
                            <input type="tel" class="form-control" id="numberOr"
                                placeholder="{{ __('Organisation phone') }}" name="numberOr"
                                value="{{ old('numberOr', $organisation->numberOr ?? '') }}" required />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="mb-6">
                            <label class="form-label" for="stateOr">{!! showAsterix('stateOr') !!}
                                {{ __('Organisation state') }}</label>
                            <div class="input-group">
                                <input type="hidden" id="latitude" name="latitude"
                                    value="{{ old('latitude', $organisation->latitude ?? '') }}">
                                <input type="hidden" id="longitude" name="longitude"
                                    value="{{ old('longitude', $organisation->longitude ?? '') }}">
                                <input type="text" class="form-control" id="stateOr"
                                    placeholder="{{ __('Organisation state') }}" name="stateOr"
                                    value="{{ old('stateOr', $organisation->stateOr ?? '') }}" required />
                                <button type="button" id="btnLocate" class="btn btn-outline-secondary"
                                    title="Localiser">
                                    <i class="menu-icon icon-base ti tabler-map-pin"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mb-6">
                        <label for="picOr" class="form-label">
                            @if (!isset($organisation))
                                <span id="pic_required_span">{!! showAsterix('picOr') !!} </span>
                            @endif
                            {{ __('Organisation Pic') }}
                        </label>
                        <input type="file" class="form-control" id="picOr" name="picOr" accept="image/*" />
                        @if (isset($organisation) && $organisation->picOr)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $organisation->picOr) }}" alt="Organisation Logo"
                                    class="img-thumbnail" style="max-width: 200px; max-height: 200px;"
                                    id="currentPicOr">
                            </div>
                        @endif
                        <div class="mt-2" id="picOrPreview" style="display: none;">
                            <img src="" alt="Preview" class="img-thumbnail"
                                style="max-width: 200px; max-height: 200px;" id="previewImage">
                        </div>
                    </div>
                </div>

                <!-- Snow Theme -->
                <div class="mb-6">
                    <label class="form-label" for="description">{!! showAsterix('description') !!}
                        {{ __('Organisation description') }}</label>
                    <div id="snow-editor"></div>
                    <input type="hidden" name="descriptionOr" id="descriptionOr"
                        value="{{ old('descriptionOr', $organisation->descriptionOr ?? '') }}">
                </div>
            </div>
        </div>
        <!-- /Organisation Information -->
    </div>

    <!-- Second column -->
    <div class="col-12 col-lg-4">
        <!-- Orgaisation Social Card -->
        <div class="card mb-6">
            <div class="card-header">
                <h5 class="card-title mb-0">{{ __('Social networks') }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6 mb-6">
                        <label class="form-label" for="whatsapp">{!! showAsterix('whatsapp') !!}
                            {{ __('Organisation whatsapp') }}</label>
                        <input type="tel" class="form-control" id="whatsapp"
                            placeholder="{{ __('Organisation whatsapp') }}" name="whatsapp"
                            value="{{ old('whatsapp', $social->whatsapp ?? '') }}" required />
                    </div>
                    <div class="col-6">
                        <div class="mb-6">
                            <label class="form-label" for="facebook">{{ __('Organisation facebook') }}</label>
                            <input type="tel" class="form-control" id="facebook"
                                placeholder="{{ __('Organisation facebook') }}" name="facebook"
                                value="{{ old('facebook', $social->facebook ?? '') }}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Orgaisation Social Card -->
    </div>
    <!-- /Second column -->
</div>

<x-map-modal></x-map-modal>
