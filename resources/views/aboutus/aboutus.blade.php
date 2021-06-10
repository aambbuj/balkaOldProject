@extends('layouts.frontend.master')
@section('title')
Balkae || About Us
@endsection
@section('content')
<div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="content-box">
                    <p class="heading-style">{{$aboutuses[0]->style}}</p>
                    <p class="heading-style-signature">{{$aboutuses[0]->signature}}</p>
                    <p class="about-paragraph">{{$aboutuses[0]->paragraph}} </p>
                </div>
            </div>
            <div class="col-md-6" style="background-color: #FFFCEF; padding: 0;">
                <img style="width: 100%;" src="{{asset('theme/aboutusimg/' . $aboutuses[0]->image)}}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6" style="padding: 0;">
                <img class="only_web" style="width: 100%;" src="{{asset('theme/aboutusimg/' . $aboutuses[1]->image)}}">
            </div>
            <div class="col-md-6">
                <div class="content-box">
                    <!-- <p class="heading-style">Our <span class="heading-style-signature">about who we are...</span></p> -->
                    <!-- <p class="heading-style-signature">about who we are...</p> -->
                    <p class="mob_alignment_gaap-two"><span class="heading-style  ">{{$aboutuses[1]->style}} &nbsp;</span> <span class="heading-style-signature margin-down-style">{{$aboutuses[1]->signature}}</span></p>
                    <p class="about-paragraph mob_alignment_gaap">{{$aboutuses[1]->paragraph}}  </p>
                    <img class="only_mobile" style="width: 100%;" src="{{asset('theme/aboutusimg/' . $aboutuses[1]->image)}}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="content-box">
                    <p class="heading-style">{{$aboutuses[2]->style}}</p>
                    <p class="heading-style-signature">{{$aboutuses[2]->signature}}</p>
                    <p class="about-paragraph">{{$aboutuses[2]->paragraph}}  </p>
                </div>
            </div>
            <div class="col-md-6" style="background-color: #FFFCEF; padding: 0;">
                <img style="width: 100%;" src="{{asset('theme/aboutusimg/' . $aboutuses[2]->image)}}">
            </div>
        </div>
        <div class="row">
            <div class="col mt-5">
                <div class="heading-style-center">
                    <p class="about-heading-style">“Let’s add a quote in this area if it helps.”</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container big-gapping mt-2">
        <div class="row">
            <div class="col-md-6">
                <p><span class="heading-style">And &nbsp;</span> <span class="heading-style-signature margin-down-style"> here’s us!</span></p>
                <div class="user-profile">
                    <img src="{{asset('theme/aboutusimg/' . $aboutusprofiles[0]->image)}}">
                    <p class="profile_name">{{$aboutusprofiles[0]->pname}}</p>
                    <p class="profile-text">{{$aboutusprofiles[0]->ptext}} </p>
                </div>
            </div>
            <div class="col-md-6">
                <p><span class="heading-style only_web" style="visibility: hidden;">A&nbsp;</span> </p>
                <div class="user-profile">
                    <img src="{{asset('theme/aboutusimg/' . $aboutusprofiles[1]->image)}}">
                    <p class="profile_name">{{$aboutusprofiles[1]->pname}}</p>
                    <p class="profile-text">{{$aboutusprofiles[1]->ptext}}</p>
                </div>
            </div>
        </div>
    </div>
@endsection