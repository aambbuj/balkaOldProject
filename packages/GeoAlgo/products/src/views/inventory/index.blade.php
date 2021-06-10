@extends('layouts.master')
@section('title')
Inventory
@endsection

@section('content')


@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif



<div class="card shadow mb-4">
    <div class="card-header py-3 row">
        <div class="col-4">
          <h6 class="m-0 font-weight-bold text-primary">Inventory Management</h6>
        </div>
        <div class="col-4"></div>
        <div class="col-4">
          <button class="badge badge-success custom-label pull-right custom-right" onclick="createNew()">Create New</button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                      <th>Sl No</th>
                      <th>SKU</th>
                      <th>name</th>
                      <th>mrp</th>
                      <th>discount</th>
                      <th>price</th>
                      <th>qty</th>
                      <th>sold</th>
                      <th>available</th>
                      <th width="280px">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection

@push('css')
<style>
.custom-right{
  float: right;
}
</style>
@endpush

@push('js')
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
          url: "{{ route('inventory.list') }}",
          type: 'post',
          data: function ( d ) {
              return $.extend( {}, d, {
                  "_token": "{{ csrf_token() }}"
              });
          },
          /*success :function(data22){
            console.log(data22);
          },*/
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
              "data": "sku",
              "name": "items.sku",
              "orderable": true,
              
          },
           {
              "targets": 2,
              "data": "product_name",
              "name": "items.product.product_name",
              "orderable": false,
              
          },
          {
              "targets": 3,
              "data": "cost",
              "name": "items.cost",
              "orderable": false,
          },
          {
              "targets": 4,
              "data": "discount",
              "name": "items.discount",
              "orderable": false,
          },
          {
              "targets": 5,
              "data": "sale_price",
              "name": "items.sale_price",
              "orderable": false,
          },
          {
              "targets": 6,
              "data": "qty",
              "name": "items.qty",
              "orderable": false,
          },
          {
              "targets": 7,
              "data": "sold",
              "name": "items.sold",
              "orderable": false,
          },
          {
              "targets": 8,
              "data": "available",
              "name": "items.available",
              "orderable": false,
          },
          {
              "targets": 9,
              "orderable": false,
              "searchable": false,
              "render": function(data, type, row, meta){
                var btn_str = "";
                btn_str += "&nbsp;<a class='btn btn-primary btn-sm custom-btn' href='javascript:editInventory("+row.id+")'><i class='fas fa-edit' aria-hidden='true'></i></a>";
                btn_str += "&nbsp;<a class='btn btn-info btn-danger btn-sm custom-btn' href='javascript:deleteInventory("+row.id+")'><i class='fas fa-trash-alt' aria-hidden='true'></i></a>";
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
      title: 'Add New Inventory',
      animation: 'zoom',
      closeAnimation: 'scale',
      columnClass: 'col-md-6 col-md-offset-3',
      content: function () {
          var self = this;
          return $.ajax({
              url: "{{ route('inventory.create') }}",
              data:{
                "_token": "{{ csrf_token() }}",
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

function editInventory(id = 0){
  // alert(id);
  $.confirm({
      title: 'Edit Inventory',
      animation: 'zoom',
      closeAnimation: 'scale',
      columnClass: 'col-md-6 col-md-offset-3',
      content: function () {
          var self = this;
          return $.ajax({
              url: "{{ route('inventory.create') }}",
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

function deleteInventory(id = 0){
  //alert(id);
    $.alert({
        title: 'Confirm!',
        content: 'Are u sure want to delete!',
        buttons: {
            confirm: function () {
                $.ajax({
                    url: "{{ route('inventory.delete') }}",
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
@endpush
