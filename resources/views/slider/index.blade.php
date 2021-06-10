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
                       <a href="{{ route('slider.create') }}" class="btn btn-primary"><i class="fas fa-plus pr-1"></i>ADD PRODUCT</a>
                    </div>
                    <div class="card-content">
                        <div class="card-body card-dashboard">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Image</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody> 
                                    @foreach($sliders as $slider)
                                        <tr>
                                            <th>{{$slider->product->product_name}}</th>
                                            <th><img src="{{asset('Pimages/' . $slider->product->image)}}" style="width: 120px;  height: 100px;" ></th>
                                            <th><a href="{{ route('slider.edit',[$slider->id]) }}" class="text-success"><i class="fas fa-edit"></i></a></th>
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

@endsection
