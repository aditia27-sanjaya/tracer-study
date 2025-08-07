<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="icon" href="{{ asset('assets/favicon.png') }}" type="image/png"/>

<link href="{{ asset('assets/backend/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/backend/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/backend/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/backend/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="{{ asset('assets/backend/css/pace.min.css') }}" rel="stylesheet"/>
<script src="{{ asset('assets/backend/js/pace.min.js') }}"></script>

<link href="{{ asset('assets/backend/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/backend/css/bootstrap-extended.css') }}" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
<link href="{{ asset('assets/backend/css/app.css') }}" rel="stylesheet">
<link href="{{ asset('assets/backend/css/icons.css') }}" rel="stylesheet">

<link rel="stylesheet" href="{{ asset('assets/backend/css/dark-theme.css') }}"/>
<link rel="stylesheet" href="{{ asset('assets/backend/css/semi-dark.css') }}"/>
<link rel="stylesheet" href="{{ asset('assets/backend/css/header-colors.css') }}"/>
<link href="{{ asset('assets/backend/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
<style>
    .form-group.required .control-label:after {
   content:"*";
   color:red;
}
#pageloader
    {
    background: rgba( 255, 255, 255, 0.8 );
    display: none;
    height: 100%;
    position: fixed;
    width: 100%;
    z-index: 9999;
    }

    #pageloader img
    {
    left: 50%;
    margin-left: -32px;
    margin-top: -32px;
    position: absolute;
    top: 50%;
    }
</style>
<title>Tracer Study</title>
