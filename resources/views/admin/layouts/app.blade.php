<!DOCTYPE html>
<html lang="en">
<head>
	@include('admin.layouts.header')
</head>
<body class="vertical-layout vertical-menu-modern 2-columns  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">

	<!-- BEGIN: Header Main Menu-->
    @include('admin.layouts.navbar')
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- Main Contect Start -->
                @yield('main_content')
                <!-- Main Contect end -->
            </div>
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>	

	@include('admin.layouts.footer')

</body>
</html>