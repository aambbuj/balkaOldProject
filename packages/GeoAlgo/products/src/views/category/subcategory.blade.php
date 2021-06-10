@extends('admin.layouts.app')

@section('title', 'Sub-Categories')

@section('main_content')

@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif



<!-- Sub Category list start -->
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-header">
                        <b>Details</b>
                    </div>
                    <div class="card-body card-dashboard">
                        <div class="row">
                            <div class="col-md-3"><b>Name:</b> {{ $category->name }}</div>
                            <div class="col-md-7"><b>Category Type:</b> {{ $type_text }}</div>
                            <div class="col-md-2"><a href="javascript:editCategory({{ $category->id }})" class="float-right"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;Edit</a></div>
                        </div>
                        <br/><br/>
                        <div class="row">
                            <div class="col-md-6">
                                <b>Banner Image :</b><br/><br/>
                                <img src="{{ asset('banner_image') }}/{{ $category->banner_image }}" style="width: 100%"/>
                            </div>
                            <div class="col-md-6">
                                <b>Featured Image :</b><br/><br/>
                                <img src="{{ asset('images') }}/{{ $category->image }}" style="width: 100%"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-content">
                    <div class="card-header">
                        <b>Parent Categories</b>
                    </div>
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="parentCategoryTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Category Name</th>
                                        <th>Slug</th>
                                        <th>Description</th>
                                        <th>Image</th>
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
                <div class="card-content">
                    <div class="card-header">
                        <b>Children Categories</b>
                    </div>
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="childrenCategoryTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Category Name</th>
                                        <th>Type</th>
                                        <th>Banner Image</th>
                                        <th>Featured Image</th>
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
                <div class="card-content">
                    <div class="card-header">
                        <b class="float-left">Category Level Page Filters</b>
                        <b class="float-right"><a href="javascript:addPageFilter()" title="Add Category Level Page Filters"><i class="fa fa-plus" aria-hidden="true"></i></a></b>
                    </div>
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="pageFilters" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Type</th>
                                        <th>Category Name</th>
                                        <th>Attributes</th>
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
                <div class="card-content">
                    <div class="card-header">
                        <b class="float-left">Category Level Attribute and Values</b>
                        <b class="float-right"><a href="javascript:addCategoryAttributeValues()" title="Add Category Level Attribute and Value"><i class="fa fa-plus" aria-hidden="true"></i></a></b>
                    </div>
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="categoryAttributeValues" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Type</th>
                                        <th>Category Name</th>
                                        <th>Attribute</th>
                                        <th>Values</th>
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
<!-- Sub Category list ends -->


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
  table = $('#parentCategoryTable').DataTable({
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
          url: "{{ route('category.list.relation') }}",
          type: 'post',
          data: function ( d ) {
              return $.extend( {}, d, {
                  "_token": "{{ csrf_token() }}",
                  "id": "{{ $category->id }}",
                  "type": "parent"
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
              "orderable": true,
              "render": function(data, type, row, meta){
                return "<a href='{{ route('subcategory') }}/"+row.idd+"'>"+row.value_text+"</a>";
              }
          },
          {
              "targets": 2,
              "data": "types",
              "orderable": false,
          },
          {
              "targets": 3,
              "orderable": false,
              "render": function(data, type, row, meta){
                return "<a href='javascript:showImage(\""+row.name+"\",\""+row.banner_image+"\",\"banner_image\")'><img src='{{ asset('banner_image') }}/"+row.banner_image+"' height='50'/></a>";
              }
          },
          {
              "targets": 4,
              "orderable": false,
              "render": function(data, type, row, meta){
                return "<a href='javascript:showImage(\""+row.name+"\",\""+row.image+"\",\"image\")'><img src='{{ asset('images') }}/"+row.image+"' height='50' /></a>";
              }
          },
          {
              "targets": 5,
              "orderable": false,
              "searchable": false,
              "render": function(data, type, row, meta){
                var btn_str = "";
                btn_str += "&nbsp;&nbsp;&nbsp;<a class='text-success' href='javascript:editCategory("+row.idd+")'><i class='fas fa-edit' aria-hidden='true'></i></a>";
                btn_str += "&nbsp;&nbsp;&nbsp;<a class='text-danger' href='javascript:deleteCategory("+row.idd+")'><i class='fas fa-trash-alt' aria-hidden='true'></i></a>";
                return btn_str;
              }
          },
      ],
      "fnRowCallback" : function(nRow, aData, iDisplayIndex){
          $("td:first", nRow).html(iDisplayIndex +1);
          return nRow;
      },
  });

  tableChild = $('#childrenCategoryTable').DataTable({
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
          url: "{{ route('category.list.relation') }}",
          type: 'post',
          data: function ( d ) {
              return $.extend( {}, d, {
                  "_token": "{{ csrf_token() }}",
                  "id": "{{ $category->id }}",
                  "type": "child"
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
              "orderable": true,
              "render": function(data, type, row, meta){
                return "<a href='{{ route('subcategory') }}/"+row.idd+"'>"+row.value_text+"</a>";
              }
            },
          {
              "targets": 2,
              "data": "types",
              "orderable": false,
          },
          {
              "targets": 3,
              "orderable": false,
              "render": function(data, type, row, meta){
                return "<a href='javascript:showImage(\""+row.name+"\",\""+row.banner_image+"\",\"banner_image\")'><img src='{{ asset('banner_image') }}/"+row.banner_image+"' height='50'/></a>";
              }
          },
          {
              "targets": 4,
              "orderable": false,
              "render": function(data, type, row, meta){
                return "<a href='javascript:showImage(\""+row.name+"\",\""+row.image+"\",\"image\")'><img src='{{ asset('images') }}/"+row.image+"' height='50' /></a>";
              }
          },
          {
              "targets": 5,
              "orderable": false,
              "searchable": false,
              "render": function(data, type, row, meta){
                var btn_str = "";
                btn_str += "&nbsp;&nbsp;&nbsp;<a class='text-success' href='javascript:editCategory("+row.idd+")'><i class='fas fa-edit' aria-hidden='true'></i></a>";
                btn_str += "&nbsp;&nbsp;&nbsp;<a class='text-danger' href='javascript:deleteCategory("+row.idd+")'><i class='fas fa-trash-alt' aria-hidden='true'></i></a>";
                return btn_str;
              }
          },
      ],
      "fnRowCallback" : function(nRow, aData, iDisplayIndex){
          $("td:first", nRow).html(iDisplayIndex +1);
          return nRow;
      },
  });

  pageFilters = $('#pageFilters').DataTable({
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
          url: "{{ route('category.add.attribute.filter.list') }}",
          type: 'post',
          data: function ( d ) {
              return $.extend( {}, d, {
                  "_token": "{{ csrf_token() }}",
                  "id": "{{ $category->id }}",
                  "type": "parent"
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
              "data": "get_type.name",
              "orderable": true,
          },
          {
              "targets": 2,
              "data": "parent_category_name",
              "orderable": false,
          },
          {
            "targets": 3,
              "data": "attributes",
              "orderable": false,
          },
          {
              "targets": 4,
              "orderable": false,
              "searchable": false,
              "render": function(data, type, row, meta){
                var btn_str = "";
                btn_str += "&nbsp;&nbsp;&nbsp;<a class='text-success' href='javascript:editPageFilter("+row.id+")'><i class='fas fa-edit' aria-hidden='true'></i></a>";
                btn_str += "&nbsp;&nbsp;&nbsp;<a class='text-danger' href='javascript:deletePageFilter("+row.id+")'><i class='fas fa-trash-alt' aria-hidden='true'></i></a>";
                return btn_str;
              }
          },
      ],
      "fnRowCallback" : function(nRow, aData, iDisplayIndex){
          $("td:first", nRow).html(iDisplayIndex +1);
          return nRow;
      },
  });

  categoryAttributeValues = $('#categoryAttributeValues').DataTable({
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
          url: "{{ route('category.add.attribute.values.list') }}",
          type: 'post',
          data: function ( d ) {
              return $.extend( {}, d, {
                  "_token": "{{ csrf_token() }}",
                  "id": "{{ $category->id }}",
                  "type": "parent"
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
              "data": "get_type.name",
              "orderable": true,
          },
          {
              "targets": 2,
              "data": "parent_category_name",
              "orderable": false,
          },
          {
              "targets": 3,
              "data": "get_attribute_name.name",
              "orderable": false,
          },
          {
              "targets": 4,
              "data": "att_values",
              "orderable": false,
          },
          {
              "targets": 5,
              "orderable": false,
              "searchable": false,
              "render": function(data, type, row, meta){
                var btn_str = "";
                btn_str += "&nbsp;&nbsp;&nbsp;<a class='text-success' href='javascript:editCategoryAttributeValues("+row.id+")'><i class='fas fa-edit' aria-hidden='true'></i></a>";
                btn_str += "&nbsp;&nbsp;&nbsp;<a class='text-danger' href='javascript:deletePageAttributeValues("+row.id+")'><i class='fas fa-trash-alt' aria-hidden='true'></i></a>";
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

function addPageFilter(){
    $.confirm({
      title: 'Add New Page Filter',
      animation: 'zoom',
      closeAnimation: 'scale',
      columnClass: 'col-md-6 col-md-offset-3',
      content: function () {
          var self = this;
          return $.ajax({
              url: "{{ route('category.add.attribute.filter') }}",
              data:{
                "_token": "{{ csrf_token() }}",
                "id":"{{ $category->id }}",
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

function addCategoryAttributeValues(){
    $.confirm({
      title: 'Add Category Level Attribute and Values',
      animation: 'zoom',
      closeAnimation: 'scale',
      columnClass: 'col-md-6 col-md-offset-3',
      content: function () {
          var self = this;
          return $.ajax({
              url: "{{ route('category.add.attribute.values') }}",
              data:{
                "_token": "{{ csrf_token() }}",
                "id":"{{ $category->id }}",
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

function editCategoryAttributeValues($id){
    $.confirm({
      title: 'Edit Category Level Attribute and Values',
      animation: 'zoom',
      closeAnimation: 'scale',
      columnClass: 'col-md-6 col-md-offset-3',
      content: function () {
          var self = this;
          return $.ajax({
              url: "{{ route('category.add.attribute.values') }}",
              data:{
                "_token": "{{ csrf_token() }}",
                "id":"{{ $category->id }}",
                "edit": true,
                "row_id": $id,
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

function editPageFilter($id){
    $.confirm({
      title: 'Add New Sub Category',
      animation: 'zoom',
      closeAnimation: 'scale',
      columnClass: 'col-md-6 col-md-offset-3',
      content: function () {
          var self = this;
          return $.ajax({
              url: "{{ route('category.add.attribute.filter') }}",
              data:{
                "_token": "{{ csrf_token() }}",
                "id":"{{ $category->id }}",
                "edit": true,
                "row_id": $id,
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
              text: 'Save',
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


function createNew(){
  $.confirm({
      title: 'Add New Sub Category',
      animation: 'zoom',
      closeAnimation: 'scale',
      columnClass: 'col-md-6 col-md-offset-3',
      content: function () {
          var self = this;
          return $.ajax({
              url: "{{ route('subcategory.create') }}",
              data:{
                "_token": "{{ csrf_token() }}",
                "pid":"{{ $category->id }}",
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

function editCategory(id = 0){
  // alert(id);
  $.confirm({
      title: 'Edit Category',
      animation: 'zoom',
      closeAnimation: 'scale',
      columnClass: 'col-md-12',
      content: function () {
          var self = this;
          return $.ajax({
              url: "{{ route('category.create') }}",
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

function editCategory1(id = 0){
  // alert(id);
  $.confirm({
      title: 'Edit Sub Category',
      animation: 'zoom',
      closeAnimation: 'scale',
      columnClass: 'col-md-6 col-md-offset-3',
      content: function () {
          var self = this;
          return $.ajax({
              url: "{{ route('subcategory.create') }}",
              data:{
                "_token": "{{ csrf_token() }}",
                "edit": true,
                "id": id,
                "pid":"{{ $category->id }}",
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
                    url: "{{ route('category.delete') }}",
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

function deletePageAttributeValues(id = 0){
  //alert(id);
    $.alert({
        title: 'Confirm!',
        content: 'Are u sure want to delete!',
        buttons: {
            confirm: function () {
                $.ajax({
                    url: "{{ route('category.add.attribute.values.delete') }}",
                    type: "POST",
                    data:{
                        "_token": "{{ csrf_token() }}",
                        "id": id,
                    },
                    success: function(data){
                        if(data.type == "success"){
                            categoryAttributeValues.draw();
                        }else{
                            categoryAttributeValues.draw();
                        }
                    },
                    error: function(data){
                        console.log(data);
                        categoryAttributeValues.draw();
                    }
                });
            },
            cancel: function () {
                $.alert('Canceled!');
            },
        }
    });

}

function deletePageFilter(id = 0){
  //alert(id);
    $.alert({
        title: 'Confirm!',
        content: 'Are u sure want to delete!',
        buttons: {
            confirm: function () {
                $.ajax({
                    url: "{{ route('category.add.attribute.filter.delete') }}",
                    type: "POST",
                    data:{
                        "_token": "{{ csrf_token() }}",
                        "id": id,
                    },
                    success: function(data){
                        console.log(data);
                        if(data.type == "success"){
                            pageFilters.draw();
                        }else{
                            pageFilters.draw();
                        }
                    },
                    error: function(data){
                        console.log(data);
                        pageFilters.draw();
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
