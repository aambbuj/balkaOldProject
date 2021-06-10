@extends('layouts.master')
@section('title')
Orders
@endsection
@section('content')


@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif

<div class="col-xs-12 col-sm-12 col-md-12">
        <div class="alert alert-danger" role="alert" id="show_error" style="display: none;">
          This is a warning alert—check it out!
        </div>
      </div>


<div class="card shadow mb-4">
    <div class="card-header py-3 row">
        <div class="col-4">
          <h6 class="m-0 font-weight-bold text-primary">Order Management</h6>
        </div>
        <div class="col-4"></div>
        <div class="col-4">
          <!-- <button class="badge badge-success custom-label pull-right custom-right" onclick="createNew()">Create New</button> -->
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                      <th>Sl No</th>
                      <th>Bar Name</th>
                      <th>Order Number</th>
                      <th>Product Name</th>
                      <th>Order Date</th>
                      <th>Total amount</th>
                      <th width="200px">Action</th>
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
          url: "{{ route('order.list') }}",
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
              "data": "bar_name",
              "orderable": false,
              
          },
          {
              "targets": 2,
              "data": "order_number",
              "name": "orders.order_number",
              "orderable": true,
              
          },
           {
              "targets": 3,
              "data": "product_name",
              "name": "orders.details.product_name",
              "orderable": false,
              
          },
          {
              "targets": 4,
              "data": "order_date",
              "name": "orders.order_date",
              "orderable": true,
          },
          {
              "targets": 5,
              "data": "total_amount",
              "name": "orders.total_amount",
              "orderable": true,
          },
          {
              "targets": 6,
              "orderable": false,
              "searchable": false,
              "render": function(data, type, row, meta){
                var btn_str = "";
                /*btn_str += "&nbsp;<a class='btn btn-primary btn-sm custom-btn' href='javascript:assignToDriver("+row.id+")'><i class='fas fa-user-tag' aria-hidden='true'></i></a>";*/
                btn_str += "&nbsp;<a class='btn btn-info btn-sm custom-btn' href='javascript:acceptOrder("+row.id+")'>Accept</i></a>";
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

/*function createNew(){
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
}*/

function assignToDriver(id = 0){
  // alert(id);
  $.confirm({
      title: 'Assign to Driver',
      animation: 'zoom',
      closeAnimation: 'scale',
      columnClass: 'col-md-6 col-md-offset-3',
      content: function () {
          var self = this;
          return $.ajax({
              url: "{{ route('order.assign') }}",
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
          formSubmit: {
              text: 'Assign',
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

function acceptOrder(id = 0){
  //alert(id);
    $.alert({
        title: 'Confirm!',
        content: 'Are u sure to accept Order!',
        buttons: {
            confirm: function () {
                $.ajax({
                    url: "{{ route('order.acceptOrder') }}",
                    type: "POST",
                    data:{
                        "_token": "{{ csrf_token() }}",
                        "id": id,
                    },
                    success: function(data){
                        if(data.type == "success"){
                            assignToDriver(id);
                            table.draw();
                        }else{
                            table.draw();
                            $("#show_error").html(data.msg);
                            $("#show_error").show("slow");
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
