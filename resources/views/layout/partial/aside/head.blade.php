<base href="../../../">
<meta charset="utf-8"/>
<title>{{config('app.name')}}</title>
<meta name="description" content="Basic datatables examples"/>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
<link rel="canonical" href="https://keenthemes.com/metronic"/>

<!--begin::Fonts-->
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Be+Vietnam:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
<!--end::Fonts-->

<!--begin::Page Vendors Styles(used by this page)-->
<link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css"/>
<!--end::Page Vendors Styles-->

<!--begin::Global Theme Styles(used by all pages)-->
<link href="{{asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{asset('assets/plugins/custom/prismjs/prismjs.bundle.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css"/>
<!--end::Global Theme Styles-->

<!--begin::Layout Themes(used by all pages)-->

<link href="{{asset('assets/css/themes/layout/header/base/light.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{asset('assets/css/themes/layout/header/menu/light.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{asset('assets/css/themes/layout/brand/dark.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{asset('assets/css/themes/layout/aside/dark.css')}}" rel="stylesheet" type="text/css"/>
<!--end::Layout Themes-->

<link rel="shortcut icon" href="{{asset('assets/media/logos/favicon.ico')}}"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.20/lodash.min.js" integrity="sha256-ur/YlHMU96MxHEsy3fHGszZHas7NzH4RQlD4tDVvFhw=" crossorigin="anonymous"></script>
<script src="{{asset('assets/custom/i18n.js')}}" ></script>
<script>
    let dataFiles = {};//set global
</script>

<style>
    .aside-menu .menu-nav > .menu-section .menu-text {
        color: #e1f0ff;
    }
</style>
@yield('style_head')
