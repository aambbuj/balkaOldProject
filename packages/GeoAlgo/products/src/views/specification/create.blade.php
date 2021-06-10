
<div class="col-xs-12 col-sm-12 col-md-12">
<div class="alert alert-danger" role="alert" id="show_error" style="display: none;">
    This is a warning alert—check it out!
</div>
</div>

<div id="loading" style="display: none;">
    <i class="fas fa-spinner fa-spin icon-spining"></i>
</div>
    <div class="card-body">
        <form action="{{ route('secification.store') }}" method="POST" id="specification_form" class="row form" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="setting_id" value="{{ $setting_id }}"/>
            @if($edit == true && !empty($specification))
                <input type="hidden" name="id" value="{{ $specification['id'] }}"/>
                <input type="hidden" name="edit" value="true"/>
            @endif
            <div class="col-md-12">
                <div class="form-group">
                    <strong>Select Attribute</strong>
                    <select class="form-control select_2" name="attribute_id" id="attribute_id">
                        @if($specification != null && $edit == true)
                            <option value="{{ $specification['get_attribute_name']['id'] }}" selected>{{ $specification['get_attribute_name']['name'] }}</option>
                        @endif
                    </select>
                </div>

                <div class="form-group">
                    <strong>Category Name</strong>
                    <select class="form-control select_2" name="category_id[]" id="category_id" multiple="multiple">
                        @if($category != null && $edit == true  )
                            @foreach ($category as $key=>$value)
                                <option value="{{ $value['id'] }}" selected>{{ $value['text'] }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <strong>Values</strong>
                    <select class="form-control select_2" name="attribute_value_id[]" id="attribute_value_id" multiple="multiple">
                        @if($values != null && $edit == true)
                            @foreach ($values as $key=>$value)
                                <option value="{{ $value->id }}" selected>{{ $value->text }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <strong>Mandatory</strong>
                    <select name="mandatory" class="form-control">
                        <option value="" hidden>Select Mandatory Type</option>
                        <option value="1" {{ ($edit == true && $specification['mandatory'] == 1)?"selected":"" }}>Yes</option>
                        <option value="0" {{ ($edit == true && $specification['mandatory'] == 0)?"selected":"" }}>No</option>
                    </select>
                </div>
            </div>
        </form>
    </div>
    </div>
</div>

<button style="display: none;" id="success_call"></button>

<script type="text/javascript">

    $(document).ready(function(){
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
                    "tree": true,
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
                    "category_id": $("#category_id").val(),
                    "attribute_id": $("#attribute_id").val()
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

    $("#specification_form").on("submit", function(e){
        e.preventDefault();
        $("#loading").show();
        $.ajax({
        url: "{{ route('secification.store') }}",
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
