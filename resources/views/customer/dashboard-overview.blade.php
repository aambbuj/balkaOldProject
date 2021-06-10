@extends('layouts.frontend.masterfb')
@section('title')
Balkae || Dashboard
@endsection
@section('content')
    <!--Dashboard Overview-->
        <div class="wrap px-3 px-md-5 pt-5 pt-md-4">
            <h3 class="greeting mt-3 mb-4 d-none d-md-block">Nice to see you again! 👋</h3>
            <div class="balkae-ablogo">
                <svg width="199" height="438" viewBox="0 0 199 438" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M6.00002 432.303L6 6" stroke="var(--yellow)" stroke-width="11" stroke-linecap="round"/>
        <path d="M161.057 275.577L7.80999 177.201C7.14444 176.774 6.26978 177.252 6.26978 178.043L6.26978 430.881C6.26978 431.687 7.17392 432.161 7.83732 431.704L161.877 325.523C179.522 313.36 179.092 287.154 161.057 275.577Z" stroke="var(--yellow)" stroke-width="11" stroke-linecap="round"/>
        <path d="M106.044 240.784L7.8131 177.211C7.14774 176.781 6.26978 177.258 6.26978 178.051L6.26978 358.598C6.26978 359.406 7.17736 359.88 7.84044 359.419L106.864 290.605C124.383 278.43 123.954 252.375 106.044 240.784Z" stroke="var(--yellow)" stroke-width="11" stroke-linecap="round"/>
        <path d="M108.666 311.417L7.54081 246.399C6.8753 245.971 6 246.449 6 247.24L6 430.879C6 431.686 6.9048 432.16 7.56815 431.702L109.486 361.339C127.107 349.174 126.677 322.997 108.666 311.417Z" stroke="var(--yellow)" stroke-width="11" stroke-linecap="round"/>
        </svg>
        </div>
            <div class="dash-back d-block d-md-none">
                <a href=""><i class="far fa-long-arrow-left"></i> back</a>
            </div>
            <div class="dash-cpage d-block d-md-none">
                <p>Overview</p>
            </div>
            <div class="row pt-2">
                <div class="col-lg-4 mb-3 mb-lg-4">
                    <div class="user-overview">
                        <p class="user-name">{{auth()->user()->name}}</p>
                        <p class="user-mail">{{auth()->user()->email}}</p>
                        <p class="user-phone d-none d-md-block">+91 {{auth()->user()->mobile ? auth()->user()->mobile : 'Please add mobile no.'}}</p>
                        <?php
                          $since=date('d-M-Y',strtotime(auth()->user()->created_at));
                        ?>
                        <p class="user-join d-none d-md-block">Member since {{$since}}</p>
                        <a href="{{route('customer.profile')}}" role="button" class="dash-btn">Edit profile</a>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="user-values pb-2">
                        <div class="d-flex justify-content-between">
                            <p>VALUES YOU’VE PURCHASED</p>
                            <a href="#">View All</a>
                        </div>
                        <div class="user-vicons mt-3">
                            <div class="enabled-value">
                                <img src="{{asset('theme/img/values/value1.png')}}" alt="">
                            </div>
                            <div class="enabled-value">
                                <img src="{{asset('theme/img/values/value1.png')}}" alt="">
                            </div>
                            <div class="enabled-value">
                                <img src="{{asset('theme/img/values/value1.png')}}" alt="">
                            </div>
                            <div class="disabled-value">
                                <img src="{{asset('theme/img/values/value1.png')}}" alt="">
                            </div>
                            <div class="disabled-value d-none d-md-block">
                                <img src="{{asset('theme/img/values/value1.png')}}" alt="">
                            </div>
                            <div class="disabled-value d-none d-md-block">
                                <img src="{{asset('theme/img/values/value1.png')}}" alt="">
                            </div>
                            <div class="disabled-value d-none d-md-block">
                                <img src="{{asset('theme/img/values/value1.png')}}" alt="">
                            </div>
                            <div class="disabled-value d-none d-md-block">
                                <img src="{{asset('theme/img/values/value1.png')}}" alt="">
                            </div>
                            <div class="disabled-value d-none d-md-block">
                                <img src="{{asset('theme/img/values/value1.png')}}" alt="">
                            </div>
                            <div class="disabled-value d-none d-md-block">
                                <img src="{{asset('theme/img/values/value1.png')}}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!--Dashboard Overview-->
    @endsection