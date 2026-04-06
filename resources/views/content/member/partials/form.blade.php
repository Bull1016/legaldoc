@csrf
<div class="row">
    <div class="col-12 mb-6">
        <div class="card mb-1">
            <div class="card-header">
                <h5 class="card-title mb-0">{{ __('Main information') }}</h5>
            </div>
            <div class="card-body">
                <input type="hidden" name="member_id" value="{{ $member->string_id ?? null }}">
                <div class="mb-6">
                    <label class="form-label" for="name">{!! showAsterix('name') !!}
                        {{ __('Member name') }}</label>
                    <input type="text" class="form-control" id="name"
                        placeholder="{{ __('Member name') }}" name="name"
                        value="{{ old('name', $member->full_name ?? '') }}" autofocus required />
                </div>

                <div class="row">
                    <div class="col-6 mb-6">
                        <label class="form-label" for="email">{!! showAsterix('email') !!}
                            {{ __('Member email') }}</label>
                        <input type="email" class="form-control" id="email"
                            placeholder="{{ __('Member email') }}" name="email"
                            value="{{ old('email', $member->email ?? '') }}" required />
                    </div>
                    <div class="col-6">
                        <div class="mb-6">
                            <label class="form-label" for="phone">{!! showAsterix('phone') !!}
                                {{ __('Member phone') }} <span>( {{ __('Without Space') }} )</span> </label>
                            <input type="tel" class="form-control" id="phone"
                                placeholder="{{ __('Member phone') }}" name="phone"
                                value="{{ old('phone', $member->phone ?? '') }}" required />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="mb-6">
                            <label class="form-label" for="sex">{!! showAsterix('sex') !!}
                                {{ __('Member sex') }}</label>
                            <select name="sex" id="sex" class="selectpicker w-100 select2"
                                data-style="btn-default" required>
                                <option value="" selected disabled>{{ __('Select a sex') }}</option>
                                <option value="male" @selected(old('sex', $member->sex ?? '') == 'male')>
                                    {{ __('Male') }}</option>
                                <option value="female" @selected(old('sex', $member->sex ?? '') == 'female')>
                                    {{ __('Female') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-6">
                            <label class="form-label" for="job">{!! showAsterix('job') !!}
                                {{ __('Member job') }}</label>
                            <input type="text" class="form-control" id="job"
                                placeholder="{{ __('Member job') }}" name="job"
                                value="{{ old('job', $member->job ?? '') }}" required />
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="form-label" for="birth">{!! showAsterix('birth') !!}
                        {{ __('Member birth') }}</label>
                    <input class="form-control" type="date" name="birth" id="birth"
                        value="{{ old('birth', $member->birth ?? '') }}">
                </div>

                <div class="row">
                    <div class="col-12 mb-6">
                        <label for="photo" class="form-label">
                            @if (!isset($member))
                                <span id="pic_required_span">{!! showAsterix('photo') !!} </span>
                            @endif
                            {{ __('Member Pic') }}
                        </label>
                        <input type="file" class="form-control" id="photo" name="photo" accept="image/*" />
                        @if (isset($member) && $member->photo)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $member->photo) }}" alt="Member photo"
                                    class="img-thumbnail" style="max-width: 200px; max-height: 200px;"
                                    id="currentPhoto">
                            </div>
                        @endif
                        <div class="mt-2" id="photoPreview" style="display: none;">
                            <img src="" alt="Preview" class="img-thumbnail"
                                style="max-width: 200px; max-height: 200px;" id="previewPhoto">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
