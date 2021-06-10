@extends('admin.layouts.app')

@section('title', 'User Update')

@section('main_content')

@if(count($errors) > 0)
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @break
        @endforeach
    </ul>
</div>
@endif

    <!-- users create start -->    
    <section class="users-edit">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <ul class="nav nav-tabs mb-3" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center active" id="account-tab" data-toggle="tab" href="#account" aria-controls="account" role="tab" aria-selected="true">
                                <i class="feather icon-user mr-25"></i><span class="d-none d-sm-block">User Account</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center" id="information-tab" data-toggle="tab" href="#information" aria-controls="information" role="tab" aria-selected="false">
                                <i class="feather icon-info mr-25"></i><span class="d-none d-sm-block">Information</span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
                           
                            <!-- users account form start -->
                            <form action="{{ route('users.update',$user->id) }}" method="POST" novalidate>
                                @csrf
                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Name</label>
                                                <input type="text" class="form-control" placeholder="Name" name="name" value="{{ $user->name}}" required data-validation-required-message="This username field is required">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>E-mail</label>
                                                <input type="email" class="form-control" placeholder="Email" name="email" value="{{ $user->email }}" required data-validation-required-message="This email field is required">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Phone</label>
                                                <input type="number" class="form-control" placeholder="Phone" name="phone" value="{{ $user->phone }}" required data-validation-required-message="This phone field is required">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Password</label>
                                                <input type="password" class="form-control" placeholder="Password" name="password" required data-validation-required-message="This password field is required">
                                            </div>
                                        </div>                                       
                                    </div>

                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label>Role</label>
                                            <select class="form-control" id="roles" name="roles">
                                                <option value="null">Select Role</option>
                                                @foreach($roles as $key => $role)
                                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                                                @endforeach
                                               
                                            </select>
                                        </div>                                        
                                    </div>                                 

                                    <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                                        <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-1">Update</button>
                                        <a href="{{ route('users.index') }}" class="btn btn-info">Back</a>
                                    </div>
                                </div>
                            </form>
                            <!-- users account form ends -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- users create ends -->

@endsection

@section('page-script')
<script>
  $(document).ready(function() {
    const rolesOldValue = '{{ old('roles') }}';    
    if(rolesOldValue !== '') {
      $('#roles').val(rolesOldValue);
    }
    const teamOldValue = '{{ old('teams') }}';
    if(teamOldValue !== '') {
        $('#teams').val(teamOldValue);
    }
    const parentuserOldValue = '{{ old('parent_id') }}';
    if (parentuserOldValue !== '') {
        $('#parent_id').val(parentuserOldValue);
    }
  });
</script>
@endsection