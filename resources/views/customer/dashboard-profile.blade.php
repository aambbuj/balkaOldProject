@extends('layouts.frontend.masterfb')
@section('title')
Balkae || Dashboard-Profile
@endsection
@section('content')
 <!--Dashboard Profile-->
<div class="wrap prfl px-3 px-md-5 pt-5 pt-md-4">
@if (count($errors) > 0)
  <div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
       @foreach ($errors->all() as $error)
         <li>{{ $error }}</li>
       @endforeach
    </ul>
  </div>
@endif
      <h3 class="greeting mt-3 mb-4 d-none d-md-block">Profile Details</h3>
      <div class="balkae-ablogo">        
        <svg width="199" height="438" viewBox="0 0 199 438" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M6.00002 432.303L6 6" stroke="var(--yellow)" stroke-width="11" stroke-linecap="round"/>
        <path d="M161.057 275.577L7.80999 177.201C7.14444 176.774 6.26978 177.252 6.26978 178.043L6.26978 430.881C6.26978 431.687 7.17392 432.161 7.83732 431.704L161.877 325.523C179.522 313.36 179.092 287.154 161.057 275.577Z" stroke="var(--yellow)" stroke-width="11" stroke-linecap="round"/>
        <path d="M106.044 240.784L7.8131 177.211C7.14774 176.781 6.26978 177.258 6.26978 178.051L6.26978 358.598C6.26978 359.406 7.17736 359.88 7.84044 359.419L106.864 290.605C124.383 278.43 123.954 252.375 106.044 240.784Z" stroke="var(--yellow)" stroke-width="11" stroke-linecap="round"/>
        <path d="M108.666 311.417L7.54081 246.399C6.8753 245.971 6 246.449 6 247.24L6 430.879C6 431.686 6.9048 432.16 7.56815 431.702L109.486 361.339C127.107 349.174 126.677 322.997 108.666 311.417Z" stroke="var(--yellow)" stroke-width="11" stroke-linecap="round"/>
        </svg>
      </div>
      <div class="dash-back d-block d-md-none">
        <a href="dashboard-overview.html"><i class="far fa-long-arrow-left"></i> back</a>
      </div>
      <div class="dash-cpage d-block d-md-none">
        <p>Profile Details</p>
      </div>
      <div class="mobile-edit d-block d-md-none mt-3 mb-5">
        <p class="username font-weight-bold mb-1">Sushmita Pillai</p>
        <p>Member sine January 2019.</p>
        <button type="button" class="btn btn-track Edit-pf-m bg-white mt-2">EDIT PROFILE</button>
      </div>
    <div class="row pt-2 pb-5">
      <div class="col-lg-8"> 
        <div class="profile-form">
          <form action="{{route('customer.update',[$user->id])}}" method="POST"  enctype="multipart/form-data">
          @csrf
            <div class="row">
              <div class="form-group col-md-6">
                <label for="inputfname">First Name</label>
                <input type="text" class="form-control" name="f_name" id="inputfname" value="{{$user->f_name}}" placeholder="First Name" readonly>
              </div>
              <div class="form-group col-md-6">
                <label for="inputlname">Last Name</label>
                <input type="text" class="form-control" name="l_name" id="inputlname" value="{{$user->l_name}}" placeholder="Last Name" readonly>
              </div>
              <div class="form-group col-md-6">
                <label for="inputEmailId">Email ID</label>
                <input type="text" class="form-control"  id="inputEmailId" value="{{$user->email}}" placeholder="email" readonly>
              </div>
              <div class="form-group col-md-6">
                <label for="inputCN">Contact Number</label>
                <div class="country-code">
                  <p>+91</p>
                </div>
                <input type="text" class="form-control" name="mobile" id="inputCN" value="{{$user->mobile ? $user->mobile : ' '}}" placeholder="mobile no." readonly>
              </div>
              <div class="form-group col-md-12">
                <p class="dabi mb-2 mt-3">Date of Birth</p>
                <div class="d-flex">
                  <select name="dd" id="change_date" class="mr-3 dd-show">
                    <option value="">DD</option>
                    <?php
                    $j=0;
                    ?>
                    @for($j=1;$j<=31;$j++)
                    <option value="{{$j}}">{{$j}}</option>
                    @endfor
                  </select>
                  <select name="mm" id="change_month" class="mr-3">
                    <option value="">MMM</option>
                    <option value="01">Jan</option>
                    <option value="02">Feb</option>
                    <option value="03">Mar</option>
                    <option value="04">Apr</option>
                    <option value="05">May</option>
                    <option value="06">Jun</option>
                    <option value="07">Jul</option>
                    <option value="08">Aug</option>
                    <option value="09">Sep</option>
                    <option value="10">Oct</option>
                    <option value="11">Nov</option>
                    <option value="12">Dec</option>
                  </select>
                  <select name="yy" id="change_year" class="">
                    <option value="">YYYY</option>
                    <?php
                    $i=0;
                    $currentYears = date("Y");
                    ?>
                    @for($i=1970;$i<=$currentYears;$i++)
                    <option value="{{$i}}">{{$i}}</option>
                    @endfor
                  </select>
                </div>
              </div>
              <div class="form-group col-md-12">
                <p class="sv-add mb-2">Saved Address</p>
                <div class="pfl-address">
                @foreach($addresses as $address)
                  <div class="sv-address">
                    <p>{{$address->address1}}, {{$address->address2}}</p>
                    <p>{{$address->city}}, {{$address->state}} {{$address->postal_code}}</p>
                    <p>{{$address->country}}</p>
                    <div class="edit-option">
                      <a href="#" data-toggle="modal" onclick="editModal({{$address}})"><i class="far fa-edit"></i></a>
                    </div>
                  </div>
                 @endforeach 
                  <a href="#">
                    <div class="add-address mb-3" data-toggle="modal" data-target="#AddAdress">
                      <p>+ Add A New Address</p>
                    </div>
                  </a>
                </div>
                
              </div>
              <div class="form-group col-md-6">
                <label for="inputPass">Password</label>
                <input type="Password" name="password" class="form-control" id="inputPass" placeholder="•••••••••••••••••" readonly>
                <input type="hidden" name="dob"  id="pushdob">
              </div>
              <div class="form-row col-md-12">
                <div class="pf-btns mt-3 ml-1">
                  <button type="button" class="btn btn-track Edit-pf">EDIT PROFILE</button>
                  <button type="submit" class="btn btn-track Save-pf" style="display:none">SAVE DETAILS</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>   
    </div>    
  </div>
   <!--Dashboard Profile-->
   <!-- Add Address Modal -->
<div class="modal fade dash-modal" id="AddAdress" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h5 class="modal-title text-uppercase" id="exampleModalLabel">Add new address</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="address-field">
          <form action="{{route('address.add',[$user->id])}}" method="POST"  enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="form-group col-md-6">
                <label class="control-label" for="textinput">Address Line 1</label>
                <div class="">
                  <input type="text" name="address1" placeholder="Address Line 1" class="form-control">
                </div>
              </div>

              <!-- Text input-->
              <div class="form-group col-md-6">
                <label class="control-label" for="textinput">Address Line 2</label>
                <div class="">
                  <input type="text" name="address2" placeholder="Address Line 2" class="form-control">
                </div>
              </div>

              <!-- Text input-->
              <div class="form-group col-md-6">
                <label class="control-label" for="textinput">City</label>
                <div class="">
                  <input type="text" name="city" placeholder="City" class="form-control">
                </div>
              </div>

              <!-- Text input-->
              <div class="form-group col-md-6">
                <label class="control-label" for="textinput">State</label>
                <div class="">
                  <input type="text" name="state" placeholder="State" class="form-control">
                </div>
              </div>

              <div class="form-group col-md-6">
                <label class="control-label" for="textinput">Postcode</label>
                <div class="">
                  <input type="text" name="postal_code" placeholder="Post Code" class="form-control">
                </div>
              </div>  



              <!-- Text input-->
              <div class="form-group col-md-6">
                <label class="control-label" for="textinput">Country</label>
                <div class="">
                  <input type="text" name="country" placeholder="Country" class="form-control">
                </div>
              </div>

              <div class="form-group">
                <div class="col-md-12">
                  <div class="mt-3">
                    <button type="submit" class="btn btn-track">Save Address</button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
      <!-- <div class="modal-footer justify-content-start border-0 pt-0">
        <button type="button" class="btn btn-track">Save Address</button>
      </div> -->
    </div>
  </div>
</div>
<!-- Add Address Modal -->


   <!-- Edit Address Modal -->
   <div class="modal fade dash-modal" id="AddAdress-two" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h5 class="modal-title text-uppercase" id="exampleModalLabel">Edit the address</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="papulateHTML">
            <!-- form open from javascript -->
      </div>
    </div>
  </div>
</div>
<!-- Edit Address Modal -->
@endsection
@section('css')
<style>
.edit-option {
    float: right;
    bottom: 78px;
    position: absolute;
    right: 28px;
}
.nice-select.open .list {
    width: 100%;
    height: 43vh;
    overflow: auto;
}
</style>
@endsection

@section('js')
<script>

//////////////////////  select date month and year /////////////////////////
let date = '';
        let month = '';
        let year = '';
        let  dateMonthYear = '';
      $('#change_date').change(function() {
        date = $('#change_date').val();
      })

      $('#change_month').change(function() {
        month = $('#change_month').val();
      })
      $('#change_year').change(function() {
        year = $('#change_year').val();
      })



    $(".Edit-pf").click(function(){
      $(".profile-form input").removeAttr("readonly");
      $("#inputEmailId").attr("readonly", "readonly");
      $("#inputfname").focus();
      $(".Edit-pf").hide();
      $(".Save-pf").show();
    });
    $(".Save-pf").click(function(){
      dateMonthYear = year+-+month+-+date;
      $('#pushdob').val(dateMonthYear)
      //  console.log(dateMonthYear)
      $(".Edit-pf").show();
      $(".Save-pf").hide();
      $(".profile-form input").attr("readonly", "readonly");
      $(".Edit-pf-m").css("opacity", "1");
    });
    $(".Edit-pf-m").click(function(){
      $(".profile-form input").removeAttr("readonly");
      $("#inputEmailId").attr("readonly", "readonly");
      $("#inputfname").focus();
      $(".Edit-pf-m").css("opacity", "0.4");
      $(".Save-pf").show();
    });

    function editModal(userAddress){
      $('#AddAdress-two').modal('show');
      console.log(userAddress);
     var data =  `<div class="address-field">
          <form action="{{route('address.update')}}" method="POST"  enctype="multipart/form-data">
            @csrf
            <div class="row">
            <input type="hidden" name="id" placeholder="Address Line 1" value="${userAddress.id}" class="form-control">
              <div class="form-group col-md-6">
                <label class="control-label" for="textinput">Address Line 1</label>
                <div class="">
                  <input type="text" name="address1" placeholder="Address Line 1" value="${userAddress.address1}" class="form-control">
                </div>
              </div>

              <!-- Text input-->
              <div class="form-group col-md-6">
                <label class="control-label" for="textinput">Address Line 2</label>
                <div class="">
                  <input type="text" name="address2" placeholder="Address Line 2"  value="${userAddress.address2}" class="form-control">
                </div>
              </div>

              <!-- Text input-->
              <div class="form-group col-md-6">
                <label class="control-label"  for="textinput">City</label>
                <div class="">
                  <input type="text" name="city"  value="${userAddress.city}" placeholder="City" class="form-control">
                </div>
              </div>

              <!-- Text input-->
              <div class="form-group col-md-6">
                <label class="control-label" for="textinput">State</label>
                <div class="">
                  <input type="text" name="state"  value="${userAddress.state}"  placeholder="State" class="form-control">
                </div>
              </div>

              <div class="form-group col-md-6">
                <label class="control-label" for="textinput">Postcode</label>
                <div class="">
                  <input type="text" name="postal_code" value="${userAddress.postal_code}" placeholder="Post Code" class="form-control">
                </div>
              </div>  



              <!-- Text input-->
              <div class="form-group col-md-6">
                <label class="control-label" for="textinput">Country</label>
                <div class="">
                  <input type="text" name="country" value="${userAddress.country}" placeholder="Country" class="form-control">
                </div>
              </div>

              <div class="form-group">
                <div class="col-md-12">
                  <div class="mt-3">
                    <button type="submit" class="btn btn-track">Save Address</button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>`

      $('#papulateHTML').html(data);
    }

  </script>  
  @endsection