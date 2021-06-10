                <div id="loading" style="display: none;">
                  <i class="fas fa-spinner fa-spin icon-spining"></i>
                </div>
                 <div class="card-body">
                  <form action="{{ route('category.update',[$category->id]) }}" method="POST" id="categoryupdate_form" class="form" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                      <input type="text" name="name" class="form-control" value="{{ $category->name }}" placeholder="Category Name" required>
                    </div>
                    <div class="form-group">
                      <input type="text" name="slug" class="form-control" value="{{ $category->slug }}" placeholder="Slug" required>
                    </div>
                    <div class="form-group">
                      <textarea name="description" class="form-control"  placeholder="Description" required>{{ $category->description }}</textarea>
                    </div>
                    <div class="form-group">
                      <input type="file" name="image" class="form-control"  placeholder="Image" accept="image/*" required>
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
                    url: "{{ route('category.update',[$category->id]) }}",
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
                        alert("Category Created");
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

            