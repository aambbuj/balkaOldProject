@extends('admin.layouts.app')

@section('title', 'Create Product')

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

@if (\Session::has('success'))
    <div class="alert alert-success">
        <ul>
            <li>{!! \Session::get('success') !!}</li>
        </ul>
    </div>
@endif
               <div class="card-body">
                  <form action="{{ route('product.store') }}" method="POST" id="category_form" class="form row" enctype="multipart/form-data">
                    @csrf
                    <div class="col-sm-9">
                    <div class="form-group">
                      <strong>Product Name</strong>
                      <input type="text" name="name" class="form-control" value="{{ $product->product_name }}" placeholder="Product Name" required>
                    </div>
                    <div class="form-group">
                      <strong>Product Description</strong>
                      <textarea name="description" class="form-control" id="description" value="{{ $product->product_description }}" placeholder="Description">{{$product->product_description}}</textarea>
                    </div>
                    <div class="form-group">
                      <strong>Product short Description</strong>
                      <textarea name="short_description" class="form-control" id="short_description" value="{{ $product->short_description }}" placeholder="Description">{{ $product->short_description }}</textarea>
                    </div>

                    <div class="card">
                        <div class="" id="loading_category_base">
                          <img src="{{ asset('default/loader.gif') }}" class=""/>
                        </div>
                        <div class="card-header">
                            <div class="col-md-12">
                                <div class="float-left"><h5>Product Data</h5></div>
                                <span onclick="toggleContent(this)" class="float-right" style="cursor: pointer; color: blue;"><i class="fas fa-caret-down"></i></span>
                            </div>
                        </div>
                        <hr style="margin-bottom: 0px;"/>
                        <div class="card-content">
                            <div class="tab">
                                <button type="button" class="tablinks" onclick="openCity(event, 'inventory')">Inventory</button>
                                <button type="button" class="tablinks" onclick="openCity(event, 'shipping')">Shipping</button>
                                <button type="button" class="tablinks" onclick="openCity(event, 'linked_product')">Linked Product</button>
                                <button type="button" class="tablinks active" onclick="openCity(event, 'variations')">Variations</button>
                                <button type="button" class="tablinks" onclick="openCity(event, 'specifications')">Specification</button>
                                <button type="button" class="tablinks" onclick="openCity(event, 'washcare')">Washcare</button>
                                <button type="button" class="tablinks" onclick="openCity(event, 'attribute')">Attribute</button>
                            </div>

                            <div id="inventory_tab" class="tabcontent">
                              <div class="form-group row">
                                <label for="main_sku" class="col-sm-5 col-form-label">SKU :</label>
                                <div class="col-sm-7">
                                  <input type="text" class="form-control" name="main_sku" id="main_sku" placeholder="Main SKU">
                                </div>
                              </div>
                              <div class="form-group row">
                                <label for="main_stock_quantity" class="col-sm-5 col-form-label">Stock Status :</label>
                                <div class="col-sm-7">
                                  <select class="form-control" name="main_stock_status" id="main_stock_status" placeholder="Main Stock Status">
                                    <option value="" hidden>Select Stock Status</option>
                                    <option value="In Stock">In Stock</option>
                                    <option value="Out of Stock">Out of Stock</option>
                                  </select>
                                </div>
                              </div>
                              <div class="form-group row">
                                <label for="main_stock_quantity" class="col-sm-5 col-form-label">Stock Quantity :</label>
                                <div class="col-sm-7">
                                  <input type="number" class="form-control" name="main_stock_quantity" id="main_stock_quantity" placeholder="Main Stock Quantity">
                                </div>
                              </div>

                              <div class="form-group row">
                                <label for="price" class="col-sm-5 col-form-label">Price :</label>
                                <div class="col-sm-7">
                                  <input type="number" class="form-control" name="price" id="price" placeholder="Product Price">
                                </div>
                              </div>

                              <div class="form-group row">
                                <label for="main_low_stock_threshold" class="col-sm-5 col-form-label">Low Stock Threshold :</label>
                                <div class="col-sm-7">
                                  <input type="number" class="form-control" name="main_low_stock_threshold" id="main_low_stock_threshold" placeholder="Main Low Stock Threshold">
                                </div>
                              </div>
                            </div>

                            <div id="shipping_tab" class="tabcontent">
                              <div class="form-group row">
                                <label for="main_weight" class="col-sm-5 col-form-label">Weight (g) :</label>
                                <div class="col-sm-7">
                                  <input type="number" class="form-control" name="main_weight" id="main_weight" placeholder="Main Weight (g)">
                                </div>
                              </div>
                              <div class="form-group row">
                                <label class="col-sm-5 col-form-label">Dimensions (cm) :</label>
                                <div class="col-sm-7">
                                  <div class="row">
                                    <div class="col">
                                      <input type="number" class="form-control" name="main_dimension_length" id="main_dimension_length" placeholder="Length">
                                    </div>
                                    <div class="col">
                                      <input type="number" class="form-control" name="main_dimension_width" id="main_dimension_width" placeholder="Width">
                                    </div>
                                    <div class="col">
                                      <input type="number" class="form-control" name="main_dimension_height" id="main_dimension_height" placeholder="Height">
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-4">
                                  <div class="form-group" id="exchange_form">
                                    <label for="exchange_form_select" class="form-label">Exchange :</label>
                                    <select type="number" class="form-control" name="exchange_form_select" id="exchange_form_select">
                                      <option value="" hidden>Select Exchange Type</option>
                                      <option value="yes">Yes</option>
                                      <option value="Only if the merchandise is faulty or defective or is completely different from what was ordered.">Only if the merchandise is faulty or defective or is completely different from what was ordered.</option>
                                      <option value="no">No</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="form-group" id="return_form">
                                    <label for="return_form_select" class="form-label">Return :</label>
                                    <select type="number" class="form-control" name="return_form_select" id="return_form_select">
                                      <option value="" hidden>Select Return Type</option>
                                      <option value="yes">Yes</option>
                                      <option value="Only if the merchandise is faulty or defective or is completely different from what was ordered.">Only if the merchandise is faulty or defective or is completely different from what was ordered.</option>
                                      <option value="no">No</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="form-group" id="delivery_form">
                                    <label for="delivery_form_select" class="form-label">Delivery Timeline :</label>
                                    <select type="number" class="form-control" name="delivery_form_select" id="delivery_form_select">
                                      <option value="" hidden>Select Delivery Timeline</option>
                                      <option value="Not Defined">Not Defined</option>
                                      <option value="2-3 Days">2-3 Days</option>
                                      <option value="4-7 Days">4-7 Days</option>
                                      <option value="8-12 Days">8-12 Days</option>
                                      <option value="13-15 Days">13-15 Days</option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div id="linked_product_tab" class="tabcontent">
                              <div class="form-group">
                                <label for="model_wearing">Model is also wearing :</label>
                                <select type="number" class="form-control" name="model_wearing" id="model_wearing" placeholder="Select Model is also Wearing" multiple>

                                </select>
                              </div>
                            </div>

                            <div id="variations_tab" class="tabcontent" style="display: block;">                                
                                <div class="row" id="variations_data_tab">
                                </div>
                                <div class="row">
                                  <div class="col-md-12">
                                    <button id="add_variation" type="button" class="btn btn-success btn-sm float-right">Add Variation</button>
                                  </div>                                  
                                </div>
                            </div>

                            <div id="specification_data_form_type" style="display: none;">
                              <div class="col-md-6">
                                <div class="form-group row">
                                  <label class="col-sm-5 col-form-label">+++</label>
                                  <div class="col-sm-7">
                                    <select class="form-control" name="specification[---]" placeholder="Select Option">
                                      ++-++
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div id="attribute_data_form_type" style="display: none;">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="form-label">+++</label>
                                  <select class="form-control ++++" name="attribute[---]" placeholder="Select Option">
                                    ++-++
                                  </select>
                                </div>
                              </div>
                            </div>

                            <div id="washcare_data_form_type" style="display: none;">
                              <div class="col-md-6">
                                <div class="form-group row">
                                  <label class="col-sm-5 col-form-label">+++</label>
                                  <div class="col-sm-7">
                                    <select class="form-control" name="washcare[---]" placeholder="Select Option">
                                      ++-++
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div id="variation_data_form_type" style="display: none;">
                              <div class="form-group same-row">
                                <label class="form-label">+++</label>
                                <select class="form-control" name="variation[---][variation_type][++++]">                                
                                  ++-++
                                </select>
                              </div>
                            </div>

                            <div id="variation_data_form" style="display: none;">
                              <div class="accordion col-md-12" id="varAccordion---">
                                <div class="card">
                                  <div class="card-header" data-toggle="collapse" data-target="#varCollapseOne---" aria-expanded="true" aria-controls="varCollapseOne---">
                                    <div class="form-row">
                                      --_--
                                    </div>
                                  </div>

                                  <div id="varCollapseOne---" class="collapse card-body" aria-labelledby="headingOne" data-parent="#varAccordion---">
                                    <div class="form-group-own row">
                                      <div class="form-group variation-featured-image">
                                        <input name="variation[---][featured_image]" class="variation-featured-image-input" type="file" accept="image/*" style="display: none;"/>
                                        <div class="featured_imagee">
                                          <img class="featured_image_img" src="{{ asset('default/no_image.jpg') }}"/>
                                        </div>
                                      </div>
                                      <div class="form-group variation-featured-image">
                                        <label class="form-label">SKU :</label>
                                        <input type="text" class="form-control" name="variation[---][sku]" placeholder="Variation SKU">
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label class="form-label">Regular Price :</label>
                                          <input type="number" class="form-control" name="variation[---][regular_price]" placeholder="Regular Price">                                              
                                        </div>
                                      </div>

                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label class="form-label">Sale Price :</label>
                                          <input type="number" class="form-control" name="variation[---][sale_price]" placeholder="Sale Price">                                              
                                        </div>
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label class="form-label">Stock Status :</label>
                                          <select class="form-control" name="variation[---][stock_status]" placeholder="Stock Status">
                                            <option value="" hidden>Select Stock Status</option>
                                            <option value="In Stock">In Stock</option>
                                            <option value="Out of Stock">Out of Stock</option>
                                          </select>
                                        </div>
                                        <div class="form-group">
                                          <label class="form-label">Stock Quantity :</label>
                                          <input type="number" class="form-control" name="variation[---][stock_quantity]" placeholder="Stock Quantity">                                              
                                        </div>
                                        <div class="form-group">
                                          <label class="form-label">Low Stock Threshold :</label>
                                          <input type="number" class="form-control" name="variation[---][stock_threshold]" placeholder="Low Stock Threshold">
                                        </div>
                                      </div>
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label class="form-label">Weight (g) :</label>
                                          <input type="number" class="form-control" name="variation[---][weight]" placeholder="Weight (g)"/>
                                        </div>
                                        <div class="form-group">
                                          <label class="form-label">Dimensions (cm) :</label>
                                          <div class="row">
                                            <div class="col">
                                              <input type="number" class="form-control" name="variation[---][length]" placeholder="Length">
                                            </div>
                                            <div class="col">
                                              <input type="number" class="form-control" name="variation[---][width]" placeholder="Width">
                                            </div>
                                            <div class="col">
                                              <input type="number" class="form-control" name="variation[---][height]" placeholder="Height">
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div id="specifications_tab" class="tabcontent">
                            </div>

                            <div id="washcare_tab" class="tabcontent">
                              
                            </div>

                            <div id="attribute_tab" class="tabcontent">
                              <div class="row" id="attribute_data_tab">
                              </div>                              
                            </div>


                        </div>
                    </div>

                </div>


                    <div class="col-sm-3">
                        <div class="form-group">
                            <strong>Select Brand</strong>
                            <select class="form-control" name="brand_id">
                              <option hidden value="">Select Brand</option>

                              @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                              @endforeach

                            </select>
                          </div>
                        <div class="form-group">
                            <strong>Select Type</strong>
                            <select class="form-control" name="type_id" id="type_id">
                                <option value="" hidden>Select Product Type</option>
                                 @foreach ($type as $key=>$value)
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                      <div class="form-group">
                        <strong>Select Category</strong>
                        <select select class="form-control" name="category_id" id="category_id" multiple="multiple">
                        </select>
                      </div>

                      <div class="form-group">
                        <strong>Product Featured Image</strong>
                        <input type="file" name="featured_image" id="featured_image_input" class="form-control" value="{{ old('image') }}" placeholder="Image" accept="image/*" style="display: none;">
                        <div class="form-control featured_image" onclick="getFeatureImage()">
                          <img src="{{ asset('default/no_image.jpg') }}" id="featured_image"/>

                        </div>
                        <div class="tagging" style="bottom: 5px; left: 10px;"><a href="javascript:removeFeaturedImage()">Remove Product Image</a></div>
                      </div>
                      <div class="form-group">
                        <strong>Gallery Images</strong>
                        <!-- <input type="file" name="gallery_image" id="gallery_image_list" class="form-control" value="{{ old('image') }}" placeholder="Image" accept="image/*" multiple style="display: none;"> -->
                        <input type="file" name="gallery_image[]" id="gallery_image_input" class="form-control" value="{{ old('image') }}" placeholder="Image" accept="image/*" multiple style="display: none;">
                        <div class="form-control featured_image" onclick="getGalleryImage()" id="gallery_image_group" style="height: auto; padding: 10px; max-height: auto;">
                            <img src="{{ asset('default/no_image.jpg') }}" id="gallery_image"/>
                            <br class="clear" />
                        </div>
                        <div class="tagging" style="bottom: 5px; left: 10px;"><a href="javascript:removeGalleryImage()" style="float: left;">Remove all images</a><a href="javascript:getGalleryImage()" style="float: right;">Add more images</a></div>
                      </div>
                      <div class="form-group">
                        <br/>
                        <strong>ValueIcons</strong>
                        <select id="value_icons" class="form-control" name="value_icon" multiple>

                        </select>
                      </div>

                      <div class="form-group">
                        <br/>
                        <strong>HSN Code</strong>
                        <input type="text" id="hsn_code" class="form-control" name="hsn_code"/>
                      </div>
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary">Add</button>
                      <button type="button" class="btn btn-danger" onclick="window.location='{{route('product.index')}}'">Cancel</button>
                     </div>
                  </form>
                </div>


      <div class="container">

  <!-- The Modal -->
  <div class="modal fade" id="attributsModal">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Select Attribute </h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
         <div class="row" id="selectAtributeValue">

         </div>
            <input type="button" id="save_value" name="save_value" value="Ok" />
        </div>
      </div>
    </div>
  </div>

</div>
<button style="display: none;" id="success_call"></button>

     @endsection

     @section('page-script')

     <script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"></script>
     <script>
        var formData = new FormData();
        var variationHtml = null;
        var variationCount = 0;
        $(document).ready(function(){
          $("#loading_category_base").hide();

          $("#add_variation").on("click", function(e){
            if(variationHtml == null){
              alert("Please select category");
            }else{
              variationCount = variationCount + 1;
              $("#variations_data_tab").append(variationHtml.replace(/---/g, variationCount));
            }
          });

          $("body").on("click", ".featured_image_img", function(e){
            $(this).parents(".variation-featured-image").find(".variation-featured-image-input").trigger("click");
          });

          $("body").on("change", ".variation-featured-image-input", function(event){
            let file = event.target.files[0];
            $(this).parents(".variation-featured-image").find(".featured_image_img").attr("src", window.URL.createObjectURL(file));
          });

          ClassicEditor
            .create(document.querySelector("#description"), {

            })
            .catch(error => {
                console.log(error);
            });

          ClassicEditor
            .create(document.querySelector("#short_description"), {

            })
            .catch(error => {
                console.log(error);
            });

          $("#featured_image_input").on("change", function(event){
            let file = event.target.files[0];
            $("#featured_image").attr("src", window.URL.createObjectURL(file));
          });

          $("#gallery_image_input").on("change", function(event){
            let files = event.target.files;
            $("#gallery_image").hide("slow");
            for(var i = 0; i < files.length; i++){             

              var html_str = "<div class='gallery_image_tiles'><img src='"+ window.URL.createObjectURL(files[i]) +"'/></div>";
              // $("#gallery_image_group").append(html_str);
              $(html_str).insertBefore("#gallery_image_group .clear");
              formData.append("gallery_image[]", files[i]);
            }
            console.log(formData);
          });

          $("#category_id").select2({
              containerCssClass: "error",
              dropdownCssClass: "select2_dropdown_balkae",
              placeholder: "Select Category Types",
              ajax: {
                  url: "{{ route('category.list.parent') }}",
                  type: "POST",
                  dataType: 'json',
                  data: function (params) {
                  var query = {
                      "search": params.term,
                      "_token": "{{ csrf_token() }}",
                      "type": $("#type_id").val(),
                  }

                  // Query parameters will be ?search=[term]&type=public
                  return query;
                  },
                  processResults: function (data) {
                  // Transforms the top-level key of the response object from 'items' to 'results'
                  if(data.type == "success"){
                      return {
                        results: data.data
                      };
                  }else{
                      return {
                        results: []
                      };
                  }
                  },
                  // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
              }
          }).on("change", function(e){
            changeProductData(this);
          });

          $("#model_wearing").select2({
              containerCssClass: "error",
              dropdownCssClass: "select2_dropdown_balkae",
              placeholder: "Select Products",
              ajax: {
                  url: "{{ route('category.list.parent') }}",
                  type: "POST",
                  dataType: 'json',
                  data: function (params) {
                  var query = {
                      "search": params.term,
                      "_token": "{{ csrf_token() }}",
                      "type": $("#type_id").val(),
                  }

                  // Query parameters will be ?search=[term]&type=public
                  return query;
                  },
                  processResults: function (data) {
                  // Transforms the top-level key of the response object from 'items' to 'results'
                  if(data.type == "success"){
                      return {
                        results: data.data
                      };
                  }else{
                      return {
                        results: []
                      };
                  }
                  },
                  // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
              }
          });

            $("#value_icons").select2({
                containerCssClass: "error",
                dropdownCssClass: "select2_dropdown_balkae",
                placeholder: "Select Value Icons",
                ajax: {
                    url: "{{ route('value_icons.list.selected') }}",
                    type: "POST",
                    dataType: 'json',
                    data: function (params) {
                    var query = {
                        "search": params.term,
                        "_token": "{{ csrf_token() }}",
                        "category_id": $("#category_id").val(),
                    }

                    // Query parameters will be ?search=[term]&type=public
                    return query;
                    },
                    processResults: function (data) {
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    if(data.type == "success"){
                        return {
                        results: data.data
                        };
                    }else{
                        return {
                        results: []
                        };
                    }
                    },
                    // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                }
            });

        });

        function toggleContent(e){
            $(e).parents(".card").find(".card-content").toggle();
        }

        function getFeatureImage(){
          $("#featured_image_input").trigger("click");
        }

        function removeFeaturedImage(){
            $("#featured_image_input").val(null);
            $("#featured_image").attr("src", "{{ asset('default/images.png') }}");
        }

        function getGalleryImage(){
          $("#gallery_image_input").trigger("click");
        }

        function removeGalleryImage(){
            // $("#featured_image_input").val(null);
            // $("#featured_image").attr("src", "{{ asset('default/images.png') }}");
        }

        function openCity(evt, cityName) {
            // Declare all variables
            var i, tabcontent, tablinks;

            // Get all elements with class="tabcontent" and hide them
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }

            // Get all elements with class="tablinks" and remove the class "active"
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }

            // Show the current tab, and add an "active" class to the link that opened the tab
            document.getElementById(cityName+"_tab").style.display = "block";
                evt.currentTarget.className += " active";
            }

      var allAttrValue=[];
       var attrComData=[];
       /// Get attribute and value ..................................
        $(document).ready(function(){
          $("#select_attributs").change(function(e){
            if ($('#select_attributs').val() == 'variant_product') {
            e.preventDefault();
            $("#loading").show();
            $.ajax({
              url: "{{ route('product.add-attributs') }}",
              type: "POST",
              contentType: false,
              cache: false,
              processData:false,
              beforeSend : function(){
                //$("#preview").fadeOut();
                // $("#err").fadeOut();
              },
              success: function(data){
                $("#loading").hide();
                console.log(data); //Call me bhai  name2
                //$('#name2').val(data.data[0].name)
                allAttrValue = data.data;
                console.log(allAttrValue);
                  var attrData = [];
                  var attrValue =[];
              for (let i = 0; i < data.data.length; i++) {
                  attrData[i]= `<div class="col-md-3">
                                <div class="checkbox">
                                    <label>
                                      <input type="checkbox" class="select_attribute" onclick="selectAttr(${data.data[i].id})" class="chkListItem" value="${data.data[i].id}" name="select_attribute[]">&nbsp;${data.data[i].name}
                                    </label>
                                </div>
                                  <div id="value${data.data[i].id}">
                                  </div>`
                }

                $('#selectAtributeValue').html(attrData);


                $('#attributsModal').modal('show');
                if(data.type == "success"){
                  $("#success_call").trigger("click");
                }else{
                  $("#show_error").html(data.msg);
                  $("#show_error").show("slow");
                }
              },
              error: function(error){
                $("#show_error").html("Please contact admin");
                $("#show_error").show("slow");
              }
            });
            }
          });
        });
        //////////      sava a variable with atribute and value ...................
        $('#save_value').click(function(){
          $('#attributsModal').modal('hide');
          //console.log('kkkkkkk')
          console.log(attrComData)
         // $('#attribute_value').val(attrComData);
        })
        //////////  manage attribute ......................
        function selectAttr(id){
          var valueData = [];
          for (let i = 0; i < allAttrValue.length; i++) {
            if (allAttrValue[i].id == id) {
              for (let j = 0; j < allAttrValue[i].values.length; j++) {
                valueData[j]= `<div class="checkbox"><label><input type="checkbox" class="select_value" style="font-size:20px" onclick="selectValus(${allAttrValue[i].values[j].id})" name="select_value[]" value="${allAttrValue[i].values[j].id}">&nbsp;${allAttrValue[i].values[j].value}</label></div>`
              }
              break;
            }
          }
          $(`#value${id}`).html(valueData)
        }
        ////////////// manage and compair attribute and value ///////////////////////////////
        function selectValus(att_value){
          attr_id = [];
          value_id = [];
          att_values = [];
          $(".select_value:checked").each(function(i){
              value_id[i]=$(this).val();
            });

            $(".select_attribute:checked").each(function(i){
                  attr_id[i] = $(this).val();
            });
            for (let j = 0; j < allAttrValue.length; j++) {
              for (let k = 0; k < attr_id.length; k++) {
              if(allAttrValue[j].id == attr_id[k]){
                for (let l = 0; l < allAttrValue[j].values.length; l++) {
                    for (let m = 0; m < value_id.length; m++) {
                      if (allAttrValue[j].values[l].id == value_id[m]) {
                        att_values.push(allAttrValue[j].values[l]);
                      }
                    }
                }
              }
              }
            }
            attrComData = att_values
            console.log(attrComData);
        }




  function addAttributImage(product_id){
   console.log(product_id)
  $.confirm({
      title: 'Add the Product Attributs and value',
      animation: 'zoom',
      closeAnimation: 'scale',
      columnClass: 'col-md-12',
      content: function () {
          var self = this;
          return $.ajax({
              url: "{{ route('product.add-attributs-image') }}",
              data:{
                "_token": "{{ csrf_token() }}",
                product_id:product_id
              },
              dataType: 'json',
              method: 'POST'
          }).done(function (response) {
              // alert(response);
              self.setContent(response.data);
              // self.setContentAppend('<br>Version: ' + response.version);
              // self.setTitle(response.name);
          }).fail(function(data){
              self.setContent(data.responseText);
          });
      },
      type: 'green',
      buttons: {
          formSubmit: {
              text: 'Add',
              btnClass: 'btn-green',
              action: function () {
                  this.$content.find('.form').trigger("submit");
                  return false;
              }
          },
          cancel: function () {
              return true;
          },
      },
      onContentReady: function () {
          // bind to events
          var jc = this;
          this.$content.find('#success_call').on('click', function (e) {
              $message = jc.$content.find('#message_of_call').val();
              jc.close();
              table.draw();
          });
      }
  });
}

    function changeProductData(thiss){
        $("#loading_category_base").show("slow");
        $.ajax({
            url: "{{ route('product.category.select.list') }}",
            type: "POST",
            data: {
              _token: "{{ csrf_token() }}",
              ids: $(thiss).val()
            },
            success: function(data){
              if(data.type == "success"){
                console.log(data);
                var selectStr = "";
                var strr = $("#variation_data_form_type").html();
                $.each(data.data.variations, function(index, value){   
                  var optionStr = "<option value='' hidden>Select</option>";               
                  $.each(value, function(i, v){
                    if(i != "name"){
                      optionStr = optionStr + "<option value='"+i+"'>"+v+"</option>";
                    }
                  });
                  selectStr = selectStr + strr.replace('++-++', optionStr).replace('+++', value.name).replace('++++', index);
                });

                var htmlStr = '<div class="col-md-12"><p style="padding: 10px;"><strong>The possible variations are below</strong></p></div>';
                variationHtml = $("#variation_data_form").html().replace('--_--', selectStr);
                for(var i = 1; i <= 5; i++){
                  htmlStr = htmlStr + variationHtml.replace(/---/g, i);
                  variationCount = i;
                }                
                $("#variations_data_tab").html(htmlStr);

                // Specifications
                var specificationStr = '<p style="padding: 10px;"><strong>The possible Specifications are below</strong></p>';
                $.each(data.data.specification, function(index, value){   
                  var optionStr = "<option value='' hidden>Select</option>";
                  // console.log(value.attrbute_value);
                  $.each(value.attrbute_value, function(i, v){
                    optionStr = optionStr + "<option value='"+v.id+"'>"+v.text+"</option>";
                  });
                  specificationStr = specificationStr + $("#specification_data_form_type").html().replace('++-++', optionStr).replace('+++', value.attribute_name).replace('---', value.attribute_id);
                });
                $("#specifications_tab").html(specificationStr);

                // Specifications
                var washcareStr = '<p style="padding: 10px;"><strong>The possible Washcare are below</strong></p>';
                $.each(data.data.wash_care, function(index, value){   
                  var optionStr = "<option value='' hidden>Select</option>";
                  // console.log(value.attrbute_value);
                  $.each(value.attrbute_value, function(i, v){
                    optionStr = optionStr + "<option value='"+v.id+"'>"+v.text+"</option>";
                  });
                  washcareStr = washcareStr + $("#washcare_data_form_type").html().replace('++-++', optionStr).replace('+++', value.attribute_name).replace('---', value.attribute_id);
                });
                $("#washcare_tab").html(washcareStr);

                //Attribute
                var attributeStr = '<div class="col-md-12"><p style="padding: 10px;"><strong>The possible Attribute are below</strong></p></div>';
                
                $.each(data.data.attribution, function(index, value){   
                  var optionStr = "<option value='' hidden>Select</option>";
                  // console.log(value.attrbute_value);
                  $.each(value, function(i, v){
                    if(i != "name" && i != "mandatory"){
                      optionStr = optionStr + "<option value='"+i+"'>"+v+"</option>";
                    }                    
                  });
                  attributeStr = attributeStr + $("#attribute_data_form_type").html().replace('++-++', optionStr).replace('+++', value.name).replace('---', index);
                  if(value.mandatory == 0){
                    attributeStr = attributeStr.replace('++++', '');
                  }else{
                    attributeStr = attributeStr.replace('++++', 'required');
                  }
                });
                $("#attribute_data_tab").html(attributeStr);
              }else{

              }
              $("#loading_category_base").hide();
              
            },
            error: function(error){
              console.log(error);
              $("#loading_category_base").hide();
              console.log(error);
            }
        });
    }
  </script>

<script type="text/javascript">

 $(document).ready(function(){
    $("#category_form").on("submit", function(e){
      // e.preventDefault();
      console.log($(this).serialize());
      console.log(new FormData(this));

      // $("#loading").show();
      var data;
      data = new FormData(this);
      // data.append( 'attribute_value',JSON.stringify(attrComData));
      $.ajax({
        url: "{{ route('product.store') }}",
        type: "POST",
        data: data,
        contentType: false,
        cache: false,
        processData:false,
        beforeSend : function(){
          //$("#preview").fadeOut();
          // $("#err").fadeOut();
        },
        success: function(data){
          $("#loading").hide();
          console.log(data); //Call me bhai
          if(data.type == "success"){
            $("#success_call").trigger("click");
            // if (data.data>0) {
            //   addAttributImage(data.data);
            // }

          }else{
            $("#show_error").html(data.msg);
            $("#show_error").show("slow");
          }
        },
        error: function(error){
          $("#show_error").html("Please contact admin");
          $("#show_error").show("slow");
        }
      });
    });
 });
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

@section('page-style')
<style>
  .ck-editor__editable {
    min-height: 300px;
  }
  .ck-editor__editable_inline {
      min-height: 300px;
  }
  .featured_image{
    height: 30vh;
    text-align: center;
    cursor: pointer;
  }
  #featured_image, #gallery_image{
    vertical-align: middle;
    max-width: 100%;
    max-height: 100%;
  }
  .gallery_image_tiles{
    float: left;
    width: 29% !important;
    text-align: center;
    height: 80px;
    margin-left: 2%;
    margin-right: 2%;
  }
  .gallery_image_tiles img{
      max-width: 100%;
      max-height: 100%;
      vertical-align: middle;

  }
  .clear { clear: both; }
  * {box-sizing: border-box}

/* Style the tab */
.tab {
  float: left;
  border: 1px solid #eee;
  background-color: #fff;
  width: 25%;
  height: 300px;
}

/* Style the buttons that are used to open the tab content */
.tab button {
  display: block;
  background-color: inherit;
  color: black;
  padding: 10px 6px;
  width: 100%;
  border: none;
  outline: none;
  text-align: left;
  cursor: pointer;
  transition: 0.3s;
  border-bottom: 1px solid #ddd;
  padding-right: 80px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #fff;
}

/* Create an active/current "tab button" class */
.tab button.active {
  background-color: #ccc;
  box-shadow: 10px 10px 54px -6px rgba(0,0,0,0.75);
}

/* Style the tab content */
.tabcontent {
  float: left;
  padding: 12px 30px;
  border: 1px solid #ccc;
  width: 75%;
  border-left: none;
  display: none;
}
#variations_tab{
    padding: 0px;
}
#variations_tab .card-header{
    border: 1px solid #ccc;
    padding: 5px;
}
#variations_tab .card{
    margin-bottom: 0px;
}

#loading_category_base{
  z-index: 999999999999;
  min-height: 300px;
  width: 100%;
  position: absolute;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: white;
  height: auto;
  margin-bottom: 1px;
}
.form-row{
  width: 100%;
}
.same-row{
  float: left;
  width: fit-content;
  margin-left: 10px;
  padding-right: 30px !important;
  margin-bottom: 2px !important;
}
.variation-featured-image{
  width: 50%;
  height: auto;
  padding-bottom: 1px;
  padding: 5%;
  float: left;
}
.featured_image{
  width: 100%;
}

.featured_imagee img{
  height: 120px;
}
.accordion .card{
  border: 1px solid #ccc;
  border-radius: 7px !important;
  margin: 5px;
  margin-bottom: 10px !important;
}

.accordion .card .card-header{
  border-bottom: 2px solid #ccc !important;
  padding: 5px !important;
}

</style>
@endsection
