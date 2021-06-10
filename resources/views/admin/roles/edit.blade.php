@extends('admin.layouts.app')

@section('title', 'Role Update')

@section('main_content')

@if (count($errors) > 0)
<div class="alert alert-danger" role="alert">
    <strong>Whoops!</strong> There were some problems with your input.<br>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @break
        @endforeach
    </ul>
</div>
@endif

<div class="card">    
    <div class="card-body">
        <ul class="nav nav-tabs mb-3" role="tablist">
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center active" id="account-tab" data-toggle="tab" href="#account" aria-controls="account" role="tab" aria-selected="true">
                    <i class="feather icon-user mr-25"></i><span class="d-none d-sm-block">Role Update</span>
                </a>
            </li>                        
        </ul>

        {!! Form::model($role, ['method' => 'PATCH','route' => ['roles.update', $role->id]]) !!}
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Name : </label>
                    <div class="col-sm-10">
                        {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group row">
                    <label for="input" class="col-sm-2 col-form-label">Permission : </label>
                    <div class="col-sm-10">
                        @foreach($permission as $value)
                            <label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                            {{ $value->name }}</label>
                        <br/>
                        @endforeach
                    </div>
                </div>
            </div>            
        </div>

        <div class="form-group row">
            <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-3">
                <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-1">Update</button>
                <a href="{{ route('roles.index') }}" class="btn btn-info">Back</a>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <!-- /.card-body -->
</div>
@endsection