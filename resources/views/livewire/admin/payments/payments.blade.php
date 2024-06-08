<div>
    <div class="page-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row gx-3 mb-0">
                                <div class="col mb-4">
                                    <h5 class="mb-0">{{ __('main.receipt_list') }}</h5>
                                </div>
                                    <div class="col-auto mb-4" style="display:none;">
                                        <a href="{{ route('admin.add_payments') }}" class="btn btn-primary px-2"
                                            type="button">
                                            <i class="fa fa-plus me-2"></i>{{ __('main.add_new_receipt') }}
                                        </a>
                                    </div>
                                <div class="col-12">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa fa-search"></i></span>
                                        <input class="form-control" type="text" wire:model="search"
                                            placeholder="{{ __('main.search_here') }}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive mt-0">
                            <table class="table">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-primary" scope="col">{{ __('main.slno') }} </th>
                                        <th class="text-primary" scope="col">{{ __('main.date') }} </th>
                                        <th class="text-primary" scope="col">{{ __('main.customer') }}</th>
                                        <th class="text-primary" scope="col">{{ __('main.amount') }}</th>
                                        <th class="text-primary" scope="col">{{ __('main.paid') }}</th>
                                        <th class="text-primary" scope="col">{{ __('main.balance') }}</th>
                                        <th class="text-primary" scope="col">{{ __('main.status') }}</th>
                                        <th class="text-primary" scope="col">{{ __('main.invoice_no') }}</th>
                                        <th class="text-primary" scope="col">{{ __('main.actions') }} </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payments as $index => $item)
                                        <tr>
                                            <th>
                                                {{ $index + 1 }}
                                            </th>
                                            <td>
                                                <div class="mb-0">{{ date('d-m-Y', strtotime($item['created_at'])) }}</div>
                                                <!-- <div class="mt-50 text-xs text-secondary fw-bold">{{ __('main.by') }}
                                                    {{ $item->createdBy->name ?? 'Unknown' }}</div> -->
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="customer-icon rounded text-center text-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="feather feather-user mb-0">
                                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                            <circle cx="12" cy="7" r="4">
                                                            </circle>
                                                        </svg>
                                                    </div>
                                                    <div class="ms-2 mb-0 fw-bold">
                                                        <div class="mb-0">{{ $item->customer_name ?? '' }}
                                                        </div>
                                                        <div class="mb-50">{{ $item->customer_phone ?? '' }}
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="mb-0 fw-bold">
                                                    {{ getFormattedCurrency($item->total) }}</div>
                                            </td>
                                           
                                                
                                            
                                                <td>
                                                   {{$item->paid($item->id)}}
                                                </td>
                                            
                                                <td>
                                                    {{$item->balance($item->id)}}
                                                </td>
                                                <td>
                                                    
                                                <span class="btn badge {{ getInvoiceStatusColor($item->status) }} text-uppercase p-2">{{ getInvoiceStatus($item->status) }}</span>
                                                </td>
                                                <td>
                                                    
                                                        #{{ $item->invoice_number ?? '' }}
                                                </td>
                                            
                                            <td>
                                                @if($item->balance($item->id) == 0)
                                                <span class="btn badge bg-primary text-uppercase p-2">Paid</span> &nbsp;
                                                @else
                                               
                                                    <a data-bs-toggle="modal" wire:click="edit({{ $item->id }})"
                                                        data-bs-target="#editpayment2"
                                                        class="btn btn-secondary btn-sm px-2" type="button">
                                                        <i class="fa fa-money"></i>
                                                    </a> &nbsp;
                                               
                                                @endif
                                                @if($item->status == 2)
                                                <a data-bs-toggle="modal"
                                                    wire:click="deleteConfirm({{ $item->id }})"
                                                    data-bs-target="#confirmdelete"
                                                    class="btn btn-success btn-sm px-2" type="button">
                                                    <i class="fa fa-check-circle" ></i>{{ __('main.ready') }}
                                                </a> &nbsp;
                                                @endif
                                                <a href="{{ route('admin.print_voucher', $item->id) }}"
                                                    class="btn btn-success btn-sm px-2" type="button"
                                                    target="_blank">
                                                    <i class="fa fa-print me-2"></i>{{ __('main.print') }}
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if (count($payments) == 0)
                            <x-empty-item-component :title="__('main.empty_item_title')" />
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editpayment2" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('main.payment') }} </h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form>
                       @if($payment != null)
                        <div class="modal-body">
                            <div class="row align-items-start g-3">
                                <div class="col-lg-12 col-12">
                                    <div class="row g-3 align-items-center">
                                        <div class="col">
                                            <div class="d-flex align-items-center">
                                                <div class="customer-icon rounded text-center text-primary p-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" class="feather feather-user mb-0">
                                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                        <circle cx="12" cy="7" r="4">
                                                        </circle>
                                                    </svg>
                                                </div>
                                                <div class="ms-2 mb-0 fw-bold">
                                                    <div class="mb-50">{{ $payment->customer_name }}</div>
                                                    <div class="mb-0">{{ getCountryCode() }}
                                                        {{ $payment->customer_phone ?? '' }} </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <div class="">
                                                <h6 class="mb-50">{{ __('main.invoice') }} #
                                                    <span>{{ $payment->invoice_number ?? '' }}</span></h6>
                                                <div class="mb-0"><span>{{ __('main.date') }}:</span>
                                                   {{ date('d-m-Y', strtotime($payment['date'] ?? '')) }}
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="bg-light mt-3 mb-0">
                                </div>
                                <div class="col-lg-12 col-12">
                                    
                                    <div class="row mb-50 align-items-center">
                                        <div class="col">{{ __('main.total_amount') }}:</div>
                                        <div class="col-auto">{{ $payment->total ?? '' }} {{ getCurrency() }}
                                        </div>
                                    </div>
                                    <div class="row mb-50 align-items-center">
                                        <div class="col">{{ __('main.paid_amount') }}:</div>
                                       
                                        <div class="col-auto">{{ $Totpaid_amount ?? '' }} {{ getCurrency() }}</div>
                                    </div>
                                    <hr class="bg-light mt-1 mb-1">
                                    <div class="row align-items-center mb-2">
                                        <div class="col fw-bold">{{ __('main.balance_amount') }}:</div>
                                        <div class="col-auto fw-bolder text-secondary">
                                        {{ $balance ?? '' }} {{ getCurrency() }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <div class="">
                                        <label class="form-label">{{ __('main.paid_amount') }}</label>
                                        <div class="input-group">
                                            <input class="form-control" type="number" value=""
                                                placeholder="{{ __('main.paid_amount') }}"
                                                wire:model="paid_amount" />
                                            <span class="input-group-text">{{ getCurrency() }}</span>
                                        </div>
                                        @error('paid_amount')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <div class="">
                                        <label class="form-label">{{ __('main.payment_method') }}</label>
                                        <select required class="form-select" wire:model="pay_mode">
                                            <option value="">{{ __('main.select_a_method') }} </option>
                                            <option value="1">{{ __('main.cash') }}</option>
                                            <option value="2">{{ __('main.card') }}</option>
                                            <option value="3">{{ __('main.upi') }}</option>
                                            <option value="4">{{ __('main.cheque') }}</option>
                                            <option value="5">{{ __('main.bank_transfer') }}</option>
                                        </select>
                                        @error('pay_mode')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12 col-12">
                                    <div class="">
                                        <label class="form-label">{{ __('main.status') }}</label>
                                        <select required class="form-select" wire:model="status">
                                            <option value="3">{{ __('main.ready_to_deliver') }}</option>
                                            <option value="4">{{ __('main.delivered') }}</option>
                                        </select>
                                        @error('status')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-lg-12 col-12">
                                    <div class="">
                                        <label class="form-label">{{ __('main.reference') }}</label>
                                        <input class="form-control" wire:model="reference" value=""
                                            type="text" placeholder="{{ __('main.reference') }}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                       @endif
                   
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button"
                            data-bs-dismiss="modal">{{ __('main.cancel') }}</button>
                        <button class="btn btn-primary" type="submit"
                            wire:click.prevent="update">{{ __('main.submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="confirmdelete" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('main.status') }} </h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form>
                    <div class="modal-body text-center">
                        <div class="pb-4 pt-3">
                            <h5 class="mb-3">{{ __('main.are_you_sure') }}</h5>
                            <p class="mb-0 text-sm">{{ __('main.item_ready') }}</p>
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
</div>