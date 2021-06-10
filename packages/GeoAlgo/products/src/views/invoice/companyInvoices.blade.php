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
          <h6 class="m-0 font-weight-bold text-primary">{{$barname}} Invoices</h6>
        </div>
        <div class="col-4"></div>
        <div class="col-4" style="text-align: right;">
          <a href="{{route('invoice.index')}}"><button class="badge badge-success custom-label pull-right custom-right">Back</button></a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                      <th>Order Number</th>
                      <th>Order Date</th>
                      <th>Amount</th>
                      <th width="200px">Action</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach($invoices as $invoice)
                  <tr>
                  <td>{{$invoice->order_number}}</td>
                  <td>{{$invoice->order_date}}</td>
                  <td>{{$invoice->total_amount}}</td>
                  <td><a class='btn btn-info btn-sm custom-btn' href="{{route('invoice.show',[$invoice->id])}}"><i class="fa fa-eye"></i></a></td>
                  </tr>
                  @endforeach
                </tbody>
            </table>
        </div>
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
