<!-- Title -->
<title>
    @yield('title')
</title>




@yield('css')


<!-- CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<!-- JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>



@if (App::getlocale() == 'en' || App::getlocale() == 'fr')
    <!-- Favicon -->
    <link rel="icon" href="{{ URL::asset('assets/img/brand/favicon.png') }}" type="image/x-icon" />
    <!-- Icons css -->
    <link href="{{ URL::asset('assets/css/icons.css') }}" rel="stylesheet">
    <!--  Custom Scroll bar-->
    <link href="{{ URL::asset('assets/plugins/mscrollbar/jquery.mCustomScrollbar.css') }}" rel="stylesheet" />
    <!--  Right-sidemenu css -->
    <link href="{{ URL::asset('assets/plugins/sidebar/sidebar.css') }}" rel="stylesheet">
    <!-- Sidemenu css -->
    <link rel="stylesheet" href="{{ URL::asset('assets/css/sidemenu.css') }}">
    <!-- Maps css -->
    <link href="{{ URL::asset('assets/plugins/jqvmap/jqvmap.min.css') }}" rel="stylesheet">
    <!-- style css -->
    <link href="{{ URL::asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/style-dark.css') }}" rel="stylesheet">
    <!---Skinmodes css-->
    <link href="{{ URL::asset('assets/css/skin-modes.css') }}" rel="stylesheet" />
@else
    <!-- Favicon -->
    <link rel="icon" href="{{ URL::asset('assets/img/brand/favicon.png') }}" type="image/x-icon" />
    <!-- Icons css -->
    <link href="{{ URL::asset('assets/css/icons.css') }}" rel="stylesheet">
    <!--  Custom Scroll bar-->
    <link href="{{ URL::asset('assets/plugins/mscrollbar/jquery.mCustomScrollbar.css') }}" rel="stylesheet" />
    <!--  Sidebar css -->
    <link href="{{ URL::asset('assets/plugins/sidebar/sidebar.css') }}" rel="stylesheet">
    <!-- Sidemenu css -->
    <link rel="stylesheet" href="{{ URL::asset('assets/css-rtl/sidemenu.css') }}">
    <!--- Style css -->
    <link href="{{ URL::asset('assets/css-rtl/style.css') }}" rel="stylesheet">
    <!--- Dark-mode css -->
    <link href="{{ URL::asset('assets/css-rtl/style-dark.css') }}" rel="stylesheet">
    <!---Skinmodes css-->
    <link href="{{ URL::asset('assets/css-rtl/skin-modes.css') }}" rel="stylesheet">
@endif

<!-- Custom Logo Styling -->
<style>
    /* Logo in sidebar menu */
    .sidebar-logo-container {
        padding: 20px 15px !important;
        text-align: center;
        margin-bottom: 10px;
        border-bottom: 1px solid #e9ecef;
    }

    .sidebar-logo-link {
        display: inline-block;
    }

    .sidebar-main-logo {
        max-width: 130px;
        height: auto;
    }

    /* Dark mode */
    .dark-mode .sidebar-logo-container {
        border-bottom-color: rgba(255, 255, 255, 0.1);
    }

    /* Remove default category styling from logo */
    .sidebar-logo-container.side-item-category {
        background: transparent !important;
        color: inherit !important;
        text-transform: none !important;
    }

    /* Mobile responsive */
    @media (max-width: 768px) {
        .sidebar-logo-container {
            padding: 15px 10px !important;
        }

        .sidebar-main-logo {
            max-width: 100px;
        }
    }
</style>
