@extends('layouts.frontend.master')
@section('title')
Balkae || favorite product page
@endsection
@section('content')

@php
$allProductsCategory = $categoryProducts;
@endphp


<!--Favorite Product SORT Section for Desktop-->
<section class="fav-sort pt-5 pb-0 pb-md-0">
  <div class="container-fluid px-4 px-sm-5">
    <div class="row">
      <div class="col-lg-3 mb-3 mb-lg-0">
        <div class="favsort-txt">
          <h4>Find your next favourite</h4>
          <!--for Mobile only-->
          <div class="favsort-btns d-block d-lg-none my-3">
            <ul>
            <li class="active"><a href="#">Men</a></li>
            <li><a href="#">Women</a></li>
            <li><a href="#">Unisex</a></li>
            </ul>
          </div>
          <!--for Mobile-->
        </div>
      </div>
      <div class="col-lg-3 mb-3 mb-lg-0">
        <div class="favsort-select">
          <select name="category_id" id="category_id">
            @foreach($allProductsCategory as $key => $categoryProduct)
              <option value="{{$categoryProduct->id}}">{{$categoryProduct->name}}</option>
            @endforeach
            <option value=""selected><a href="#" class="slviewall">All</a></option>
          </select>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="lksaji mt-3 mt-lg-0">
          <div class="fav-tags">
            @foreach($categoryMains  as   $categoryProduct)
                  <a href="#" role="buuton" class="ftag-btn">{{$categoryProduct->name}}</a>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--Favorite Product SORT Section for Desktop-->

<!--Favorite Product SORT Section for Mobile-->

<!--Favorite Product SORT Section for Mobile-->

<!--listing product display-->
<section class="fav-products pt-5 pb-2 pb-md-5">
  <div class="container-fluid px-4 px-sm-5">
    <div class="row">
    @foreach($allProductsCategory  as $key =>  $category)
      @foreach($category->products  as $key =>  $product)
      <div class="col-lg-3 col-6">
        <div class="product-boxx">
          <img src="{{asset('Pimages/' . $product->image )}}" class="img-fluid" alt="">
          <p class="product-category">{{$category->name}}</p>
          <p class="product-name">{{$product->product_name}}</p>
          <a href="javascript:void(0)">
          <div class="product-button">
            <svg width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M7.01506 18.4001C7.16756 18.4001 7.31382 18.3395 7.42165 18.2317C7.52948 18.1238 7.59006 17.9776 7.59006 17.8251V13.9151C7.59006 13.7626 7.52948 13.6163 7.42165 13.5085C7.31382 13.4007 7.16756 13.3401 7.01506 13.3401C6.86256 13.3401 6.71631 13.4007 6.60848 13.5085C6.50064 13.6163 6.44006 13.7626 6.44006 13.9151V17.8251C6.44006 17.9776 6.50064 18.1238 6.60848 18.2317C6.71631 18.3395 6.86256 18.4001 7.01506 18.4001Z" fill="black"></path>
            <path d="M10.005 18.4001C10.1575 18.4001 10.3037 18.3395 10.4116 18.2317C10.5194 18.1238 10.58 17.9776 10.58 17.8251V13.9151C10.58 13.7626 10.5194 13.6163 10.4116 13.5085C10.3037 13.4007 10.1575 13.3401 10.005 13.3401C9.85249 13.3401 9.70624 13.4007 9.59841 13.5085C9.49057 13.6163 9.42999 13.7626 9.42999 13.9151V17.8251C9.42999 17.9776 9.49057 18.1238 9.59841 18.2317C9.70624 18.3395 9.85249 18.4001 10.005 18.4001Z" fill="black"></path>
            <path d="M12.9951 18.4001C13.1476 18.4001 13.2939 18.3395 13.4017 18.2317C13.5095 18.1238 13.5701 17.9776 13.5701 17.8251V13.9151C13.5701 13.7626 13.5095 13.6163 13.4017 13.5085C13.2939 13.4007 13.1476 13.3401 12.9951 13.3401C12.8426 13.3401 12.6964 13.4007 12.5885 13.5085C12.4807 13.6163 12.4201 13.7626 12.4201 13.9151V17.8251C12.4201 17.9776 12.4807 18.1238 12.5885 18.2317C12.6964 18.3395 12.8426 18.4001 12.9951 18.4001Z" fill="black"></path>
            <path d="M15.9853 18.4001C16.1378 18.4001 16.284 18.3395 16.3919 18.2317C16.4997 18.1238 16.5603 17.9776 16.5603 17.8251V13.9151C16.5603 13.7626 16.4997 13.6163 16.3919 13.5085C16.284 13.4007 16.1378 13.3401 15.9853 13.3401C15.8328 13.3401 15.6865 13.4007 15.5787 13.5085C15.4709 13.6163 15.4103 13.7626 15.4103 13.9151V17.8251C15.4103 17.9776 15.4709 18.1238 15.5787 18.2317C15.6865 18.3395 15.8328 18.4001 15.9853 18.4001Z" fill="black"></path>
            <path d="M20.93 11.8519V8.86195C20.9309 8.78586 20.9167 8.71035 20.8882 8.63979C20.8598 8.56923 20.8175 8.50502 20.7641 8.4509C20.7106 8.39677 20.6469 8.3538 20.5767 8.32447C20.5064 8.29514 20.4311 8.28004 20.355 8.28005H18.745L16.5347 3.91005C16.5347 3.89395 16.5186 3.87785 16.5094 3.86405C16.3365 3.59406 16.0984 3.37201 15.817 3.21844C15.5356 3.06487 15.22 2.98474 14.8994 2.98545H14.7798C14.6914 2.65622 14.4972 2.36523 14.227 2.15739C13.9568 1.94955 13.6257 1.83642 13.2848 1.83545H9.71521C9.37433 1.83642 9.04324 1.94955 8.77305 2.15739C8.50286 2.36523 8.30858 2.65622 8.22021 2.98545H8.11901C7.79312 2.98497 7.47234 3.06645 7.18617 3.22239C6.90001 3.37833 6.65766 3.60373 6.48141 3.87785C6.47386 3.89365 6.46541 3.90901 6.45611 3.92385L4.24811 8.28005H2.63811C2.48681 8.28187 2.34232 8.34325 2.23598 8.45088C2.12963 8.55852 2.07 8.70374 2.07001 8.85505V11.845C2.06992 11.8853 2.07455 11.9255 2.08381 11.9647L3.75131 19.1821C3.85795 19.6786 4.13217 20.1234 4.52794 20.4417C4.92371 20.7599 5.41693 20.9324 5.92481 20.93H17.0752C17.581 20.9334 18.0726 20.763 18.4678 20.4473C18.863 20.1317 19.1379 19.6899 19.2464 19.1959L20.9162 11.9739C20.9257 11.9339 20.9303 11.893 20.93 11.8519ZM9.31501 3.39025C9.31501 3.28411 9.35717 3.18232 9.43222 3.10727C9.50728 3.03221 9.60907 2.99005 9.71521 2.99005H13.2848C13.3909 2.99005 13.4927 3.03221 13.5678 3.10727C13.6428 3.18232 13.685 3.28411 13.685 3.39025V3.50985C13.685 3.61599 13.6428 3.71778 13.5678 3.79283C13.4927 3.86789 13.3909 3.91005 13.2848 3.91005H9.71521C9.60907 3.91005 9.50728 3.86789 9.43222 3.79283C9.35717 3.71778 9.31501 3.61599 9.31501 3.50985V3.39025ZM7.47501 4.47585C7.54747 4.37224 7.64383 4.28763 7.75593 4.22917C7.86804 4.17072 7.99258 4.14015 8.11901 4.14005H8.30071C8.42268 4.41346 8.62109 4.64577 8.87206 4.809C9.12302 4.97222 9.41583 5.05941 9.71521 5.06005H13.2848C13.5842 5.05941 13.877 4.97222 14.128 4.809C14.3789 4.64577 14.5773 4.41346 14.6993 4.14005H14.8994C15.0217 4.13863 15.1425 4.16724 15.2512 4.22338C15.3599 4.27953 15.4531 4.36148 15.5227 4.46205L17.4639 8.28005H5.53611L7.47501 4.47585ZM3.22001 9.43005H19.78V11.2701H3.22001V9.43005ZM18.1263 18.9405C18.0737 19.1797 17.9406 19.3935 17.7493 19.5462C17.558 19.699 17.32 19.7816 17.0752 19.7801H5.92481C5.67935 19.7813 5.44091 19.6982 5.24952 19.5445C5.05813 19.3908 4.92544 19.1759 4.87371 18.936L3.36721 12.4201H19.6328L18.1263 18.9405Z" fill="black"></path>
            </svg>
            <p class="cart-add">Add to Bag</p>
            <p class="product-price">₹{{$product->unit_price}}</p>
          </div>
          </a>
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
    @endforeach
    </div>
  </div>
  <a href="#">
  <div class="random-click">
      <i class="far fa-sync-alt fa-spin" style="animation-play-state: paused;animation-iteration-count: infinite;"></i>
    <div class="random-tooltip">
      <p>Click this to refresh your selection</p>
    </div>
  </div>
  </a>
</section>
<!--listing product display-->

<!--listing pop up-->
<div class="modal fade bd-example-modal-lg listingModal" id="listingModal" tabindex="-1" role="dialog" aria-labelledby="listingModal" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close limd-close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>  
        <div class="listing-modal">
          <div class="container-fluid px-2">
            <div class="row">
              <div class="col-lg-5 d-none d-lg-block">
                <div class="limodal-gallery">
                  <div class="limodal-gallery-img mb-4">
                    <img src="{{asset('img/limodalimg1.jpg')}}" class="img-fluid" alt="">
                  </div>
                  <div class="limodal-galthumb">
                    <div class="row no-gutters">
                      <div class="col-4 d-flex justify-content-start">
                        <img src="{{asset('img/limodalt1.jpg')}}" class="img-fluid" alt="">
                      </div>
                      <div class="col-4 d-flex justify-content-center">
                        <img src="{{asset('img/limodalt1.jpg')}}" class="img-fluid" alt="">
                      </div>
                      <div class="col-4 d-flex justify-content-end">
                        <img src="{{asset('img/limodalt1.jpg')}}" class="img-fluid" alt="">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-7">
                <div class="list-mdltxt">
                  <p class="arlter">ARTE ALTER</p>
                  <h4>Arie Front Sailor Striped Top</h4>
                  <p class="product-price">₹1,100.00</p>
                  <div class="size-select mb-4 mt-4">
                    <h5 class="d-none d-md-block">Choose Size</h5>
                    <h5 class="d-block d-md-none">WHat’s your size?</h5>
                    <div class="size-blocks">
                      <div class="size-xs">
                        <input type="radio" id="size1" name="size" value="XS">
                        <label for="size1"><p>XS</p></label>
                      </div>
                      <div class="size-xs">
                        <input type="radio" checked id="size2" name="size" value="S">
                        <label for="size2"><p>S</p></label>
                      </div>
                      <div class="size-xs">
                        <input type="radio" disabled id="size3" name="size" value="M">
                        <label for="size3"><p>M</p></label>
                      </div>
                      <div class="size-xs">
                        <input type="radio" id="size4" name="size" value="L">
                        <label for="size4"><p>L</p></label>
                      </div>
                      <div class="size-xs">
                        <input type="radio" id="size5" name="size" value="XL">
                        <label for="size5"><p>XL</p></label>
                      </div>
                    </div>
                  </div>
                  <div class="val-icons">
                    <h5>Value Icons</h5>
                    <div class="val-gal">
                      <div class="commit-block">  
                        <img src="{{asset('img/commit/Ellipse2.png')}}" class="img-fluid for-size" alt="">
                        <div class="commit-cir">
                          <div class="cmt-cnt">
                            <img src="{{asset('img/commit/fruit.png')}}" class="img-fluid" alt="">
                            <h5>vegan</h5>
                          </div>
                        </div>
                      </div>
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
                  <div class="limdl-btns mt-4 w-lg-5">
                    <a href="javascript:void(0);">
                      <div class="product-button mb-2">
                        <svg width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.01506 18.4001C7.16756 18.4001 7.31382 18.3395 7.42165 18.2317C7.52948 18.1238 7.59006 17.9776 7.59006 17.8251V13.9151C7.59006 13.7626 7.52948 13.6163 7.42165 13.5085C7.31382 13.4007 7.16756 13.3401 7.01506 13.3401C6.86256 13.3401 6.71631 13.4007 6.60848 13.5085C6.50064 13.6163 6.44006 13.7626 6.44006 13.9151V17.8251C6.44006 17.9776 6.50064 18.1238 6.60848 18.2317C6.71631 18.3395 6.86256 18.4001 7.01506 18.4001Z" fill="black"/>
                        <path d="M10.005 18.4001C10.1575 18.4001 10.3037 18.3395 10.4116 18.2317C10.5194 18.1238 10.58 17.9776 10.58 17.8251V13.9151C10.58 13.7626 10.5194 13.6163 10.4116 13.5085C10.3037 13.4007 10.1575 13.3401 10.005 13.3401C9.85249 13.3401 9.70624 13.4007 9.59841 13.5085C9.49057 13.6163 9.42999 13.7626 9.42999 13.9151V17.8251C9.42999 17.9776 9.49057 18.1238 9.59841 18.2317C9.70624 18.3395 9.85249 18.4001 10.005 18.4001Z" fill="black"/>
                        <path d="M12.9951 18.4001C13.1476 18.4001 13.2939 18.3395 13.4017 18.2317C13.5095 18.1238 13.5701 17.9776 13.5701 17.8251V13.9151C13.5701 13.7626 13.5095 13.6163 13.4017 13.5085C13.2939 13.4007 13.1476 13.3401 12.9951 13.3401C12.8426 13.3401 12.6964 13.4007 12.5885 13.5085C12.4807 13.6163 12.4201 13.7626 12.4201 13.9151V17.8251C12.4201 17.9776 12.4807 18.1238 12.5885 18.2317C12.6964 18.3395 12.8426 18.4001 12.9951 18.4001Z" fill="black"/>
                        <path d="M15.9853 18.4001C16.1378 18.4001 16.284 18.3395 16.3919 18.2317C16.4997 18.1238 16.5603 17.9776 16.5603 17.8251V13.9151C16.5603 13.7626 16.4997 13.6163 16.3919 13.5085C16.284 13.4007 16.1378 13.3401 15.9853 13.3401C15.8328 13.3401 15.6865 13.4007 15.5787 13.5085C15.4709 13.6163 15.4103 13.7626 15.4103 13.9151V17.8251C15.4103 17.9776 15.4709 18.1238 15.5787 18.2317C15.6865 18.3395 15.8328 18.4001 15.9853 18.4001Z" fill="black"/>
                        <path d="M20.93 11.8519V8.86195C20.9309 8.78586 20.9167 8.71035 20.8882 8.63979C20.8598 8.56923 20.8175 8.50502 20.7641 8.4509C20.7106 8.39677 20.6469 8.3538 20.5767 8.32447C20.5064 8.29514 20.4311 8.28004 20.355 8.28005H18.745L16.5347 3.91005C16.5347 3.89395 16.5186 3.87785 16.5094 3.86405C16.3365 3.59406 16.0984 3.37201 15.817 3.21844C15.5356 3.06487 15.22 2.98474 14.8994 2.98545H14.7798C14.6914 2.65622 14.4972 2.36523 14.227 2.15739C13.9568 1.94955 13.6257 1.83642 13.2848 1.83545H9.71521C9.37433 1.83642 9.04324 1.94955 8.77305 2.15739C8.50286 2.36523 8.30858 2.65622 8.22021 2.98545H8.11901C7.79312 2.98497 7.47234 3.06645 7.18617 3.22239C6.90001 3.37833 6.65766 3.60373 6.48141 3.87785C6.47386 3.89365 6.46541 3.90901 6.45611 3.92385L4.24811 8.28005H2.63811C2.48681 8.28187 2.34232 8.34325 2.23598 8.45088C2.12963 8.55852 2.07 8.70374 2.07001 8.85505V11.845C2.06992 11.8853 2.07455 11.9255 2.08381 11.9647L3.75131 19.1821C3.85795 19.6786 4.13217 20.1234 4.52794 20.4417C4.92371 20.7599 5.41693 20.9324 5.92481 20.93H17.0752C17.581 20.9334 18.0726 20.763 18.4678 20.4473C18.863 20.1317 19.1379 19.6899 19.2464 19.1959L20.9162 11.9739C20.9257 11.9339 20.9303 11.893 20.93 11.8519ZM9.31501 3.39025C9.31501 3.28411 9.35717 3.18232 9.43222 3.10727C9.50728 3.03221 9.60907 2.99005 9.71521 2.99005H13.2848C13.3909 2.99005 13.4927 3.03221 13.5678 3.10727C13.6428 3.18232 13.685 3.28411 13.685 3.39025V3.50985C13.685 3.61599 13.6428 3.71778 13.5678 3.79283C13.4927 3.86789 13.3909 3.91005 13.2848 3.91005H9.71521C9.60907 3.91005 9.50728 3.86789 9.43222 3.79283C9.35717 3.71778 9.31501 3.61599 9.31501 3.50985V3.39025ZM7.47501 4.47585C7.54747 4.37224 7.64383 4.28763 7.75593 4.22917C7.86804 4.17072 7.99258 4.14015 8.11901 4.14005H8.30071C8.42268 4.41346 8.62109 4.64577 8.87206 4.809C9.12302 4.97222 9.41583 5.05941 9.71521 5.06005H13.2848C13.5842 5.05941 13.877 4.97222 14.128 4.809C14.3789 4.64577 14.5773 4.41346 14.6993 4.14005H14.8994C15.0217 4.13863 15.1425 4.16724 15.2512 4.22338C15.3599 4.27953 15.4531 4.36148 15.5227 4.46205L17.4639 8.28005H5.53611L7.47501 4.47585ZM3.22001 9.43005H19.78V11.2701H3.22001V9.43005ZM18.1263 18.9405C18.0737 19.1797 17.9406 19.3935 17.7493 19.5462C17.558 19.699 17.32 19.7816 17.0752 19.7801H5.92481C5.67935 19.7813 5.44091 19.6982 5.24952 19.5445C5.05813 19.3908 4.92544 19.1759 4.87371 18.936L3.36721 12.4201H19.6328L18.1263 18.9405Z" fill="black"/>
                        </svg>
                        <p class="cart-add">Add to Bag</p>
                        <p class="product-price">₹1,100.00</p>
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
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer d-flex justify-content-center border-0 pb-4 pt-0">
        <p class="li-md-ftxt">Psst, hey! Just remember you can add or edit details from the cart as well</p>
      </div>
    </div>
  </div>
</div>
<!--listing pop up-->
@endsection

@section('page-script')
<script type="text/javascript">
$('#category_id').change(function(){
    var allData = <?php echo json_encode($allProductsCategory); ?>; 
    console.log(allData);
            let category_id =  $('#category_id').val();
        $.ajax({
            url: "{{ route('product.product-category_id') }}",
            method: "get",            
            data: { category_id : category_id, 
              _token: '{{ csrf_token() }}'},
            datatype: 'json',
            success: function(data){                
                console.log(data);
                allData=[];
                allData.push(data);
                console.log(allData);               
            },
            error: function(data){
               // console.log(data);            
            },       
        });
            
        })
</script>
@endsection