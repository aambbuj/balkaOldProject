@extends('admin.layouts.app')

@section('title', 'Create Product')

@section('main_content')

@if (count($errors) > 0)
  <div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
       @foreach ($errors->all() as $error)
         <li>{{ $error }}</li>
       @endforeach
    </ul>
  </div>
@endif
               <div class="card-body">
                  <form action="{{ route('product.store') }}" method="POST" id="category_form" class="form row" enctype="multipart/form-data">
                    @csrf
                    <div class="col-sm-8">
                    <div class="form-group">
                      <strong>Product Name</strong>
                      <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Product Name" required>
                    </div>
                    <div class="form-group">
                      <strong>Description</strong>
                      <textarea name="description" class="form-control" id="create-ck" value="{{ old('description') }}" placeholder="Description"></textarea>
                    </div>
                    <div class="form-group">
                      <strong>Select Variant</strong>
                      <select class="form-control" id="select_attributs" name="select_attributs">
                        <option hidden value="">Select Variant</option>
                          <option value="normal" selected>Normal</option>
                          <option  value="variant_product">Variant Product</option>
                      </select>
                    </div>
                    </div>


                    <div class="col-sm-4">
                      <div class="form-group">
                      <strong>Select Category</strong>
                      <select class="form-control" name="category_id">
                        <option hidden value="">Select Category</option>
                      @foreach($categories as $key => $allCategory)
                        @if($allCategory->subCategories->count() > 0 && $allCategory->parent_id == NULL)
                            <option value="{{ $allCategory->id }}">{{ $allCategory->name }}</option>     <!--no padding and margin -->
                                @foreach($allCategory->subCategories as $subCat)
                                    @if($subCat->childrenCategories->count() > 0)
                                          <option  value="{{ $subCat->id }}"> &nbsp;&nbsp;&nbsp;&nbsp;- {{ $subCat->name }}</option>  <!--padding and margin like 20 px-->
                                        @foreach($subCat->childrenCategories as $childCat)
                                            <option value="{{ $childCat->id }}"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -- {{ $childCat->name }}</option> <!--padding and margin like 30 px-->
                                        @endforeach
                                    @elseif($subCat->childrenCategories->count() == 0)
                                      <option value="{{ $subCat->id }}"> &nbsp;&nbsp;&nbsp;&nbsp;- {{ $subCat->name }}</option> <!--padding and margin like 20 px-->
                                    @endif
                                @endforeach 
                        @elseif($allCategory->subCategories->count()==0 && $allCategory->parent_id == NULL)
                          <option value="{{ $allCategory->id }}">{{ $allCategory->name }}</option>
                        @endif   
                    @endforeach
                      </select>
                    </div>

                    <div class="form-group">
                      <strong>Select Brand</strong>
                      <select class="form-control" name="brand_id">
                        <option hidden value="">Select Brand</option>

                        @foreach ($brands as $brand)
                          <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <!-- <div class="form-group">
                      <input type="button" class="form-control" id="select_attributs" value="Select Attributs">
                    </div> -->
                    <div class="form-group">
                      <strong>Quantity</strong>
                      <input type="text" name="qty" class="form-control" value="{{ old('qty') }}" placeholder="Quantity" required>
                    </div>
                    <div class="form-group">
                      <strong>Price</strong>
                      <input type="text" name="price" class="form-control" value="{{ old('price') }}" placeholder="Price" required>
                    </div>
                    <div class="form-group">
                    <strong>Discount</strong>
                    <input type="text" name="discount" class="form-control" value="{{ old('discount') }}" placeholder="Discount" required>
                    </div>
                    <div class="form-group">
                      <strong>Image</strong>
                      <input type="file" name="image" class="form-control" value="{{ old('image') }}" placeholder="Image" accept="image/*" required>
                    </div>
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary">Add</button>
                      <button type="button" class="btn btn-danger" onclick="window.location='{{route('product.index')}}'">Cancel</button>
                     </div> 
                  </form>
                </div>


      <div class="container">

  <!-- The Modal -->
  <div class="modal fade" id="attributsModal">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Select Attribute </h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
         <div class="row" id="selectAtributeValue">

         </div>
            <input type="button" id="save_value" name="save_value" value="Ok" />
        </div>
      </div>
    </div>
  </div>
  
</div>
<button style="display: none;" id="success_call"></button>

     @endsection       

     @section('page-script')

      <script src="https://cdn.ckeditor.com/ckeditor5/24.0.0/classic/ckeditor.js"></script>
     <script>
          ClassicEditor
            .create( document.querySelector( '#create-ck' ) )
                .then( editor => {
                    console.log( editor );
                    } )
                    .catch( error => {
                      console.error( error );
                    } );
    </script>

<!-- <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script> -->
<script>
// CKEDITOR.replace( '#create-ck' );
</script>


  <script type="text/javascript">

      var allAttrValue=[];
       var attrComData=[];
       /// Get attribute and value ..................................
        $(document).ready(function(){
          $("#select_attributs").change(function(e){
            if ($('#select_attributs').val() == 'variant_product') {
            e.preventDefault();
            $("#loading").show();
            $.ajax({
              url: "{{ route('product.add-attributs') }}",
              type: "POST",
              contentType: false,
              cache: false,
              processData:false,
              beforeSend : function(){
                //$("#preview").fadeOut();
                // $("#err").fadeOut();
              },
              success: function(data){
                $("#loading").hide();
                console.log(data); //Call me bhai  name2
                //$('#name2').val(data.data[0].name)
                allAttrValue = data.data;
                console.log(allAttrValue);
                  var attrData = [];
                  var attrValue =[];
              for (let i = 0; i < data.data.length; i++) {
                  attrData[i]= `<div class="col-md-3">
                                <div class="checkbox">
                                    <label>
                                      <input type="checkbox" class="select_attribute" onclick="selectAttr(${data.data[i].id})" class="chkListItem" value="${data.data[i].id}" name="select_attribute[]">&nbsp;${data.data[i].name}
                                    </label>
                                </div>
                                  <div id="value${data.data[i].id}">
                                  </div>`
                }

                $('#selectAtributeValue').html(attrData);


                $('#attributsModal').modal('show');
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
            }
          });
        });
        //////////      sava a variable with atribute and value ...................
        $('#save_value').click(function(){
          $('#attributsModal').modal('hide');
          //console.log('kkkkkkk')
          console.log(attrComData)
         // $('#attribute_value').val(attrComData);
        })
        //////////  manage attribute ......................
        function selectAttr(id){
          var valueData = [];
          for (let i = 0; i < allAttrValue.length; i++) {
            if (allAttrValue[i].id == id) {
              for (let j = 0; j < allAttrValue[i].values.length; j++) {
                valueData[j]= `<div class="checkbox"><label><input type="checkbox" class="select_value" style="font-size:20px" onclick="selectValus(${allAttrValue[i].values[j].id})" name="select_value[]" value="${allAttrValue[i].values[j].id}">&nbsp;${allAttrValue[i].values[j].value}</label></div>`
              }
              break;
            }
          }
          $(`#value${id}`).html(valueData)
        }
        ////////////// manage and compair attribute and value ///////////////////////////////
        function selectValus(att_value){
          attr_id = [];
          value_id = [];
          att_values = [];
          $(".select_value:checked").each(function(i){
              value_id[i]=$(this).val();
            });

            $(".select_attribute:checked").each(function(i){
                  attr_id[i] = $(this).val();
            });
            for (let j = 0; j < allAttrValue.length; j++) {
              for (let k = 0; k < attr_id.length; k++) {
              if(allAttrValue[j].id == attr_id[k]){
                for (let l = 0; l < allAttrValue[j].values.length; l++) {
                    for (let m = 0; m < value_id.length; m++) {
                      if (allAttrValue[j].values[l].id == value_id[m]) {
                        att_values.push(allAttrValue[j].values[l]);
                      }
                    }
                }
              }
              }
            }
            attrComData = att_values
            console.log(attrComData);
        }


        

  function addAttributImage(product_id){
   console.log(product_id)
  $.confirm({
      title: 'Add the Product Attributs and value',
      animation: 'zoom',
      closeAnimation: 'scale',
      columnClass: 'col-md-12',
      content: function () {
          var self = this;
          return $.ajax({
              url: "{{ route('product.add-attributs-image') }}",
              data:{
                "_token": "{{ csrf_token() }}",
                product_id:product_id
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
              text: 'Add',
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

<script type="text/javascript">
  
 $(document).ready(function(){
    $("#category_form").on("submit", function(e){
      e.preventDefault();
      $("#loading").show();
      var data;
        data = new FormData(this);
        data.append( 'attribute_value',JSON.stringify(attrComData));
        $.ajax({
          url: "{{ route('product.store') }}",
          type: "POST",
          data: data,
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
            if (data.data>0) {
              addAttributImage(data.data);
            }

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
  
     @endsection

     @section('page-style')
      <style>
.ck-editor__editable_inline {
    min-height: 300px;
}
</style>
     @endsection