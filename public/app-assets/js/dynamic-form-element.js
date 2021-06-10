$(document).ready(function(){
	var maxField = 10;

    var addButton = $('.addHeading');
    var wrapper = $('.field_wrapper');    
    var fieldHTML = '<div class="child"><div class="row mb-3"><div class="col-11"><label contenteditable="true">Heading</label><input type="text" name="txt_heading[]" value="" class="form-control" placeholder="Heading"></div><div class="col-1" style="padding-top:40px;"><a href="javascript:void(0);" class="remove_button"><i class="fas fa-trash-alt text-danger"></i></a></div></div></div>';
    var x = 1;    
    
    $(addButton).click(function(){       
        if(x < maxField){ 
            x++;
            $(wrapper).append(fieldHTML);
        }
    });    
   
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();            
        $(this).closest('div.child').remove();
        x--;
    });

    $(addButton).click(function(){
    	$('.emptyPlaceholderLine').hide();
    });


	// ADD FULL NAME FIELD
    var addButton = $('.addFullName');
    var wrapper = $('.field_wrapper');    
    var fieldHTML = '<div class="child"><div class="row mb-3"><div class="col-11"><label contenteditable="true">Full Name</label><input type="text" name="txt_fullname[]" value="" class="form-control" placeholder="Full Name"></div><div class="col-1" style="padding-top:40px;"><a href="javascript:void(0);" class="remove_button"><i class="fas fa-trash-alt text-danger"></i></a></div></div></div>';
    var x = 1;    
    
    $(addButton).click(function(){       
        if(x < maxField){ 
            x++;
            $(wrapper).append(fieldHTML);
        }
    });    
   
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();        
        $(this).closest('div.child').remove();
        x--;
    });

    $(addButton).click(function(){
    	$('.emptyPlaceholderLine').hide();
    });

});
