
<div class="col-xs-12 col-sm-12 col-md-12">
    <div class="alert alert-danger" role="alert" id="show_error" style="display: none;">
      This is a warning alert—check it out!
    </div>
  </div>
            <div id="loading" style="display: none;">
              <i class="fas fa-spinner fa-spin icon-spining"></i>
            </div>
           <div class="card-body">
              <form action="{{ route('category.store-attribute-value') }}" method="POST" id="add_category_filter_attribute" class="form" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="category_id" value="{{ $category->id }}"/>
                @if($edit == true)
                <input type="hidden" name="edit" value="true"/>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <select class="form-control" id="type_id" name="type_id" required>
                                <option hidden>Select Type</option>
                                @foreach($typeCategory as $key => $value)
                                    <option value="{{ $value->id }}" {{ ($filter != null && $filter->type_id == $value->id)? "selected": "" }}>{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" style="display: {{ ($any_parent == true)? 'block':'none' }}">
                            <select class="form-control" id="category_id" name="category_parent_id" {{ $any_parent == true? 'required':'' }} {{ ($parentCategory == null)? "disabled": "" }}>
                                @if($parentCategory != null && $any_parent == true)
                                    <option value="{{ $parentCategory->id }}" selected>{{ $parentCategory->name }}</option>
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control" id="attribute_id" name="attribute_id" required>
                                @if($attribute_list != null)
                                    <option value="{{ $attribute_list->id }}" selected="selected">{{ $attribute_list->name }}</option>
                                @endif
                            </select>
                        </div>

                        <div class="form-group">
                            <select class="form-control" id="attribute_value_id" name="attribute_value_id[]" required multiple="multiple" {{ ($attribute_list == null)? "disabled": "" }}>
                                @if($value_list != null)
                                    @foreach($value_list as $key => $value)
                                        <option value="{{ $value->id }}" selected="selected">{{ $value->text }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group">
                            <select class="form-control" id="attribute_value_mandatory" required name="attribute_value_mandatory">
                                <option value="" hidden>Select mandatory</option>
                                <option value="0" {{ ($filter != null && $filter->mandatory == 0) ? "selected": "" }}>Not Mandatory</option>
                                <option value="1" {{ ($filter != null && $filter->mandatory == 1) ? "selected": "" }}>Mandatory</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <select class="form-control" id="attribute_value_gallery" required name="attribute_value_gallery">
                                <option value="" hidden>Do Gallery Required</option>
                                <option value="1" {{ ($filter != null && $filter->gallery_mandatory == 1)? "selected": "" }}>Gallery Required</option>
                                <option value="0" {{ ($filter != null && $filter->gallery_mandatory == 0)? "selected": "" }}>Gallery Not Required</option>
                            </select>
                        </div>
                        {{-- <br/><br/>
                        <label>Select Attribute Value</label>
                        <div class="form-group border" id="attribute_values">

                        </div> --}}
                    </div>
                </div>
              </form>
            </div>
          </div>
        </div>

        <button style="display: none;" id="success_call"></button>

        <script type="text/javascript">

         $(document).ready(function(){
             $("#type_id").on("change", function(e){
                $("#category_id").attr("disabled", "disabled");
                // $("#attribute_id").attr("disabled", "disabled");
                $.ajax({
                    url: "{{ route('category.list.parent.category') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "search": "",
                        "type": e.target.value,
                        "id": "{{ $category->id }}"
                    },
                    success: function(data){
                        if(data.type == "success"){
                            var option_str = "<option value='' hidden>Select Parent Category</option>";
                            if(data.data.length > 0){
                                $("#category_id").parents(".form-group").show();
                                $("#category_id").removeAttr("required");
                                $.each(data.data, function(index, value){
                                    option_str = option_str + "<option value='"+value.id+"'>"+value.text+"</option>";
                                });
                                $("#category_id").html(option_str);
                                $("#category_id").removeAttr("disabled");
                            }else{
                                $("#category_id").parents(".form-group").hide();
                                $("#category_id").attr("required", "required");
                            }
                        }else{
                            alert("Please try again later");
                        }
                    },
                    error: function(data){
                        alert("Please try again later");
                    }
                });
            });

            $("#category_id").on("change", function(e){
                $("#attribute_id").removeAttr("disabled");
            });

            $('#attribute_id').on("change", function(){
                if(this.value > 0){
                    $("#attribute_value_id").removeAttr("disabled");
                }
            });

            $('#attribute_id').select2({
                containerCssClass: "error",
                dropdownCssClass: "select2_dropdown",
                placeholder: "Select Attribute",
                ajax: {
                  url: "{{ route('category.add.attribute.list') }}",
                  type: "POST",
                  dataType: 'json',
                  data: function (params) {
                    var query = {
                      "search": params.term,
                      "_token": "{{ csrf_token() }}",
                      "id": {{ $category->id }},
                      "category_id": $("#category_id").val(),
                      "type_id": $("#type_id").val()
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

            $('#attribute_value_id').select2({
                containerCssClass: "error",
                dropdownCssClass: "select2_dropdown",
                placeholder: "Select Attribute Values",
                ajax: {
                  url: "{{ route('category.add.attribute.list.values') }}",
                  type: "POST",
                  dataType: 'json',
                  data: function (params) {
                    var query = {
                      "search": params.term,
                      "_token": "{{ csrf_token() }}",
                      "id": {{ $category->id }},
                      "category_id": $("#category_id").val(),
                      "attribute_id": $("#attribute_id").val(),
                      "type_id": $("#type_id").val(),
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

            $("#add_category_filter_attribute").on("submit", function(e){
                e.preventDefault();
                if($("#add_category_filter_attribute")[0].checkValidity()){
                    $.ajax({
                        url: "{{ route('category.add.attribute.values.store') }}",
                        type: "POST",
                        data: $(this).serialize(),
                        success: function(data){
                            console.log(data);
                            if(data.type == "success"){
                                $("#success_call").trigger("click");
                            }else{
                                alert("Please try again or contact admin!");
                            }
                        },
                        error: function(e){
                            console.log(e);
                            alert("Please try again or contact admin!");
                        }
                    });
                }else{
                    alert("Please fill all the field!");
                }
            });
        });

        </script>
        <style>
            .border{
                border: 1px solid #ddd;
            }
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
