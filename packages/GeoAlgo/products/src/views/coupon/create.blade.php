              
<div class="col-xs-12 col-sm-12 col-md-12">
        <div class="alert alert-danger" role="alert" id="show_error" style="display: none;">
          This is a warning alert—check it out!
        </div>
      </div>

                <div id="loading" style="display: none;">
                  <i class="fas fa-spinner fa-spin icon-spining"></i>
                </div>
               <div class="card-body">
                  <form action="{{ route('coupone.store') }}" method="POST" id="brand_form" class="form" enctype="multipart/form-data">
                    @csrf
                    
                    @if($edit == true && !empty($coupon))
                    <input type="hidden" name="id" value="{{ $coupon->id }}"/>
                    <input type="hidden" name="edit" value="true"/>
                    @endif

                    <div class="form-group">
                            <label>Select Category :</label>
                            <select class="category related-post form-control" name="category[]" multiple>
                              @foreach($categories as $category)
                                <option readonly> {{$category->name}}</option>
                                    @foreach($category->sub_categories as $sub_category)
                                    <option value="{{$sub_category->id}}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{$sub_category->name}}</option>
                                        @foreach($sub_category->childrenCategory as $children_category)
                                        <option value="{{$children_category->id}}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$children_category->name}}</option>
                                        @endforeach
                                    @endforeach

                              @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Select Product :</label>
                            <select class="product related-post form-control" name="products[]" multiple>
                                @foreach($products as $product)
                                  <option value="{{$product->id}}">{{$product->product_name}}</option>
                                @endforeach
                            </select>
                        </div>
<!-- 
                    <div class="form-group">
                      <strong>Category Name</strong>
                      <input type="text" name="category_id" class="form-control" value="{{ ($edit == true && !empty($coupon))?$coupon->name:'' }}" placeholder="Brand Name" required>
                    </div>

                    <div class="form-group">
                      <strong>Product Name</strong>
                      <input type="text" name="product_id" class="form-control" value="{{ ($edit == true && !empty($coupon))?$coupon->name:'' }}" placeholder="Brand Name" required>
                    </div> -->

                    <div class="form-group">
                      <strong>Coupon Code</strong>
                      <input type="text" name="coupon_code" class="form-control" value="{{ ($edit == true && !empty($coupon))?$coupon->name:'' }}" placeholder="Brand Name" required>
                    </div>

                    <div class="form-group">
                      <strong>Coupon Value</strong>
                      <input type="text" name="coupon_value" class="form-control" value="{{ ($edit == true && !empty($coupon))?$coupon->coupon_value:'' }}" placeholder="Coupon Value" required>
                    </div>

                    <div class="form-group">
                            <label>Select Type :</label>
                            <select class="form-control" name="type">
                                  <option selected>Select Type</option>
                                  <option value="fixed">Fixed</option>
                                  <option value="percent">Percent</option>
                            </select>
                        </div>

                    <div class="form-group">
                      <strong>Minimun Price</strong>
                      <input type="text" name="min_price" class="form-control" value="{{ ($edit == true && !empty($coupon))?$coupon->name:'' }}" placeholder="Brand Name" required>
                    </div>

                    <div class="form-group">
                      <strong>Maximum  Price</strong>
                      <input type="text" name="max_price" class="form-control" value="{{ ($edit == true && !empty($coupon))?$coupon->name:'' }}" placeholder="Brand Name" required>
                    </div>

                    <div class="form-group">
                      <strong>Exp Date</strong>
                      <input type="text" name="exp_date" class="form-control" value="{{ ($edit == true && !empty($coupon))?$coupon->name:'' }}" placeholder="Brand Name" required>
                    </div>

                  </form>
                </div>
              </div>
            </div>

            <button style="display: none;" id="success_call"></button>


    <script type="text/javascript">

        $(document).ready(function(){
          $('.mainCategory').select2().prop("disabled", false);
          $select2_for = $(".category").select2({
                containerCssClass: "error",
                dropdownCssClass: "select2_dropdown_balkae",
                placeholder: "Select Categories",
            });
            $('.category').change(function(e){
               var category_ids = JSON.stringify($('.category').val());
               console.log(category_ids);
              e.preventDefault();

                });
        });

        $(document).ready(function(){
          $select2_for = $(".product").select2({
                containerCssClass: "error",
                dropdownCssClass: "select2_dropdown_balkae",
                placeholder: "Select Products",
            });


            $('.product').change(function(e){
               var product_id = $('.product').val();
                console.log(product_id);
                e.preventDefault();
                });


        });

    </script>

            <script type="text/javascript">

              
             $(document).ready(function(){
                $("#brand_form").on("submit", function(e){
                  e.preventDefault();
                  $("#loading").show();
                  $.ajax({
                    url: "{{ route('coupone.store') }}",
                    type: "POST",
                    data: new FormData(this),
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