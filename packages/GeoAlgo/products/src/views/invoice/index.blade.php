@extends('layouts.master')
@section('title')
Invoices
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
          <h6 class="m-0 font-weight-bold text-primary">Invoices</h6>
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
                      <th>Bar Name</th>
                      <th>Address</th>
                      <th>Pincode</th>
                      <th width="200px">Action</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach($bars as $bar)
                  <tr>
                  <td>{{$bar->company_name}}</td>
                  <td>{{$bar->address}}</td>
                  <td>{{$bar->pincode}}</td>
                  <td><a class='btn btn-info btn-sm custom-btn' href="{{route('invoice.get',[$bar->id])}}"><i class="fas fa-file-invoice"></i></a></td>
                  </tr>
                  @endforeach
                </tbody>
            </table>
        </div>
    </div>


@endsection

@push('css')
@endpush

@push('js')
<script>
  $(document).ready(function() {
    $('#dataTable').DataTable();
} );
</script>
@endpush
