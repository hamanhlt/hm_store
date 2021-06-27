@section('style_head')
    @parent
    <link href="{{ asset('assets/css/pages/wizard/wizard-6.css') }}" rel="stylesheet" type="text/css"/>
    <link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
    <style>
        .close-region, .close-time, .close-branch {
            border: 1px solid;
            border-radius: 10px;
        }

        .chosen-container-multi {
            width: 100% !important;
        }
    </style>
@endsection
