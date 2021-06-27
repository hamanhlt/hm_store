@php
    $countNotify=auth()->user()->unreadNotifications->count();
    $notifications = auth()->user()->notifications()->orderBy('created_at','desc')->limit(40)->get();
    $sysNotifications = [];#chưa làm
@endphp
<div class="dropdown">
    <!--begin::Toggle-->
    <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
        <div class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1 pulse pulse-primary">
            <i class="flaticon2-bell-2 icon-2x text-primary"></i>
            <span class="pulse-ring"></span>
            @if(!empty($countNotify))
                <span class="label label-danger label-rounded">{{$countNotify}}</span>
            @endif
        </div>
    </div>
    <!--end::Toggle-->
    <!--begin::Dropdown-->
    <div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg">
        <!--begin::Header-->
        <div class="d-flex flex-column pt-12 bgi-size-cover bgi-no-repeat rounded-top"
             style="background-image: url({{asset('assets/custom/image/bg-1.jpg')}})">
            <!--begin::Title-->
            <h4 class="d-flex flex-center rounded-top">
                <span class="text-white">Thông báo</span>
                @if(!empty($countNotify))
                    <span
                        class="btn btn-text btn-success btn-sm font-weight-bold btn-font-md ml-2">{{$countNotify}} mới</span>
                @endif
            </h4>
            <!--end::Title-->
            <!--begin::Tabs-->
            <ul class="nav nav-bold nav-tabs nav-tabs-line nav-tabs-line-3x nav-tabs-line-transparent-white nav-tabs-line-active-border-success mt-3 px-8"
                role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="javscript:;">
                        Thông báo chung</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="javscript:;">
                        Cập nhật hệ thống</a>
                </li>
            </ul>
            <!--end::Tabs-->
        </div>
        <!--end::Header-->
        <!--begin::Content-->
        <div class="tab-content">
            <!--begin::Tabpane-->
            <div class="tab-pane active show pb-4" id="topbar_notifications"
                 role="tabpanel">
                <!--begin::Scroll-->
                <div class="mr-n7 navi navi-hover scroll" data-scroll="true"
                     data-height="500"
                     data-mobile-height="200">
                @if($notifications->isNotEmpty())
                    @foreach($notifications as $notification)
                        <!--begin::Item-->
                            <a class="d-flex text-hover-dark align-items-center navi-item mr-7 @if($notification->unread()) bg-dark-o-20 @endif "
                               href="{{route('system.user.notification.view', $notification->_id)}}">
                                <div class="navi-link ">
                                    <!--begin::Symbol-->
                                    <div class="symbol symbol-40 symbol-light-primary">
                                                        <span class="symbol-label">
                                                                {!! $notification['data']['icon_html']??'' !!}
                                                        </span>
                                    </div>
                                    <!--end::Symbol-->
                                    <!--begin::Text-->
                                    <div class="d-flex flex-column font-size-base pl-4">
                                                        <span href="#"
                                                              class="text-dark mb-1 font-size-lg">
                                                            {!! $notification['data']['title']??'' !!}
                                                        </span>
                                        <span
                                            class="">{!! $notification['data']['content']??'' !!}</span>
                                        <div
                                            class="text-muted font-size-sm">{{ $notification['created_at']->format('H:i:s d-m-Y')??'' }}</div>
                                    </div>
                                    <!--end::Text-->
                                </div>
                            </a>
                            <!--end::Item-->
                    @endforeach
                @else
                    <!--begin::Nav-->
                        <div class="d-flex flex-center text-center text-muted min-h-200px">
                            Hết thông báo :(
                        </div>
                        <!--end::Nav-->
                    @endif
                </div>
                <!--end::Scroll-->
                <!--begin::Action-->
                <div class="d-flex flex-center pt-7">
                    <a href="{{route('system.user.notification')}}"
                       class="btn text-center text-primary">Xem thêm thông báo</a>
                    <form action="{{route('system.user.notification.markAsReadAll')}}" method="POST">
                        @csrf
                        <button type="submit" class="btn text-center text-primary ">
                            Đánh dấu đã đọc hết
                        </button>
                    </form>
                </div>
                <!--end::Action-->
            </div>
            <!--end::Tabpane-->
            <!--begin::Tabpane-->
            <div class="tab-pane show" id="topbar_system_notifications"
                 role="tabpanel">
                <!--begin::Scroll-->
                <div class="mr-n7 navi navi-hover scroll" data-scroll="true"
                     data-height="500"
                     data-mobile-height="200">
                    <!--begin::Nav-->
                    <div class="d-flex flex-center text-center text-muted min-h-200px">
                        Hết thông báo :(
                    </div>
                    <!--end::Nav-->
                </div>
                <!--end::Scroll-->
            </div>
            <!--end::Tabpane-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Dropdown-->
</div>
