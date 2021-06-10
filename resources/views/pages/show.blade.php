@extends('layouts.frontend.master')
@section('title')
Balkae || {{ $page ? $page->name : ''}}
@endsection
@section('content')
<div class="container-fluid">
{!! html_entity_decode($page->content) !!}
</div>
@endsection