<div>
    <div class="page-body">
        <div class="container-fluid">
            <div class="row gx-3 mb-3 align-items-center">
                <div class="col">
                    <h5 class="mb-0">{{ __('main.customer_details') }}</h5>
                </div>
                <div class="col-auto">
                    <a data-bs-toggle="modal" data-bs-target="#addpaymentdiscount" class="btn btn-light px-2 text-primary"
                        type="button" wire:click="$emit('resetdiscount')">
                        <i class="fa fa-plus me-2"></i>{{ __('main.add_payment_discount') }}
                    </a>
                </div>
                <div class="col-auto">
                    <a href="{{ route('admin.add_payments') }}" class="btn btn-primary px-2" type="button">
                        <i class="fa fa-plus me-2"></i>{{ __('main.add_payment') }}
                    </a>
                </div>
                @if (Auth::user()->user_type != 2)
                    <div class="col-auto">
                        <a href="{{ route('admin.edit_customer', $customer_id) }}" class="btn btn-secondary px-2"
                            type="button">
                            <i class="fa fa-pencil-square-o me-2"></i>{{ __('main.edit') }}
                        </a>
                    </div>
                @endif
                <div class="col-auto">
                    <a href="{{ route('admin.customers') }}" class="btn btn-custom-primary px-2" type="button">
                        <i class="fa fa-arrow-left me-2"></i>{{ __('main.back') }}
                    </a>
                </div>
            </div>
            <div class="row gx-3">
                
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row g-2 mb-0">
                                <div class="col-auto">
                                    <a href="{{ route('admin.view_customer', $customer_id) }}" type="button"
                                        class="btn btn-nav-primary ">{{ __('main.invoice_list') }}</a>
                                </div>
                                <div class="col-auto">
                                    <a href="{{ route('admin.view_customer_payments', $customer_id) }}" type="button"
                                        class="btn btn-nav-primary">{{ __('main.payments_list') }}</a>
                                </div>
                                <div class="col-auto">
                                    <a href="{{ route('admin.view_customer_measurement', $customer_id) }}"
                                        type="button"
                                        class="btn btn-nav-primary">{{ __('main.add_measurement') }}</a>
                                </div>
                                <div class="col-auto" style="display:none;">
                                    <a href="{{ route('admin.view_customer_discount', $customer_id) }}" type="button"
                                        class="btn btn-nav-primary">{{ __('main.payment_discount') }}</a>
                                </div>
                                <div class="col-auto">
                                    <a href="{{ route('admin.view_customer_discount', $customer_id) }}"
                                        type="button"
                                        class="btn btn-nav-primary active">{{ __('main.measurements') }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive mt-0">
                            <table class="table">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-primary w-table-15" scope="col">
                                            {{ __('main.nos') }}</th>
                                        <th class="text-primary w-table-20" scope="col">
                                            {{ __('main.measurements') }}</th>
                                        <th class="text-primary w-table-20" scope="col">
                                            {{ __('main.measurement_unit') }}</th>
                                        <th class="text-primary w-table-30" scope="col">
                                            {{ __('main.value') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="table-responsive mt-0 customer-view-scroll">
                            <table class="table">
                                <tbody>
                            @php
                            $measurementDetails = \App\Models\CustomerMeasurementDetail::where('customer_id',$customer_id)->get();
                            @endphp
                                    @foreach($measurementDetails as $key => $details)
                                    <tr>
                                            <th class="w-table-15">
                                                <div class="mb-0 ">#{{ $key + 1}}</div>
                                            </th>
                                            <td class="w-table-20">
                                               {{$details->attributes['name']}}
                                            </td>
                                            <td class="w-table-20">
                                            {{$details->getUnit()}}
                                            </td>
                                            <td class="w-table-30">
                                            {{$details->value}}
                                            </td>
                                            
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if ($hasMorePages)
                                <div x-data="{
                                    init() {
                                        let observer = new IntersectionObserver((entries) => {
                                            entries.forEach(entry => {
                                                if (entry.isIntersecting) {
                                                    @this.call('loadPayments')
                                                    console.log('loading...')
                                                }
                                            })
                                        }, {
                                            root: null
                                        });
                                        observer.observe(this.$el);
                                    }
                                }"
                                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mt-4">
                                    <div class="text-center pb-2 d-flex justify-content-center align-items-center">
                                        Loading...
                                        <div class="spinner-grow d-inline-flex mx-2 text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @livewire('components.customer-discount', ['id' => $customer_id])
</div>