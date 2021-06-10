@extends('admin.layouts.app')

@section('title', 'Size Chart')

@section('main_content')



@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif

<!-- Product list start -->
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <form method="POST" action="{{ route('size_chart.store') }}" enctype="multipart/form-data" id="size_chart_form">
                {{ csrf_field() }}
                <div class="card">
                    <div class="card-header">
                        <a href="javascript:selectImage()" class="btn btn-primary">Replace Size Chart</a>
                        <input type="file" id="size_chart_file" name="file" placeholder="Image" accept="image/*" style="display: none;"/>
                    </div>
                    <hr/>
                    <div class="card-content">
                        <div class="card-body card-dashboard" style="max-height: 60vh; overflow-y: auto;">
                            <img src="{{ !empty($vendor_data)? asset('size_chart_img/'.$vendor_data->size_guide):'' }}" id="size_chart_image"/>
                        </div>
                    </div>
                    <div class="card-footer">
                        <input type="submit" value="Update" class="btn btn-primary disabled" id="size_submit_button" disabled/>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- Product list ends -->

@endsection

@section("page-script")
<script>
    function selectImage(){
        $("#size_chart_file").trigger("click");
    }

    $(document).ready(function(e){
        $("#size_chart_file").on("change", function(e){
            let file = event.target.files[0];
            $("#size_chart_image").attr("src", window.URL.createObjectURL(file));
            $("#size_submit_button").removeAttr("disabled");
            $("#size_submit_button").removeClass("disabled");
            $("#size_submit_button").parent().removeClass("disabled");
            $("#size_submit_button").val("Upload");
        });

        $("#size_chart_form").on("submit", function(e){
            e.preventDefault();
            $("#size_submit_button").attr("disabled", "disabled");
            $("#size_submit_button").addClass("disabled");
            $("#size_submit_button").parent().addClass("disabled");
            $("#size_submit_button").val("Uploading...");
            var formData = new FormData(this);

            $.ajax({
                url: "{{ route('size_chart.store') }}",
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
</script>
@endsection
