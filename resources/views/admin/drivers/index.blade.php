@extends('layouts.admin-app')
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop
@section('content')
    <div class="m-grid m-grid--hor m-grid--root m-page">
        @include('layouts.header')
        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
            @include('layouts.sidebar')
            <div class="m-grid__item m-grid__item--fluid m-wrapper">

                <!-- BEGIN: Subheader -->
                <div class="m-subheader ">
                    <div class="d-flex align-items-center">
                        <div class="mr-auto">
                            <h3 class="m-subheader__title m-subheader__title--separator">{{Config('constants.drivers')}}</h3>
                            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                                <li class="m-nav__item m-nav__item--home">
                                    <a href="{{url('/admin/dashboard')}}" class="m-nav__link m-nav__link--icon">
                                        <i class="m-nav__link-icon la la-home"></i>
                                    </a>
                                </li>
                                <li class="m-nav__item">
                                    <a href="" class="m-nav__link">
                                        <span class="m-nav__link-text"></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div>
  							<span class="m-subheader__daterange" id="m_dashboard_daterangepicker">
					<span class="m-subheader__daterange-label">
						<span class="m-subheader__daterange-title"></span>
						<span class="m-subheader__daterange-date m--font-brand"></span>
					</span>
					<a href="#" class="btn btn-sm btn-brand m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill">
						<i class="la la-angle-down"></i>
					</a>
				</span>
                        </div>
                    </div>
                </div>
                <div class="m-content">
                    <div class="row">
                        <div class="col-md-12">
                            <!--begin::Portlet-->
                            <div class="m-portlet m-portlet--tab">
                                <div class="m-portlet__head">
                                    <div class="m-portlet__head-caption">
                                        <div class="m-portlet__head-title">
						<span class="m-portlet__head-icon m--hide">
						<i class="la la-gear"></i>
						</span>
                                            <h3 class="m-portlet__head-text">
                                                Driver Registration Form
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                <!--begin::Form-->
                                <form class="m-form m-form--fit m-form--label-align-right" method="post" action="{{url('admin/drivers')}}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $existing == null ? '' : $existing->id }}">
                                    <div class="m-portlet__body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group m-form__group">
                                                    <label for="fname">First Name</label>
                                                    <input type="text" name="fname" value="{{ $existing == null ? old('fname') : $existing->fname }}" class="form-control m-input" id="fname" aria-describedby="emailHelp" placeholder="Enter First Name">
                                                </div>
                                                @if ($errors->has('fname'))
                                                    <span class="invalid-feedback" style="display: block"  role="alert">
                                                        <strong>{{ $errors->first('fname') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group m-form__group">
                                                    <label for="fname">Last Name</label>
                                                    <input type="text" name="lname" value="{{ $existing == null ? old('lname') : $existing->lname }}" class="form-control m-input" id="lname" aria-describedby="emailHelp" placeholder="Enter Last Name">
                                                </div>
                                                @if ($errors->has('lname'))
                                                    <span class="invalid-feedback" style="display: block"  role="alert">
                                                        <strong>{{ $errors->first('lname') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group m-form__group">
                                                    <label for="email">Email</label>
                                                    <input type="text" name="email" value="{{ $existing == null ? old('email') : $existing->email }}" class="form-control m-input" id="email" aria-describedby="emailHelp" placeholder="Enter Email">
                                                </div>
                                                @if ($errors->has('email'))
                                                    <span class="invalid-feedback" style="display: block"  role="alert">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group m-form__group">
                                                    <label for="phone_number">Phone Number</label>
                                                    <input type="text" name="phone_number" value="{{ $existing == null ? old('phone_number') : $existing->phone_number }}" class="form-control m-input" id="phone_num" aria-describedby="emailHelp" placeholder="Enter Phone Number">
                                                </div>
                                                @if ($errors->has('phone_number'))
                                                    <span class="invalid-feedback" style="display: block"  role="alert">
                                                        <strong>{{ $errors->first('phone_number') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group m-form__group">
                                                    <label for="license">License Number</label>
                                                    <input type="text" name="license" value="{{ $existing == null ? old('license') : $existing->license }}" class="form-control m-input" id="license" aria-describedby="emailHelp" placeholder="Enter License Number">
                                                </div>
                                                @if ($errors->has('license'))
                                                    <span class="invalid-feedback" style="display: block"  role="alert">
                                                        <strong>{{ $errors->first('license') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group m-form__group">
                                                    <label for="city">City</label>
                                                    <input type="text" name="city" value="{{ $existing == null ? old('city') : $existing->city }}" class="form-control m-input" id="city" aria-describedby="emailHelp" placeholder="Enter City Name">
                                                </div>
                                                @if ($errors->has('city'))
                                                    <span class="invalid-feedback" style="display: block"  role="alert">
                                                        <strong>{{ $errors->first('city') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group m-form__group">
                                                    <label for="country">Country</label>
                                                    <input type="text" name="country" value="{{ $existing == null ? old('country') : $existing->country }}" class="form-control m-input" id="country" aria-describedby="emailHelp" placeholder="Enter Country">
                                                </div>
                                                @if ($errors->has('country'))
                                                    <span class="invalid-feedback" style="display: block"  role="alert">
                                                        <strong>{{ $errors->first('country') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group m-form__group">
                                                    <label for="phone_num">address</label>
                                                    <input type="text" name="address" value="{{ $existing == null ? old('address') : $existing->address }}" class="form-control m-input" id="address" aria-describedby="emailHelp" placeholder="Enter Street Address">
                                                </div>
                                                @if ($errors->has('address'))
                                                    <span class="invalid-feedback" style="display: block"  role="alert">
                                                        <strong>{{ $errors->first('address') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group m-form__group">
                                                    <label for="zip">Zip Code</label>
                                                    <input type="text" name="zip" value="{{ $existing == null ? old('zip') : $existing->zip }}" class="form-control m-input" id="zip" aria-describedby="emailHelp" placeholder="Enter Zip Code">
                                                </div>
                                                @if ($errors->has('zip'))
                                                    <span class="invalid-feedback" style="display: block"  role="alert">
                                                        <strong>{{ $errors->first('zip') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group m-form__group">
                                                    <label for="profile_image">Profile Image</label>
                                                    <input type="file" name="profile_image" class="form-control m-input" id="profile_image" >
                                                </div>
                                                @if ($errors->has('profile_image'))
                                                    <span class="invalid-feedback" style="display: block"  role="alert">
                                                        <strong>{{ $errors->first('profile_image') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group m-form__group">
                                                    <label for="country">License Image</label>
                                                    <input type="file" name="license_image" class="form-control m-input" id="profile_image">
                                                </div>
                                                @if ($errors->has('license_image'))
                                                    <span class="invalid-feedback" style="display: block"  role="alert">
                                                        <strong>{{ $errors->first('license_image') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="m-portlet__foot m-portlet__foot--fit">
                                        <div class="m-form__actions">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                            <button type="reset" class="btn btn-secondary">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Portlet-->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="m-portlet m-portlet--mobile">
                                <div class="m-portlet__body">
                                    <!--begin: Datatable -->
                                    <table class="table table-striped- table-bordered table-hover table-checkable responsive no-wrap" id="data">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>License Image</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Phone Num</th>
                                            <th>License Num</th>
                                            <th>City</th>
                                            <th>Country</th>
                                            <th>Address</th>
                                            <th>Zip</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <?php $i = 0; ?>
                                        @foreach($record as $item)
                                            <tr>
                                                {{ $i++ }}
                                                <td>
                                                    {{ $i }}
                                                </td>
                                                <td>
                                                    <a href="{{asset('css/uploads/'.$item->license_image)}}" target="_blank">
                                                        Download Image
                                                    </a>
                                                </td>
                                                <td>
                                                    <img src="{{asset('css/uploads/'.$item->profile_image)}}" style="width: 41px; height: 41px; border-radius: 50%" />
                                                    {{$item->fname}}
                                                </td>
                                                <td>
                                                    {{$item->lname}}
                                                </td>
                                                <td>
                                                    {{$item->email}}
                                                </td>
                                                <td>
                                                    {{$item->phone_number}}
                                                </td>
                                                <td>
                                                    {{$item->license}}
                                                </td>
                                                <td>
                                                    {{$item->city}}
                                                </td>
                                                <td>
                                                    {{$item->country}}
                                                </td>
                                                <td>
                                                    {{$item->address}}
                                                </td>
                                                <td>
                                                    {{$item->zip}}
                                                </td>
                                                <td>
                                                    <a class="btn btn-primary" href="{{route('drivers.edit',['driver' => $item->id])}}" role="button">Edit</a>
                                                    <button onclick="return Confirm({{$item->id}});" class="btn btn-danger">Delete</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- END: Subheader -->		                      <!--Begin::Section-->
                <!--End::Section-->

                <!--Begin::Section-->
                <!--End::Section-->

                <!--Begin::Section-->
                <!--End::Section-->

                <!--Begin::Section-->
                <!--End::Section-->

                <!--Begin::Section-->
                <!--End::Section-->

                <!--Begin::Section-->
                <!--End::Section-->

                <!--Begin::Section-->
                <!--End::Section-->
            </div>

        </div>

        @include('layouts.footer')
    </div>
    <!-- begin::Quick Sidebar -->
    <div id="m_quick_sidebar" class="m-quick-sidebar m-quick-sidebar--tabbed m-quick-sidebar--skin-light">
        <div class="m-quick-sidebar__content m--hide">
            <span id="m_quick_sidebar_close" class="m-quick-sidebar__close"><i class="la la-close"></i></span>
            <ul id="m_quick_sidebar_tabs" class="nav nav-tabs m-tabs m-tabs-line m-tabs-line--brand" role="tablist">
                <li class="nav-item m-tabs__item">
                    <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_quick_sidebar_tabs_messenger" role="tab">Messages</a>
                </li>
                <li class="nav-item m-tabs__item">
                    <a class="nav-link m-tabs__link" 		data-toggle="tab" href="#m_quick_sidebar_tabs_settings" role="tab">Settings</a>
                </li>
                <li class="nav-item m-tabs__item">
                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_quick_sidebar_tabs_logs" role="tab">Logs</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="m_quick_sidebar_tabs_messenger" role="tabpanel">
                    <div class="m-messenger m-messenger--message-arrow m-messenger--skin-light">
                        <div class="m-messenger__messages m-scrollable">
                            <div class="m-messenger__wrapper">
                                <div class="m-messenger__message m-messenger__message--in">
                                    <div class="m-messenger__message-pic">
                                        <img src="assets/app/media/img//users/user3.jpg" alt=""/>
                                    </div>
                                    <div class="m-messenger__message-body">
                                        <div class="m-messenger__message-arrow"></div>
                                        <div class="m-messenger__message-content">
                                            <div class="m-messenger__message-username">
                                                Megan wrote
                                            </div>
                                            <div class="m-messenger__message-text">
                                                Hi Bob. What time will be the meeting ?
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-messenger__wrapper">
                                <div class="m-messenger__message m-messenger__message--out">
                                    <div class="m-messenger__message-body">
                                        <div class="m-messenger__message-arrow"></div>
                                        <div class="m-messenger__message-content">
                                            <div class="m-messenger__message-text">
                                                Hi Megan. It's at 2.30PM
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-messenger__wrapper">
                                <div class="m-messenger__message m-messenger__message--in">
                                    <div class="m-messenger__message-pic">
                                        <img src="assets/app/media/img//users/user3.jpg" alt=""/>
                                    </div>
                                    <div class="m-messenger__message-body">
                                        <div class="m-messenger__message-arrow"></div>
                                        <div class="m-messenger__message-content">
                                            <div class="m-messenger__message-username">
                                                Megan wrote
                                            </div>
                                            <div class="m-messenger__message-text">
                                                Will the development team be joining ?
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-messenger__wrapper">
                                <div class="m-messenger__message m-messenger__message--out">
                                    <div class="m-messenger__message-body">
                                        <div class="m-messenger__message-arrow"></div>
                                        <div class="m-messenger__message-content">
                                            <div class="m-messenger__message-text">
                                                Yes sure. I invited them as well
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-messenger__datetime">2:30PM</div>
                            <div class="m-messenger__wrapper">
                                <div class="m-messenger__message m-messenger__message--in">
                                    <div class="m-messenger__message-pic">
                                        <img src="assets/app/media/img//users/user3.jpg"  alt=""/>
                                    </div>
                                    <div class="m-messenger__message-body">
                                        <div class="m-messenger__message-arrow"></div>
                                        <div class="m-messenger__message-content">
                                            <div class="m-messenger__message-username">
                                                Megan wrote
                                            </div>
                                            <div class="m-messenger__message-text">
                                                Noted. For the Coca-Cola Mobile App project as well ?
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-messenger__wrapper">
                                <div class="m-messenger__message m-messenger__message--out">
                                    <div class="m-messenger__message-body">
                                        <div class="m-messenger__message-arrow"></div>
                                        <div class="m-messenger__message-content">
                                            <div class="m-messenger__message-text">
                                                Yes, sure.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-messenger__wrapper">
                                <div class="m-messenger__message m-messenger__message--out">
                                    <div class="m-messenger__message-body">
                                        <div class="m-messenger__message-arrow"></div>
                                        <div class="m-messenger__message-content">
                                            <div class="m-messenger__message-text">
                                                Please also prepare the quotation for the Loop CRM project as well.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-messenger__datetime">3:15PM</div>
                            <div class="m-messenger__wrapper">
                                <div class="m-messenger__message m-messenger__message--in">
                                    <div class="m-messenger__message-no-pic m--bg-fill-danger">
                                        <span>M</span>
                                    </div>
                                    <div class="m-messenger__message-body">
                                        <div class="m-messenger__message-arrow"></div>
                                        <div class="m-messenger__message-content">
                                            <div class="m-messenger__message-username">
                                                Megan wrote
                                            </div>
                                            <div class="m-messenger__message-text">
                                                Noted. I will prepare it.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-messenger__wrapper">
                                <div class="m-messenger__message m-messenger__message--out">
                                    <div class="m-messenger__message-body">
                                        <div class="m-messenger__message-arrow"></div>
                                        <div class="m-messenger__message-content">
                                            <div class="m-messenger__message-text">
                                                Thanks Megan. I will see you later.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-messenger__wrapper">
                                <div class="m-messenger__message m-messenger__message--in">
                                    <div class="m-messenger__message-pic">
                                        <img src="assets/app/media/img//users/user3.jpg"  alt=""/>
                                    </div>
                                    <div class="m-messenger__message-body">
                                        <div class="m-messenger__message-arrow"></div>
                                        <div class="m-messenger__message-content">
                                            <div class="m-messenger__message-username">
                                                Megan wrote
                                            </div>
                                            <div class="m-messenger__message-text">
                                                Sure. See you in the meeting soon.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="m-messenger__seperator"></div>

                        <div class="m-messenger__form">
                            <div class="m-messenger__form-controls">
                                <input type="text" name="" placeholder="Type here..." class="m-messenger__form-input">
                            </div>
                            <div class="m-messenger__form-tools">
                                <a href="" class="m-messenger__form-attachment">
                                    <i class="la la-paperclip"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="m_quick_sidebar_tabs_settings" role="tabpanel">
                    <div class="m-list-settings m-scrollable">
                        <div class="m-list-settings__group">
                            <div class="m-list-settings__heading">General Settings</div>
                            <div class="m-list-settings__item">
                                <span class="m-list-settings__item-label">Email Notifications</span>
                                <span class="m-list-settings__item-control">
							<span class="m-switch m-switch--outline m-switch--icon-check m-switch--brand">
							<label>
							<input type="checkbox" checked="checked" name="">
							<span></span>
							</label>
							</span>
							</span>
                            </div>
                            <div class="m-list-settings__item">
                                <span class="m-list-settings__item-label">Site Tracking</span>
                                <span class="m-list-settings__item-control">
							<span class="m-switch m-switch--outline m-switch--icon-check m-switch--brand">
							<label>
							<input type="checkbox" name="">
							<span></span>
							</label>
							</span>
							</span>
                            </div>
                            <div class="m-list-settings__item">
                                <span class="m-list-settings__item-label">SMS Alerts</span>
                                <span class="m-list-settings__item-control">
							<span class="m-switch m-switch--outline m-switch--icon-check m-switch--brand">
							<label>
							<input type="checkbox" name="">
							<span></span>
							</label>
							</span>
							</span>
                            </div>
                            <div class="m-list-settings__item">
                                <span class="m-list-settings__item-label">Backup Storage</span>
                                <span class="m-list-settings__item-control">
							<span class="m-switch m-switch--outline m-switch--icon-check m-switch--brand">
							<label>
							<input type="checkbox" name="">
							<span></span>
							</label>
							</span>
							</span>
                            </div>
                            <div class="m-list-settings__item">
                                <span class="m-list-settings__item-label">Audit Logs</span>
                                <span class="m-list-settings__item-control">
							<span class="m-switch m-switch--outline m-switch--icon-check m-switch--brand">
							<label>
							<input type="checkbox" checked="checked" name="">
							<span></span>
							</label>
							</span>
							</span>
                            </div>
                        </div>
                        <div class="m-list-settings__group">
                            <div class="m-list-settings__heading">System Settings</div>
                            <div class="m-list-settings__item">
                                <span class="m-list-settings__item-label">System Logs</span>
                                <span class="m-list-settings__item-control">
							<span class="m-switch m-switch--outline m-switch--icon-check m-switch--brand">
							<label>
							<input type="checkbox" name="">
							<span></span>
							</label>
							</span>
							</span>
                            </div>
                            <div class="m-list-settings__item">
                                <span class="m-list-settings__item-label">Error Reporting</span>
                                <span class="m-list-settings__item-control">
							<span class="m-switch m-switch--outline m-switch--icon-check m-switch--brand">
							<label>
							<input type="checkbox" name="">
							<span></span>
							</label>
							</span>
							</span>
                            </div>
                            <div class="m-list-settings__item">
                                <span class="m-list-settings__item-label">Applications Logs</span>
                                <span class="m-list-settings__item-control">
							<span class="m-switch m-switch--outline m-switch--icon-check m-switch--brand">
							<label>
							<input type="checkbox" name="">
							<span></span>
							</label>
							</span>
							</span>
                            </div>
                            <div class="m-list-settings__item">
                                <span class="m-list-settings__item-label">Backup Servers</span>
                                <span class="m-list-settings__item-control">
							<span class="m-switch m-switch--outline m-switch--icon-check m-switch--brand">
							<label>
							<input type="checkbox" checked="checked" name="">
							<span></span>
							</label>
							</span>
							</span>
                            </div>
                            <div class="m-list-settings__item">
                                <span class="m-list-settings__item-label">Audit Logs</span>
                                <span class="m-list-settings__item-control">
							<span class="m-switch m-switch--outline m-switch--icon-check m-switch--brand">
							<label>
							<input type="checkbox" name="">
							<span></span>
							</label>
							</span>
							</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="m_quick_sidebar_tabs_logs" role="tabpanel">
                    <div class="m-list-timeline m-scrollable">
                        <div class="m-list-timeline__group">
                            <div class="m-list-timeline__heading">
                                System Logs
                            </div>
                            <div class="m-list-timeline__items">
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-success"></span>
                                    <a href="" class="m-list-timeline__text">12 new users registered <span class="m-badge m-badge--warning m-badge--wide">important</span></a>
                                    <span class="m-list-timeline__time">Just now</span>
                                </div>
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-info"></span>
                                    <a href="" class="m-list-timeline__text">System shutdown</a>
                                    <span class="m-list-timeline__time">11 mins</span>
                                </div>
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-danger"></span>
                                    <a href="" class="m-list-timeline__text">New invoice received</a>
                                    <span class="m-list-timeline__time">20 mins</span>
                                </div>
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-warning"></span>
                                    <a href="" class="m-list-timeline__text">Database overloaded 89% <span class="m-badge m-badge--success m-badge--wide">resolved</span></a>
                                    <span class="m-list-timeline__time">1 hr</span>
                                </div>
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-success"></span>
                                    <a href="" class="m-list-timeline__text">System error</a>
                                    <span class="m-list-timeline__time">2 hrs</span>
                                </div>
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-info"></span>
                                    <a href="" class="m-list-timeline__text">Production server down <span class="m-badge m-badge--danger m-badge--wide">pending</span></a>
                                    <span class="m-list-timeline__time">3 hrs</span>
                                </div>
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-success"></span>
                                    <a href="" class="m-list-timeline__text">Production server up</a>
                                    <span class="m-list-timeline__time">5 hrs</span>
                                </div>
                            </div>
                        </div>
                        <div class="m-list-timeline__group">
                            <div class="m-list-timeline__heading">
                                Applications Logs
                            </div>
                            <div class="m-list-timeline__items">
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-info"></span>
                                    <a href="" class="m-list-timeline__text">New order received <span class="m-badge m-badge--info m-badge--wide">urgent</span></a>
                                    <span class="m-list-timeline__time">7 hrs</span>
                                </div>
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-success"></span>
                                    <a href="" class="m-list-timeline__text">12 new users registered</a>
                                    <span class="m-list-timeline__time">Just now</span>
                                </div>
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-info"></span>
                                    <a href="" class="m-list-timeline__text">System shutdown</a>
                                    <span class="m-list-timeline__time">11 mins</span>
                                </div>
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-danger"></span>
                                    <a href="" class="m-list-timeline__text">New invoices received</a>
                                    <span class="m-list-timeline__time">20 mins</span>
                                </div>
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-warning"></span>
                                    <a href="" class="m-list-timeline__text">Database overloaded 89%</a>
                                    <span class="m-list-timeline__time">1 hr</span>
                                </div>
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-success"></span>
                                    <a href="" class="m-list-timeline__text">System error <span class="m-badge m-badge--info m-badge--wide">pending</span></a>
                                    <span class="m-list-timeline__time">2 hrs</span>
                                </div>
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-info"></span>
                                    <a href="" class="m-list-timeline__text">Production server down</a>
                                    <span class="m-list-timeline__time">3 hrs</span>
                                </div>
                            </div>
                        </div>
                        <div class="m-list-timeline__group">
                            <div class="m-list-timeline__heading">
                                Server Logs
                            </div>
                            <div class="m-list-timeline__items">
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-success"></span>
                                    <a href="" class="m-list-timeline__text">Production server up</a>
                                    <span class="m-list-timeline__time">5 hrs</span>
                                </div>
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-info"></span>
                                    <a href="" class="m-list-timeline__text">New order received</a>
                                    <span class="m-list-timeline__time">7 hrs</span>
                                </div>
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-success"></span>
                                    <a href="" class="m-list-timeline__text">12 new users registered</a>
                                    <span class="m-list-timeline__time">Just now</span>
                                </div>
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-info"></span>
                                    <a href="" class="m-list-timeline__text">System shutdown</a>
                                    <span class="m-list-timeline__time">11 mins</span>
                                </div>
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-danger"></span>
                                    <a href="" class="m-list-timeline__text">New invoice received</a>
                                    <span class="m-list-timeline__time">20 mins</span>
                                </div>
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-warning"></span>
                                    <a href="" class="m-list-timeline__text">Database overloaded 89%</a>
                                    <span class="m-list-timeline__time">1 hr</span>
                                </div>
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-success"></span>
                                    <a href="" class="m-list-timeline__text">System error</a>
                                    <span class="m-list-timeline__time">2 hrs</span>
                                </div>
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-info"></span>
                                    <a href="" class="m-list-timeline__text">Production server down</a>
                                    <span class="m-list-timeline__time">3 hrs</span>
                                </div>
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-success"></span>
                                    <a href="" class="m-list-timeline__text">Production server up</a>
                                    <span class="m-list-timeline__time">5 hrs</span>
                                </div>
                                <div class="m-list-timeline__item">
                                    <span class="m-list-timeline__badge m-list-timeline__badge--state-info"></span>
                                    <a href="" class="m-list-timeline__text">New order received</a>
                                    <span class="m-list-timeline__time">1117 hrs</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end::Quick Sidebar -->
    <!-- begin::Scroll Top -->
    <div id="m_scroll_top" class="m-scroll-top">
        <i class="la la-arrow-up"></i>
    </div>
    <div class="modal fade" id="m_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Passenger</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>The Item Will Permanently Deleted</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Don't Delete</button>
                    <button type="button" id="confirm_delete" class="btn btn-danger">Yes Delete It</button>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="delete_id">
@stop
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#data').DataTable();
        });
        function Confirm(id) {
            $('#delete_id').val(id);
            $('#m_modal_1').modal('show');
        }

        $('#confirm_delete').click(function(){
            var id = $('#delete_id').val();
            $('#m_modal_1').modal('toggle');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // alert(id);
            // $.post("passengers/"+id, {"_method":"delete"}, function(data){
            //     location.reload();
            // });
            $.ajax({
                type:'POST',
                data:{
                    _method: "DELETE",
                },
                url:'drivers/'+id,
                success: function(data){
                    if(data){
                        location.reload();
                    }
                }

            })
        });
    </script>
@stop
