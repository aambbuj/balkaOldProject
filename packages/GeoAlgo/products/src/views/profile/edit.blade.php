              
@extends('admin.layouts.app')

@section('title', 'Brand')

@section('main_content')

@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif       
<div class="col-xs-12 col-sm-12 col-md-12">

        <div class="alert alert-danger" role="alert" id="show_error" style="display: none;">
          This is a warning alert—check it out!
        </div>
      </div>
                <div id="loading" style="display: none;">
                  <i class="fas fa-spinner fa-spin icon-spining"></i>
                </div>
               <div class="card-body">
                  <form action="{{ route('profile.store') }}" method="POST" id="brand_form" class="form" enctype="multipart/form-data">
                    @csrf
                    
                    @if($edit == true && !empty($brand))
                    <input type="hidden" name="user_id" value="{{ $brand ? $brand->id : null}}"/>
                    <input type="hidden" name="brand_id" value="{{ $brand->brand ? $brand->brand->id:null }}"/>
                    <input type="hidden" name="vendor_id" value="{{ $brand->vendorAddress?$brand->vendorAddress->id : null}}"/>
                    <input type="hidden" name="edit" value="true"/>
                    @endif

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Vendor Name</strong>
                                <input type="name" name="username" class="form-control" value="{{ ($edit == true && !empty($brand))?$brand->name:'' }}" placeholder="Username" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Parent Firm</strong>
                                <input type="text" name="email" class="form-control" value="{{ ($edit == true && !empty($brand))?$brand->email:'' }}" placeholder="Parent Firm (if applicable)">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                            <strong>Type of Establishment</strong>
                            <select class="form-control" id="type_establishment" name="type_establishment">
                                <option value="" selected>{{ ($edit == true && !empty($brand->vendorAddress))?$brand->vendorAddress->type_establishment:'Select Type of Establishment' }}</option>
                                <option value="Private Limited Company">Private Limited Company</option>
                                <option  value="Partnership/LLP">Partnership/LLP</option>
                                <option  value="Sole Proprietorship">Sole Proprietorship</option>
                            </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Registered Address</strong>
                                <textarea name="reg_address" value="{{ ($edit == true && !empty($brand->vendorAddress))?$brand->vendorAddress->reg_address:'' }}" class="form-control" placeholder="Registered Address" required>{{ ($edit == true && !empty($brand->vendorAddress))?$brand->vendorAddress->reg_address:'' }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Shipping Address</strong>
                                <textarea name="shi_address" value="" class="form-control" placeholder="Shipping Address (to calculate for Pickkr)">{{ ($edit == true && !empty($brand->vendorAddress))?$brand->vendorAddress->shi_address:'' }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Office Contact</strong>
                                <input type="number" name="phone" class="form-control" value="{{ ($edit == true && !empty($brand))?$brand->mobile:'' }}" placeholder="Office Contact" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Official Email id</strong>
                                <input type="email" name="email" class="form-control" value="{{ ($edit == true && !empty($brand->vendorAddress))?$brand->email:'' }}" placeholder="Official Email id" required>
                            </div>
                        </div>

                        <!-- <div class="col-md-6">
                            <div class="form-group">
                                <strong>Official Password</strong>
                                <input type="password" name="password" class="form-control" value="{{ ($edit == true && !empty($brand->vendorAddress))?$brand->password:'' }}" placeholder="Official password" required>
                            </div>
                        </div> -->


                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Authorised person</strong>
                                <input type="text" name="authorised_person" class="form-control" value="{{ ($edit == true && !empty($brand->vendorAddress))?$brand->vendorAddress->authorised_person:'' }}" placeholder="Authorised person" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Authorised person contact number</strong>
                                <input type="number" name="authorised_contact" class="form-control" value="{{ ($edit == true && !empty($brand->vendorAddress))?$brand->vendorAddress->authorised_contact:'' }}" placeholder="Authorised person contact number" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Authorised person email id </strong>
                                <input type="email" name="authorised_email" class="form-control" value="{{ ($edit == true && !empty($brand->vendorAddress))?$brand->vendorAddress->authorised_email:'' }}" placeholder="Authorised person email id " required>
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
                                <input type="text" name="commercial_terms" class="form-control" value="{{ ($edit == true && !empty($brand->vendorAddress))?$brand->vendorAddress->commercial_terms:'' }}" placeholder="Commercial Terms" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>GST (if applicable)</strong>
                                <input type="text" name="gst" class="form-control" value="{{ ($edit == true && !empty($brand->vendorAddress))?$brand->vendorAddress->gst:'' }}" placeholder="GST (if applicable)" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>HSN codes applicable</strong>
                                <input type="text" name="HSN_codes" class="form-control" value="{{ ($edit == true && !empty($brand->vendorAddress))?$brand->vendorAddress->HSN_codes:'' }}" placeholder="HSN codes applicable" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>vendor Logo</strong>
                                <input type="file" name="vendor_logo" class="form-control" value="{{ ($edit == true && !empty($brand->vendorAddress))?$brand->vendorAddress->vendor_logo:'' }}" placeholder="vendor Logo" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Shipping (By vendor or Balkae)</strong>
                                <select class="form-control" id="shipping_type" name="shipping_type">
                                    <option value="" selected>{{ ($edit == true && !empty($brand->vendorAddress))?$brand->vendorAddress->shipping_type:'Shipping (By vendor or Balkae)' }}</option>
                                    <option value="Private Limited Company">By vendor</option>
                                    <option  value="Partnership/LLP">By Balkae</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Brand Name</strong>
                                <input type="text" name="brand_name" class="form-control" value="{{ ($edit == true && !empty($brand->brand))?$brand->brand->name:'' }}" placeholder="Brand Name" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Brand Image</strong>
                                <input type="file" name="brand_image" class="form-control" value="{{ ($edit == true && !empty($brand->brand))?$brand->brand->brand_image:'' }}" placeholder="Brand Image" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Brand Percentage</strong>
                                <input type="number" name="percentage" class="form-control" value="{{ ($edit == true && !empty($brand->brand))?$brand->brand->percentage:'' }}" placeholder="Brand Percentage" required>
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
              </div>
            </div>

            <button style="display: none;" id="success_call"></button>

            <script type="text/javascript">
              
            //  $(document).ready(function(){
            //     $("#brand_form").on("submit", function(e){
            //       e.preventDefault();
            //       $("#loading").show();
            //       $.ajax({
            //         url: "{{ route('brand.store') }}",
            //         type: "POST",
            //         data: new FormData(this),
            //         contentType: false,
            //         cache: false,
            //         processData:false,
            //         beforeSend : function(){
            //           //$("#preview").fadeOut();
            //           // $("#err").fadeOut();
            //         },
            //         success: function(data){
            //           $("#loading").hide();
            //           console.log(data); //Call me bhai
            //           if(data.type == "success"){
            //             $("#success_call").trigger("click");
            //           }else{
            //             $("#show_error").html(data.msg);
            //             $("#show_error").show("slow");
            //           }
            //         },
            //         error: function(error){
            //           $("#show_error").html("Please contact admin");
            //           $("#show_error").show("slow");
            //         }
            //       });
            //     });
            //  });
            </script>
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

@push('css')
@endpush

@push('js')
<script>
  $(document).ready(function() {
    $('#dataTable').DataTable();
} );
</script>
@endpush