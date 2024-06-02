<div class="flex w-full items-center  justify-center shrink-0" x-data="cartHome" >
    <div class="flex w-[70rem]  pt-24 flex-col  lg:pb-10 ">
        <div class="lg:pt-8 p-2">
            <div class="flex justify-between items-center">
                <div class="font-bold text-primary text-2xl">{{__('main.cart')}}</div>
                <a href="{{ route('frontend') }}"
                    class="px-4 py-2 text-sm flex justify-center items-center gap-2 hover:bg-secondary/20 rounded-lg font-medium shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                        <path fill-rule="evenodd"
                            d="M20.25 12a.75.75 0 01-.75.75H6.31l5.47 5.47a.75.75 0 11-1.06 1.06l-6.75-6.75a.75.75 0 010-1.06l6.75-6.75a.75.75 0 111.06 1.06l-5.47 5.47H19.5a.75.75 0 01.75.75z"
                            clip-rule="evenodd" />
                    </svg>
                    {{__('main.frontend_home')}}
                </a>
            </div>
        </div>

        <div class="flex lg:flex-row flex-col gap-8 p-2">
            <div class="shadow-[0px_0px_30px_10px_#00000007]  flex flex-col rounded-lg w-full p-5 h-fit  grow-0 ">
                <div class=" font-semibold text-md  ">
                    {{__('main.delivery_details')}}<span class="text-red-400">*</span>
                </div>
                <div class="">
                    <div class="flex flex-col mt-2">
                        <label for="" class="text-sm">{{__('main.address')}} <span class="text-neutral-500">({{__('main.enter_your_full_address')}})</span>.</label>
                    </div>
                    <textarea name="address" id="" autocomplete="street-address"
                        class="border border-black/10 mt-2 rounded-lg p-2 w-full resize-none" rows="6"
                        placeholder="{{__('main.enter_your_full_address')}}" wire:model="address"></textarea>
                </div>
                @error('address') <span class="error text-xs text-red-500">{{ $message }}</span>@enderror
                <div class="grid lg:grid-cols-2 grid-cols-1 gap-4 mt-2 text-sm">
                    <div class="flex flex-col">
                        <label for="" class="text-sm">{{__('main.country')}}</label>
                        <input type="text" name="country" autocomplete="country" placeholder="{{__('main.enter_your_country')}}"
                            id="" class="border border-black/10  rounded-lg p-2 w-full resize-none"  wire:model="country">
                    </div>
                    <div class="flex flex-col">
                        <label for="" class="text-sm">{{__('main.state')}}</label>
                        <input type="text" name="state" autocomplete="state" id=""
                            placeholder="{{__('main.enter_your_state')}}"
                            class="border border-black/10  rounded-lg p-2 w-full resize-none"  wire:model="state">
                    </div>
                    <div class="flex flex-col">
                        <label for="" class="text-sm">{{__('main.city')}}</label>
                        <input type="text" name="city" autocomplete="city" id=""
                            placeholder="{{__('main.enter_your_city')}}"
                            class="border border-black/10  rounded-lg p-2 w-full resize-none"  wire:model="city">
                    </div>

                    <div class="flex flex-col">
                        <label for="" class="text-sm">{{__('main.zip_code')}}</label>
                        <input type="text" name="zipcode" autocomplete="zipcode" placeholder="{{__('main.enter_your_zip')}}"
                            id="" class="border border-black/10  rounded-lg p-2 w-full resize-none"  wire:model="zip_code">
                    </div>
                </div>
                <div class=" font-semibold text-md  mt-4 ">
                    {{__('main.preferred_delivery_time')}}<span class="text-red-400">*</span>
                </div>
                <div class="">
                    <input type="datetime-local" class="border border-black/10 mt-2 rounded-lg p-2 w-full"  wire:model="preferred_time">
                </div>
                @error('preferred_time') <span class="error text-xs text-red-500">{{ $message }}</span>@enderror
                <div class=" font-semibold text-md mt-4 ">
                    {{__('main.notes')}} <span class="font-normal text-sm"></span>
                </div>
                <div class="">
                    <textarea name="" id="" class="border border-black/10 mt-2 rounded-lg p-2 w-full resize-none"  wire:model="notes"
                        rows="6"></textarea>
                </div>
            </div>
            <div class="shadow-[0px_0px_30px_10px_#00000007] w-full lg:w-[40%] shrink-0 flex flex-col rounded-lg" >
                <div class="text-center font-semibold text-md py-5 ">
                    {{__('main.cart_items')}}
                </div>
                <div class=" flex flex-col gap-3 overflow-y-auto p-5 pt-0 pb-0 h-full">
                    @foreach ($itemList as $item)
                        <div
                            class="flex justify-between items-center border-b pb-4 border-neutral-100">
                            <div class="flex items-center">
                                <div class=" h-14 w-14 shrink-0 relative">
                                    @if ($item['image'] && file_exists(public_path($item['image'])))
                                    <img src="{{ $item['image'] }}" class=" object-cover h-full rounded-xl w-full">
                                    @else
                                        <img src="{{ asset('assets/images/sample.jpg') }}"
                                            class=" object-cover h-full rounded-xl w-full">
                                    @endif
                                    <div 
                                        class="absolute h-6 w-6 text-xs bg-primary rounded-full text-white flex justify-center items-center bottom-0 right-0 font-semibold">
                                        {{$item['quantity']}}</div>
                                </div>
                                <div class="flex-col px-3">
                                    <div class=" text-sm " >
                                        {{$item['name']}}
                                    </div>
                                    <div class="text-xs text-neutral-500 max-w-[10rem] truncate" >
                                        {{$item['notes'] ?? 'Add a note'}}
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 ">
                                <button title="Add Notes"  @click.prevent="showNote({{$item['id']}})"
                                    class="bg-secondary text-xs  rounded-full text-white font-semibold flex items-center justify-center p-2 gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="22" viewBox="0 -960 960 960"
                                        width="22" fill="currentColor">
                                        <path
                                            d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h360v80H200v560h560v-360h80v360q0 33-23.5 56.5T760-120H200Zm120-160v-80h320v80H320Zm0-120v-80h320v80H320Zm0-120v-80h320v80H320Zm360-80v-80h-80v-80h80v-80h80v80h80v80h-80v80h-80Z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        @endforeach
                 
                </div>
                <div class="border-t border-neutral-100 w-full p-5 flex flex-col pb-0">
                    <div class="border rounded-lg border-neutral-200 flex flex-col p-3 gap-3">
                        <div class="w-full  flex justify-between">
                            <div class="text-sm text-secondary">{{__('main.sub_total')}}</div>
                            <div class="text-sm font-medium text-primary" >{{getFormattedCurrency($subtotal)}}</div>
                        </div>
                        <div class="w-full   flex justify-between">
                            <div class="text-sm text-secondary">{{__('main.tax_total')}}</div>
                            <div class="text-sm font-medium text-primary" >{{getFormattedCurrency($tax_total)}}</div>
                        </div>

                        <div class="w-full   flex justify-between">
                            <div class="text-sm text-secondary">{{__('main.total')}}</div>
                            <div class="text-sm font-medium text-primary" >{{getFormattedCurrency($total)}}</div>
                        </div>
                    </div>
                </div>
                <div class="p-5 mt-1 flex gap-2 lg:flex-row flex-col">
                    <a href="#" wire:click="save" class=" w-full">
                        <button class="w-full px-5 py-3 rounded-lg bg-secondary text-white" wire:click="save"
                            >{{__('main.continue')}}</button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="" x-data="modalFunction" id="add-note">
        <div class="fixed h-screen w-screen bg-black/50 inset-0 z-[200] " x-cloak x-show="modalShown"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

        </div>
        <div class="fixed h-screen w-screen inset-0 z-[200] flex justify-center items-center" x-cloak
            x-show="modalShown" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90">
            <div class="z-[201] lg:w-[35rem] w-[90%] p-4 bg-white rounded-xl">
                <div class="h-full w-full flex flex-col">
                    <div class="flex justify-between items-center">
                        <div class="text-lg font-semibold tracking-wide text-primary">
                            {{__('main.add_note')}}
                        </div>
                        <button @click.prevent="$dispatch('hide-my-modal','add-note')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="font-light mt-3 text-sm">
                        <textarea name="" placeholder="Enter your notes" id="" class="border border-black/10 mt-2 rounded-lg p-2 w-full resize-none outline-none"
                        rows="6" x-model="notes"></textarea>
                    </div>
                    <div class="flex justify-start items-center mt-5 gap-4 flex-wrap lg:flex-nowrap">
                        <a href="#" @click.prevent="$dispatch('hide-my-modal','add-note')"
                            class="w-full px-5 py-3 rounded-lg border border-primary text-center">{{__('main.cancel')}}</a>
                        <a href="#" @click.prevent="saveNote($wire)"
                            class="w-full px-5 py-3 rounded-lg bg-secondary text-white text-center">{{__('main.add_note')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('head')
    <script defer>
        'use strict'
        function cartHome()
        {
            return{
                init()
                {
                    this.getProducts()
                },
                getProducts()
                {
                    this.$wire.getProducts().then((response) => {
                       this.$dispatch('get-products',response)
                    })
                },
            }
        }
    </script>
@endpush
