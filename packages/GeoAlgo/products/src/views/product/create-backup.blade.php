@extends('layouts.master')
@section('content')

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
               <div class="card-body">
                  <form action="{{ route('product.store') }}" method="POST" id="category_form" class="form" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                      <input type="text" name="SKU" class="form-control" value="{{ old('SKU') }}" placeholder="SKU" required>
                    </div>
                    <div class="form-group">
                      <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Product Name" required>
                    </div>
                    <div class="form-group">
                      <textarea name="description" class="form-control" value="{{ old('description') }}" placeholder="Description" required></textarea>
                    </div>
                    <div class="form-group">
                      <select class="form-control" name="category_name" id="category_name">

                      </select>
                    </div>
                    <div class="form-group">
                      <input type="text" name="qty" class="form-control" value="{{ old('qty') }}" placeholder="Quantity" required>
                    </div>
                    <div class="form-group">
                      <input type="text" name="price" class="form-control" value="{{ old('price') }}" placeholder="Price" required>
                    </div>
                    <div class="form-group">
                    <input type="text" name="reorderlevel" class="form-control" value="{{ old('reorderlevel') }}" placeholder="Reorder Level" required>
                    </div>
                    <div class="form-group">
                      <input type="file" name="image" class="form-control" value="{{ old('image') }}" placeholder="Image" accept="image/*" required>
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary">Submit</button>
                     </div>
                  </form>
                </div>

     @endsection

@section('page-script')
<script>
    $(document).ready(function(e){
        $("#category_name").select2({
            containerCssClass: "error",
            dropdownCssClass: "select2_dropdown_balkae",
            placeholder: "Select Category Types",
        });
    });
</script>
@endsection
