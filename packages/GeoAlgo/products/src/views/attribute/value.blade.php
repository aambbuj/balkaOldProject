
<div class="col-xs-12 col-sm-12 col-md-12">
        <div class="alert alert-danger" role="alert" id="show_error" style="display: none;">
          This is a warning alert—check it out!
        </div>
      </div>

                <div id="loading" style="display: none;">
                  <i class="fas fa-spinner fa-spin icon-spining"></i>
                </div>
               <div class="card-body">
                  <form id="category_form" class="form">
                    @csrf
                    <input type="hidden" id="attribute_id" name="attribute_id" value="{{$attribute->id}}"/>
                    <div class="form-group">
                      <strong>{{ $attribute->name }} Value</strong>
                      <br/>
                      <div class="input-group">
                          @if(isset($value))
                            <input type="hidden" name="id" value="{{ $value->id }}"/>
                          @endif
                        <input type="text" name="value" id="value" class="form-control" placeholder="Value" aria-label="Value" aria-describedby="basic-addon2" value="{{ (isset($value))? $value->value: "" }}">
                      </div>
                      <div class="contents">
                        <p class="value-content" id="value_content"></p>
                      </div>
                    </div>
                    @if($attribute->is_specific == "specific")
                        <div class="form-group">
                            <strong>Specific Value</strong>
                            @if(strtolower($attribute->name) == "color")
                                <input type="color" class="form-control" name="relate" required placeholder="Select Color" value="{{ (isset($value))? $value->relate: '' }}"/>
                            @else
                                <input type="text" class="form-control" name="relate" required placeholder="Select Value if Any" value="{{ (isset($value))? $value->relate: '' }}"/>
                            @endif
                        </div>
                    @endif
                    {{-- @foreach($AttrValues as $AttrValue)
                    <span> <a href="#" style="font-size: 15px;font-weight: 700;color: blue;border: 1px solid darkred;border-radius: 10px;padding: 3px;margin: 2px;" onclick = "updateAttribute({{ $AttrValue }})">{{$AttrValue->value}}</a></span>
                    @endforeach --}}
                  </form>
                </div>
              </div>
            </div>

            <button style="display: none;" id="success_call"></button>


    <script type = "text/javascript">

    function updateAttribute(data){
        $('#value').val(data.value);
        $('#id').val(data.id);
    }

    $(document).ready(function(e){
        $("#category_form").on("submit", function(e){
            e.preventDefault();
            $("#loading").show();
            $.ajax({
                url: "{{ route('attribute.storeValue') }}",
                type: "POST",
                data: $("#category_form").serialize(),
                beforeSend : function(){
                    //$("#preview").fadeOut();
                    // $("#err").fadeOut();
                },
                success: function(data){
                    $("#loading").hide();
                    console.log(data); //Call me bhai
                    if(data.type == "success"){
                        table.draw();
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

        // function addAttributs() {
        //           var id = $('#id').val();
        //           var attribute_id = $('#attribute_id').val();
        //           var value = $('#value').val();
        //           $("#loading").show();
        //           $.ajax({
        //             url: "{{ route('attribute.storeValue') }}",
        //             type: "POST",
        //             data:{
        //                 "_token": "{{ csrf_token() }}",
        //                 "id": id,
        //                 "value": value,
        //                 "attribute_id": attribute_id,
        //             },
        //             beforeSend : function(){
        //               //$("#preview").fadeOut();
        //               // $("#err").fadeOut();
        //             },
        //             success: function(data){
        //               $("#loading").hide();
        //                console.log(data); //Call me bhai
        //               if(data.type == "success"){
        //                // $("#success_call").trigger("click");
        //               }else{
        //                 $("#show_error").html(data.msg);
        //                 $("#show_error").show("slow");
        //               }
        //             },
        //             error: function(error){
        //               $("#show_error").html("Please contact admin");
        //               $("#show_error").show("slow");
        //             }
        //           });

        // }
    </script>
    <script>

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
        p.value-content ul {
            display: inline-block;
            list-style-type: none;
            padding-left: 10px;
        }
    </style>
