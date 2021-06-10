@extends('layouts.frontend.masterfb')
@section('title')
Balkae || Dashboard
@endsection
@section('content')
<!--Dashboard-->
<div class="dasboard order-his">
  <div class="wrap px-3 px-md-5 pt-5 pt-md-4">
      <h3 class="greeting mt-3 mb-3 d-none d-md-block">Order History</h3>
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
        <p>Order History</p>
      </div>
      <div class="order-selects">  
        <div class="row pt-2">
          <div class="col-md-2 col-5">
              <select name="status" id="status">
                <option value="ALL ORDERS">ALL ORDERS</option>
                <option value="Dispatched">Dispatched</option>
                <option value="SHIPPED">SHIPPED</option>
                <option value="CANCELLED">CANCELLED</option>
              </select>
          </div>
          <div class="col-md-3 col-7">
              <select name="status" id="month">
                <option value="1 month">Since 1 months</option>
                <option value="3 month">Since 3 months</option>
                <option value="6 month">Since 6 months</option>
                <option value="1 year">Since 1 Year</option>
                <option value="Since Joining">Since Joining</option>
              </select>
          </div>
        </div>
      </div>
        <!-- ////////////////////   push data from AJAX ///////////////////////////////////////-->
        <span id="pushData">
        <span >
    </div>
  </div>
</div>
<!--Dashboard-->
<!-- Order Track Modal -->
<div class="modal fade dash-modal" id="TrackOrder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h5 class="modal-title text-uppercase" id="exampleModalLabel">DELIVERY DETAILS</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="order-detailst">
          <p class="track-no">Tracking ID: <span>742043846643</span></p>
          <p>Sushmita Pillao</p>
          <p>B-809, 766 Purva Windermerep</p>
          <p>Bhavani Amman Kovil St, Bhavani Amman Kovil St</p>
          <p>CHENNAI, TAMIL NADU 600100</p>
        </div>
        <div class="track-field">
          <div class="rightbox">
            <p class="tlat-date">Monday, <span>21st Dec</span></p>
            <div class="rb-container">
              <ul class="rb">
                <li class="rb-item" ng-repeat="itembx">
                  <div class="timestamp">
                    7:00 PM
                  </div>
                  <div class="item-title">DELIVERED</div>
                  <p class="item-tdet"><i>Chennai_Tambaram_D, IN</i></p>

                </li>
                <li class="rb-item" ng-repeat="itembx">
                  <div class="timestamp">
                     3:00 PM
                  </div>
                  <div class="item-title">Out for delivery</div>
                  <p class="item-tdet"><i>Chennai_Tambaram_D, IN</i></p>
                </li>

                <li class="rb-item" ng-repeat="itembx">
                  <div class="timestamp">
                    1:00 PM
                  </div>
                  <div class="item-title">Package arrived at a courier facility</div>
                  <p class="item-tdet"><i>Chennai_Tambaram_D, IN</i></p>

                </li>

                <li class="rb-item" ng-repeat="itembx">
                  <div class="timestamp">
                    1:00 PM
                  </div>
                  <div class="item-title">Package LEFT THEcourier facility</div>
                  <p class="item-tdet"><i>MAA_Poonamallee_HB, IN</i></p>

                </li>

              </ul>

            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-start border-0 pt-0">
        <button type="button" class="btn btn-track">SEE ALL UPDATES</button>
      </div>
    </div>
  </div>
</div>
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
  $('.track-order').click(function(){
    alert('good');
  })
  </script>

<script>

  var month='';
  var status ='';
  $(document).ready(function () {
    getData();
  });

  $(document).ready(function(){
    $('#month').change(function(){
      month = $('#month').val();
      getData();
    })
  })

  $(document).ready(function(){
    $('#status').change(function(){
        status = $('#status').val();
      getData();
    })
  })
  function getData(){
    //alert(month + status);
    var data = {
            '_token': $('input[name=_token]').val(),
            'quantity':null,
            'product_id':null,
            'cart_id' : null,
          };
    $.ajax({
          url: '/customer/orders-history',
          type: 'get',
          data: data,
          success: function (response) {
              console.log(response.orders.length)
              var htmldata = '';
                for (let i = 0; i < response.orders.length; i++) {
                  for (let j = 0; j < response.orders[i].order_details.length; j++) {
                    console.log(response.orders[i].order_details.length)
                    htmldata = htmldata + `<div class="order-block mt-4">
                                    <p class="order-number">${response.orders[i].order_number}</p>
                                    <a href="javascript:void(0);" class="track-order" data-toggle="modal" data-target="#TrackOrder">Track Order</a>
                                    <div class="row pt-3 mb-2">
                                      <div class="col-md-2 col-6 order-md-1 order-2">
                                        <div class="order-status">
                                          <p class="status-head">Status:</p>
                                          <p class="position-relative"><img src="{{asset('img/values/dispatch.svg')}}" alt=""> Dispatched</p>
                                        </div>
                                      </div>
                                      <div class="col-md-3 col-12 order-md-2 order-6">
                                        <div class="order-status">
                                          <p class="status-head">Expected Date of Arrival:</p>
                                          <p>Tuesday, January 30th, 2021</p>
                                        </div>
                                      </div>
                                      <div class="col-md-3 col-6 order-md-3 order-4">
                                        <div class="order-status">
                                          <p class="status-head">Order Placed on:</p>
                                          <p>Friday, 17th Dec, 2020</p>
                                        </div>
                                      </div>
                                      <div class="col-md-2 col-6 order-md-4 order-5">
                                        <div class="order-status">
                                          <p class="status-head">Order Amount:</p>
                                          <p>₹ ${response.orders[i].order_details[j].total_price}.00</p>
                                        </div>
                                      </div>
                                      <div class="col-md-2 col-6 order-md-6 order-3">
                                        <div class="order-status">
                                          <p class="status-head">Shipped To:</p>
                                          <p>Sushmita Pillai</p>
                                        </div>
                                      </div>
                                      <div class="col-12 order-1 order-md-7">
                                        <div class="order-product mt-3">
                                          <div class="oproduct-img">
                                            <img src="{{asset('Pimages/${response.orders[i].order_details[j].image}')}}" alt="image">
                                          </div>
                                          <div class="orderp-details">
                                            <a href="#">Arie Front Pintuck Dress in Mustard</a>
                                            <p class="o-price">₹ ${response.orders[i].order_details[j].total_price}.00</p>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="ordr-btns">
                                      <a href="#">Return or Replace</a>
                                      <a href="#">Share Review</a>
                                    </div>
                                  </div>`
                  }
                }
                $('#pushData').html(htmldata);

          }
      });
  }
  </script>
@endsection