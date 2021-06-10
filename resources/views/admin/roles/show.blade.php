@extends('admin.layouts.app')

@section('main_content')

<div class="card">
    <div class="card-header">
        <h5 class="card-title text-muted">Role Details</h5>
        <div class="float-right">
            <a class="btn btn-sm btn-info" href="{{ route('roles.index') }}"> Back</a>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">       
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Name : </label>
                    <div class="col-sm-10">
                        {{ $role->name }}
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group row">
                    <label for="input" class="col-sm-2 col-form-label">Permission : </label>
                    <div class="col-sm-10">
                        @if(!empty($rolePermissions))
                            @foreach($rolePermissions as $v)
                                <label class="label label-success">{{ $v->name }},</label>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <a class="btn btn-sm btn-info" href="{{ route('roles.index') }}"> Back</a>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <!-- /.card-body -->
</div>
@endsection