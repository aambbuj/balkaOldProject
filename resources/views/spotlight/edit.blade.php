@extends('admin.layouts.app')

@section('title', 'BannerUpdate')

@section('main_content')

@if (count($errors) > 0)
  <div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
       @foreach ($errors->all() as $error)
         <li>{{ $error }}</li>
       @endforeach
    </ul>
  </div>
@endif

                <div class="col-md-12 col-12">
                            <div class="card center-card">
                                <div class="card-header">
                                    <h4 class="card-title">Spotlight section updation</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form action="{{ route('spotlight.update',[$spotlight->id]) }}" method="POST" class="form form-vertical" enctype="multipart/form-data">
                                        @csrf
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="text1-vertical">Select Category</label>
                                                            <select class="form-control" name="category_id">
                                                            <option hidden value="">Select Category</option>
                                                            @foreach ($categories as $category)
                                                              <option value="{{ $category->id }}" {{ ($category->id == $spotlight->category_id) ? 'selected': '' }}>{{ $category->name }}</option>
                                                            @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <button type="submit" class="btn btn-primary mr-1 mb-1">Update</button>
                                                        <button type="button" class="btn btn-danger mr-1 mb-1" onclick="window.location='{{route('spotlight.index')}}'">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>                

     @endsection       

@section('page-style')
<style>
.center-card{
  margin: 0 auto;
  max-width: 50%;
}
</style>
@endsection

@section('page-script')

@endsection