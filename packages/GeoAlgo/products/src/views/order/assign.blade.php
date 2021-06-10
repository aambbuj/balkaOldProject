              
<div class="col-xs-12 col-sm-12 col-md-12">
        <div class="alert alert-danger" role="alert" id="show_error" style="display: none;">
          This is a warning alert—check it out!
        </div>
      </div>

                <div id="loading" style="display: none;">
                  <i class="fas fa-spinner fa-spin icon-spining"></i>
                </div>
               <div class="card-body">
                  <form action="{{ route('order.assign_store') }}" method="POST" id="category_form" class="form" enctype="multipart/form-data">
                    @csrf
                    
                    <input type="hidden" name="id" value="{{ $id }}"/>
                    <div class="form-group">
                      <strong>Select Driver</strong>
                      <select class="form-control" name="driver_id">
                        <option hidden value="">Select Driver</option>

                        @foreach ($users as $user)
                          <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <strong>Comments for Driver</strong>
                      <textarea name="comment" class="form-control" value="" placeholder="Comments" required></textarea>
                    </div>
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
                    url: "{{ route('order.assign_store') }}",
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
                        console.log(data);
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