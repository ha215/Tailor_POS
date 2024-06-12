<div>
    <div class="page-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row gx-3 mb-0">
                                <div class="col mb-4">
                                    <h5 class="mb-0">{{ __('main.products') }}</h5>
                                </div>
                                <div class="col-auto mb-4">
                                    <a data-bs-toggle="modal" data-bs-target="#addproduct" class="btn btn-primary px-2" type="button" >
                                        <i class="fa fa-plus me-2"></i>{{ __('main.add_new_product') }}
                                    </a>
                                </div>
                                <div class="col-12">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa fa-search"></i></span>
                                        <input class="form-control" type="text" placeholder="{{ __('main.search_here') }}" wire:model="search" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive mt-0">
                            <table class="table">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-primary" scope="col"># </th>
                                        <th class="text-primary" scope="col">{{ __('main.item_code') }}</th>
                                        <th class="text-primary" scope="col">{{ __('main.product_name') }}</th>
                                        <th class="text-primary" scope="col">{{ __('main.stitching_cost') }}</th>
                                        <th class="text-primary" scope="col">{{ __('main.status') }} </th>
                                        <th class="text-primary" scope="col">{{ __('main.actions') }} </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($products)
                                    @foreach($products as $row)
                                    <tr>
                                        <th scope="row">{{$loop->index+1}}</th>
                                        <th scope="row">{{$row->item_code ? $row->item_code : '-'}}</th>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($row->image && file_exists(public_path($row->image)))
                                                <img src="{{$row->image}}" class="img-50 rounded max-h-invoice-image">
                                                @else
                                                <img src="{{asset('assets/images/sample.jpg')}}" class="img-50 rounded max-h-invoice-image">
                                                @endif
                                                <div class="ms-2 mb-0 fw-bold">
                                                    <div class="mb-0">{{$row->name}}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            {{getFormattedCurrency($row->stitching_cost)}}
                                        </td>
                                        <td>
                                        @if(Auth::user()->user_type == 3)
                                            @if(Auth::user()->id == $row->created_by)
                                            <div class="media-body switch-lg">
                                                <label class="switch" id="active">
                                                    <input id="active" type="checkbox" @if($row->is_active==1) checked @endif wire:click="toggle({{$row->id}})"/><span class="switch-state"></span>
                                                </label>
                                            </div>
                                            @endif
                                            @endif
                                            @if(Auth::user()->user_type == 2)
                                            <div class="media-body switch-lg">
                                                <label class="switch" id="active">
                                                    <input id="active" type="checkbox" @if($row->is_active==1) checked @endif wire:click="toggle({{$row->id}})"/><span class="switch-state"></span>
                                                </label>
                                            </div>
                                            @endif

                                            
                                        </td>
                                        <td>
                                             <button class="btn btn-primary edit-product" data-id="{{ $row->id }}" data-bs-toggle="modal" data-bs-target="#editproduct" class="btn btn-primary px-2"><i class="fa fa-pencil-square-o me-2"></i>{{ __('main.edit') }}</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        @if(count($products) == 0)
                        <x-empty-item-component :title="__('main.empty_item_title')" />
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div  class="modal fade" id="addproduct" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('main.add_product') }} </h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form enctype="multipart/form-data" action="{{ route('products.save') }}" method="POST" >
                     {!! csrf_field() !!}
                    <div class="modal-body pb-1">
                        <div class="mb-3">
                            <label class="form-label">{{ __('main.product_image') }} (300X300 px)</label>
                            <input type="file" class="form-control" name="image" id="" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('main.product_name') }} <span class="text-danger">*</span> </label>
                            <input type="text" required class="form-control" placeholder="{{ __('main.enter_product_name') }}" name="name">
                            @error('name') <span class="error text-danger">{{ $message }}</span>@enderror
                        </div>
                         @php
                            $pdtCount = \App\Models\Product::count();
                            $itemNum = str_pad($pdtCount+1, 3, '0', STR_PAD_LEFT);
                            @endphp
                        <div class="mb-3" style="display:none;">
                            <label class="form-label">{{ __('main.item_code') }}</label>
                            <input type="text"  class="form-control" placeholder="{{ __('main.enter_item_code') }}"  name="item_code">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('main.stitching_cost') }} <span class="text-danger">*</span> </label>
                            <div class="input-group">
                                <input class="form-control" required type="number" placeholder="{{ __('main.enter_amount') }}" name="stitching_cost">
                                <span class="input-group-text">{{getCurrency()}} / Nos</span>
                            </div>
                            @error('stitching_cost') <span class="error text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('main.description') }} </label>
                                <textarea class="form-control"  type="number" placeholder="{{ __('main.description') }}" name="description" rows="5"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-4" style="display:none;">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('main.is_featured') }}</label>
                                    <div class="media-body switch-lg">
                                        <label class="switch" id="feature">
                                            <input id="feature" type="checkbox" name="is_featured" /><span class="switch-state"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-0">
                                    <label class="form-label">{{ __('main.is_active') }}</label>
                                    <div class="media-body switch-lg">
                                        <label class="switch" id="active">
                                            <input id="active" type="checkbox" name="is_active" /><span class="switch-state"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">{{ __('main.cancel') }}</button>
                        <button class="btn btn-primary" type="submit" >{{ __('main.submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div  class="modal fade" id="editproduct" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('main.edit_product') }} </h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form enctype="multipart/form-data" action="{{ route('products.update') }}" method="POST" >{!! csrf_field() !!}
                    <div class="modal-body pb-1">
                        <div class="mb-3">
                            <label class="form-label">{{ __('main.product_image') }} (300X300 px)</label>
                            <input type="file" class="form-control" name="image" id="" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('main.product_name') }} <span class="text-danger">*</span> </label>
                            <input type="text" required class="form-control" placeholder="{{ __('main.enter_product_name') }}" name="name" id="name">
                            @error('name') <span class="error text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('main.item_code') }}</label>
                            <input type="text" required class="form-control" placeholder="{{ __('main.enter_item_code') }}" name="item_code" id="item_code">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('main.stitching_cost') }} <span class="text-danger">*</span> </label>
                            <div class="input-group">
                                <input class="form-control" required type="number" placeholder="{{ __('main.enter_amount') }}" name="stitching_cost" id="stitching_cost">
                                 <input class="form-control"  type="hidden" placeholder="" name="editId" id="editId">
                                <span class="input-group-text">{{getCurrency()}} / Nos</span>
                            </div>
                            @error('stitching_cost') <span class="error text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('main.description') }}  </label>
                                <textarea class="form-control"  type="number" placeholder="{{ __('main.description') }}" name="description" id="description" rows="5"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-4" style="display:none;">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('main.is_featured') }}</label>
                                    <div class="media-body switch-lg">
                                        <label class="switch" id="feature">
                                            <input id="feature" type="checkbox" name="is_featured" id="is_featured" /><span class="switch-state"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4" style="display:none;">
                                <div class="mb-0">
                                    <label class="form-label">{{ __('main.is_active') }}</label>
                                    <div class="media-body switch-lg">
                                        <label class="switch" id="active">
                                            <input id="active" type="checkbox" name="is_active" id="is_active" /><span class="switch-state"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">{{ __('main.cancel') }}</button>
                        <button class="btn btn-primary" type="submit" >{{ __('main.submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@push('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.edit-product').on('click', function() {
            var productId = $(this).data('id');

            // Fetch the product details using AJAX
            $.ajax({
                url: '/admin/inventory/products/' + productId + '/edit',
                type: 'GET',
                success: function(response) {
                    $('#editId').val(response.id);
                    $('#name').val(response.name);
                    $('#stitching_cost').val(response.stitching_cost);
                    $('#item_code').val(response.item_code);
                    $('#description').val(response.description);
                    $('#is_featured').prop('checked', response.is_featured);
                   if(response.is_active == 0){
                       $('#is_active').prop('checked', false); 
                   }else{
                       $('#is_active').prop('checked', true);
                   }
                    
                    $('#editproduct').modal('show');
                }
            });
        });
    });
</script>

@endpush
    
</div>
