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
                  <form action="{{ route('product.update',[$product->id]) }}" method="POST" id="category_form" class="form" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                      <input type="text" name="SKU" class="form-control" value="{{ $product->SKU }}" placeholder="SKU" required>
                    </div>
                    <div class="form-group">
                      <input type="text" name="name" class="form-control" value="{{ $product->ProductName }}" placeholder="Product Name" required>
                    </div>
                    <div class="form-group">
                      <textarea name="description" class="form-control" value="" placeholder="Description" required>{{ $product->ProductDescription }}</textarea>
                    </div>
                    <div class="form-group">
                      <select class="form-control" name="category_name">
                        <option value="{{ $product->CategoryName }}">{{ $product->CategoryName }}</option>
                        <option value="">Change the Category</option>

                        @foreach ($categories as $category)
                          <option value="{{ $category->name }}">{{ $category->name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <input type="text" name="qty" class="form-control" value="{{ $product->QtyPerUnit }}" placeholder="Quantity" required>
                    </div>
                    <div class="form-group">
                      <input type="text" name="price" class="form-control" value="{{ $product->UnitPrice }}" placeholder="Price" required>
                    </div>
                    <div class="form-group">
                    <input type="text" name="reorderlevel" class="form-control" value="{{ $product->ReorderLevel }}" placeholder="Reorder Level" required>
                    </div>
                    <div class="form-group">
                      <input type="file" name="image" class="form-control" value="{{ old('image') }}" placeholder="Image" accept="image/*" required>
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary">Update</button>
                     </div> 
                  </form>
                </div>

     @endsection       