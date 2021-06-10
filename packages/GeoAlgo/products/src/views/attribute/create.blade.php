
<div class="col-xs-12 col-sm-12 col-md-12">
        <div class="alert alert-danger" role="alert" id="show_error" style="display: none;">
          This is a warning alert—check it out!
        </div>
      </div>

                <div id="loading" style="display: none;">
                  <i class="fas fa-spinner fa-spin icon-spining"></i>
                </div>
               <div class="card-body">
                  <form action="{{ route('attribute.store') }}" method="POST" id="category_form" class="form" enctype="multipart/form-data">
                    @csrf

                    @if($edit == true && !empty($attribute))
                    <input type="hidden" name="id" value="{{ $attribute->id }}"/>
                    <input type="hidden" name="edit" value="true"/>
                    @endif

                    <div class="form-group">
                      <strong>Attribute Name</strong>
                      <input type="text" name="name" class="form-control" value="{{ ($edit == true && !empty($attribute))?$attribute->name:'' }}" placeholder="Category Name" required>
                    </div>

                    <div class="form-group">
                        <strong>Is Specific</strong>
                        <select type="text" name="is_specific" class="form-control" placeholder="Category Name" required>
                            <option value="normal" {{ ($edit == true && !empty($attribute) && $attribute->is_specific == "normal")? 'selected':'' }}>Not Specific</option>
                            <option value="specific" {{ ($edit == true && !empty($attribute) && $attribute->is_specific == "specific")? 'selected':'' }}>Yes Specific</option>
                        </select>
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
                    url: "{{ route('attribute.store') }}",
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
                      // console.log(data); //Call me bhai
                      if(data.type == "success"){
                        // attributeValues(data.data.id);
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
