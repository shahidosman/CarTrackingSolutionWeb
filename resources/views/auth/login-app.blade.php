@extends('layouts.login')
@section('content')
    <!-- begin:: Page -->
    <div class="m-grid m-grid--hor m-grid--root m-page">


        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-grid--tablet-and-mobile m-grid--hor-tablet-and-mobile m-login m-login--1 m-login--signin" id="m_login">
            <div class="m-grid__item m-grid__item--order-tablet-and-mobile-2 m-login__aside">
                <div class="m-stack m-stack--hor m-stack--desktop">
                    <div class="m-stack__item m-stack__item--fluid">

                        <div class="m-login__wrapper">

                            <div class="m-login__logo">
                                <a href="#">
                                    <img src="{{asset('css/images/app-logo.png')}}">
                                </a>
                            </div>

                            <div class="m-login__signin">
                                <div class="m-login__head">
                                    <h3 class="m-login__title">Sign In To Admin</h3>

                                </div>

                                <form class="m-login__form m-form" method="post" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group m-form__group">
                                        <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} m-input" type="text" placeholder="Email" name="email" value="{{ old('email') }}" autocomplete="off">
                                    </div>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" style="display: block"  role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                    <div class="form-group m-form__group">
                                        <input class="form-control m-input m-login__form-input--last" type="password" placeholder="Password" name="password">
                                    </div>
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                    <div class="row m-login__form-sub">
                                        <div class="col m--align-left">
                                            <label class="m-checkbox m-checkbox--focus">
                                                <input type="checkbox" name="remember"> Remember me
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="col m--align-right">
                                            <a href="javascript:;" id="m_login_forget_password" class="m-link">Forget Password ?</a>
                                        </div>
                                    </div>
                                    <div class="m-login__form-action">
                                        <button id="m_login_signin_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air">Sign In</button>
                                    </div>
                                </form>
                            </div>

                            <div class="m-login__forget-password">
                                <div class="m-login__head">
                                    <h3 class="m-login__title">Forgotten Password ?</h3>
                                    <div class="m-login__desc">Enter your email to reset your password:</div>
                                </div>
                                <form class="m-login__form m-form" action="">
                                    <div class="form-group m-form__group">
                                        <input class="form-control m-input" type="text" placeholder="Email" name="email" id="m_email" autocomplete="off">
                                    </div>
                                    <div class="m-login__form-action">
                                        <button id="m_login_forget_password_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air">Request</button>
                                        <button id="m_login_forget_password_cancel" class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="m-grid__item m-grid__item--fluid m-grid m-grid--center m-grid--hor m-grid__item--order-tablet-and-mobile-1	m-login__content m-grid-item--center" style="background-image: url({{asset('css/images/bg-4.jpg')}})">
                <div class="m-grid__item">
                    <h3 class="m-login__welcome">{{Config::get('constants.app-name')}}</h3>
                    <p class="m-login__msg">

                    </p>
                </div>
            </img>
        </div>
    </div>
@endsection