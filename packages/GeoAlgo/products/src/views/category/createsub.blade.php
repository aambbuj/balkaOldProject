              
<div class="col-xs-12 col-sm-12 col-md-12">
        <div class="alert alert-danger" role="alert" id="show_error" style="display: none;">
          This is a warning alert—check it out!
        </div>
      </div>

                <div id="loading" style="display: none;">
                  <i class="fas fa-spinner fa-spin icon-spining"></i>
                </div>
               <div class="card-body">
                  <form action="{{ route('category.store') }}" method="POST" id="category_form" class="form" enctype="multipart/form-data">
                    @csrf
                    @if($edit == true && !empty($category))
                    <input type="hidden" name="id" value="{{ $category->id }}"/>
                    <input type="hidden" name="edit" value="true"/>
                    @endif
                    <div class="form-group">
                      <strong>Select Parent Category</strong>
                      <select class="form-control" name="parent_id">
                        <option hidden value="">Select Parent Category</option>

                        @foreach ($parentCategories as $categoryy)
                          <option value="{{ $categoryy->id }}" {{ (!empty($pid))?($pid==$categoryy->id ? 'selected': ''):'' }}>{{ $categoryy->name }}</option>
                        @endforeach
                      </select>
                    </div>

                    <div class="form-group">
                      <strong>Category Name</strong>
                      <input type="text" name="name" class="form-control" value="{{ ($edit == true && !empty($category))?$category->name:'' }}" placeholder="Category Name" required>
                    </div>
                    <div class="form-group">
                      <strong>Category Slug</strong>
                      <input type="text" name="slug" class="form-control" value="{{ ($edit == true && !empty($category))?$category->slug:'' }}" placeholder="Slug" required>
                    </div>
                    <div class="form-group">
                      <strong>Category Description</strong>
                      <textarea name="description" class="form-control" value="" placeholder="Description" required>{{ ($edit == true && !empty($category))?$category->description:'' }}</textarea>
                    </div>
                    <div class="form-group">
                      <strong>Category Image</strong>
                      <input type="file" name="image" class="form-control" value="{{ old('image') }}" placeholder="Image" accept="image/*" required>
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
                    url: "{{ route('subcategory.store') }}",
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