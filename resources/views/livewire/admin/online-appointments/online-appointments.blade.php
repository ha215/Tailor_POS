<div>
    <div class="page-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row gx-3 mb-0">
                                <div class="col mb-4">
                                    <h5 class="mb-0">{{ __('main.appointments') }}</h5>
                                </div>
                                <div class="col-auto mb-4">
                                    
                                </div>
                                <div class="col-12">
                                    <div class="input-group">
                                        <span class="input-group-text" wire:ignore><i class="fa fa-search"></i></span>
                                        <input class="form-control" wire:model="search_query" type="text"
                                            placeholder="{{ __('main.search_here') }}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive mt-0">
                            <table class="table">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-primary" scope="col"># </th>
                                        <th class="text-primary" scope="col">
                                            {{ __('main.customer') }}</th>
                                        </th>
                                        
                                        <th class="text-primary" scope="col">
                                            {{ __('main.appointment_date') }}</th>
                                        </th>
                                        <th class="text-primary" scope="col">
                                            {{ __('main.status') }} </th>
                                        <th class="text-primary" scope="col">
                                            {{ __('main.actions') }} </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($appointments as $item)
                                        <tr>
                                            <th scope="row">{{ $loop->index + 1 }}</th>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class=" mb-0 fw-bold">
                                                        <div class="mb-0">{{ $item->customer->name }}</div>
                                                    </div>
                                                   
                                                </div>
                                                <div class="mt-50 text-xs text-secondary fw-bold">
                                                    {{ $item->branch?->name }}</div>
                                            </td>
                                         
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="mb-0 ">
                                                        <div class="mb-0">{{ \Carbon\Carbon::parse($item->date)->format('d/m/Y h:i A') }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="media-body switch-lg">
                                                    <select name="" class="form-select w-75" wire:change="changeStatus({{$item->id}},$event.target.value)" >
                                                        <option value="0" @if($item->status == 0) selected @endif>Pending</option>
                                                        <option value="1" @if($item->status == 1) selected @endif>Completed</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                @if($item->notes)
                                                <a data-bs-toggle="modal"
                                                        wire:click="viewNote({{ $item->id }})"
                                                        data-bs-target="#viewnote"
                                                        class="btn btn-custom-info btn-sm px-2" type="button">
                                                        <i class="fa fa-book me-2"></i>{{ __('main.notes') }}
                                                    </a>
                                                @endif
                                                @if (Auth::user()->id == $item->branch_id)
                                                    <a data-bs-toggle="modal"
                                                        wire:click="viewNote({{ $item->id }})"
                                                        data-bs-target="#confirmdelete"
                                                        class="btn btn-custom-danger btn-sm px-2" type="button">
                                                        <i class="fa fa-trash-o me-2"></i>{{ __('main.delete') }}
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if (count($appointments) == 0)
                            <x-empty-item-component :title="__('main.empty_item_title')" />
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    <div class="modal fade" id="confirmdelete" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('main.confirm_delete') }} </h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form>
                    <div class="modal-body text-center">
                        <div class="pb-4 pt-3">
                            <h5 class="mb-3">{{ __('main.are_you_sure') }}</h5>
                            <p class="mb-0 text-sm">{{ __('main.confirm_delete_offer') }}</p>
                        </div>
                    </div>
                    <div class="text-center pb-4">
                        <button class="btn btn-secondary me-2" type="button"
                            data-bs-dismiss="modal">{{ __('main.cancel') }}</button>
                        <button class="btn btn-primary" type="submit"
                            wire:click.prevent="delete">{{ __('main.confirm') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewnote" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('main.notes') }} </h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form>
                    @if($appointment)
                    <div class="modal-body ">
                        <div class="pb-4 pt-3">
                            <p class="mb-0 text-sm" style="white-space: pre-line">
                                {{$appointment->notes}}
                            </p>
                        </div>
                    </div>
                    @endif
                    <div class="text-center pb-4">
                        <button class="btn btn-secondary me-2" type="button"
                            data-bs-dismiss="modal">{{ __('main.close') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
