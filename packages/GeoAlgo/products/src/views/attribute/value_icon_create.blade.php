
<div class="col-xs-12 col-sm-12 col-md-12">
    <div class="alert alert-danger" role="alert" id="show_error" style="display: none;">
      This is a warning alert—check it out!
    </div>
  </div>

            <div id="loading" style="display: none;">
              <i class="fas fa-spinner fa-spin icon-spining"></i>
            </div>
           <div class="card-body">
              <form action="{{ route('value_icons.store') }}" method="POST" id="category_form" class="form" enctype="multipart/form-data">
                @csrf

                @if($edit == true && !empty($value_icon))
                <input type="hidden" name="id" value="{{ $value_icon->id }}"/>
                <input type="hidden" name="edit" value="true"/>
                @endif

                <div class="form-group">
                  <strong>Value Icon Name </strong>
                  <input type="text" name="name" class="form-control" value="{{ ($edit == true && !empty($value_icon))?$value_icon->name:'' }}" placeholder="Value Icon Name" required>
                </div>

                <div class="form-group">
                    <strong>Value Icon Image</strong>
                    <input type="file" name="image" class="form-control" placeholder="Value Icon Image" accept="image/*" required>
                </div>
                <div class="form-group">
                    <strong>Value Icon Description</strong>
                    <textarea name="description" class="form-control" placeholder="Value Icon Description" required>{{ ($edit == true && !empty($value_icon))?$value_icon->description:'' }}</textarea>
                </div>
                <div class="form-group">
                    <strong>Applicable Categories (Optional)</strong>
                    <select id="category_id" name="category[]" class="form-control" multiple>
                        @if($edit == true && !empty($value_icon))
                            @foreach ($value_icon->category_array as $key=>$value)
                                <option value="{{ $value['id'] }}" selected>{{ $value['text'] }}</option>
                            @endforeach
                        @endif
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
                url: "{{ route('value_icons.store') }}",
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
