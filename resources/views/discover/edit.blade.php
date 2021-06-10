@extends('admin.layouts.app')

@section('title', 'SpecificUpdate')

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
                                    <h4 class="card-title">Discover section updation</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form action="{{ route('discover.update',[$discover->id]) }}" method="POST" class="form form-vertical" enctype="multipart/form-data">
                                        @csrf
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="text1-vertical">First Text</label>
                                                            <input type="text" name="text1" class="form-control" value="{{$discover->text1}}" placeholder="Text 1" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="text1-vertical">Second Text</label>
                                                            <input type="text" name="text2" class="form-control" value="{{$discover->text2}}" placeholder="Text 1" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="text1-vertical">Desktop Text</label>
                                                            <input type="text" name="desktoptext" class="form-control" value="{{$discover->desktoptext}}" placeholder="Text 1" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="url-vertical">URL</label>
                                                            <input type="text" name="desktopurl" class="form-control" value="{{$discover->desktopurl}}" placeholder="Url" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="text1-vertical">Mobile Text</label>
                                                            <input type="text" name="mobiletext" class="form-control" value="{{$discover->mobiletext}}" placeholder="Text 1" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="url-vertical">URL</label>
                                                            <input type="text" name="mobileurl" class="form-control" value="{{$discover->mobileurl}}" placeholder="Url" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <button type="submit" class="btn btn-primary mr-1 mb-1">Update</button>
                                                        <button type="button" class="btn btn-danger mr-1 mb-1" onclick="window.location='{{route('discover.index')}}'">Cancel</button>
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