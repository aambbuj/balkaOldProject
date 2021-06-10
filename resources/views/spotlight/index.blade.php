@extends('admin.layouts.app')

@section('title', 'Banners')

@section('main_content')



@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif



<!-- Slider list start -->    
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
                                            <th>Category Name</th>
                                            <th>Image</th>
                                            <th>Action</th>
                                            <th>Show</th>
                                        </tr>
                                    </thead>
                                    <tbody> 
                                    @foreach($spotlights as $spotlight)
                                        <tr>
                                            <th>{{$spotlight->category->name}}</th>
                                            <th><img src="{{asset('images/' . $spotlight->category->image)}}" style="width: 120px;  height: 100px;" ></th>
                                            <th><a href="{{ route('spotlight.edit',[$spotlight->id]) }}" class="text-success"><i class="fas fa-edit"></i></a></th>
                                            <th><a href="{{ route('spotlightproduct.index',[$spotlight->category_id]) }}" class="text-success"><i class="fas fa-edit"></i></a></th>
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
    <!-- Slider list ends -->


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
