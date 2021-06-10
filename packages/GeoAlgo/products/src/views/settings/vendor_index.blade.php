@extends('admin.layouts.app')

@section('title', 'Products')

@section('main_content')



@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif

<!-- Product list start -->
<section id="basic-datatable">
    <div class="row">
        <form class="col-12" id="vendor_setting_form">
            <div class="card">
                <div class="card-header">
                    <a href="javascript:saveVendorSettings()" class="btn btn-primary btn-sm float-right"><i class="fas fa-plus pr-1"></i>Update</a>
                </div>
                <hr/>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="delivery_timeline_filter">Delivery timeline filter</label>
                                <select class="form-control" id="delivery_timeline_filter">
                                    <option value="" hidden>Select delivery timeline</option>
                                    <option value="2-3 days">2-3 days</option>
                                    <option value="4-7 days">4-7 days</option>
                                    <option value="8-12 days">8-12 days</option>
                                    <option value="13-15 days">13-15 days</option>
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="featured_product">Select 2 featured Product</label>
                                <select class="form-control" id="featured_product">
                                    <option value="" hidden>Select Featured Product</option>
                                </select>
                                <small id="featured_product_help" class="form-text text-muted"><a href="#">Add Product</a></small>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="shipping_type">Select Shipping Type</label>
                                <select class="form-control" id="shipping_type">
                                    <option value="" hidden>Select Shipping Type</option>
                                    <option value="Shipping by Vendor">Shipping by Vendor</option>
                                    <option value="Shipping by Balkae">Shipping by Balkae</option>
                                    <option value="Shipping by Customer">Shipping by Customer</option>
                                </select>
                            </div>
                            <div class="col-md-8">
                                <label for="about_info">Enter your info for porduct details</label>
                                <textarea class="form-control" id="about_info" rows="5" style="resize: none;"></textarea>
                                <small class="form-text text-muted float-right"><i id="about_info_textarea_count">0</i> of 100</small>
                            </div>
                            <div class="col-md-4">
                                <label for="vendor_logo">Select your logo</label>
                                <input type="file" id="vendor_logo" style="display: none;" accept="image/*"/>
                                <div class="form-control" style="height: 135px; text-align:center; cursor: pointer;" onclick="getImage()">
                                    <img src="{{ asset('default/images.png') }}" id="vendor_logo_image" style="max-height: 100%; max-width: 100%; vertical-align: bottom;"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-primary text-center" id="size_submit_button" style="width: 30vw">Update</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<!-- Product list ends -->

@endsection


@section("page-script")
<script>
$(document).ready(function(e){
    $("#featured_product").select2();

    $("#about_info").on('keyup', function() {
        var words = 0;

        if ((this.value.match(/\S+/g)) != null) {
            words = this.value.match(/\S+/g).length;
        }

        if (words > 200) {
            // Split the string on first 200 words and rejoin on spaces
            var trimmed = $(this).val().split(/\s+/, 200).join(" ");
            // Add a space at the end to make sure more typing creates new words
            $(this).val(trimmed + " ");
        }
        else {
            $('#about_info_textarea_count').text(words);
            // $('#word_left').text(200-words);
        }
    });

    $("#vendor_logo").on("change", function(e){
        let file = event.target.files[0];
        $("#vendor_logo_image").attr("src", window.URL.createObjectURL(file));
    });

    $("#vendor_setting_form").on("submit", function(e){
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "{{ route('settings.vendor.store') }}",
            type: 'POST',
            data: formData,
            success: function (data) {
                $("#size_submit_button").val("Uploaded");
            },
            error: function (data) {
                $("#size_submit_button").removeAttr("disabled");
                $("#size_submit_button").removeClass("disabled");
                $("#size_submit_button").parent().removeClass("disabled");
                $("#size_submit_button").val("Upload");
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});

function getImage(){
    $("#vendor_logo").trigger("click");
}
</script>
@endsection
