@extends('layouts.admin-app')
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop
@section('google-script')
    <script src="https://maps.google.com/maps/api/js?key={{env('GOOGLE_MAP')}}"></script>
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
                            <h3 class="m-subheader__title m-subheader__title--separator">{{Config('constants.driver-ride')}}</h3>
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
                                               Current Rides
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                <!--begin::Form-->
                                <div class="m-form m-form--fit m-form--label-align-right">
                                    <div class="m-portlet__body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group m-form__group">
                                                    <label for="ride_id">Select Pick Up Location</label>
                                                    <select class="form-control m-input m-input--square"
                                                            name="ride_id" id="ride_id">
                                                        <option value="">-- Select Pickup Location --</option>
                                                        @if(is_array($ride_options) || is_object($ride_options))
                                                            @foreach($ride_options as $ride_option)
                                                                <option value="{{$ride_option['id']}}"
                                                                >
                                                                    {{$ride_option['pick_loc_address']}}</option>
                                                            @endforeach
                                                        @else
                                                            <option value="">No Data</option>
                                                        @endif
                                                    </select>
                                                </div>
                                                <label>
                                                    <img id="loadingimg" style="display:none" src="{{asset('css/images/loading.gif')}}"/>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                                            <th>Driver Name</th>
                                            <th>Status</th>
                                            <th>Current Loc</th>
                                            <th>Esti Time</th>
                                            <th>Distance</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
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
@stop
@section('scripts')
    <script>

        $(document).ready(function() {

            var uk = { lat: 51.50, lng: -0.11 };

            var map = new google.maps.Map(document.getElementById('map'), {

                zoom: 7,

                center: uk

            });

            $('#data').DataTable();

            function update_map(curr_lat,curr_long,pick_lat,pick_long) {

                var directionsService = new google.maps.DirectionsService();

                var directionsDisplay = new google.maps.DirectionsRenderer();

                var origin = new google.maps.LatLng(curr_lat,curr_long);

                var destination = new google.maps.LatLng(pick_lat,pick_long);

                directionsDisplay.setMap(map);

                directionsService.route({

                    origin: origin,

                    destination: destination,

                    travelMode: 'DRIVING'

                }, function(response, status) {

                    if (status === 'OK') {

                        directionsDisplay.setDirections(response);

                    } else {

                        window.alert('Directions request failed due to ' + status);

                    }

                });

            }

            var lineCoordinates = new Array();

            function update_marker_distance(lat,long)

            {

                lineCoordinates.push = new google.maps.LatLng(lat,long);

            }

            $('#ride_id').change(function(){

                var id = $(this).val();
                if(id == ''){
                    return false;
                }
                $('#loadingimg').show();

                $.ajax({

                    type:'GET',

                    url:'current-ride-location/'+id,

                    success: function(data){

                        if(data){

                            var rows = '';

                            $.each(data.data, function (i, item) {

                                rows += '<tr>'

                                rows += '<td>' + item.driver_name + '</td>'

                                rows += '<td>' + item.status + '</td>'

                                rows += '<td>' + item.curr_loc_address + '</td>'

                                rows += '<td>' + item.duration + '</td>'

                                rows += '<td>' + item.distance + '</td>'

                                rows += '</tr>';

                                if(item.status == "Driver Assigned")

                                {

                                    update_map(parseFloat(item.curr_loc_lat),parseFloat(item.curr_loc_long),parseFloat(item.pick_loc_lat),parseFloat(item.pick_loc_long));

                                }

                                if(item.status == "Picked" || item.status == "On Way")

                                {


                                    // var loc = { lat: parseFloat(item.pick_loc_lat), lng: parseFloat(item.pick_loc_long) };

                                    // var marker = new google.maps.Marker({

                                    //     position: loc,

                                    //     label: item.driver_name[0],

                                    //     visible: true,

                                    // });

                                    // marker.setMap(map);

                                    // map.setZoom(17);

                                    // map.panTo(loc);

                                    //ToDo Get a list of current locations from current_rides table

                                    $.ajax({

                                        type: 'GET',

                                        url: 'current-ride-travelled/'+item.id,

                                        success: function (polyLineData) {
                                            var lastLoc = '';
                                            var lastLoc2 = [];

                                            for(i=0;i<polyLineData.length; i++)

                                            {
                                                var location = { lat: parseFloat(polyLineData[i]['curr_loc_lat']), lng: parseFloat(polyLineData[i]['curr_loc_long']) }

                                                lastLoc = location;
                                                lastLoc2.push(location);
                                            }
                                            //start point Marker start
                                            var firstLoc = { lat: parseFloat(polyLineData[0]['curr_loc_lat']), lng: parseFloat(polyLineData[0]['curr_loc_long']) }
                                            var latlng = new google.maps.LatLng(firstLoc);
                                            var startPointMarker = new google.maps.Marker({
                                                position: latlng,
                                                icon: '{{ asset('css/images/startMarker.png') }}',
                                                map: map
                                            });
                                            //start point Marker end

                                            //end point Marker start
                                            var latlng = new google.maps.LatLng(lastLoc);
                                            var dmarker = new google.maps.Marker({
                                                position: latlng,
                                                label: item.driver_name[0],
                                                visible: true,
                                            });

                                            dmarker.setMap(map);

                                            map.setZoom(13);

                                            map.panTo(latlng);
                                            //end point Marker end

                                            //tracking line start
                                            var lineCoordinatePath = new google.maps.Polyline({

                                                path: lastLoc2,

                                                geodesic: true,

                                                map: map,

                                                strokeColor: '#FF0000',

                                                strokeOpacity: 1.0,

                                                strokeWeight: 2

                                            });
                                            lineCoordinatePath.setMap(map);
                                            //tracking line end

                                        }

                                    });

                                    //ToDo Just show current location via marker if destination location is not set

                                    //ToDo if destination location is set update the current ride locations

                                }

                            });

                            $('#data').DataTable().destroy();

                            $('#data').find('tbody').html(rows);

                            $('#data').DataTable().draw();

                            $('#loadingimg').hide();

                        }

                    }

                })

            });

        });

        var coveredCoordinates = [];

        function update_marker(lat,long)

        {

            alert(lat,long);

            coveredCoordinates.push(new google.maps.LatLng(lat,long));

            console.log(coveredCoordinates);

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
