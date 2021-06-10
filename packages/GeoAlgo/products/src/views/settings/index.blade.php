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
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="javascript:createSpecification()" class="btn btn-primary btn-sm"><i class="fas fa-plus pr-1"></i>Add Specifications</a>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="specificationTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Sub Heading</th>
                                        <th>Categories Applicable</th>
                                        <th>Value</th>
                                        <th>Mandatory</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <a href="javascript:createShipping()" class="btn btn-primary btn-sm"><i class="fas fa-plus pr-1"></i>Add Shipping</a>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="shippingTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Sub Heading</th>
                                        <th>Categories Applicable</th>
                                        <th>Value</th>
                                        <th>Mandatory</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <a href="javascript:createWashcare()" class="btn btn-primary btn-sm"><i class="fas fa-plus pr-1"></i>Add Wash Care</a>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="washcareTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Sub Heading</th>
                                        <th>Categories Applicable</th>
                                        <th>Value</th>
                                        <th>Mandatory</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Product list ends -->

@endsection


@section("page-script")
<script>
    var specificationTable = null;
    var shippingTable = null;
    var washcareTable = null;

    $(document).ready(function(e){
        specificationTable = $('#specificationTable').DataTable({
            "dom": 'lfrtip',
            "processing": true,
            "serverSide": true,
            "ordering" : true,
            "order":[[ 1, "desc" ]],
            "colReorder": true,
            "select": true,
            "autoWidth": false,
            "language": {
                "infoFiltered":"",
                "processing": "<img src='{{ asset('images/loader.gif') }}'/>",
            },
            "pageLength": 50,
            "lengthMenu": [[50, 100, 200, -1], [50, 100, 200, "All"]],

            "buttons":[{
                text: "Lead ",
                className: "btn-sm btn-default c_lead_btn c_btn",
                action: function(e, dt, node, config){
                    btn_toggling(node, 0);
                }
            }],
            "responsive":{
                "details": {
                    type: 'column'
                }
            },
            "keys":!0,
            "ajax": {
                url: "{{ route('secification.list') }}",
                type: 'post',
                data: function ( d ) {
                    return $.extend( {}, d, {
                        "_token": "{{ csrf_token() }}",
                        "type": "parent",
                        "setting_id": 1,
                    });
                },
                complete: function(data){
                    console.log(data);
                },
                error: function(data){
                    var obj = $.parseJSON( data.responseText );
                    $(".dataTables_processing").hide();
                }
            },
            "columnDefs":[
                {
                    "className": 'control',
                    "orderable": false,
                    "targets":   0,
                    "defaultContent":''
                },
                {
                    "targets": 1,
                    "data": "get_attribute_name.name",
                    "orderable": false,
                },
                {
                    "targets": 2,
                    "data": "categories",
                    "orderable": false,
                },
                {
                    "targets": 3,
                    "data": "att_values",
                    "orderable": false,
                },
                {
                    "targets": 4,
                    "orderable": false,
                    "render": function(data, type, row, meta){
                        if(row.mandatory == 1){
                            return "Yes";
                        }else{
                            return "No";
                        }
                    }
                },
                {
                    "targets": 5,
                    "orderable": false,
                    "searchable": false,
                    "render": function(data, type, row, meta){
                        var btn_str = "";
                        btn_str += "&nbsp;&nbsp;&nbsp;<a class='text-success' href='javascript:editSpecification("+row.id+")'><i class='fas fa-edit' aria-hidden='true'></i></a>";
                        btn_str += "&nbsp;&nbsp;&nbsp;<a class='text-danger' href='javascript:deleteSpecification("+row.id+")'><i class='fas fa-trash-alt' aria-hidden='true'></i></a>";
                        return btn_str;
                    }
                },
            ],
            "fnRowCallback" : function(nRow, aData, iDisplayIndex){
                $("td:first", nRow).html(iDisplayIndex +1);
                return nRow;
            },
        });

        shippingTable = $('#shippingTable').DataTable({
            "dom": 'lfrtip',
            "processing": true,
            "serverSide": true,
            "ordering" : true,
            "order":[[ 1, "desc" ]],
            "colReorder": true,
            "select": true,
            "autoWidth": false,
            "language": {
                "infoFiltered":"",
                "processing": "<img src='{{ asset('images/loader.gif') }}'/>",
            },
            "pageLength": 50,
            "lengthMenu": [[50, 100, 200, -1], [50, 100, 200, "All"]],

            "buttons":[{
                text: "Lead ",
                className: "btn-sm btn-default c_lead_btn c_btn",
                action: function(e, dt, node, config){
                    btn_toggling(node, 0);
                }
            }],
            "responsive":{
                "details": {
                    type: 'column'
                }
            },
            "keys":!0,
            "ajax": {
                url: "{{ route('secification.list') }}",
                type: 'post',
                data: function ( d ) {
                    return $.extend( {}, d, {
                        "_token": "{{ csrf_token() }}",
                        "type": "parent",
                        "setting_id": 2,
                    });
                },
                complete: function(data){
                    console.log(data);
                },
                error: function(data){
                    var obj = $.parseJSON( data.responseText );
                    $(".dataTables_processing").hide();
                }
            },
            "columnDefs":[
                {
                    "className": 'control',
                    "orderable": false,
                    "targets":   0,
                    "defaultContent":''
                },
                {
                    "targets": 1,
                    "data": "get_attribute_name.name",
                    "orderable": false,
                },
                {
                    "targets": 2,
                    "data": "categories",
                    "orderable": false,
                },
                {
                    "targets": 3,
                    "data": "att_values",
                    "orderable": false,
                },
                {
                    "targets": 4,
                    "orderable": false,
                    "render": function(data, type, row, meta){
                        if(row.mandatory == 1){
                            return "Yes";
                        }else{
                            return "No";
                        }
                    }
                },
                {
                    "targets": 5,
                    "orderable": false,
                    "searchable": false,
                    "render": function(data, type, row, meta){
                        var btn_str = "";
                        btn_str += "&nbsp;&nbsp;&nbsp;<a class='text-success' href='javascript:editShipping("+row.id+")'><i class='fas fa-edit' aria-hidden='true'></i></a>";
                        btn_str += "&nbsp;&nbsp;&nbsp;<a class='text-danger' href='javascript:deleteShipping("+row.id+")'><i class='fas fa-trash-alt' aria-hidden='true'></i></a>";
                        return btn_str;
                    }
                },
            ],
            "fnRowCallback" : function(nRow, aData, iDisplayIndex){
                $("td:first", nRow).html(iDisplayIndex +1);
                return nRow;
            },
        });

        washcareTable = $('#washcareTable').DataTable({
            "dom": 'lfrtip',
            "processing": true,
            "serverSide": true,
            "ordering" : true,
            "order":[[ 1, "desc" ]],
            "colReorder": true,
            "select": true,
            "autoWidth": false,
            "language": {
                "infoFiltered":"",
                "processing": "<img src='{{ asset('images/loader.gif') }}'/>",
            },
            "pageLength": 50,
            "lengthMenu": [[50, 100, 200, -1], [50, 100, 200, "All"]],

            "buttons":[{
                text: "Lead ",
                className: "btn-sm btn-default c_lead_btn c_btn",
                action: function(e, dt, node, config){
                    btn_toggling(node, 0);
                }
            }],
            "responsive":{
                "details": {
                    type: 'column'
                }
            },
            "keys":!0,
            "ajax": {
                url: "{{ route('secification.list') }}",
                type: 'post',
                data: function ( d ) {
                    return $.extend( {}, d, {
                        "_token": "{{ csrf_token() }}",
                        "type": "parent",
                        "setting_id": 3,
                    });
                },
                complete: function(data){
                    console.log(data);
                },
                error: function(data){
                    var obj = $.parseJSON( data.responseText );
                    $(".dataTables_processing").hide();
                }
            },
            "columnDefs":[
                {
                    "className": 'control',
                    "orderable": false,
                    "targets":   0,
                    "defaultContent":''
                },
                {
                    "targets": 1,
                    "data": "get_attribute_name.name",
                    "orderable": false,
                },
                {
                    "targets": 2,
                    "data": "categories",
                    "orderable": false,
                },
                {
                    "targets": 3,
                    "data": "att_values",
                    "orderable": false,
                },
                {
                    "targets": 4,
                    "orderable": false,
                    "render": function(data, type, row, meta){
                        if(row.mandatory == 1){
                            return "Yes";
                        }else{
                            return "No";
                        }
                    }
                },
                {
                    "targets": 5,
                    "orderable": false,
                    "searchable": false,
                    "render": function(data, type, row, meta){
                        var btn_str = "";
                        btn_str += "&nbsp;&nbsp;&nbsp;<a class='text-success' href='javascript:editWashcare("+row.id+")'><i class='fas fa-edit' aria-hidden='true'></i></a>";
                        btn_str += "&nbsp;&nbsp;&nbsp;<a class='text-danger' href='javascript:deleteWashcare("+row.id+")'><i class='fas fa-trash-alt' aria-hidden='true'></i></a>";
                        return btn_str;
                    }
                },
            ],
            "fnRowCallback" : function(nRow, aData, iDisplayIndex){
                $("td:first", nRow).html(iDisplayIndex +1);
                return nRow;
            },
        });
    });

    function createSpecification(){
        $.confirm({
            title: 'Add Specifications',
            animation: 'zoom',
            closeAnimation: 'scale',
            columnClass: 'col-md-6 col-md-offset-3',
            content: function () {
                var self = this;
                return $.ajax({
                    url: "{{ route('secification.create') }}",
                    data:{
                        "_token": "{{ csrf_token() }}",
                        "user_id":"{{ auth()->user()->id }}",
                        "setting_id": 1,
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
                    text: 'Create',
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

    function editSpecification($id){
        $.confirm({
            title: 'Edit Specifications',
            animation: 'zoom',
            closeAnimation: 'scale',
            columnClass: 'col-md-6 col-md-offset-3',
            content: function () {
                var self = this;
                return $.ajax({
                    url: "{{ route('secification.create') }}",
                    data:{
                        "_token": "{{ csrf_token() }}",
                        "user_id":"{{ auth()->user()->id }}",
                        "id": $id,
                        "edit": true,
                        "setting_id": 1,
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
                    text: 'Create',
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

    function deleteSpecification($id){
        $.confirm({
            title: 'Delete Specifications',
            animation: 'zoom',
            closeAnimation: 'scale',
            columnClass: 'col-md-6 col-md-offset-3',
            content: "Do you really want to delete this specification",
            type: 'green',
            buttons: {
                formSubmit: {
                    text: 'Yes',
                    btnClass: 'btn-green',
                    action: function () {
                        $.ajax({
                            url: "{{ route('secification.delete') }}",
                            type: "POST",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id": $id,
                            },
                            success: function(data){
                                specificationTable.ajax.reload();
                            },
                            error: function(data){
                                specificationTable.ajax.reload();
                            }
                        });
                        return true;
                    }
                },
                cancel: {
                    text: 'No',
                    action: function(){
                        return true;
                    }
                },
            },
        });
    }



    function createShipping(){
        $.confirm({
            title: 'Add Shipping',
            animation: 'zoom',
            closeAnimation: 'scale',
            columnClass: 'col-md-6 col-md-offset-3',
            content: function () {
                var self = this;
                return $.ajax({
                    url: "{{ route('secification.create') }}",
                    data:{
                        "_token": "{{ csrf_token() }}",
                        "user_id":"{{ auth()->user()->id }}",
                        "setting_id": 2,
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
                    text: 'Create',
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

    function editShipping($id){
        $.confirm({
            title: 'Edit Shipping',
            animation: 'zoom',
            closeAnimation: 'scale',
            columnClass: 'col-md-6 col-md-offset-3',
            content: function () {
                var self = this;
                return $.ajax({
                    url: "{{ route('secification.create') }}",
                    data:{
                        "_token": "{{ csrf_token() }}",
                        "user_id":"{{ auth()->user()->id }}",
                        "id": $id,
                        "edit": true,
                        "setting_id": 2,
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
                    text: 'Create',
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

    function deleteShipping($id){
        $.confirm({
            title: 'Delete Shipping',
            animation: 'zoom',
            closeAnimation: 'scale',
            columnClass: 'col-md-6 col-md-offset-3',
            content: "Do you really want to delete this specification",
            type: 'green',
            buttons: {
                formSubmit: {
                    text: 'Yes',
                    btnClass: 'btn-green',
                    action: function () {
                        $.ajax({
                            url: "{{ route('secification.delete') }}",
                            type: "POST",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id": $id,
                            },
                            success: function(data){
                                specificationTable.ajax.reload();
                            },
                            error: function(data){
                                specificationTable.ajax.reload();
                            }
                        });
                        return true;
                    }
                },
                cancel: {
                    text: 'No',
                    action: function(){
                        return true;
                    }
                },
            },
        });
    }




    function createWashcare(){
        $.confirm({
            title: 'Add Washcare',
            animation: 'zoom',
            closeAnimation: 'scale',
            columnClass: 'col-md-6 col-md-offset-3',
            content: function () {
                var self = this;
                return $.ajax({
                    url: "{{ route('secification.create') }}",
                    data:{
                        "_token": "{{ csrf_token() }}",
                        "user_id":"{{ auth()->user()->id }}",
                        "setting_id": 3,
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
                    text: 'Create',
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

    function editWashcare($id){
        $.confirm({
            title: 'Edit Washcare',
            animation: 'zoom',
            closeAnimation: 'scale',
            columnClass: 'col-md-6 col-md-offset-3',
            content: function () {
                var self = this;
                return $.ajax({
                    url: "{{ route('secification.create') }}",
                    data:{
                        "_token": "{{ csrf_token() }}",
                        "user_id":"{{ auth()->user()->id }}",
                        "id": $id,
                        "edit": true,
                        "setting_id": 3,
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
                    text: 'Create',
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

    function deleteWashcare($id){
        $.confirm({
            title: 'Delete Washcare',
            animation: 'zoom',
            closeAnimation: 'scale',
            columnClass: 'col-md-6 col-md-offset-3',
            content: "Do you really want to delete this specification",
            type: 'green',
            buttons: {
                formSubmit: {
                    text: 'Yes',
                    btnClass: 'btn-green',
                    action: function () {
                        $.ajax({
                            url: "{{ route('secification.delete') }}",
                            type: "POST",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id": $id,
                            },
                            success: function(data){
                                specificationTable.ajax.reload();
                            },
                            error: function(data){
                                specificationTable.ajax.reload();
                            }
                        });
                        return true;
                    }
                },
                cancel: {
                    text: 'No',
                    action: function(){
                        return true;
                    }
                },
            },
        });
    }
</script>
@endsection
