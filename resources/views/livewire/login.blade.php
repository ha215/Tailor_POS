<div class="bg-login" x-data="alpineLogin">
    <section>
        <div class="container-fluid ">
            <div class="row" >
                <div class="col-xl-5" wire:ignore> <img class="bg-img-cover bg-center" src="assets/images/login/3.png" alt="looginpage" /></div>
                <div class="col-xl-7 p-0" >
                    <div class="login-card" >
                        <form class="theme-form login-form" x-cloak x-show="show == 1">
                            <h4 class="mb-2">{{$lang->data['welcome_back']??"Welcome Back!"}} </h4>
                            <h6>{{ __('main.log_in_to_your_account_to_continue') }} </h6>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <div class="form-group">
                                <label>{{ __('main.email_address') }} </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                    <input class="form-control" type="email" placeholder="{{ __('main.enter_mail_id') }}" wire:model="email">
                                </div>
                                @error('email') <span class="error text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label>{{ __('main.password') }} </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa fa-key"></i></span>
                                    <input class="form-control" type="password" name="login[password]" required="" placeholder="{{ __('main.enter_password') }}" wire:model="password">
                                </div>
                                @error('password') <span class="error text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="text-left mb-4">
                                @if($forget_password)
                                <a class="text-secondary fw-bold" href="#" @click="showForgetPassword">{{ __('main.forget_password') }} </a>
                                @endif
                            </div>
                            @if (session()->has('error'))
                            <div class="text-left mb-4">
                                <span class="error text-danger">
                                    {{ session('error') }}
                                </span>
                            </div>
                            @endif
                            @error('login_error') <span class="error mb-4 text-danger">{{$message}}</span> @enderror
                            <div class="form-group pb-4">
                                <a class="btn btn-primary btn-block" wire:click.prevent="login()">{{$lang->data['login']??"Login"}} </a>
                            </div>
                            <div class="login-social-title text-center">
                                <h5>{{ __('main.powered_by') }} <div>{{getApplicationName()}}</div> </h5>
                            </div>
                        </form>
                        <form class="theme-form login-form" x-cloak x-show="show == 2">
                            <h4 class="mb-2">{{__('main.forgot_password')}} </h4>
                            <h6>{{ __('main.forget_password_info') }} </h6>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <div class="form-group">
                                <label>{{ __('main.email_address') }} </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                    <input class="form-control" type="email" placeholder="{{ __('main.enter_mail_id') }}" wire:model="email">
                                </div>
                                @error('email') <span class="error text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="text-left mb-4">
                                <a class="text-secondary fw-bold" href="#" @click="showLogin">{{ __('main.i_remember_password') }} </a>
                            </div>
                            @if (session()->has('error'))
                            <div class="text-left mb-4">
                                <span class="error text-danger">
                                    {{ session('error') }}
                                </span>
                            </div>
                            @endif
                            @if($success) <div class=" mb-2 text-success">{{__('main.reset_mail_sent')}}</div> @endif
                            @error('login_error') <span class="error mb-4 text-danger">{{$message}}</span> @enderror
                            <div class="form-group pb-4">
                                <a class="btn btn-primary btn-block" wire:click.prevent="forgotpassword()">{{ __('main.reset_password')}} </a>
                            </div>
                             @php
                             $settings = new App\Models\MasterSetting();
            
                             $site = $settings->siteData();
                             @endphp
                            <div class="login-social-title text-center">
                                <h5>{{ __('main.powered_by') }} <div>{{ isset($site['company_name']) && !empty($site['company_name']) ? $site['company_name'] : '' }}</div> </h5>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        function alpineLogin()
        {
        "use strict";
            return{
                show : 1,
                init()
                {
                },
                showLogin()
                {
                    this.show = 1;
                },
                showForgetPassword()
                {
                    this.show = 2;
                }
            }
        }
    </script>
</div>