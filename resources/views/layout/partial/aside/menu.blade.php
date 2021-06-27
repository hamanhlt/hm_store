<!--begin::Aside Menu-->
<div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
    <!--begin::Menu Container-->
    <div
        id="kt_aside_menu"
        class="aside-menu my-4 "
        data-menu-vertical="1"
        data-menu-scroll="1" data-menu-dropdown-timeout="500">
        <!--begin::Menu Nav-->
        <ul class="menu-nav ">
            @if(!empty(session()->get('userGroup')['permissions_subs']) && !empty(config('menu')['left']))
                @foreach(config('menu')['left'] as $key => $menuBlock)
                    @if(Helper::isShowBlock($menuBlock)===false) @continue @endif
                    <li class="menu-section ">
                        <h4 class="menu-text">{{$menuBlock['label']}}</h4>{{--SHOW BLOCK--}}
                        <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                    </li>
                    @foreach($menuBlock['items'] as $item)
                        @if(Helper::isShowItemMenu($item)===false) @continue @endif
                        @if(!empty($item['permission']))
                            <li class="menu-item {{$item['class']??''}} {{Helper::urlToRoute($item['url'])===request()->route()->getName()?'menu-item-active':''}}"
                                aria-haspopup="true"
                                data-menu-toggle="hover">
                                <a href="{{$item['url']??'javascript:;'}}"
                                   class="menu-link {{!empty($item['child']) ?'menu-toggle':''}}">
                        <span class="svg-icon menu-icon">
                            {!! $item['icon_html']??'' !!}
                        </span>
                                    <span class="menu-text">{{$item['label']??''}}</span>
                                    <span class="menu-label" style="display: none">
                                        <span class="label label-rounded label-danger  data-count"
                                              data-count="{{$item['count']??''}}">
                                        </span>
                                    </span>
                                    @if(!empty($item['child']) )
                                        <i class="menu-arrow"></i>
                                    @endif
                                </a>
                                @if(!empty($item['child']) && Helper::isShowItemMenu($item)===true)
                                    <div class="menu-submenu" kt-hidden-height="80" style="">
                                        <i class="menu-arrow"></i>
                                        <ul class="menu-subnav">
                                            <li class="menu-item menu-item-parent {{Helper::urlToRoute($item['url'])===request()->route()->getName()?'menu-item-active menu-item-open':''}}"
                                                aria-haspopup="true">
                                                <span class="menu-link">
                                                    <span class="menu-text">{{$item['label']??''}}</span>
                                                </span>
                                            </li>
                                            @foreach($item['child'] as $itemChild)
                                                @if(Helper::isShowItemMenu($itemChild)===false) @continue @endif
                                                <li class="menu-item {{Helper::urlToRoute($itemChild['url'])===request()->route()->getName()?'menu-item-active menu-item-open':''}}"
                                                    aria-haspopup="true">
                                                    <a href="{{$itemChild['url']??'javascript:;'}}"
                                                       class="menu-link {{!empty($itemChild['child']) ?'menu-toggle':''}}">
                                                        <i class="menu-bullet menu-bullet-dot">
                                                            <span></span>
                                                        </i>
                                                        <span class="menu-text">{{$itemChild['label']??''}}</span>

                                                        @if(!empty($itemChild['child'] ))
                                                            <i class="menu-arrow"></i>
                                                        @endif
                                                    </a>

                                                    @if(!empty($itemChild['child'])&&Helper::isShowItemMenu($itemChild)===true)
                                                        <div class="menu-submenu" kt-hidden-height="80" style="">
                                                            <i class="menu-arrow"></i>
                                                            <ul class="menu-subnav">
                                                                <li class="menu-item menu-item-parent {{Helper::urlToRoute($itemChild['url'])===request()->route()->getName()?'menu-item-active menu-item-open' :''}}"
                                                                    aria-haspopup="true">
                                                <span class="menu-link">
                                                    <span class="menu-text">{{$itemChild['label']??''}}</span>
                                                </span>
                                                                </li>
                                                                @foreach($itemChild['child'] as $itemChild2)
                                                                    @if(Helper::isShowItemMenu($itemChild2)===false) @continue @endif
                                                                    <li class="menu-item {{Helper::urlToRoute($itemChild2['url'])===request()->route()->getName()?'menu-item-active menu-item-open':''}}"
                                                                        aria-haspopup="true">
                                                                        <a href="{{$itemChild2['url']??'javascript:;'}}"
                                                                           class="menu-link">
                                                                            <i class="menu-bullet menu-bullet-dot">
                                                                                <span></span>
                                                                            </i>
                                                                            <span
                                                                                class="menu-text">{{$itemChild2['label']??''}}</span>
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </li>
                        @endif
                    @endforeach
                @endforeach
            @endif
        </ul>
        <!--end::Menu Nav-->
    </div>
    <!--end::Menu Container-->
</div>
<!--end::Aside Menu-->
