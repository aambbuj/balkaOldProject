              
<div class="col-xs-12 col-sm-12 col-md-12">
        <div class="alert alert-danger" role="alert" id="show_error" style="display: none;">
          This is a warning alert—check it out!
        </div>
      </div>
                <div id="loading" style="display: none;">
                  <i class="fas fa-spinner fa-spin icon-spining"></i>
                </div>
               <div class="card-body">
                  <form action="{{ route('category.parent-cat-store') }}" method="POST" id="parent_cat_store" class="form" enctype="multipart/form-data">
                    @csrf
                    @if($edit == true && !empty($category))
                    <input type="hidden" name="id" value="{{ $category->id }}"/>
                    <input type="hidden" name="edit" value="true"/>
                    @endif

                    @foreach($allCategories as $key => $allCategory)
                        @if($allCategory->subCategories->count() > 0 && $allCategory->parent_id == NULL)
                            <div class="radio">
                                <label class="container">
                                    <input type="radio" name="subcategory" value="{{$allCategory->id}}" style="margin-right: 5px;">{{$allCategory->name}}
                                </label>
                            </div>
                                @foreach($allCategory->subCategories as $subCat)
                                    @if($subCat->childrenCategories->count() > 0)
                                        <div class="radio" style="margin-left:35px">
                                            <label class="container"><input type="radio" value="{{$subCat->id}}" name="subcategory" style="margin-right: 5px;">{{$subCat->name}}</label>
                                        </div>
                                        @foreach($subCat->childrenCategories as $childCat)
                                            <div class="radio" style="margin-left:55px">
                                                <label class="container"><input type="radio" value="{{$childCat->id}}" name="subcategory" style="margin-right: 5px;">{{$childCat->name}}</label>
                                            </div>
                                        @endforeach
                                    @elseif($subCat->childrenCategories->count() == 0)
                                        <div class="radio" style="margin-left:35px">
                                                <label class="container"><input type="radio" value="{{$subCat->id}}" name="subcategory" style="margin-right: 5px;">{{$subCat->name}}</label>
                                        </div>
                                    @endif

                                @endforeach 
                        @elseif($allCategory->subCategories->count()==0 && $allCategory->parent_id == NULL)
                            <div class="radio">
                                <label class="container"><input type="radio" value="{{$allCategory->id}}" name="subcategory" style="margin-right: 5px;">{{$allCategory->name}}</label>
                            </div>
                        @endif   
                    @endforeach
                    
                  </form>
                </div>
              </div>
            </div>

            <button style="display: none;" id="success_call"></button>

            <script type="text/javascript">
              
             $(document).ready(function(){
                $("#parent_cat_store").on("submit", function(e){
                  e.preventDefault();
                  $("#loading").show();
                  $.ajax({
                    url: "{{ route('category.parent-cat-store') }}",
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
                      console.log(data.data.id); //Call me bhai
                      attributeValue(data.data.id);
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


            function attributeValue(category_id = 0){
              $.confirm({
                  title: 'Create Attribute Values',
                  animation: 'zoom',
                  closeAnimation: 'scale',
                  columnClass: 'col-md-12',
                  content: function () {
                      var self = this;
                      return $.ajax({
                          url: "{{ route('category.create-attribute-values') }}",
                          data:{
                            "_token": "{{ csrf_token() }}",
                            "edit": true,
                            "category_id": category_id,
                          },
                          dataType: 'json',
                          method: 'POST'
                      }).done(function (response) {
                          // alert(response);
                          self.setContent(response.data);
                          // self.setContentAppend('<br>Version: ' + response.version);
                          // self.setTitle(response.name);
                      }).fail(function(data){
                          self.setContent(data.responseText);
                      });
                  },
                  type: 'green',
                  buttons: {
                      formSubmit: {
                          text: 'Save Changes',
                          btnClass: 'btn-green',
                          action: function () {
                              this.$content.find('.form').trigger("submit");
                              return false;
                          }
                      },
                      cancel: function () {
                          return true;
                      },
                  },
                  onContentReady: function () {
                      // bind to events
                      var jc = this;
                      this.$content.find('#success_call').on('click', function (e) {
                          $message = jc.$content.find('#message_of_call').val();
                          jc.close();
                          table.draw();
                      });
                  }
              });
            }
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

            label{
                font-size: 18px;
                margin-bottom: 5px;
                padding-left: 2px;
                /* margin-right: 10px; */
                color: darkorange;
                }
            </style>