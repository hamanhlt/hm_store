<div id="kt_header" class="header header-fixed">
    <!--begin::Container-->
    <div class="container-fluid d-flex align-items-stretch justify-content-between">
        <!--begin::Header Menu Wrapper-->
        <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
            <!--begin::Header Menu-->
            <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
                <!--begin::Header Nav-->
                <!--end::Header Nav-->
            </div>
            <!--end::Header Menu-->
        </div>
        <!--end::Header Menu Wrapper-->
        <!--begin::Topbar-->
        <div class="topbar">
            <!--begin::User-->
            <div class="topbar-item">
                <div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2"
                     id="kt_quick_user_toggle">
                    @php
                        $avatarUrl = Helper::getDataFiles(Auth::user(),'avatar', false);
                        $fullname = Auth::user()['fullname']??'';
                        $username = Auth::user()['username']??'';
                        $showName = $fullname??$username;
                    @endphp
                    <span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">Hi,</span>
                    <span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3">{{$fullname}}</span>
                    <span class="text-muted font-size-base d-block mr-3">{{'@'.$username}}</span>

                    @if(empty($avatarUrl))
                        <span class="symbol symbol-lg-35 symbol-25 symbol-light-success">
                        <span class="symbol-label font-size-h5 font-weight-bold">
                            {{ucfirst(substr($showName, 0,1))}}
                        </span>
					</span>
                    @else
                        <div class="symbol symbol-lg-35 symbol-25 mr-5">
                            <div class="symbol-label"
                                 style="background-image:url('{{asset($avatarUrl)}}')"></div>
                        </div>
                    @endif
                </div>
            </div>
            <!--end::User-->
        </div>
        <!--end::Topbar-->
    </div>
    <!--end::Container-->
</div>
