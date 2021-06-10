              
<div class="col-xs-12 col-sm-12 col-md-12">
        <div class="alert alert-danger" role="alert" id="show_error" style="display: none;">
          This is a warning alert—check it out!
        </div>
      </div>

                <div id="loading" style="display: none;">
                  <i class="fas fa-spinner fa-spin icon-spining"></i>
                </div>
               <div class="card-body">
                  <form action="{{ route('inventory.store') }}" method="POST" id="category_form" class="form" enctype="multipart/form-data">
                    @csrf
                    
                    @if($edit == true && !empty($item))
                    <input type="hidden" name="id" value="{{ $item->id }}"/>
                    <input type="hidden" name="edit" value="true"/>
                    @endif
                    <div class="form-group">
                      <select class="form-control" name="product_id">
                        <option value="">Select Product Name</option>

                        @foreach ($products as $product)
                          <option value="{{ $product->id }}"{{ ($edit == true && !empty($item))?($item->product_id==$product->id ? 'selected': ''):'' }}>{{ $product->product_name }}</option>
                        @endforeach
                      </select>
                    </div>


                    <div class="form-group">
                      <select class="form-control" name="bar_id">
                        <option value="">Select Bar </option>

                        @foreach ($bars as $bar)
                          <option value="{{ $bar->id }}"{{ ($edit == true && !empty($item))?($item->company_id==$bar->id ? 'selected': ''):'' }}>{{ $bar->company_name }}</option>
                        @endforeach
                      </select>
                    </div>


                    <div class="form-group">
                      <input type="text" name="mrp" class="form-control" value="{{ ($edit == true && !empty($item))?$item->mrp:'' }}" placeholder="MRP" required>
                    </div>
                    <div class="form-group">
                      <input type="text" name="discount" class="form-control" value="{{ ($edit == true && !empty($item))?$item->discount:'' }}" placeholder="Discount" required>
                    </div>
                    <div class="form-group">
                      <input type="text" name="price" class="form-control" value="{{ ($edit == true && !empty($item))?$item->price:'' }}" placeholder="Price" required>
                    </div>
                    <div class="form-group">
                      <input type="text" name="qty" class="form-control" value="{{ ($edit == true && !empty($item))?$item->qty:'' }}" placeholder="qty" required>
                    </div>
                    <div class="form-group">
                      <input type="text" name="sold" class="form-control" value="{{ ($edit == true && !empty($item))?$item->sold:'' }}" placeholder="sold" required>
                    </div>
                    <!-- <div class="form-group">
                      <input type="text" name="available" class="form-control" value="{{ ($edit == true && !empty($item))?$item->available:'' }}" placeholder="available" required>
                    </div> -->
                    
                  </form>
                </div>
              </div>
            </div>

            <button style="display: none;" id="success_call"></button>

            <script type="text/javascript">
              
             $(document).ready(function(){
                $("#category_form").on("submit", function(e){
                  e.preventDefault();
                  $("#loading").show();
                  $.ajax({
                    url: "{{ route('inventory.store') }}",
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