@extends('admin.layouts.app')

@section('title', 'Banners')

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
                                            <th>Url</th>
                                            <th>Image</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody> 
                                    @foreach($banners as $banner)
                                        <tr>
                                            <th>{{$banner->text1}}</th>
                                            <th>{{$banner->text2}}</th>
                                            <th>{{$banner->url}}</th>
                                            <th><img src="{{asset('theme/motivationimg/' . $banner->image)}}" style="width: 120px;  height: 100px;" ></th>
                                            <th><a href="{{ route('motivation.edit',[$banner->id]) }}" class="text-success"><i class="fas fa-edit"></i></a></th>
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

@endsection
