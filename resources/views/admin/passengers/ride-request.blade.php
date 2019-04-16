@extends('layouts.admin-app')
@section('google-script')
    <script type="text/javascript" src="https://maps.google.com/maps/api/js?key={{env('GOOGLE_MAP')}}&libraries=places"></script>
<style>
    .map-control {
        margin-top: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    }
    #pick_up {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 50%;
    }
    #pick_up:focus {
        border-color: #4d90fe;
    }
</style>
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
                            <h3 class="m-subheader__title m-subheader__title--separator">{{Config('constants.ride-request')}}</h3>
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
                    @if(Session::has('success'))
                    <div class="m-alert m-alert--outline alert alert-success alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        </button>
                        <strong>Congratulations!</strong> {{Session::get('success')}}
                    </div>
                    @endif
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
                                                Passenger Ride Request Form
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                <!--begin::Form-->
                                <form class="m-form m-form--fit m-form--label-align-right" method="post"
                                      action="{{url('admin/ride-request')}}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $existing == null ? '' : $existing->id }}">
                                    <div class="m-portlet__body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group m-form__group">
                                                    <label for="driver_id">Select passenger</label>
                                                    <select class="form-control m-input m-input--square"
                                                            name="passenger_id">
                                                        @foreach($passenger_options as $passenger)
                                                            @if($passenger->passenger_id==null)
                                                                <option value="{{$passenger->id}}"
                                                                        @if($existing != null && $existing->passenger_id == $passenger->passenger_id) selected @endif>
                                                                    {{$passenger->fname. " ". $passenger->lname}}</option>
                                                            @endif
                                                                @if($passenger->passenger_id!=null && ($passenger->status == "Processed" || $passenger->status == "Cancelled"))
                                                                    <option value="{{$passenger->id}}"
                                                                            @if($existing != null && $existing->passenger_id == $passenger->passenger_id) selected @endif>
                                                                        {{$passenger->fname. " ". $passenger->lname}}</option>
                                                                @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @if ($errors->has('passenger_id'))
                                                    <span class="invalid-feedback" style="display: block" role="alert">
                                                        <strong>{{ $errors->first('passenger_id') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group m-form__group">
                                                    <label for="pick_loc_address">Pick up location Address</label>
                                                    <input type="text" name="pick_loc_address"
                                                           value="{{ $existing == null ? old('pick_loc_address') : $existing->pick_loc_address }}"
                                                           class="form-control m-input"
                                                           aria-describedby="emailHelp" id="pick_loc_address" readonly>
                                                </div>
                                                @if ($errors->has('pick_loc_address'))
                                                    <span class="invalid-feedback" style="display: block" role="alert">
                                                        <strong>{{ $errors->first('pick_loc_address') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group m-form__group">
                                                    <label for="pick_loc_lat">Pick up Latitute</label>
                                                    <input type="text" name="pick_loc_lat"
                                                           value="{{ $existing == null ? old('pick_loc_lat') : $existing->pick_loc_lat }}"
                                                           class="form-control m-input" id="pick_loc_lat"
                                                           aria-describedby="emailHelp" readonly>
                                                </div>
                                                @if ($errors->has('pick_loc_lat'))
                                                    <span class="invalid-feedback" style="display: block" role="alert">
                                                        <strong>{{ $errors->first('pick_loc_lat') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group m-form__group">
                                                    <label for="pick_loc_long">Pick up Longitude</label>
                                                    <input type="text" name="pick_loc_long"
                                                           value="{{ $existing == null ? old('pick_loc_long') : $existing->pick_loc_long }}"
                                                           class="form-control m-input" id="pick_loc_long"
                                                           aria-describedby="emailHelp" readonly>
                                                </div>
                                                @if ($errors->has('pick_loc_long'))
                                                    <span class="invalid-feedback" style="display: block" role="alert">
                                                        <strong>{{ $errors->first('pick_loc_long') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group m-form__group">
                                                    <label for="dest_loc_address">Destination Location Address</label>
                                                    <input type="text" name="dest_loc_address"
                                                           value="{{ $existing == null ? old('dest_loc_address') : $existing->dest_loc_address }}"
                                                           class="form-control m-input" id="dest_loc_address"
                                                           aria-describedby="emailHelp"
                                                           id="dest_loc_address" readonly>
                                                </div>
                                                @if ($errors->has('dest_loc_address'))
                                                    <span class="invalid-feedback" style="display: block" role="alert">
                                                        <strong>{{ $errors->first('dest_loc_address') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group m-form__group">
                                                    <label for="dest_loc_lat">Destination Location Latitude</label>
                                                    <input type="text" name="dest_loc_lat"
                                                           value="{{ $existing == null ? old('dest_loc_lat') : $existing->dest_loc_lat }}"
                                                           class="form-control m-input" id="dest_loc_lat" readonly>
                                                </div>
                                                @if ($errors->has('dest_loc_lat'))
                                                    <span class="invalid-feedback" style="display: block" role="alert">
                                                        <strong>{{ $errors->first('dest_loc_lat') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group m-form__group">
                                                    <label for="dest_loc_long">Destination Location Longitude</label>
                                                    <input type="text" name="dest_loc_long"
                                                           value="{{ $existing == null ? old('dest_loc_long') : $existing->dest_loc_long }}"
                                                           class="form-control m-input" id="dest_loc_long" readonly>
                                                </div>
                                                @if ($errors->has('dest_loc_long'))
                                                    <span class="invalid-feedback" style="display: block" role="alert">
                                                        <strong>{{ $errors->first('dest_loc_long') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group m-form__group">
                                                    <label for="request_mode">Request Mode</label>
                                                    <select class="form-control m-input m-input--square"
                                                            name="request_mode">
                                                        <option value="Mobile"
                                                                @if($existing != null && $existing->request_mode == "Mobile") selected @endif>
                                                            Mobile
                                                        </option>
                                                        <option value="Email"
                                                                @if($existing != null && $existing->request_mode == "Email") selected @endif>
                                                            Email
                                                        </option>
                                                    </select>

                                                </div>
                                                @if ($errors->has('request_mode'))
                                                    <span class="invalid-feedback" style="display: block" role="alert">
                                                        <strong>{{ $errors->first('request_mode') }}</strong>
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

                    <input id="pick_up" type="text" placeholder="Enter Location" class="map-control">
                    <button id="enter_dest" class="btn btn-success">Enter Destination Location</button>
                    <button id="enter_pick" class="btn btn-danger">Enter Pick Up Location Again</button>
                    <div id="map" style="height:600px;">
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
        // In the following example, markers appear when the user clicks on the map.
        // Each marker is labeled with a single alphabetical character.
        // var labels = 'SIDDIQ';
        // var labelIndex = 0;
        //
        // function initialize() {
        //     var uk = { lat: 51.50, lng: -0.11 };
        //     var map = new google.maps.Map(document.getElementById('map'), {
        //         zoom: 12,
        //         center: uk
        //     });
        //
        //     // This event listener calls addMarker() when the map is clicked.
        //     google.maps.event.addListener(map, 'click', function(event) {
        //         addMarker(event.latLng, map);
        //     });
        //
        //     // Add a marker at the center of the map.
        //     addMarker(uk, map);
        // }
        //
        // // Adds a marker to the map.
        // function addMarker(location, map) {
        //     // Add the marker at the clicked location, and add the next-available label
        //     // from the array of alphabetical characters.
        //     var marker = new google.maps.Marker({
        //         position: location,
        //         label: labels[labelIndex++ % labels.length],
        //         map: map
        //     });
        // }

        $(document).ready(function () {
            initMap();
            function initMap() {
                var uk = { lat: 51.50, lng: -0.11 };
                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 12,
                    center: uk
                });
                var input = document.getElementById('pick_up');
                map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

                var autocomplete = new google.maps.places.Autocomplete(input);
                autocomplete.bindTo('bounds', map);

                var infowindow = new google.maps.InfoWindow();
                var marker = new google.maps.Marker({
                    map: map,
                    anchorPoint: new google.maps.Point(0, -29)
                });

                autocomplete.addListener('place_changed', function() {
                    infowindow.close();
                    marker.setVisible(false);
                    var place = autocomplete.getPlace();

                    /* If the place has a geometry, then present it on a map. */
                    if (place.geometry.viewport) {
                        map.fitBounds(place.geometry.viewport);
                    } else {
                        map.setCenter(place.geometry.location);
                        map.setZoom(17);
                    }
                    marker.setIcon(({
                        url: place.icon,
                        size: new google.maps.Size(71, 71),
                        origin: new google.maps.Point(0, 0),
                        anchor: new google.maps.Point(17, 34),
                        scaledSize: new google.maps.Size(35, 35)
                    }));
                    marker.setPosition(place.geometry.location);
                    marker.setVisible(true);

                    var address = '';
                    if (place.address_components) {
                        address = [
                            (place.address_components[0] && place.address_components[0].short_name || ''),
                            (place.address_components[1] && place.address_components[1].short_name || ''),
                            (place.address_components[2] && place.address_components[2].short_name || '')
                        ].join(' ');
                    }

                    infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
                    infowindow.open(map, marker);

                    /* Location details */
                    if(destination==false)
                    {
                        document.getElementById('pick_loc_address').value = place.formatted_address;
                        document.getElementById('pick_loc_lat').value = place.geometry.location.lat();
                        document.getElementById('pick_loc_long').value = place.geometry.location.lng();
                    }
                    else
                    {
                        document.getElementById('dest_loc_address').value = place.formatted_address;
                        document.getElementById('dest_loc_lat').value = place.geometry.location.lat();
                        document.getElementById('dest_loc_long').value = place.geometry.location.lng();
                    }
                });
            }

            var destination = false;
//            google.maps.event.addDomListener(window, 'load', initMap);

            $('#enter_dest').click(function () {
                $('#pick_up').val('');
                $('#pick_up').focus();
                destination = true;
            });

            $('#enter_pick').click(function () {
                $('#pick_up').val('');
               $('#pick_loc_address').val("");
               $('#pick_loc_lat').val("");
               $('#pick_loc_long').val("");
               destination = false;
            });
        });

    </script>
@stop
