@extends('admin.layouts.app')

@section('title', 'Add Attribute')

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
                  <form action="{{ route('product.attribute') }}" method="POST" id="category_form" class="form row" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                      <div class="col-sm-12">
                        <div class="form-group">
                          <input type="hidden" name="id" value="{{ $productId }}"/>
                    <strong>Put the Attribute Name</strong>
                        </div>
                      </div>
                      <div class="col-sm-12">
                    <div class="form-group">
                      <div class="field_wrapper">
                          <div class="col-sm-12 pl-0 mb-2">
                              <input type="text" name="name[]" placeholder="Attribute Name" id ="name" value=""/>
                              <a href="javascript:void(0);" class="add_button" title="Add field">Add</a>
                          </div>
                       </div>
                     </div>
                   </div>
                   <div class="col-sm-12">
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary">Next</button>
                      </div>
                    </div>  
                      </div>
                  </form>
                </div>

     @endsection       

     @section('page-script')
    
   <!--  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
     <script>
      $(document).ready(function(){
          var maxField = 10; //Input fields increment limitation
          var addButton = $('.add_button'); //Add button selector
          var wrapper = $('.field_wrapper'); //Input field wrapper
          var fieldHTML = '<div class="col-sm-12 pl-0 mb-2"><input type="text" name="name[]" placeholder="Attribute Name" id ="name" value=""/><a href="javascript:void(0);" class="remove_button">Remove</a></div>'; //New input field html 
          var x = 1; //Initial field counter is 1
          
          //Once add button is clicked
          $(addButton).click(function(){
              //Check maximum number of input fields
              if(x < maxField){ 
                  x++; //Increment field counter
                  $(wrapper).append(fieldHTML); //Add field html
              }
          });
          
          //Once remove button is clicked
          $(wrapper).on('click', '.remove_button', function(e){
              e.preventDefault();
              $(this).parent('div').remove(); //Remove field html
              x--; //Decrement field counter
          });
      });
      </script>
      
     @endsection

     @section('page-style')
      
     @endsection