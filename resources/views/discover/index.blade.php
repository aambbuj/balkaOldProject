@extends('admin.layouts.app')

@section('title', 'Specific')

@section('main_content')



@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif



<!-- Discover list start -->    
    <section id="basic-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-content">
                        <div class="card-body card-dashboard">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Text 1</th>
                                            <th>Text 2</th>
                                            <th>Desktop Text</th>
                                            <th>Url</th>
                                            <th>Moblie Text</th>
                                            <th>Url</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody> 
                                    @foreach($discovers as $discover)
                                        <tr>
                                            <th>{{$discover->text1}}</th>
                                            <th>{{$discover->text2}}</th>
                                            <th>{{$discover->desktoptext}}</th>
                                            <th>{{$discover->desktopurl}}</th>
                                            <th>{{$discover->mobiletext}}</th>
                                            <th>{{$discover->mobileurl}}</th>
                                            <th><a href="{{ route('discover.edit',[$discover->id]) }}" class="text-success"><i class="fas fa-edit"></i></a></th>
                                        </tr>
                                        @endforeach
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
    <!-- Discover list ends -->


@endsection

@section('page-style')

@endsection

@section('page-script')
<script>
var table = null;
$(document).ready(function() {
  table = $('#dataTable').DataTable({  
  });
});

</script>
@endsection
