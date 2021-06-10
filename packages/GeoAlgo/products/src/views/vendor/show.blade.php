@extends('admin.layouts.app')

@section('title', 'Create Vendor')

@section('main_content')

<!-- @if (count($errors) > 0)
  <div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
       @foreach ($errors->all() as $error)
         <li>{{ $error }}</li>
       @endforeach
    </ul>
  </div>
@endif -->

    @if (\Session::has('error'))
        <div class="alert alert-success">
            <ul>
                <li>{!! \Session::get('error') !!}</li>
            </ul>
        </div>
    @endif

    <div class="card-body">
        <form action="{{ route('vendor.store') }}" method="POST" id="vendor_form" class="form row" enctype="multipart/form-data">
            @csrf
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <strong>Vendor Name</strong>
                            <input type="name" name="username" class="form-control" value="{{ old('name') }}" placeholder="Username" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <strong>Parent Firm</strong>
                            <input type="text" name="email" class="form-control" value="{{ old('email') }}" placeholder="Parent Firm (if applicable)">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                        <strong>Type of Establishment</strong>
                        <select class="form-control" id="type_establishment" name="type_establishment">
                            <option hidden value="">Select Type of Establishment</option>
                            <option value="Private Limited Company" selected>Private Limited Company</option>
                            <option  value="Partnership/LLP">Partnership/LLP</option>
                            <option  value="Sole Proprietorship">Sole Proprietorship</option>
                        </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <strong>Registered Address</strong>
                            <textarea name="reg_address" class="form-control" placeholder="Registered Address" required></textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <strong>Shipping Address</strong>
                            <textarea name="shi_address" class="form-control" placeholder="Shipping Address (to calculate for Pickkr)"></textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <strong>Office Contact</strong>
                            <input type="number" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="Office Contact" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <strong>Official Email id</strong>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Official Email id" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <strong>Official Password</strong>
                            <input type="password" name="password" class="form-control" value="{{ old('password') }}" placeholder="Official password" required>
                        </div>
                    </div>

                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <strong>Authorised person</strong>
                            <input type="text" name="authorised_person" class="form-control" value="{{ old('authorised_person') }}" placeholder="Authorised person" required>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <strong>Authorised person contact number</strong>
                            <input type="number" name="authorised_contact" class="form-control" value="{{ old('authorised_contact') }}" placeholder="Authorised person contact number" required>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <strong>Authorised person email id </strong>
                            <input type="email" name="authorised_email" class="form-control" value="{{ old('authorised_email') }}" placeholder="Authorised person email id " required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                        <strong>Product Category</strong><br>
                            <label class="checkbox-inline"><input type="checkbox"  name="product_category[]" value="Apparel"> Apparel</label>
                            <label class="checkbox-inline"><input type="checkbox"  name="product_category[]"  value="Fine Jewellery"> Fine Jewellery</label>
                            <label class="checkbox-inline"><input type="checkbox"  name="product_category[]"  value="Imitation Jewellery"> Imitation Jewellery</label>
                            <label class="checkbox-inline"><input type="checkbox"  name="product_category[]"  value="Scarves"> Scarves</label>
                            <label class="checkbox-inline"><input type="checkbox"  name="product_category[]"  value="Belts"> Belts</label>
                            <label class="checkbox-inline"><input type="checkbox"  name="product_category[]"  value="Footwear"> Footwear</label>
                            <label class="checkbox-inline"><input type="checkbox"  name="product_category[]"  value="Other Accessories"> Other Accessories</label>
                            <label class="checkbox-inline"><input type="checkbox"  name="product_category[]"  value="Skincare"> Skincare</label>
                            <label class="checkbox-inline"><input type="checkbox"  name="product_category[]"  value="Haircare"> Haircare</label>
                            <label class="checkbox-inline"><input type="checkbox"  name="product_category[]"  value="Makeup"> Makeup</label>
                        </div>
                    </div>

                                        
                    <div class="col-md-6">
                        <div class="form-group">
                            <strong>Commercial Terms</strong>
                            <input type="text" name="commercial_terms" class="form-control" value="{{ old('commercial_terms') }}" placeholder="Commercial Terms" required>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <strong>GST (if applicable)</strong>
                            <input type="text" name="gst" class="form-control" value="{{ old('gst') }}" placeholder="GST (if applicable)" required>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <strong>HSN codes applicable</strong>
                            <input type="text" name="HSN_codes" class="form-control" value="{{ old('HSN_codes') }}" placeholder="HSN codes applicable" required>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <strong>vendor Logo</strong>
                            <input type="file" name="vendor_logo" class="form-control" value="{{ old('address2') }}" placeholder="vendor Logo" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <strong>Shipping (By vendor or Balkae)</strong>
                            <select class="form-control" id="shipping_type" name="shipping_type">
                                <option hidden value="">Shipping (By vendor or Balkae)</option>
                                <option value="Private Limited Company" selected>By vendor</option>
                                <option  value="Partnership/LLP">By Balkae</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <strong>Brand Name</strong>
                            <input type="text" name="brand_name" class="form-control" value="{{ old('brand_image') }}" placeholder="Brand Name" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <strong>Brand Image</strong>
                            <input type="file" name="brand_image" class="form-control" value="{{ old('brand_image') }}" placeholder="Brand Image" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <strong>Brand Percentage</strong>
                            <input type="number" name="percentage" class="form-control" value="{{ old('percentage') }}" placeholder="Brand Percentage" required>
                        </div>
                    </div>
                     
                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Add</button>
                            <button type="button" class="btn btn-danger" onclick="window.location='{{route('product.index')}}'">Cancel</button>
                        </div>
                    </div>
            
                </div>
        </form>
    </div>

    <button style="display: none;" id="success_call"></button>

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

<!-- <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script> -->
<script>
// CKEDITOR.replace( '#create-ck' );
</script>


    <script type="text/javascript">

    <style>
  .icon-spining {
        position: absolute;
        top: 45%;
        left: 45%;
        font-size: 40px;
    }
    div#loading {
        background: #f0f8ffa6;
        width: 100%;
        height: 100%;
        position: absolute;
        filter: blur(1px);
    }
</style>
  
     @endsection

     @section('page-style')
      <style>
.ck-editor__editable_inline {
    min-height: 300px;
}
</style>
     @endsection