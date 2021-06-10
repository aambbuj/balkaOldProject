     
<div class="col-xs-12 col-sm-12 col-md-12">
        <div class="alert alert-danger" role="alert" id="show_error" style="display: none;">
          This is a warning alert—check it out!
        </div>
      </div>
                <div id="loading" style="display: none;">
                  <i class="fas fa-spinner fa-spin icon-spining"></i>
                </div>
               <div class="card-body">
                  <form action="{{ route('category.store-attribute-value') }}" method="POST" id="parent_cat_store" class="form" enctype="multipart/form-data">
                    @csrf
                    @if($edit == true && !empty($category))
                    <input type="hidden" name="id" value="{{ $category->id }}"/>
                    <input type="hidden" name="edit" value="true"/>
                    @endif
                        <div class="row">
                        @foreach($attributValue as $attributVal)
                        <div class="col-md-3">
                        <div class="input-group mb-1" style="width:50%">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                <input type="checkbox" class="attribute_id" name="attribute_name[]" value="{{$attributVal->id}}">
                                </div>
                                <!-- <span class="input-group-text">{{$attributVal->name}}</span> -->
                            </div>
                            <input type="text" class="form-control" readonly="readonly" value="{{$attributVal->name}}" name="attribute" style="color: brown;border: 1px solid #545484;border-radius: 0px 15px 15px 0px;">
                            </div>
                            @foreach($attributVal->values as $value)
                                <div class="input-group ml-2" style="margin-bottom: 5px;">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                    <input type="checkbox" class="attribute_value_id" name="attribute_value_id{{$attributVal->id}}[]" value="{{$value->id}}">
                                    </div>
                                    <span class="input-group-text">{{$value->value}}</span>
                                </div>
                                    <!-- <input type="number" class="form-control" placeholder="Enter Product Price" name="price{{$value->id}}"> -->
                                    <!-- <input type="file" class="form-control" name="att_val_image{{$value->id}}[]" multiple="multiple"> -->
                                    <input type="hidden" class="form-control" name="category_id" value="{{$category_id ? $category_id : null}}">
                                    
                                </div>
                            @endforeach
                        </div>
                        @endforeach
                        </div>

                  </form>
                </div>
              </div>
            </div>

            <button style="display: none;" id="success_call"></button>

            <script type="text/javascript">
              
             $(document).ready(function(){
                $("#parent_cat_store").on("submit", function(e){
                  e.preventDefault();
                  $("#loading").show();
                  $.ajax({
                    url: "{{ route('category.store-attribute-value') }}",
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

            label{
                font-size: 18px;
                margin-bottom: 5px;
                padding-left: 2px;
                /* margin-right: 10px; */
                color: darkorange;
                }

                .input-group-text {
                 // color: brown;
                 // border: 1px solid #545484;
                //  border-radius: 0px 15px 15px 0px;
                 // padding: 0px;
                  /* padding-left: 5px; */
                //  text-align: center;
                }
            </style>