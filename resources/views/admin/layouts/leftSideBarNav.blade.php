    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto"><a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                        <div class="brand">
                            <img src="{{ asset('app-assets/images/logo/logo-info.png')}}" width="35" height="24">
                        </div>
                        <h2 class="brand-text mb-0">Balkae</h2>
                    </a></li>
                <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary" data-ticon="icon-disc"></i></a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class="nav-item {{ (\Route::currentRouteName() == 'admin.dashboard')? 'active' :'' }}"><a href="{{ route('admin.dashboard') }}"><i class="feather icon-home"></i><span class="menu-title" data-i18n="Dashboard">Dashboard</span></a>
                </li>

                <li class="navigation-header"><span>Products</span>
                </li>
                @if(Auth::user()->is_admin == 1)
                <li class="navigation-header"><span>Modules</span>
                </li>
                <li class="nav-item {{ (\Route::currentRouteName() == 'category.index')? 'active' :'' }}"><a href="{{ route('category.index') }}"><i class="feather icon-package"></i><span class="menu-title" data-i18n="Team">Categories</span></a>
                </li>
                <li class="nav-item {{ (\Route::currentRouteName() == 'brand.index')? 'active' :'' }}"><a href="{{ route('brand.index') }}"><i class="feather icon-bold"></i><span class="menu-title" data-i18n="Team">Brand</span></a>
                </li>
                @endif
                @if(Auth::user()->is_admin == 2 || Auth::user()->is_admin == 1)
                <li class="nav-item {{ (\Route::currentRouteName() == 'attribute.index')? 'active' :'' }}"><a href="{{ route('attribute.index') }}"><i class="feather icon-archive"></i><span class="menu-title" data-i18n="Team">Attributes</span></a>
                </li>
                @endif

                @if(Auth::user()->is_admin == 2 || Auth::user()->is_admin == 1)
                <li class="nav-item {{ (\Route::currentRouteName() == 'product.index')? 'active' :'' }}"><a href="{{ route('product.index') }}"><i class="feather icon-shopping-bag"></i><span class="menu-title" data-i18n="Team">Product & Inventory</span></a>
                </li>
                <li class="nav-item {{ (\Route::currentRouteName() == 'coupone.index')? 'active' :'' }}"><a href="{{ route('coupone.index') }}"><i class="feather icon-shopping-bag"></i><span class="menu-title" data-i18n="Team">Coupone</span></a>
                </li>

                @endif

                @if(Auth::user()->is_admin == 2)
                <li class="nav-item {{ (\Route::currentRouteName() == 'settings.vendor.index')? 'active' :'' }}"><a href="{{ route('settings.vendor.index') }}"><i class="feather icon-shopping-bag"></i><span class="menu-title" data-i18n="Team">Settings</span></a>
                </li>
                <li class="nav-item {{ (\Route::currentRouteName() == 'size_chart.index')? 'active' :'' }}"><a href="{{ route('size_chart.index') }}"><i class="feather icon-shopping-bag"></i><span class="menu-title" data-i18n="Team">Size Chart</span></a>
                </li>
                @endif

                @if(Auth::user()->is_admin == 1)
                <li class="nav-item {{ (\Route::currentRouteName() == 'settings.index')? 'active' :'' }}"><a href="{{ route('settings.index') }}"><i class="feather icon-shopping-bag"></i><span class="menu-title" data-i18n="Team">Settings</span></a>
                </li>
                <li class=" navigation-header"><span>Homepage Settings</span>
                </li>
                <li class="nav-item {{ (\Route::currentRouteName() == 'banner.index')? 'active' :'' }}"><a href="{{ route('banner.index') }}"><i class="feather icon-shopping-bag"></i><span class="menu-title" data-i18n="Team">Banner</span></a>
                </li>
                <li class="nav-item {{ (\Route::currentRouteName() == 'specific.index')? 'active' :'' }}"><a href="{{ route('specific.index') }}"><i class="feather icon-shopping-bag"></i><span class="menu-title" data-i18n="Team">Specific</span></a>
                </li>
                <li class="nav-item {{ (\Route::currentRouteName() == 'motivation.index')? 'active' :'' }}"><a href="{{ route('motivation.index') }}"><i class="feather icon-shopping-bag"></i><span class="menu-title" data-i18n="Team">Motivation</span></a>
                </li>
                <li class="nav-item {{ (\Route::currentRouteName() == 'slider.index')? 'active' :'' }}"><a href="{{ route('slider.index') }}"><i class="feather icon-shopping-bag"></i><span class="menu-title" data-i18n="Team">Slider</span></a>
                </li>
                <li class="nav-item {{ (\Route::currentRouteName() == 'discover.index')? 'active' :'' }}"><a href="{{ route('discover.index') }}"><i class="feather icon-shopping-bag"></i><span class="menu-title" data-i18n="Team">Discover</span></a>
                </li>
                <li class="nav-item {{ (\Route::currentRouteName() == 'popularproduct.index')? 'active' :'' }}"><a href="{{ route('popularproduct.index') }}"><i class="feather icon-shopping-bag"></i><span class="menu-title" data-i18n="Team">Popular Product</span></a>
                </li>
                <li class="nav-item {{ (\Route::currentRouteName() == 'promisingpick.index')? 'active' :'' }}"><a href="{{ route('promisingpick.index') }}"><i class="feather icon-shopping-bag"></i><span class="menu-title" data-i18n="Team">Promising Pick</span></a>
                </li>
                <li class="nav-item {{ (\Route::currentRouteName() == 'breakoutbrand.index')? 'active' :'' }}"><a href="{{ route('breakoutbrand.index') }}"><i class="feather icon-shopping-bag"></i><span class="menu-title" data-i18n="Team">Braekout Brand</span></a>
                </li>
                <li class="nav-item {{ (\Route::currentRouteName() == 'spotlight.index')? 'active' :'' }}"><a href="{{ route('spotlight.index') }}"><i class="feather icon-shopping-bag"></i><span class="menu-title" data-i18n="Team">Spotlight</span></a>
                </li>
                <li class="nav-item {{ (\Route::currentRouteName() == 'trending.index')? 'active' :'' }}"><a href="{{ route('trending.index') }}"><i class="feather icon-shopping-bag"></i><span class="menu-title" data-i18n="Team">Trending</span></a>
                </li>
                <li class="nav-item {{ (\Route::currentRouteName() == 'liketrending.index')? 'active' :'' }}"><a href="{{ route('liketrending.index') }}"><i class="feather icon-shopping-bag"></i><span class="menu-title" data-i18n="Team">Like Trending</span></a>
                </li>

                <li class=" navigation-header"><span>Aboutus Settings</span>
                </li>
                <li class="nav-item {{ (\Route::currentRouteName() == 'aboutus.index')? 'active' :'' }}"><a href="{{ route('aboutus.index') }}"><i class="feather icon-shopping-bag"></i><span class="menu-title" data-i18n="Team">About us</span></a>
                </li>
                <li class="nav-item {{ (\Route::currentRouteName() == 'aboutusprofile.index')? 'active' :'' }}"><a href="{{ route('aboutusprofile.index') }}"><i class="feather icon-shopping-bag"></i><span class="menu-title" data-i18n="Team">Profile</span></a>
                </li>

                <li class=" navigation-header"><span>Our Value Settings</span>
                </li>
                <li class="nav-item {{ (\Route::currentRouteName() == 'ourvalue.index')? 'active' :'' }}"><a href="{{ route('ourvalue.index') }}"><i class="feather icon-shopping-bag"></i><span class="menu-title" data-i18n="Team">Our value</span></a>
                </li>

                <li class=" navigation-header"><span>Contact us Settings</span>
                </li>
                <li class="nav-item {{ (\Route::currentRouteName() == 'contactus.index')? 'active' :'' }}"><a href="{{ route('contactus.index') }}"><i class="feather icon-shopping-bag"></i><span class="menu-title" data-i18n="Team">Contact us</span></a>
                </li>
                <li class="nav-item {{ (\Route::currentRouteName() == 'contactusimage.index')? 'active' :'' }}"><a href="{{ route('contactusimage.index') }}"><i class="feather icon-shopping-bag"></i><span class="menu-title" data-i18n="Team">Image</span></a>
                </li>

                <li class=" navigation-header"><span>Pages Settings</span>
                </li>
                <li class="nav-item {{ (\Route::currentRouteName() == 'pages.index')? 'active' :'' }}"><a href="{{ route('pages.index') }}"><i class="feather icon-shopping-bag"></i><span class="menu-title" data-i18n="Team">Pages</span></a>
                </li>
                @endif
<!--
                <li class=" navigation-header"><span>Vendor Settings</span>
                </li>
                <li class="nav-item {{ (\Route::currentRouteName() == 'vendor.show')? 'active' :'' }}"><a href="{{ route('vendor.show') }}"><i class="feather icon-shopping-bag"></i><span class="menu-title" data-i18n="Team">Vendors</span></a>
                </li> -->

            </ul>
        </div>
    </div>
