                <div id="loading" style="display: none;">
                  <i class="fas fa-spinner fa-spin icon-spining"></i>
                </div>
                 <div class="card-body">
                  <form action="{{ route('coupone.update',[$coupon->id]) }}" method="POST" id="categoryupdate_form" class="form" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="form-group">
                      <strong>Category Name</strong>
                      <input type="text" name="category_id" class="form-control" value="{{ ($edit == true && !empty($coupon))?$coupon->name:'' }}" placeholder="Brand Name" required>
                    </div>

                    <div class="form-group">
                      <strong>Product Name</strong>
                      <input type="text" name="product_id" class="form-control" value="{{ ($edit == true && !empty($coupon))?$coupon->name:'' }}" placeholder="Brand Name" required>
                    </div>

                    <div class="form-group">
                      <strong>Coupon Code</strong>
                      <input type="text" name="coupon_code" class="form-control" value="{{ ($edit == true && !empty($coupon))?$coupon->name:'' }}" placeholder="Brand Name" required>
                    </div>

                    <div class="form-group">
                      <strong>Type</strong>
                      <input type="text" name="type" class="form-control" value="{{ ($edit == true && !empty($coupon))?$coupon->name:'' }}" placeholder="Brand Name" required>
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

            <script type="text/javascript">
              
             $(document).ready(function(){
                $("#categoryupdate_form").on("submit", function(e){
                  e.preventDefault();
                  $("#loading").show();
                  $.ajax({
                    url: "{{ route('coupone.update',[$coupon->id]) }}",
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
                        alert("Brand Created");
                      }else{
                        alert(data.message);
                      }
                    },
                    error: function(error){
                      $("#loading").hide();
                      console.log(error);
                      alert(error);
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

            