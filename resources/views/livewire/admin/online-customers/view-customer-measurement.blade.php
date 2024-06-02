<div>
    <div class="page-body">
        <div class="container-fluid">
            <div class="row gx-3 mb-3 align-items-center">
                <div class="col">
                    <h5 class="mb-0">{{ __('main.online_customer_measurement_settings') }}</h5>
                </div>
                <div class="col-auto">
                    <a href="{{ route('admin.online-customers') }}" class="btn btn-custom-primary px-2" type="button">
                        <i class="fa fa-arrow-left me-2"></i>{{ __('main.back') }}
                    </a>
                </div>
            </div>
            <div class="row gx-3">
                <div class="col-lg-12">
                    <div class="card pt-3">
                        <div class="card-body pb-0">
                            <div class="row gx-3 mb-4 ">
                                <div class="col-lg-6">
                                    <label
                                        class="form-label">{{ __('main.select_product_type') }}
                                        <span class="text-danger">*</span></label>
                                    <select required class="form-select" wire:model="type">
                                        <option value="">
                                            {{ __('main.select_an_option') }}</option>
                                        @foreach ($measurements as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }} </option>
                                        @endforeach
                                    </select>
                                    @error('type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                @if ($attributes && count($attributes) > 0)
                                    <div class="col-lg-3">
                                        <label
                                            class="form-label">{{ __('main.measurement_unit') }}
                                            <span class="text-danger">*</span></label>
                                        <select required class="form-select" wire:model="unit">
                                            <option value="">{{ __('main.select_unit') }}
                                            </option>
                                            <option value="1">{{ __('main.inches ') }}</option>
                                            <option value="2">{{ __('main.cm') }} </option>
                                            <option value="3">{{ __('main.mtr') }}</option>
                                            <option value="4">{{ __('main.yrd') }}</option>
                                            <option value="5">{{ __('main.ft') }}</option>
                                        </select>
                                        @error('unit')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="translation-add-scroll">
                            <div class="card-body pt-0">
                                <div class="row g-3">
                                    @if ($attributes && count($attributes) > 0)
                                        @foreach ($attributes as $item)
                                            <div class="col-lg-6 col-12">
                                                <div class="mb-0">
                                                    <div class="input-group">
                                                        <span
                                                            class="input-group-text col-6">{{ $item->attribute->name ?? '' }}</span>
                                                        <input class="form-control col-6" type="number"
                                                            placeholder="{{ __('main.enter_value') }}"
                                                            wire:model="userattributes.{{ $item->id }}" />
                                                    </div>
                                                    @error('userattributes.' . $item->id)
                                                        <span class="text-danger">The {{ $item->attribute->name ?? '' }}
                                                            field is required</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="col-lg-12 col-12">
                                            <div class="mb-0">
                                                <label class="form-label">{{ __('main.notes') }}</label>
                                                <textarea class="form-control" placeholder="{{ __('main.enter_notes') }}" wire:model="notes"> </textarea>
                                                @error('notes')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row justify-content-end">
                                <div class="col-auto">
                                    <button class="btn btn-light text-primary me-2" type="submit"
                                        wire:click.prevent="save">{{ __('main.save_measurements') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>