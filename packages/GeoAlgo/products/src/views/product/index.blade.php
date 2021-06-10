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
                        <a href="{{route('product.create')}}" class="btn btn-primary"><i class="fas fa-plus pr-1"></i>ADD PRODUCT</a>                        
                        <a href="{{route('product.sample.export.get')}}" class="btn btn-primary"><i class="fas fa-file-download pr-1"></i>Sample CSV</a>
                    </div>
                    <div class="card-content">
                        <div class="card-body card-dashboard">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Sl No</th>
                                            <th>Product Name</th>
                                            <th>SKU</th>
                                            <th>Description</th>
                                            <th>Qty</th>
                                            <th>Price</th>
                                            <th>Discount</th>
                                            <th>Image</th>
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
    <!-- Product list ends -->


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
          url: "{{ route('product.list') }}",
          type: 'post',
          data: function ( d ) {
              return $.extend( {}, d, {
                  "_token": "{{ csrf_token() }}",
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
              "data": "product_name",
              "name": "products.product_name",
              "orderable": true,
          },
          {
              "targets": 2,
              "data": "sku",
              "name": "products.sku",
              "orderable": false,
          },
          {
              "targets": 3,
              "data": "product_description",
              "name": "products.product_description",
              "orderable": false,
          },
          {
              "targets": 4,
              "data": "qty_per_unit",
              "name": "products.qty_per_unit",
              "orderable": true,
          },
          {
              "targets": 5,
              "data": "unit_price",
              "name": "products.unit_price",
              "orderable": true,
          },
          {
              "targets": 6,
              "data": "discount",
              "name": "products.discount",
              "orderable": true,
          },
          {
              "targets": 7,
              "orderable": false,
              "render": function(data, type, row, meta){
                return "<img src='{{ asset('Pimages') }}/"+row.image+"' height='50'/>";
              }
          },
          {
              "targets": 8,
              "orderable": false,
              "searchable": false,
              "render": function(data, type, row, meta){
                console.log(row.id);
                var btn_str = "";
                btn_str += "&nbsp;<a class='text-primary' href='javascript:addInventory("+row.id+")'><i class='fa fa-plus' aria-hidden='true' title='add qty'></i></a>";
                btn_str += "&nbsp;&nbsp;&nbsp;<a class='text-success' href='{{route('product.edit')}}/"+row.id+"'><i class='fas fa-edit' aria-hidden='true' title='edit'></i></a>";
                btn_str += "&nbsp;&nbsp;&nbsp;<a class='text-danger' href='javascript:deleteCategory("+row.id+")'><i class='fas fa-trash-alt' aria-hidden='true' title='delete'></i></a>";
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

function addInventory(id = 0){
  // alert(id);
  $.confirm({
      title: 'Add the product Quantity',
      animation: 'zoom',
      closeAnimation: 'scale',
      columnClass: 'col-md-6 col-md-offset-3',
      content: function () {
          var self = this;
          return $.ajax({
              url: "{{ route('product.addqty') }}",
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
              text: 'Add',
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

function addAttributs(product_id){
   alert('ffffffffff');
  $.confirm({
      title: 'Add the Product Attributs and value',
      animation: 'zoom',
      closeAnimation: 'scale',
      columnClass: 'col-md-12',
      content: function () {
          var self = this;
          return $.ajax({
              url: "{{ route('product.add-attributs-image') }}",
              data:{
                "_token": "{{ csrf_token() }}",
                product_id:product_id
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
              text: 'Add',
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
                    url: "{{ route('product.delete') }}",
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
