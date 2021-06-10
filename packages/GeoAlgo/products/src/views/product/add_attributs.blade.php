    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="alert alert-danger" role="alert" id="show_error" style="display: none;">
          This is a warning alert—check it out!
        </div>
      </div>

        <div id="loading" style="display: none;">
            <i class="fas fa-spinner fa-spin icon-spining"></i>
        </div>
        <div class="card-body">
            <form action="{{ route('product.product-attribute-value') }}" method="POST" id="productAttributeValue" class="form" enctype="multipart/form-data">
            @csrf
            @foreach($productAttValDetails as $key => $productAttVal)
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">{{$productAttVal->attributes->name}}</span>
                        <span class="input-group-text">{{$productAttVal->attributeValues->value}}</span>
                    </div>
                    <input type="number" class="form-control price" name="price[]" value="{{$productAttVal ? $productAttVal->price : ''}}" placeholder="Enter Product Price">
                    <input type="hidden" class="form-control product_id"  name="id[]" value="{{$productAttVal ? $productAttVal->id : ''}}">
                    <input type="file" class="form-control att_val_image" multiple="multiple" name="att_val_image{{$productAttVal->id}}[]">
                </div>
            @endforeach

        </form>
    </div>
    </div>
</div>

            <button style="display: none;" id="success_call"></button>

            <script type="text/javascript">
              
             $(document).ready(function(){
                $("#productAttributeValue").on("submit", function(e){
                  e.preventDefault();
                //   var task_name = $(".product_price").val();
                //   console.log(task_name);
                  $("#loading").show();
                  $.ajax({
                    url: "{{ route('product.product-attribute-value') }}",
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
                          window.location.href = data.data;
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

