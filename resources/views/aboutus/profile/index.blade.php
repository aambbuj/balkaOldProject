@extends('admin.layouts.app')

@section('title', 'About us Profile')

@section('main_content')



@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif



<!-- Banner list start -->    
    <section id="basic-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-content">
                        <div class="card-body card-dashboard">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Text 1</th>
                                            <th>Text 2</th>
                                            <th>Image</th>
                                            <th>Edit</th>
                                        </tr>
                                    </thead>
                                    <tbody> 
                                    @foreach($aboutusprofiles as $aboutusprofile)
                                        <tr>
                                            <th>{{$aboutusprofile->pname}}</th>
                                            <th>{{$aboutusprofile->ptext}}</th>
                                            <th><img src="{{asset('theme/aboutusimg/' . $aboutusprofile->image)}}" style="width: 120px;  height: 100px;" ></th>
                                            <th><a href="{{ route('aboutusprofile.edit',[$aboutusprofile->id]) }}" class="text-success"><i class="fas fa-edit"></i></a></th>
                                        </tr>
                                        @endforeach
                                    </tbody>
<!--                                     <tfoot>
                                        <tr>
                                            <th>Sl No</th>
                                            <th>Team Name</th>
                                            <th>Parent Team</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot> -->
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>   
    <!-- Banner list ends -->


@endsection

@section('page-style')

@endsection

@section('page-script')
<script>
var table = null;
$(document).ready(function() {
  table = $('#dataTable').DataTable({  
  });
});

</script>
@endsection
