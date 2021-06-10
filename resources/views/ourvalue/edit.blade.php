@extends('admin.layouts.app')

@section('title', 'OurvalueUpdate')

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
                                    <h4 class="card-title">Our Value section updation</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form action="{{ route('ourvalue.update',[$ourvalue->id]) }}" method="POST" class="form form-vertical" enctype="multipart/form-data">
                                        @csrf
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="text1-vertical">First Text</label>
                                                            <input type="text" name="heading" class="form-control" value="{{ $ourvalue->heading }}" placeholder="Text 1" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="text2-vertical">Second Text</label>
                                                            <!-- <input type="text" name="ptext" class="form-control" value="{{ $ourvalue->ptext }}" placeholder="Text 2" required> -->
                                                            <textarea name="ptext" class="form-control" id="create-ck" value="" placeholder="Text 2">{{ $ourvalue->ptext }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="image-vertical">Image</label>
                                                            <input type="file" name="image" class="form-control" id="image" value="{{ old('image') }}" placeholder="Image" accept="image/*" >
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group" style="text-align: center;">
                                                             <img id="preview-image-before-upload" class="prvv" src="{{ asset('theme/ourvalueimg/'.$ourvalue->image) }}" alt="preview image" style="max-height: 200px;">
                                                        </div>
                                                    </div>    
                                                    <div class="col-12">
                                                        <button type="submit" class="btn btn-primary mr-1 mb-1">Update</button>
                                                        <button type="button" class="btn btn-danger mr-1 mb-1" onclick="window.location='{{route('ourvalue.index')}}'">Cancel</button>
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
<script src="https://cdn.ckeditor.com/ckeditor5/24.0.0/classic/ckeditor.js"></script>
     <script>
          ClassicEditor
            .create( document.querySelector( '#create-ck' ) )
                .then( editor => {
                    console.log( editor );
                    } )
                    .catch( error => {
                      console.error( error );
                    } );
</script>
<script>
$(document).ready(function (e) {
              $('#image').change(function(){
                let reader = new FileReader();
                reader.onload = (e) => {
                  $('#preview-image-before-upload').attr('src', e.target.result); 
                }
                reader.readAsDataURL(this.files[0]);
              });
             });
</script>
@endsection