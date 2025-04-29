

    @section('title')
    Login ERP
@stop

<x-guest-layout>
    @extends('layouts.master2')



    @section('css')
        <!-- Sidemenu-respoansive-tabs css -->
        <link href="{{ URL::asset('assets/plugins/sidemenu-responsive-tabs/css/sidemenu-responsive-tabs.css') }}"
            rel="stylesheet">
    @endsection
    @section('content')
        <div class="container-fluid">
            <div class="row no-gutter">
                <!-- The image half -->
                <div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent">
                    <div class="row wd-100p mx-auto text-center">
                        <div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
                            <img src="{{ URL::asset('assets/img/media/login.png') }}"
                                class="my-auto ht-xl-80p wd-md-100p wd-xl-80p mx-auto" alt="logo">
                        </div>
                    </div>
                </div>
                <!-- The content half -->
                <div class="col-md-6 col-lg-6 col-xl-5 bg-white">
                    <div class="login d-flex align-items-center py-2">
                        <!-- Demo content-->
                        <div class="container p-0">
                            <div class="row">
                                <div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
                                    <div class="card-sigin">
                                        <div class="mb-5 d-flex"> <a href="{{ url('/' . ($page = 'index')) }}"><img
                                                    src="{{ URL::asset('assets/img/brand/favicon.png') }}"
                                                    class="sign-favicon ht-40" alt="logo"></a>
                                            <h1 class="main-logo1 ml-1 mr-0 my-auto tx-28">E<span>R</span>B</h1>
                                        </div>
                                        <div class="card-sigin">
                                            <div class="main-signup-header">
                                                <h2>Welcome back!</h2>
                                                <h5 class="font-weight-semibold mb-4">Please sign in to continue.</h5>
                                                <form action="{{ url('login') }}" method="POST">
                                                    @csrf
                                                    <div>
                                                        <x-input-label for="email" :value="__('Email')" />
                                                        <x-text-input id="email" class="block mt-1 w-full"
                                                            type="email" name="email" :value="old('email')" required
                                                            autofocus autocomplete="username" />
                                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                                    </div>
                                                    <div class="form-group">
                                                        <x-input-label for="password" :value="__('Password')" />

                                                        <x-text-input id="password" class="block mt-1 w-full"
                                                            type="password" name="password" required
                                                            autocomplete="current-password" />

                                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                                    </div>

                                                    <button class="btn btn-main-primary btn-block">Sign In</button>
                                                    <div class="row row-xs">
                                                        <!-- Remember Me -->
                                                        <div class="block mt-1">
                                                            <label for="remember_me" class="inline-flex items-center">
                                                                <input id="remember_me" type="checkbox"
                                                                    class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                                                                    name="remember">
                                                                <span
                                                                    class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                                                            </label>
                                                        </div>

                                                        <div class="flex items-center justify-end mt-4">


                                                            {{-- <div class="col-sm-6">
                                                        <button class="btn btn-block"><i class="fab fa-facebook-f"></i>
                                                            Signup with Facebook</button>
                                                    </div>
                                                    <div class="col-sm-6 mg-t-10 mg-sm-t-0">
                                                        <button class="btn btn-info btn-block"><i
                                                                class="fab fa-twitter"></i> Signup with Twitter</button>
                                                    </div> --}}
                                                        </div>
                                                </form>
                                                {{-- <div class="main-signin-footer mt-5">
                                                <p><a href="{{ url('/' . ($page = 'forgot-password')) }}">Forgot 
                                                        password?</a></p>
                                           <p>Don't have an account? <a
                                                        href="{{ url('/' . ($page = 'signup')) }}">Create
                                                        an Account</a></p> 
                                            </div>
                                        </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- End -->
                        </div>
                    </div><!-- End -->
                </div>
            </div>
        @endsection
        @section('js')
        @endsection
</x-guest-layout>
