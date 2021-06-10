
      <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="alert alert-danger" role="alert" id="show_error" style="display: none;">
          This is a warning alert—check it out!
        </div>
      </div>

      <div id="loading" style="display: none;">
        <i class="fas fa-spinner fa-spin icon-spining"></i>
      </div>
               <div class="card-body">
                  <form action="{{ route('category.store') }}" method="POST" id="category_form" class="row form" enctype="multipart/form-data">
                    @csrf

                    @if($edit == true && !empty($category))
                      <input type="hidden" name="id" value="{{ $category->id }}"/>
                      <input type="hidden" name="edit" value="true"/>
                    @endif
                    <div class="col-md-6">
                        <div class="form-group">
                            <strong>Select Category Type</strong>
                            <select class="form-control select_2" name="parent_id[]" multiple="multiple">
                              @foreach ($parentCategories as $categoryy)
                                <option value="{{ $categoryy->id }}" {{ (!empty($category) && in_array($categoryy->id, explode(",", $category->parent_id)))? "selected" : "" }}>{{ $categoryy->name }}</option>
                              @endforeach
                            </select>
                          </div>

                          <div class="form-group">
                            <strong>Category Name</strong>
                            <input type="text" name="name" class="form-control" value="{{ ($edit == true && !empty($category))?$category->name:'' }}" placeholder="Category Name" required>
                          </div>
                          <!-- <div class="form-group">
                            <strong>Category Slug</strong>
                            <input type="text" name="slug" class="form-control" value="{{ ($edit == true && !empty($category))?$category->slug:'' }}" placeholder="Slug" required>
                          </div> -->
                          <div class="form-group">
                            <strong>Category Description</strong>
                            <textarea name="description" class="form-control" value="" placeholder="Description" required>{{ ($edit == true && !empty($category))?$category->description:'' }}</textarea>
                          </div>
                          <div class="form-group">
                            <strong>Category Featured Image</strong>
                            <input type="file" name="image" class="form-control" value="{{ old('image') }}" placeholder="Image" accept="image/*" required>
                          </div>
                          <div class="form-group">
                            <strong>Category Banner Image</strong>
                            <input type="file" name="banner_image" class="form-control" value="{{ old('banner_image') }}" placeholder="Banner Image" accept="image/*" required>
                          </div>
                    </div>
                    <div class="col-md-6">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                @foreach ($parentCategories as $categoryy)
                                    <a id="tab-{{ $categoryy->id }}" class="nav-item nav-link {{ ($loop->index == 0)? 'active': '' }}" data-toggle="tab" href="#nav-{{ $categoryy->id }}" role="tab" aria-controls="nav-home" aria-selected="true" style="display: {{ (!empty($category) && in_array($categoryy->id, explode(",", $category->parent_id)))? 'block': 'none' }}">{{ ucwords(strtolower($categoryy->name)) }}</a>
                                @endforeach
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                          @foreach ($parentCategories as $categoryy)
                            <div class="tab-pane fade {{ (!empty($category) && in_array($categoryy->id, explode(",", $category->parent_id)))? 'show': '' }} {{ ($loop->index == 0)? 'active': '' }}" id="nav-{{ $categoryy->id }}" role="tabpanel" aria-labelledby="nav-home-tab">
                              <div class="form-group">
                                <strong>Select Parent Category</strong>
                                <br/><br/>
                                <select class="form-control col-md-12" id="select_2_diff_{{ $categoryy->id }}" name="category_{{ $categoryy->id }}[]" multiple="multiple">
                                  @if($parentList != null && isset($parentList[$categoryy->id]))
                                    @foreach($parentList[$categoryy->id] as $key=>$value)
                                      <option value="{{ $value->id }}" selected>{{ $value->text }}</option>
                                    @endforeach
                                  @endif
                                </select>
                              </div>
                            </div>
                          @endforeach
                        </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <button style="display: none;" id="success_call"></button>

            <script type="text/javascript">

             $(document).ready(function(){
                $select2_for = $(".select_2").select2({
                    containerCssClass: "error",
                    dropdownCssClass: "select2_dropdown_balkae",
                    placeholder: "Select Category Types",
                });

                $select2_for.on("change", function(e){
                    $("#nav-tab").find(".nav-item").hide();
                    $("#nav-tab").find(".nav-item").removeClass("active");
                    $("#nav-tabContent").find(".tab-pane").removeClass("active");
                    $(e.target).val().forEach(function(tab, index){
                        if(index == 0){
                            $("#tab-"+tab).addClass("active");
                            $("#nav-"+tab).addClass("active");
                            $("#nav-"+tab).show();
                        }
                        $("#tab-"+tab).show();
                    });
                });

                // $.ajax({
                //   url: "{{ route('category.list.parent') }}",
                //   type: "POST",
                //   data: {
                //     "_token": "{{ csrf_token() }}",

                //   },
                //   success: function(data){
                //     console.log("---------------");
                //     console.log(data);
                //   },
                //   error: function(e){
                //     console.log("---------------");
                //     console.log("error");
                //     console.log(e);
                //   }
                // });
                @foreach ($parentCategories as $categoryy)
                  $('#select_2_diff_{{ $categoryy->id }}').select2({
                    containerCssClass: "error",
                    dropdownCssClass: "select2_dropdown",
                    placeholder: "Select Parent Category",
                    ajax: {
                      url: "{{ route('category.list.parent') }}",
                      type: "POST",
                      dataType: 'json',
                      data: function (params) {
                        var query = {
                          "search": params.term,
                          "_token": "{{ csrf_token() }}",
                          "type": {{ $categoryy->id }},
                          @if($edit == true && !empty($category))
                            "category_id": {{ $category->id }}
                          @endif
                        }

                        // Query parameters will be ?search=[term]&type=public
                        return query;
                      },
                      processResults: function (data) {
                        console.log(data);
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
                      }
                      // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                    }
                  });
                @endforeach

                $("#category_form").on("submit", function(e){
                  e.preventDefault();
                  $("#loading").show();
                  $.ajax({
                    url: "{{ route('category.store') }}",
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
                      if(data.type == "success"){
                        // createSubcategory(data.data.id);
                        $("#success_call").trigger("click");
                      }else{
                        $("#show_error").html(data.msg);
                        $("#show_error").show("slow");
                      }
                    },
                    error: function(error){
                        $("#loading").hide();
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
                .tab-content {
                    border-left: 1px solid #ddd;
                    border-right: 1px solid #ddd;
                    padding: 10px;
                    border: 1px solid #ddd;
                    border-radius: 7px;
                    border-top-left-radius: 0;
                }

                .nav.nav-tabs {
                    margin-bottom: 0 !important;
                }
            </style>
