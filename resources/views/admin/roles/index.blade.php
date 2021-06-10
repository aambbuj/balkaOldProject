@extends('admin.layouts.app')

@section('title', 'Role List Page')

@section('page-style')

@endsection

@section('main_content')

    <!-- Page listing start -->    
    <section id="basic-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        @can('role-create')
                        <a href="{{ route('roles.create') }}" class="btn btn-primary"><i class="fas fa-plus pr-1"></i>ADD ROLES</a>
                         @endcan
                    </div>
                    <div class="card-content">
                        <div class="card-body card-dashboard">
                            <div class="table-responsive">
                                <table class="table zero-configuration">
                                    <thead>
                                        <tr>

                                            <th width="12%">Sl No</th>
                                            <th>Role & Permission</th>
                                            <th width="18%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody> 
                                   @foreach($roles as $key => $role)                                 
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $role->name }}</td> 
                                            <td>
                                                <!-- <a class="btn btn-xs btn-info" href="{{ route('roles.show',$role->id) }}">Show</a> -->
                                                @can('role-edit')
                                                    <a class="btn btn-sm btn-primary btnRole" href="{{ route('roles.edit',$role->id) }}">Edit</a>
                                                @endcan

                                                @can('role-delete')
                                                    {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
                                                        {!! Form::submit('Delete', ['class' => 'btn btn-sm btn-danger btnRole']) !!}
                                                    {!! Form::close() !!}
                                                @endcan
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Sl No</th>
                                            <th>Role & Permission</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>   
    <!-- Page listing ends -->
@endsection