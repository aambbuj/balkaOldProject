@extends('admin.layouts.app')

@section('title', 'Coupoun')

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
                        <button class="btn btn-primary" onclick="createNewCopune()"><i class="fas fa-plus pr-1"></i>ADD NEW COUPON</button>
                    </div>
                    <div class="card-content">
                        <div class="card-body card-dashboard">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Sl No</th>
                                            <th>User Name</th>
                                            <th>Category Name</th>
                                            <th>Product Name</th>
                                            <th>Coupone Code</th>
                                            <th>Type</th>
                                            <th>Minimun Price</th>
                                            <th>Maximun Price</th>
                                            <th>Exp Date</th>
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
    <!-- Category list ends -->


@endsection

@section('page-style')
<style>
.custom-right{
  float: right;
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
          url: "{{ route('coupone.list') }}",
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
    //   "columnDefs":[
    //       {
    //           "className": 'control',
    //           "orderable": false,
    //           "targets":   0,
    //           "defaultContent":''
    //       },
    //       {
    //           "targets": 1,
    //           "data": "user_id",
    //           "name": "coupons.user_id",
    //           "orderable": false,
    //       },
    //       {
    //           "targets": 2,
    //           "data": "category_id",
    //           "name": "coupons.category_id",
    //           "orderable": false,
    //       },
    //       {
    //           "targets": 3,
    //           "data": "product_id",
    //           "name": "coupons.product_id",
    //           "orderable": false,
    //       },
    //       {
    //           "targets": 4,
    //           "data": "coupon_code",
    //           "name": "coupons.coupon_code",
    //           "orderable": false,
    //       },

    //       {
    //           "targets": 5,
    //           "data": "type",
    //           "name": "coupons.type",
    //           "orderable": false,
    //       },
    //       {
    //           "targets": 6,
    //           "data": "min_price",
    //           "name": "coupons.min_price",
    //           "orderable": false,
    //       },
    //       {
    //           "targets": 7,
    //           "data": "max_price",
    //           "name": "coupons.max_price",
    //           "orderable": false,
    //       },
    //     },
    //       {
    //           "targets": 8,
    //           "data": "exp_date",
    //           "name": "coupons.exp_date",
    //           "orderable": false,
    //       },
          
    //       {
    //           "targets": 9,
    //           "orderable": false,
    //           "searchable": false,
    //           "render": function(data, type, row, meta){
    //             var btn_str = "";
    //             btn_str += "&nbsp;&nbsp;&nbsp;<a class='text-success' href='javascript:editBrand("+row.id+")'><i class='fas fa-edit' aria-hidden='true'></i></a>";
    //             btn_str += "&nbsp;&nbsp;&nbsp;<a class='text-danger' href='javascript:deleteBrand("+row.id+")'><i class='fas fa-trash-alt' aria-hidden='true'></i></a>";
    //             return btn_str;
    //           }
    //       },
    //   ],
      "fnRowCallback" : function(nRow, aData, iDisplayIndex){
          $("td:first", nRow).html(iDisplayIndex +1);
          return nRow;
      },
  });
});

function createNewCopune(){
  $.confirm({
      title: 'Add New Coupoun',
      animation: 'zoom',
      closeAnimation: 'scale',
      columnClass: 'col-md-6 col-md-offset-3',
      content: function () {
          var self = this;
          return $.ajax({
              url: "{{ route('coupone.create') }}",
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

function editBrand(id = 0){
  // alert(id);
  $.confirm({
      title: 'Edit Copoun',
      animation: 'zoom',
      closeAnimation: 'scale',
      columnClass: 'col-md-6 col-md-offset-3',
      content: function () {
          var self = this;
          return $.ajax({
              url: "{{ route('coupone.create') }}",
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

function deleteBrand(id = 0){
  //alert(id);
    $.alert({
        title: 'Confirm!',
        content: 'Are u sure want to delete!',
        buttons: {
            confirm: function () {
                $.ajax({
                    url: "{{ route('coupone.delete') }}",
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
