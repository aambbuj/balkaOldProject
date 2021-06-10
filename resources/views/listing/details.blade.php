@extends('layouts.frontend.master')
@section('title')
Balkae || Home
@endsection
@section('content')

  @php           
    $url = $_SERVER['REQUEST_URI'];
    $url_components = parse_url($url);
    parse_str($url_components['query'], $params);
  @endphp 

<!--product section-->
<section class="pdtl-sec pt-0 pt-md-5">
  <div class="container-fluid px-0 px-md-5">
    <div class="row">
      <div class="col-lg-6">
        <div class="image-gallery sticky-top sticky-top-offset">
          <div class="row">
            <div class="col-lg-10">
               <div id="carousel-main" class="carousel slide " data-ride="false" data-interval="5000">
                <!-- Carousel items -->
                  <ol class="carousel-indicators d-md-none">
                    <li data-target="#carousel-main" data-slide-to="0" class="active"></li>
                    <li data-target="#carousel-main" data-slide-to="1"></li>
                    <!-- <li data-target="#carousel-main" data-slide-to="2"></li> -->
                  </ol>
                  <div class="carousel-inner">
                      <div class="carousel-item active" >
                        <div class="product-imgbox">
                          <img src="{{asset('Pimages/'.$product->image)}}" class="img-fluid" data-slide-number="0">
                        </div>  
                      </div>
                  @foreach($gallety_image as $key => $gallety_img)
                      @if($key != 0)
                      <div class="carousel-item" >
                        <div class="product-imgbox">
                         <img src="{{asset('gallery_image/'.$gallety_img->name)}}" id="carousel-selector-1" class="img-fluid" data-target="#carousel-main" data-slide-to="0">
                        </div>  
                      </div>
                      @endif
                    @endforeach

                  </div>



               </div>
              <div class="product-img-txt">
                <div class="left-img-txt">
                <p>Move your mouse on image to zoom in.</p>
                <p>To pan, move your mouse around the image.</p>
                </div>
                <div class="right-img-txt">
                  <p class="md-height">Model is 5’9”</p>
                  <p>Wearing a size L</p>
                </div>  
              </div>
            </div>
            <div class="col-lg-2">
              <div class="pd-slider-thumb">
           
                <div id="carousel-pager" class="carousel slide " data-ride="false" data-interval="500000000">
                  <!-- Carousel items -->
                  <div class="carousel-inner vertical">

                  @foreach($gallety_image as $key => $gallety_img)
                      @if($key == 0)
                      <div class="carousel-item active" >
                        <div class="slider-thumb-img">
                         <img src="{{asset('gallery_image/'.$gallety_img->name)}}" id="carousel-selector-1" class="img-fluid" data-target="#carousel-main" data-slide-to="0">
                        </div> 
                      </div>
                      @else
                      <div class="carousel-item" >
                        <div class="slider-thumb-img">
                          <img src="{{asset('gallery_image/'.$gallety_img->name)}}" id="carousel-selector-1" class="img-fluid" data-target="#carousel-main" data-slide-to="1">
                        </div>  
                      </div>
                      @endif
                    @endforeach

                  </div>                   
                </div>
              </div>
            </div>  
          </div>  
        </div>
      </div>
      <div class="col-lg-6">
        <div class="product-all-details px-3 px-md-0">
          <div id="section1" class="product-details-one jump-test">
            <h1 class="nasty">{{$categoryDetails->name}}</h1>
            <h3 class="boxy">{{$product->product_name}}</h3>
            <a href="#"><img src="{{asset('img/icons/share-icon.png')}}" class="wp-icn" alt=""></a>
            <div class="price-details">
              <h2>₹ {{$product->unit_price}}/-</h2>
              <p>inclusive of taxes</p>
            </div>
            <p class="bought">250 people have bought this</p>
            @foreach($attributs as $attribute)
              <div class="size-select mb-4">
                <h5 class="d-none d-md-block">Choose {{$attribute->name}}</h5>
                <h5 class="d-block d-md-none">WHat’s your {{$attribute->name}} ?</h5>
                <div class="size-blocks">
                @foreach($attributValues as $attributValue)
                  @if($attributValue->attribute_id == $attribute->id)
                  <div class="size-xs">
                    <input type="radio" id="{{$attributValue->id}}" name="attr_values" value="{{$attributValue->id}}">
                    <label for="{{$attributValue->id}}"><p>{{$attributValue->value}}</p></label>
                  </div>
                  @endif
                @endforeach
                </div>
                <!-- <a href="#" data-toggle="modal" data-target="#SG-Modal">
                <div class="size-guide">
                  <img src="{{asset('img/icons/size-guide.svg')}}" alt="" class="img-fluid sz-gd">
                  <p>Size Guide</p>
                </div>
                </a> -->
              </div>
            @endforeach
       
            <!-- <div class="val-icons">
              <h5>Value Icons</h5>
              <div class="owl-carousel owl-theme pd-value-slider">
        
                  <div class="item">
                    <div class="commit-block">  
                      <img src="{{asset('img/commit/Ellipse2.png')}}" class="img-fluid for-size" alt="">
                      <div class="commit-cir">
                        <div class="cmt-cnt">
                          <img src="{{asset('img/commit/fruit.png')}}" class="img-fluid" alt="">
                          <h5>vegan</h5>
                        </div>
                      </div>
                    </div>
                  </div>  

                  <div class="item">
                    <div class="commit-block">
                        <img src="{{asset('img/commit/Ellipse3.png')}}" class="img-fluid for-size" alt="">
                        <div class="commit-cir">
                          <div class="cmt-cnt">
                            <img src="{{asset('img/commit/dress.png')}}" class="img-fluid" alt="">
                            <h5>Artisan</h5>
                          </div>
                        </div>
                    </div>
                  </div>

              </div>
            </div> -->
            <div class="val-btns mt-4">
                <a href="javascript:void(0);">
                  <div class="product-button">
                    <svg width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.01506 18.4001C7.16756 18.4001 7.31382 18.3395 7.42165 18.2317C7.52948 18.1238 7.59006 17.9776 7.59006 17.8251V13.9151C7.59006 13.7626 7.52948 13.6163 7.42165 13.5085C7.31382 13.4007 7.16756 13.3401 7.01506 13.3401C6.86256 13.3401 6.71631 13.4007 6.60848 13.5085C6.50064 13.6163 6.44006 13.7626 6.44006 13.9151V17.8251C6.44006 17.9776 6.50064 18.1238 6.60848 18.2317C6.71631 18.3395 6.86256 18.4001 7.01506 18.4001Z" fill="black"/>
                    <path d="M10.005 18.4001C10.1575 18.4001 10.3037 18.3395 10.4116 18.2317C10.5194 18.1238 10.58 17.9776 10.58 17.8251V13.9151C10.58 13.7626 10.5194 13.6163 10.4116 13.5085C10.3037 13.4007 10.1575 13.3401 10.005 13.3401C9.85249 13.3401 9.70624 13.4007 9.59841 13.5085C9.49057 13.6163 9.42999 13.7626 9.42999 13.9151V17.8251C9.42999 17.9776 9.49057 18.1238 9.59841 18.2317C9.70624 18.3395 9.85249 18.4001 10.005 18.4001Z" fill="black"/>
                    <path d="M12.9951 18.4001C13.1476 18.4001 13.2939 18.3395 13.4017 18.2317C13.5095 18.1238 13.5701 17.9776 13.5701 17.8251V13.9151C13.5701 13.7626 13.5095 13.6163 13.4017 13.5085C13.2939 13.4007 13.1476 13.3401 12.9951 13.3401C12.8426 13.3401 12.6964 13.4007 12.5885 13.5085C12.4807 13.6163 12.4201 13.7626 12.4201 13.9151V17.8251C12.4201 17.9776 12.4807 18.1238 12.5885 18.2317C12.6964 18.3395 12.8426 18.4001 12.9951 18.4001Z" fill="black"/>
                    <path d="M15.9853 18.4001C16.1378 18.4001 16.284 18.3395 16.3919 18.2317C16.4997 18.1238 16.5603 17.9776 16.5603 17.8251V13.9151C16.5603 13.7626 16.4997 13.6163 16.3919 13.5085C16.284 13.4007 16.1378 13.3401 15.9853 13.3401C15.8328 13.3401 15.6865 13.4007 15.5787 13.5085C15.4709 13.6163 15.4103 13.7626 15.4103 13.9151V17.8251C15.4103 17.9776 15.4709 18.1238 15.5787 18.2317C15.6865 18.3395 15.8328 18.4001 15.9853 18.4001Z" fill="black"/>
                    <path d="M20.93 11.8519V8.86195C20.9309 8.78586 20.9167 8.71035 20.8882 8.63979C20.8598 8.56923 20.8175 8.50502 20.7641 8.4509C20.7106 8.39677 20.6469 8.3538 20.5767 8.32447C20.5064 8.29514 20.4311 8.28004 20.355 8.28005H18.745L16.5347 3.91005C16.5347 3.89395 16.5186 3.87785 16.5094 3.86405C16.3365 3.59406 16.0984 3.37201 15.817 3.21844C15.5356 3.06487 15.22 2.98474 14.8994 2.98545H14.7798C14.6914 2.65622 14.4972 2.36523 14.227 2.15739C13.9568 1.94955 13.6257 1.83642 13.2848 1.83545H9.71521C9.37433 1.83642 9.04324 1.94955 8.77305 2.15739C8.50286 2.36523 8.30858 2.65622 8.22021 2.98545H8.11901C7.79312 2.98497 7.47234 3.06645 7.18617 3.22239C6.90001 3.37833 6.65766 3.60373 6.48141 3.87785C6.47386 3.89365 6.46541 3.90901 6.45611 3.92385L4.24811 8.28005H2.63811C2.48681 8.28187 2.34232 8.34325 2.23598 8.45088C2.12963 8.55852 2.07 8.70374 2.07001 8.85505V11.845C2.06992 11.8853 2.07455 11.9255 2.08381 11.9647L3.75131 19.1821C3.85795 19.6786 4.13217 20.1234 4.52794 20.4417C4.92371 20.7599 5.41693 20.9324 5.92481 20.93H17.0752C17.581 20.9334 18.0726 20.763 18.4678 20.4473C18.863 20.1317 19.1379 19.6899 19.2464 19.1959L20.9162 11.9739C20.9257 11.9339 20.9303 11.893 20.93 11.8519ZM9.31501 3.39025C9.31501 3.28411 9.35717 3.18232 9.43222 3.10727C9.50728 3.03221 9.60907 2.99005 9.71521 2.99005H13.2848C13.3909 2.99005 13.4927 3.03221 13.5678 3.10727C13.6428 3.18232 13.685 3.28411 13.685 3.39025V3.50985C13.685 3.61599 13.6428 3.71778 13.5678 3.79283C13.4927 3.86789 13.3909 3.91005 13.2848 3.91005H9.71521C9.60907 3.91005 9.50728 3.86789 9.43222 3.79283C9.35717 3.71778 9.31501 3.61599 9.31501 3.50985V3.39025ZM7.47501 4.47585C7.54747 4.37224 7.64383 4.28763 7.75593 4.22917C7.86804 4.17072 7.99258 4.14015 8.11901 4.14005H8.30071C8.42268 4.41346 8.62109 4.64577 8.87206 4.809C9.12302 4.97222 9.41583 5.05941 9.71521 5.06005H13.2848C13.5842 5.05941 13.877 4.97222 14.128 4.809C14.3789 4.64577 14.5773 4.41346 14.6993 4.14005H14.8994C15.0217 4.13863 15.1425 4.16724 15.2512 4.22338C15.3599 4.27953 15.4531 4.36148 15.5227 4.46205L17.4639 8.28005H5.53611L7.47501 4.47585ZM3.22001 9.43005H19.78V11.2701H3.22001V9.43005ZM18.1263 18.9405C18.0737 19.1797 17.9406 19.3935 17.7493 19.5462C17.558 19.699 17.32 19.7816 17.0752 19.7801H5.92481C5.67935 19.7813 5.44091 19.6982 5.24952 19.5445C5.05813 19.3908 4.92544 19.1759 4.87371 18.936L3.36721 12.4201H19.6328L18.1263 18.9405Z" fill="black"/>
                    </svg>
                    <p class="cart-add">Add to Bag</p>
                    <p class="product-price">₹{{$product->unit_price}}</p>
                  </div>
                  </a>

                  <a href="javascript:void(0);">
                    <div class="wishlist-btn">
                      <svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M15.5462 2.42726C14.8923 0.930501 13.6105 0.0464187 12.0297 0.00210814C10.5132 -0.0453979 8.97424 0.713634 8 1.91045C7.02576 0.713634 5.48699 -0.0436937 3.97025 0.00210814C2.38953 0.0464187 1.10775 0.930288 0.453851 2.42726C-1.49987 6.89944 3.3923 11.0297 4.9382 12.189C5.77272 12.8149 6.70542 13.4001 7.71071 13.9284C7.80133 13.9761 7.90056 14 8 14C8.09944 14 8.19867 13.9761 8.28929 13.9284C9.29458 13.4001 10.2273 12.8147 11.0618 12.189C12.6077 11.0297 17.4999 6.89944 15.5462 2.42726ZM10.3139 11.1609C9.61303 11.6865 8.83578 12.1826 8 12.6385C7.16422 12.1826 6.38697 11.6865 5.68608 11.1609C4.72128 10.4375 -0.00977192 6.64082 1.60452 2.94578C2.21982 1.53785 3.37279 1.29777 4.00529 1.27987C4.03592 1.27902 4.06613 1.27859 4.09696 1.27859C5.45406 1.27859 6.81871 2.12177 7.43988 3.35438C7.54771 3.56805 7.76399 3.70247 8.00021 3.70247C8.23643 3.70247 8.45271 3.56805 8.56054 3.35438C9.19556 2.09387 10.6152 1.23961 11.9949 1.27987C12.6276 1.29777 13.7806 1.53785 14.3957 2.94578C16.01 6.64082 11.2787 10.4373 10.3139 11.1609Z" fill="black"/>
                      </svg>
                      <p>Add to Wishlist</p>
                    </div>
                  </a>
            </div>
          </div>
          <div id="section2" class="product-details-two py-5 jump-test">
            <div class="product-tabs">
              <nav>
                <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                  <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">SPECIFICATIONS</a>
                  <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Product Details</a>
                  <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Shipping</a>
                  <a class="nav-item nav-link" id="nav-about-tab" data-toggle="tab" href="#nav-about" role="tab" aria-controls="nav-about" aria-selected="false">WASH CARe</a>
                </div>
              </nav>
              <div class="tab-content py-3 px-0 px-sm-0" id="nav-tabContent">
                <div class="tab-pane fade show active animate__animated animate__fadeIn" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                  <div class="row pt-3">
                    <div class="col-6 mb-4">
                      <p class="feature-name">Fabric Composition</p>
                      <h4 class="feature-details">100% Pure Cotton</h4>
                    </div>
                    <div class="col-6 mb-4">
                      <p class="feature-name">Sleeve Length</p>
                      <h4 class="feature-details">Elbow Length</h4>
                    </div>
                    <div class="col-6 mb-4">
                      <p class="feature-name">Occassion</p>
                      <h4 class="feature-details">Casual</h4>
                    </div>
                    <div class="col-6 mb-4">
                      <p class="feature-name">Art style</p>
                      <h4 class="feature-details">Modern</h4>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade animate__animated animate__fadeIn" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                  <div class="pd-dtl-tab pt-3">
                    <p class="sp-tec">Special Technique</p>
                    <p>Bagru is a hand-block printing technique using 
                    natural dyes followed by the Chippa Community 
                    of Rajasthan. This art of mud resists hand block 
                    printing represents a mix of ethnic and nature-
                    inspired designs ranging from bootis and leaves 
                    of fruits.</p>
                  </div>
                </div>
                <div class="tab-pane fade animate__animated animate__fadeIn" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                  <div class="row pt-3">
                    <div class="col-6 mb-4">
                      <p class="feature-name">Pay on delivery </p>
                      <h4 class="feature-details">Available</h4>
                    </div>
                    <div class="col-6 mb-4">
                      <p class="feature-name">Available</p>
                      <h4 class="feature-details">30 Day Returns</h4>
                    </div>
                    <div class="col-6 mb-4">
                      <p class="feature-name">Exchange</p>
                      <h4 class="feature-details">Available</h4>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade animate__animated animate__fadeIn" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                  <div class="row pt-3">
                    <div class="col-6 mb-4">
                      <p class="feature-name">Wash</p>
                      <h4 class="feature-details">Hand Wash</h4>
                    </div>
                    <div class="col-6 mb-4">
                      <p class="feature-name">Colour Spill</p>
                      <h4 class="feature-details">Possible</h4>
                    </div>
                  </div>
                </div>
              </div>           
            </div>
          </div>
          <div id="section3" class="product-details-three pb-5 jump-test">
            <h3>Model is also wearing</h3>
            <div class="row pt-4">
              <div class="col-6">
                <div class="product-boxx also-wear">
                  <img src="{{asset('img/wearing1.jpg')}}" class="img-fluid" alt="">
                  <p class="product-category">NO NASTIES</p>
                  <p class="product-name">Mask + Scrunchie Set</p>
                  <a href="javascript:void(0);">
                    <div class="insta-icon">
                          <svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.5462 2.42726C14.8923 0.930501 13.6105 0.0464187 12.0297 0.00210814C10.5132 -0.0453979 8.97424 0.713634 8 1.91045C7.02576 0.713634 5.48699 -0.0436937 3.97025 0.00210814C2.38953 0.0464187 1.10775 0.930288 0.453851 2.42726C-1.49987 6.89944 3.3923 11.0297 4.9382 12.189C5.77272 12.8149 6.70542 13.4001 7.71071 13.9284C7.80133 13.9761 7.90056 14 8 14C8.09944 14 8.19867 13.9761 8.28929 13.9284C9.29458 13.4001 10.2273 12.8147 11.0618 12.189C12.6077 11.0297 17.4999 6.89944 15.5462 2.42726ZM10.3139 11.1609C9.61303 11.6865 8.83578 12.1826 8 12.6385C7.16422 12.1826 6.38697 11.6865 5.68608 11.1609C4.72128 10.4375 -0.00977192 6.64082 1.60452 2.94578C2.21982 1.53785 3.37279 1.29777 4.00529 1.27987C4.03592 1.27902 4.06613 1.27859 4.09696 1.27859C5.45406 1.27859 6.81871 2.12177 7.43988 3.35438C7.54771 3.56805 7.76399 3.70247 8.00021 3.70247C8.23643 3.70247 8.45271 3.56805 8.56054 3.35438C9.19556 2.09387 10.6152 1.23961 11.9949 1.27987C12.6276 1.29777 13.7806 1.53785 14.3957 2.94578C16.01 6.64082 11.2787 10.4373 10.3139 11.1609Z" fill="black"></path>
                          </svg>
                    </div>
                  </a>
                </div>
              </div>
              <div class="col-6">
                <div class="product-boxx also-wear">
                  <img src="{{asset('img/wearing2.jpg')}}" class="img-fluid" alt="">
                  <p class="product-category">NO NASTIES</p>
                  <p class="product-name">Shibui Zero Waste Bag</p>
                  <a href="javascript:void(0);">
                    <div class="insta-icon">
                          <svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.5462 2.42726C14.8923 0.930501 13.6105 0.0464187 12.0297 0.00210814C10.5132 -0.0453979 8.97424 0.713634 8 1.91045C7.02576 0.713634 5.48699 -0.0436937 3.97025 0.00210814C2.38953 0.0464187 1.10775 0.930288 0.453851 2.42726C-1.49987 6.89944 3.3923 11.0297 4.9382 12.189C5.77272 12.8149 6.70542 13.4001 7.71071 13.9284C7.80133 13.9761 7.90056 14 8 14C8.09944 14 8.19867 13.9761 8.28929 13.9284C9.29458 13.4001 10.2273 12.8147 11.0618 12.189C12.6077 11.0297 17.4999 6.89944 15.5462 2.42726ZM10.3139 11.1609C9.61303 11.6865 8.83578 12.1826 8 12.6385C7.16422 12.1826 6.38697 11.6865 5.68608 11.1609C4.72128 10.4375 -0.00977192 6.64082 1.60452 2.94578C2.21982 1.53785 3.37279 1.29777 4.00529 1.27987C4.03592 1.27902 4.06613 1.27859 4.09696 1.27859C5.45406 1.27859 6.81871 2.12177 7.43988 3.35438C7.54771 3.56805 7.76399 3.70247 8.00021 3.70247C8.23643 3.70247 8.45271 3.56805 8.56054 3.35438C9.19556 2.09387 10.6152 1.23961 11.9949 1.27987C12.6276 1.29777 13.7806 1.53785 14.3957 2.94578C16.01 6.64082 11.2787 10.4373 10.3139 11.1609Z" fill="black"></path>
                          </svg>
                    </div>
                  </a>
                </div>
              </div>
            </div>
          </div>
          <div id="section4" class="product-details-three pb-4 jump-test">
            <h3>More from this collection</h3>
            <div class="row pt-4">
            @foreach($differentProduct as $differentPro)
              <div class="col-6">
                <div class="product-boxx also-wear">
                  <img src="{{asset('Pimages/'.$differentPro->image)}}" class="img-fluid" alt="">
                  <p class="product-category">NO NASTIES</p>
                  <p class="product-name">{{$differentPro->product_name}}</p>
                  <a href="javascript:void(0);">
                    <div class="insta-icon">
                          <svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.5462 2.42726C14.8923 0.930501 13.6105 0.0464187 12.0297 0.00210814C10.5132 -0.0453979 8.97424 0.713634 8 1.91045C7.02576 0.713634 5.48699 -0.0436937 3.97025 0.00210814C2.38953 0.0464187 1.10775 0.930288 0.453851 2.42726C-1.49987 6.89944 3.3923 11.0297 4.9382 12.189C5.77272 12.8149 6.70542 13.4001 7.71071 13.9284C7.80133 13.9761 7.90056 14 8 14C8.09944 14 8.19867 13.9761 8.28929 13.9284C9.29458 13.4001 10.2273 12.8147 11.0618 12.189C12.6077 11.0297 17.4999 6.89944 15.5462 2.42726ZM10.3139 11.1609C9.61303 11.6865 8.83578 12.1826 8 12.6385C7.16422 12.1826 6.38697 11.6865 5.68608 11.1609C4.72128 10.4375 -0.00977192 6.64082 1.60452 2.94578C2.21982 1.53785 3.37279 1.29777 4.00529 1.27987C4.03592 1.27902 4.06613 1.27859 4.09696 1.27859C5.45406 1.27859 6.81871 2.12177 7.43988 3.35438C7.54771 3.56805 7.76399 3.70247 8.00021 3.70247C8.23643 3.70247 8.45271 3.56805 8.56054 3.35438C9.19556 2.09387 10.6152 1.23961 11.9949 1.27987C12.6276 1.29777 13.7806 1.53785 14.3957 2.94578C16.01 6.64082 11.2787 10.4373 10.3139 11.1609Z" fill="black"></path>
                          </svg>
                    </div>
                  </a>
                </div>
              </div>
            @endforeach
            </div>
          </div>
          <div id="section5" class="product-details-three pb-4 jump-test">
            <h3>We think you’ll like these too</h3>
            <div class="row pt-4">
              <div class="col-6">
                <div class="product-boxx also-wear">
                  <img src="{{asset('img/likecollec1.jpg')}}" class="img-fluid" alt="">
                  <p class="product-category">NO NASTIES</p>
                  <p class="product-name">Razerback Tank: Vernon</p>
                  <a href="javascript:void(0);">
                    <div class="insta-icon">
                          <svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.5462 2.42726C14.8923 0.930501 13.6105 0.0464187 12.0297 0.00210814C10.5132 -0.0453979 8.97424 0.713634 8 1.91045C7.02576 0.713634 5.48699 -0.0436937 3.97025 0.00210814C2.38953 0.0464187 1.10775 0.930288 0.453851 2.42726C-1.49987 6.89944 3.3923 11.0297 4.9382 12.189C5.77272 12.8149 6.70542 13.4001 7.71071 13.9284C7.80133 13.9761 7.90056 14 8 14C8.09944 14 8.19867 13.9761 8.28929 13.9284C9.29458 13.4001 10.2273 12.8147 11.0618 12.189C12.6077 11.0297 17.4999 6.89944 15.5462 2.42726ZM10.3139 11.1609C9.61303 11.6865 8.83578 12.1826 8 12.6385C7.16422 12.1826 6.38697 11.6865 5.68608 11.1609C4.72128 10.4375 -0.00977192 6.64082 1.60452 2.94578C2.21982 1.53785 3.37279 1.29777 4.00529 1.27987C4.03592 1.27902 4.06613 1.27859 4.09696 1.27859C5.45406 1.27859 6.81871 2.12177 7.43988 3.35438C7.54771 3.56805 7.76399 3.70247 8.00021 3.70247C8.23643 3.70247 8.45271 3.56805 8.56054 3.35438C9.19556 2.09387 10.6152 1.23961 11.9949 1.27987C12.6276 1.29777 13.7806 1.53785 14.3957 2.94578C16.01 6.64082 11.2787 10.4373 10.3139 11.1609Z" fill="black"></path>
                          </svg>
                    </div>
                  </a>
                </div>
              </div>
              <div class="col-6">
                <div class="product-boxx also-wear">
                  <img src="{{asset('img/likecollec2.jpg')}}" class="img-fluid" alt="">
                  <p class="product-category">NO NASTIES</p>
                  <p class="product-name">Razerback Tank: Vienne</p>
                  <a href="javascript:void(0);">
                    <div class="insta-icon">
                          <svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.5462 2.42726C14.8923 0.930501 13.6105 0.0464187 12.0297 0.00210814C10.5132 -0.0453979 8.97424 0.713634 8 1.91045C7.02576 0.713634 5.48699 -0.0436937 3.97025 0.00210814C2.38953 0.0464187 1.10775 0.930288 0.453851 2.42726C-1.49987 6.89944 3.3923 11.0297 4.9382 12.189C5.77272 12.8149 6.70542 13.4001 7.71071 13.9284C7.80133 13.9761 7.90056 14 8 14C8.09944 14 8.19867 13.9761 8.28929 13.9284C9.29458 13.4001 10.2273 12.8147 11.0618 12.189C12.6077 11.0297 17.4999 6.89944 15.5462 2.42726ZM10.3139 11.1609C9.61303 11.6865 8.83578 12.1826 8 12.6385C7.16422 12.1826 6.38697 11.6865 5.68608 11.1609C4.72128 10.4375 -0.00977192 6.64082 1.60452 2.94578C2.21982 1.53785 3.37279 1.29777 4.00529 1.27987C4.03592 1.27902 4.06613 1.27859 4.09696 1.27859C5.45406 1.27859 6.81871 2.12177 7.43988 3.35438C7.54771 3.56805 7.76399 3.70247 8.00021 3.70247C8.23643 3.70247 8.45271 3.56805 8.56054 3.35438C9.19556 2.09387 10.6152 1.23961 11.9949 1.27987C12.6276 1.29777 13.7806 1.53785 14.3957 2.94578C16.01 6.64082 11.2787 10.4373 10.3139 11.1609Z" fill="black"></path>
                          </svg>
                    </div>
                  </a>
                </div>
              </div>
              <div class="col-6">
                <div class="product-boxx also-wear">
                  <img src="{{asset('img/likecollec3.jpg')}}" class="img-fluid" alt="">
                  <p class="product-category">NO NASTIES</p>
                  <p class="product-name">Razerback Tank: Varca</p>
                  <a href="javascript:void(0);">
                    <div class="insta-icon">
                          <svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.5462 2.42726C14.8923 0.930501 13.6105 0.0464187 12.0297 0.00210814C10.5132 -0.0453979 8.97424 0.713634 8 1.91045C7.02576 0.713634 5.48699 -0.0436937 3.97025 0.00210814C2.38953 0.0464187 1.10775 0.930288 0.453851 2.42726C-1.49987 6.89944 3.3923 11.0297 4.9382 12.189C5.77272 12.8149 6.70542 13.4001 7.71071 13.9284C7.80133 13.9761 7.90056 14 8 14C8.09944 14 8.19867 13.9761 8.28929 13.9284C9.29458 13.4001 10.2273 12.8147 11.0618 12.189C12.6077 11.0297 17.4999 6.89944 15.5462 2.42726ZM10.3139 11.1609C9.61303 11.6865 8.83578 12.1826 8 12.6385C7.16422 12.1826 6.38697 11.6865 5.68608 11.1609C4.72128 10.4375 -0.00977192 6.64082 1.60452 2.94578C2.21982 1.53785 3.37279 1.29777 4.00529 1.27987C4.03592 1.27902 4.06613 1.27859 4.09696 1.27859C5.45406 1.27859 6.81871 2.12177 7.43988 3.35438C7.54771 3.56805 7.76399 3.70247 8.00021 3.70247C8.23643 3.70247 8.45271 3.56805 8.56054 3.35438C9.19556 2.09387 10.6152 1.23961 11.9949 1.27987C12.6276 1.29777 13.7806 1.53785 14.3957 2.94578C16.01 6.64082 11.2787 10.4373 10.3139 11.1609Z" fill="black"></path>
                          </svg>
                    </div>
                  </a>
                </div>
              </div>
              <div class="col-6">
                <div class="product-boxx also-wear">
                  <img src="{{asset('img/likecollec4.jpg')}}" class="img-fluid" alt="">
                  <p class="product-category">NO NASTIES</p>
                  <p class="product-name">Kimono Jumpsuit Ilene</p>
                  <a href="javascript:void(0);">
                    <div class="insta-icon">
                          <svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.5462 2.42726C14.8923 0.930501 13.6105 0.0464187 12.0297 0.00210814C10.5132 -0.0453979 8.97424 0.713634 8 1.91045C7.02576 0.713634 5.48699 -0.0436937 3.97025 0.00210814C2.38953 0.0464187 1.10775 0.930288 0.453851 2.42726C-1.49987 6.89944 3.3923 11.0297 4.9382 12.189C5.77272 12.8149 6.70542 13.4001 7.71071 13.9284C7.80133 13.9761 7.90056 14 8 14C8.09944 14 8.19867 13.9761 8.28929 13.9284C9.29458 13.4001 10.2273 12.8147 11.0618 12.189C12.6077 11.0297 17.4999 6.89944 15.5462 2.42726ZM10.3139 11.1609C9.61303 11.6865 8.83578 12.1826 8 12.6385C7.16422 12.1826 6.38697 11.6865 5.68608 11.1609C4.72128 10.4375 -0.00977192 6.64082 1.60452 2.94578C2.21982 1.53785 3.37279 1.29777 4.00529 1.27987C4.03592 1.27902 4.06613 1.27859 4.09696 1.27859C5.45406 1.27859 6.81871 2.12177 7.43988 3.35438C7.54771 3.56805 7.76399 3.70247 8.00021 3.70247C8.23643 3.70247 8.45271 3.56805 8.56054 3.35438C9.19556 2.09387 10.6152 1.23961 11.9949 1.27987C12.6276 1.29777 13.7806 1.53785 14.3957 2.94578C16.01 6.64082 11.2787 10.4373 10.3139 11.1609Z" fill="black"></path>
                          </svg>
                    </div>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--product section-->
<div class="clearfix"></div>

<!--slider-Product-->
<section class="bg-white slider-product py-5 mt-5">
  <div class="container-fluid container-fluid px-4 px-sm-5">
    <h3>More from this brand</h3>
    <div class="owl-carousel owl-theme product-slider2">
      @foreach($moreLikeThis as $moreLikes)
        <div class="item">
          <div class="product-box2">
            <img src="{{asset('Bimages/'.$moreLikes->image)}}" class="img-fluid" alt="">
            <p class="product-category">{{$moreLikes->name}}</p>
            <p class="product-name">Beige and Grey Sports Bra</p>
            <a href="javascript:void(0);">
              <div class="insta-icon">
                    <svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M15.5462 2.42726C14.8923 0.930501 13.6105 0.0464187 12.0297 0.00210814C10.5132 -0.0453979 8.97424 0.713634 8 1.91045C7.02576 0.713634 5.48699 -0.0436937 3.97025 0.00210814C2.38953 0.0464187 1.10775 0.930288 0.453851 2.42726C-1.49987 6.89944 3.3923 11.0297 4.9382 12.189C5.77272 12.8149 6.70542 13.4001 7.71071 13.9284C7.80133 13.9761 7.90056 14 8 14C8.09944 14 8.19867 13.9761 8.28929 13.9284C9.29458 13.4001 10.2273 12.8147 11.0618 12.189C12.6077 11.0297 17.4999 6.89944 15.5462 2.42726ZM10.3139 11.1609C9.61303 11.6865 8.83578 12.1826 8 12.6385C7.16422 12.1826 6.38697 11.6865 5.68608 11.1609C4.72128 10.4375 -0.00977192 6.64082 1.60452 2.94578C2.21982 1.53785 3.37279 1.29777 4.00529 1.27987C4.03592 1.27902 4.06613 1.27859 4.09696 1.27859C5.45406 1.27859 6.81871 2.12177 7.43988 3.35438C7.54771 3.56805 7.76399 3.70247 8.00021 3.70247C8.23643 3.70247 8.45271 3.56805 8.56054 3.35438C9.19556 2.09387 10.6152 1.23961 11.9949 1.27987C12.6276 1.29777 13.7806 1.53785 14.3957 2.94578C16.01 6.64082 11.2787 10.4373 10.3139 11.1609Z" fill="black"></path>
                    </svg>
              </div>
            </a>  
          </div>
        </div>
      @endforeach


    </div>

    <div class="slide-details text-center py-3 d-none d-xl-block">
      <p class="product-category text-capitalize">Seeing <span class="slider-counter"></span> Products</p>
    </div>

  </div>
</section>
<!--slider-Product-->

<!--about the brand-->
<section class="abt-brnd bg-white pt-4 pb-5 mt-4">  
  <div class="container-fluid px-4 px-sm-5">
    <h3>About the Brand</h3>  
      <div class="row"> 
          <div class="col-lg-6">  
            <div class="left-brand">
              <div class="row align-items-center"> 
                <div class="col-md-4 mt-3 mt-md-0">
                  <div class="abt-brnd-img"> 
                    <img src="{{asset('img/nasties.png')}}" class="img-fluid" alt="">
                  </div>   
                </div>
                <div class="col-md-8 col-lg-7 mt-4 mt-md-0 mt-lg-0">
                  <div class="abt-brnd-txt">  
                    <p> No Nasties is an organic, fair trade, vegan clothing brand based in Goa, India.</p>
                    <p>pWe work with a farmers' co-operative and a fair trade factory to make all our 100% certified organic cotton products.</p>
                    <a href="javascript:void(0);" role="button">View All Products</a>
                  </div> 
                </div>
              </div>    
            </div>
          </div>
          <div class="col-lg-6 mt-4 mt-lg-0">  
              <div class="right-brand">
                <p>Featured proucts</p>
                <div class="row"> 
                  <div class="col-6">
                    <div class="img-brnd-box">  
                      <a href="#"><img src="{{asset('img/abt-brnad1.jpg')}}" class="img-fluid" alt=""></a>
                      <a href="#"><p>Ombre Coco Dress</p></a>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="img-brnd-box"> 
                      <a href="#"><img src="{{asset('img/abt-brnad2.jpg')}}" class="img-fluid" alt=""></a>
                      <a href="#"><p>Cloudie Coco Dress</p></a>
                    </div>  
                  </div>
                </div>
                <div class="view-brand-btn mt-2 d-block d-md-none mb-5 mb-lg-0">  
                  <a href="#" role="btn" class="btn btn-blkae">VIEW ALL PRODUCTS</a>
                </div>   
              </div>
          </div>
      </div>
  </div>  
</section>

<!-- Size Guide Large modal -->
<div class="modal fade bd-example-modal-lg" id="SG-Modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="SG-Modal">Brand Size Chart</h5>
        <button type="button" class="close sg-close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body sbjuy">
        <div class="sz-gd-img mx-0 mx-sm-2">
          <img src="{{asset('img/size-guide.webp" class="img-fluid" alt="">
        </div>
      </div>
      <div class="modal-footer">
        <p>These measurements are approximate. Actual garment measurements may vary slightly.</p>
      </div>
    </div>
  </div>
</div>

@endsection
@push('js')
<script>


</script>
@endpush