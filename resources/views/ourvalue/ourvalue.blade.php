@extends('layouts.frontend.master')
@section('title')
Balkae || Our Values
@endsection
@section('content')
<div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="our-value mt-5">
                    <p class="value_main_head">{{$ourvalues[0]->heading}}</p>
                    <p class="pt-5 value_main-para">{{$ourvalues[0]->ptext}}</p>
                </div>
            </div>
            <div class="col-md-6"></div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="value-card mt-5">
                    <div class="d-flex flex-row bd-highlight mb-3 value-blue-card">
                        <div class="p-2 bd-highlight badges-icon">
                            <img class="badges-one" src="{{asset('theme/ourvalueimg/' . $ourvalues[1]->image)}}">
                        </div>
                        <div class="p-2 bd-highlight">
                            <p class="value-text-head">{{$ourvalues[1]->heading}}</p>
                            <p class="value-text">{!! html_entity_decode($ourvalues[1]->ptext) !!} </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="value-card mt-5">
                    <div class="d-flex flex-row bd-highlight mb-3 value-blue-card value-red-card">
                        <div class="p-2 bd-highlight badges-icon">
                            <img class="badges-one" src="{{asset('theme/ourvalueimg/' . $ourvalues[2]->image)}}">
                        </div>
                        <div class="p-2 bd-highlight">
                            <p class="value-text-head">{{$ourvalues[2]->heading}}</p>
                            <p class="value-text">{!! html_entity_decode($ourvalues[2]->ptext) !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="value-card mt-5">
                    <div class="d-flex flex-row bd-highlight mb-3 value-blue-card value-red-card">
                        <div class="p-2 bd-highlight badges-icon">
                            <img class="badges-one" src="{{asset('theme/ourvalueimg/' . $ourvalues[3]->image)}}">
                        </div>
                        <div class="p-2 bd-highlight">
                            <p class="value-text-head">{{$ourvalues[3]->heading}}</p>
                            <p class="value-text">{!! html_entity_decode($ourvalues[3]->ptext) !!}</p>
                        </div>
                    </div>
                </div>

                <div class="value-card mt-5">
                    <div class="d-flex flex-row bd-highlight mb-3 value-blue-card">
                        <div class="p-2 bd-highlight badges-icon">
                            <img class="badges-one" src="{{asset('theme/ourvalueimg/' . $ourvalues[4]->image)}}">
                        </div>
                        <div class="p-2 bd-highlight some_alignment-on-largr_text">
                            <p class="value-text-head">{{$ourvalues[4]->heading}}</p>
                            <p class="value-text">{!! html_entity_decode($ourvalues[4]->ptext) !!}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="value-card mt-5">
                    <div class="d-flex flex-row bd-highlight mb-3 value-blue-card big-blue">
                        <div class="p-2 bd-highlight badges-icon">
                            <img class="badges-one" src="{{asset('theme/ourvalueimg/' . $ourvalues[5]->image)}}">
                        </div>
                        <div class="p-2 bd-highlight some_alignment-on-largr_text">
                            <p class="value-text-head">{{$ourvalues[5]->heading}}</p>
                            <p class="value-text">{!! html_entity_decode($ourvalues[5]->ptext) !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="value-card mt-5">
                    <div class="d-flex flex-row bd-highlight mb-3 value-blue-card value-yellow-card">
                        <div class="p-2 bd-highlight badges-icon">
                            <img class="badges-one" src="{{asset('theme/ourvalueimg/' . $ourvalues[6]->image)}}">
                        </div>
                        <div class="p-2 bd-highlight">
                            <p class="value-text-head">{{$ourvalues[6]->heading}}</p>
                            <p class="value-text">{!! html_entity_decode($ourvalues[6]->ptext) !!}</p>
                        </div>
                    </div>
                </div>

                <div class="value-card mt-5">
                    <div class="d-flex flex-row bd-highlight mb-3 value-blue-card value-yellow-card">
                        <div class="p-2 bd-highlight badges-icon">
                            <img class="badges-one" src="{{asset('theme/ourvalueimg/' . $ourvalues[7]->image)}}">
                        </div>
                        <div class="p-2 bd-highlight some_alignment-on-largr_text">
                            <p class="value-text-head">{{$ourvalues[7]->heading}}</p>
                            <p class="value-text">{!! html_entity_decode($ourvalues[7]->ptext) !!}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="value-card mt-5">
                    <div class="d-flex flex-row bd-highlight mb-3 value-blue-card big-blue  value-yellow-card">
                        <div class="p-2 bd-highlight badges-icon">
                            <img class="badges-one" src="{{asset('theme/ourvalueimg/' . $ourvalues[8]->image)}}">
                        </div>
                        <div class="p-2 bd-highlight some_alignment-on-largr_text">
                            <p class="value-text-head">{{$ourvalues[8]->heading}}</p>
                            <p class="value-text">{!! html_entity_decode($ourvalues[8]->ptext) !!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection