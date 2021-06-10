@extends('admin.layouts.app')

@section('title', 'Value Icons')

@section('main_content')

@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif



<!-- Category list start -->
    <section id="basic-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <button class="btn btn-primary" onclick="createNew()"><i class="fas fa-plus pr-1"></i>ADD VALUE ICON</button>
                    </div>
                    <div class="card-content">
                        <div class="card-body card-dashboard">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Sl No</th>
                                            <th>Attibute Name</th>
                                            <th>Image</th>
                                            <th>Categories</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
<!--                                     <tfoot>
                                        <tr>
                                            <th>Sl No</th>
                                            <th>Team Name</th>
                                            <th>Parent Team</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot> -->
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Category list ends -->


@endsection

@section('page-style')
<style>
.custom-right{
  float: right;
}
.value_icon_image{
    max-height: 100px;
}
</style>
@endsection

@section('page-script')
<script>
var table = null;
$(document).ready(function() {
  table = $('#dataTable').DataTable({
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
          url: "{{ route('value_icons.list') }}",
          type: 'post',
          data: function ( d ) {
              return $.extend( {}, d, {
                  "_token": "{{ csrf_token() }}"
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
              "name": "value_icons.name",
              "orderable": true,
              "render": function(data, type, row, meta){
                return "<a href='{{ route('attribute.getValue') }}/"+row.id+"'>"+row.name+"</a>";
              }
          },
          {
                "targets": 2,
              "name": "value_icons.image",
              "orderable": true,
              "render": function(data, type, row, meta){
                return "<img src='{{ asset('value_icon') }}/"+ row.image +"' class='value_icon_image'/>";
              }
          },
          {
              "targets": 3,
              "orderable": false,
              "render": function(data, type, row, meta){
                if(row.categories == ""){
                    return "All Categories";
                }else{
                    return row.categories;
                }
              }
          },
          {
              "targets": 4,
              "orderable": false,
              "searchable": false,
              "render": function(data, type, row, meta){
                var btn_str = "";
                btn_str += "&nbsp;&nbsp;&nbsp;<a class='text-success' href='javascript:editCategory("+row.id+")'><i class='fas fa-edit' aria-hidden='true'></i></a>";
                btn_str += "&nbsp;&nbsp;&nbsp;<a class='text-danger' href='javascript:deleteCategory("+row.id+")'><i class='fas fa-trash-alt' aria-hidden='true'></i></a>";
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

function createNew(){
  $.confirm({
      title: 'Add New Value Icon',
      animation: 'zoom',
      closeAnimation: 'scale',
      columnClass: 'col-md-6 col-md-offset-3',
      content: function () {
          var self = this;
          return $.ajax({
              url: "{{ route('value_icons.create') }}",
              data:{
                "_token": "{{ csrf_token() }}",
              },
              dataType: 'json',
              method: 'POST'
          }).done(function (response) {
              // console.log("Add Success");
              // console.log(response);

              self.setContent(response.data);
              // self.setContentAppend('<br>Version: ' + response.version);
              // self.setTitle(response.name);
              // attributeValues(response.data.id);
          }).fail(function(data){
              console.log("Add error");
              console.log(data);
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

 function attributeValues(id = 0){
  // alert(id);
  $.confirm({
      title: 'Add Attibute Values',
      animation: 'zoom',
      closeAnimation: 'scale',
      columnClass: 'col-md-6 col-md-offset-3',
      content: function () {
          var self = this;
          return $.ajax({
              url: "{{ route('attribute.value') }}",
              data:{
                "_token": "{{ csrf_token() }}",
                "id": id,
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

function editCategory(id = 0){
  // alert(id);
  $.confirm({
      title: 'Edit Value Icons',
      animation: 'zoom',
      closeAnimation: 'scale',
      columnClass: 'col-md-6 col-md-offset-3',
      content: function () {
          var self = this;
          return $.ajax({
              url: "{{ route('value_icons.create') }}",
              data:{
                "_token": "{{ csrf_token() }}",
                "edit": true,
                "id": id,
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

function deleteCategory(id = 0){
  //alert(id);
    $.alert({
        title: 'Confirm!',
        content: 'Are u sure want to delete!',
        buttons: {
            confirm: function () {
                $.ajax({
                    url: "{{ route('value_icons.delete') }}",
                    type: "POST",
                    data:{
                        "_token": "{{ csrf_token() }}",
                        "id": id,
                    },
                    success: function(data){
                        if(data.type == "success"){
                            table.draw();
                        }else{
                            table.draw();
                        }
                    },
                    error: function(data){
                        table.draw();
                    }
                });
            },
            cancel: function () {
                $.alert('Canceled!');
            },
        }
    });

}
</script>
@endsection
