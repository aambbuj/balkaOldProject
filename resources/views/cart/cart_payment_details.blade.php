@extends('layouts.frontend.master')
@section('title')
Balkae || Checkout
@endsection
@section('content')
<div class="container mt-3 mex-width">
        <div class="row ">
            <div class="col-md-4 blue-card-blue-back">
                <div class="blue-card">
                    <div class="left-information">
                        <div class="status_info pb-2">
                            <p>Order Number</p>
                            <p class="orer-id">{{$orderDetail->order_number}}</p>
                        </div>
                        <div class="success-massage mt-2 py-4">
                            <p class="massage-head">Thank you for your purchase, <br>Sushmita!</p>
                            <p class="sub-massage mt-3">Your order is on it’s way!</p>
                            <img class="balkae-box" src="img/balkae-box.png">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card-status-shadow pb-5">
                    <div class="py-2 status-timeline-card">
                        <div class="status-timeline d-flex justify-content-center">
                            <div class="text-center">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13.0244 1.38007C12.9687 1.32429 12.9025 1.28003 12.8297 1.24984C12.7569 1.21964 12.6788 1.2041 12.5999 1.2041C12.5211 1.2041 12.443 1.21964 12.3702 1.24984C12.2973 1.28003 12.2312 1.32429 12.1754 1.38007L6.59994 6.95558L4.62444 4.98008C4.51186 4.86749 4.35916 4.80424 4.19994 4.80424C4.04072 4.80424 3.88803 4.86749 3.77544 4.98008C3.66286 5.09266 3.59961 5.24536 3.59961 5.40458C3.59961 5.56379 3.66286 5.71649 3.77544 5.82908L6.17544 8.22908C6.23117 8.28486 6.29734 8.32912 6.37018 8.35931C6.44302 8.38951 6.52109 8.40505 6.59994 8.40505C6.67879 8.40505 6.75687 8.38951 6.82971 8.35931C6.90255 8.32912 6.96872 8.28486 7.02444 8.22908L13.0244 2.22907C13.0802 2.17335 13.1245 2.10718 13.1547 2.03434C13.1849 1.9615 13.2004 1.88342 13.2004 1.80457C13.2004 1.72572 13.1849 1.64765 13.1547 1.57481C13.1245 1.50197 13.0802 1.4358 13.0244 1.38007Z" fill="#101010"/>
                                <path d="M13.068 5.28159C13.0522 5.20437 13.0214 5.13102 12.9773 5.06571C12.9332 5.0004 12.8767 4.94442 12.8109 4.90096C12.7452 4.8575 12.6715 4.82742 12.5942 4.81243C12.5168 4.79744 12.4372 4.79783 12.36 4.81359C12.2828 4.82935 12.2094 4.86016 12.1441 4.90427C12.0788 4.94838 12.0228 5.00492 11.9794 5.07066C11.9359 5.13641 11.9058 5.21007 11.8908 5.28744C11.8759 5.36481 11.8762 5.44437 11.892 5.52159C12.1392 6.7288 11.9661 7.98426 11.4014 9.07952C10.8367 10.1748 9.91442 11.044 8.78763 11.5428C7.66083 12.0416 6.39732 12.14 5.20688 11.8217C4.01644 11.5033 2.97067 10.7875 2.2432 9.79283C1.51573 8.79821 1.15032 7.5847 1.20764 6.35377C1.26495 5.12284 1.74155 3.94854 2.55829 3.02582C3.37504 2.10311 4.4828 1.48748 5.69767 1.28117C6.91254 1.07485 8.16144 1.29024 9.23701 1.89159C9.37625 1.96956 9.54076 1.98903 9.69435 1.94571C9.7704 1.92426 9.84148 1.88804 9.90354 1.83912C9.96559 1.7902 10.0174 1.72953 10.056 1.66059C10.0946 1.59165 10.1193 1.51577 10.1286 1.4373C10.1378 1.35883 10.1316 1.2793 10.1101 1.20325C10.0887 1.1272 10.0525 1.05612 10.0035 0.994063C9.95462 0.932009 9.89395 0.880199 9.82501 0.841591C8.56078 0.133558 7.09867 -0.138754 5.66431 0.066674C4.22995 0.272102 2.90305 0.943852 1.88837 1.97827C0.873694 3.01268 0.227626 4.35227 0.0498633 5.79032C-0.127899 7.22838 0.172524 8.68496 0.904776 9.93532C1.63703 11.1857 2.76041 12.1603 4.10157 12.7088C5.44273 13.2574 6.92714 13.3493 8.32572 12.9704C9.72431 12.5915 10.9594 11.7629 11.8403 10.6125C12.7212 9.46198 13.199 8.05359 13.2 6.60459C13.1998 6.16031 13.1556 5.71715 13.068 5.28159Z" fill="#101010"/>
                                </svg>
                                <p class="status_label active-statsu">Ordered</p>
                            </div>
                            <div class="text-center">
                                <div class="line-dotter line-dotter_active"></div>
                            </div>
                            <div class="text-center">
                                <svg width="19" height="16" viewBox="0 0 19 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.5" d="M18.7993 7.94588L16.6172 5.69418C16.4493 5.52098 16.1975 5.43438 16.0297 5.43438C15.9458 5.43438 15.7779 5.43439 15.694 5.52099C15.3583 5.6076 15.1065 5.95401 15.1065 6.38703V6.64683H14.1834V3.78892C14.1834 3.61571 14.0994 3.52909 14.0155 3.44249C14.0155 3.44249 14.0155 3.44251 13.9316 3.3559L7.3015 0.0649527C7.13365 -0.0216509 7.04972 -0.0216509 6.88187 0.0649527L0.335721 3.3559C0.335721 3.3559 0.251765 3.35588 0.251765 3.44249C0.0839149 3.52909 0 3.7023 0 3.8755V12.2761C0 12.4493 0.0839149 12.6225 0.251765 12.7091L6.88187 16H6.96578H7.04973H7.13364H7.21754L13.7637 12.7091C13.9316 12.6225 14.0155 12.4493 14.0155 12.2761V10.8904H14.9387C14.9387 11.3234 15.2744 11.5832 15.5262 11.7564C15.694 11.843 15.8619 11.843 15.9458 11.843C16.1976 11.843 16.3654 11.7564 16.5333 11.5832L18.7153 9.33154C18.8832 9.15834 18.9671 8.89851 18.9671 8.72531C19.051 8.29229 18.9671 8.11909 18.7993 7.94588ZM7.13364 1.0176L12.6727 3.78892L10.4906 4.82815L4.95161 2.05685L7.13364 1.0176ZM3.86054 2.57645L9.39963 5.34777L7.13364 6.47361L4.11235 4.91476L1.5946 3.70231L3.86054 2.57645ZM0.923156 4.56835L4.19626 6.21381L6.63011 7.42625V14.7009L0.923156 11.843V4.56835ZM13.2602 11.843L7.63717 14.7009V7.42625L13.2602 4.56835V6.64683H11.4978C10.9942 6.64683 10.4906 7.16646 10.4906 7.68608V9.85117C10.4906 10.3708 10.9942 10.8038 11.4978 10.8038H13.2602V11.843ZM16.0297 10.7172V9.76456H11.4978L11.4138 9.67795V7.59947L11.4978 7.51286H16.0297V6.38703L18.1278 8.55212L16.0297 10.7172Z" fill="black"/>
                                </svg>
                                <p class="status_label">Shipped</p>
                            </div>
                            <div class="text-center">
                                <div class="line-dotter"></div>
                            </div>
                            <div class="text-center">
                                <svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g opacity="0.5">
                                <path d="M9.99576 17.3332C9.92135 17.3332 9.84714 17.3166 9.78127 17.2834L3.10621 13.9241C2.98096 13.8612 2.9043 13.7478 2.9043 13.6255V8.96841C2.9043 8.77595 3.09076 8.61987 3.3207 8.61987C3.55068 8.61987 3.7371 8.77595 3.7371 8.96841V13.4284L9.57935 16.3685V9.3069C9.57935 9.11444 9.76582 8.95837 9.99576 8.95837C10.2257 8.95837 10.4122 9.11444 10.4122 9.3069V16.9847C10.4122 17.1103 10.3315 17.2262 10.2007 17.2881C10.1371 17.3183 10.0663 17.3332 9.99576 17.3332Z" fill="black"/>
                                <path d="M8.34007 11.7566C8.26691 11.7566 8.19308 11.7405 8.126 11.7068L1.45094 8.34754C1.35375 8.29868 1.28442 8.21872 1.2594 8.12594C1.23421 8.03337 1.25536 7.9362 1.31778 7.85708L2.97302 5.75581C3.09623 5.59977 3.34408 5.55279 3.5352 5.64895L10.2102 9.00819C10.3074 9.05702 10.3767 9.13701 10.4018 9.22975C10.427 9.32236 10.4058 9.41953 10.3434 9.49865L8.68819 11.5999C8.60828 11.7013 8.4757 11.7566 8.34007 11.7566ZM2.25202 7.93739L8.21282 10.9372L9.40915 9.41831L3.44838 6.41851L2.25202 7.93739Z" fill="black"/>
                                <path d="M9.9955 17.3332C9.92476 17.3332 9.85422 17.3182 9.79055 17.2881C9.65984 17.2261 9.5791 17.1103 9.5791 16.9846V9.30685C9.5791 9.11439 9.76557 8.95832 9.9955 8.95832C10.2255 8.95832 10.4119 9.11439 10.4119 9.30685V16.3684L16.2542 13.4283V8.88906C16.2542 8.69657 16.4406 8.54053 16.6706 8.54053C16.9005 8.54053 17.087 8.69657 17.087 8.88906V13.6254C17.087 13.7478 17.0103 13.8611 16.885 13.9241L10.21 17.2833C10.1441 17.3165 10.0699 17.3332 9.9955 17.3332Z" fill="black"/>
                                <path d="M11.6656 11.7565C11.5306 11.7565 11.3984 11.7015 11.3185 11.6009L9.64885 9.49969C9.58581 9.42039 9.56428 9.32305 9.58927 9.2303C9.61429 9.13739 9.68342 9.05705 9.78102 9.00804L16.456 5.6488C16.647 5.55299 16.8942 5.5998 17.0172 5.75448L18.6869 7.85572C18.7499 7.93505 18.7715 8.03239 18.7465 8.12514C18.7215 8.21806 18.6524 8.29839 18.5547 8.3474L11.8797 11.7066C11.8128 11.7403 11.7386 11.7565 11.6656 11.7565ZM10.5835 9.4175L11.7917 10.9377L17.7522 7.93794L16.5441 6.4177L10.5835 9.4175Z" fill="black"/>
                                <path d="M9.99576 9.65544C9.92155 9.65544 9.84714 9.63878 9.78127 9.6056L3.10621 6.24636C2.98096 6.18338 2.9043 6.07003 2.9043 5.94766C2.9043 5.82533 2.98096 5.71198 3.10621 5.649L9.78127 2.28976C9.91302 2.2234 10.0785 2.2234 10.2102 2.28976L16.8853 5.649C17.0106 5.71198 17.0872 5.82533 17.0872 5.94766C17.0872 6.07003 17.0106 6.18338 16.8853 6.24636L10.2102 9.6056C10.1444 9.63878 10.07 9.65544 9.99576 9.65544ZM4.12894 5.94766L9.99576 8.90017L15.8626 5.94766L9.99576 2.99516L4.12894 5.94766Z" fill="black"/>
                                <path d="M16.6711 6.29613C16.5969 6.29613 16.5227 6.27965 16.4566 6.24629L9.78155 2.88705C9.65834 2.82512 9.5821 2.71432 9.57964 2.594C9.57739 2.47352 9.64939 2.36083 9.77015 2.29548L12.6828 0.722166C12.8159 0.650158 12.9871 0.647788 13.1231 0.71638L19.7982 4.07559C19.9214 4.13756 19.9977 4.24832 20.0001 4.36867C20.0023 4.48916 19.9303 4.6018 19.8096 4.66716L16.897 6.24051C16.8283 6.27759 16.7498 6.29613 16.6711 6.29613ZM10.7833 2.57783L16.6634 5.53696L18.7964 4.38484L12.9164 1.42568L10.7833 2.57783Z" fill="black"/>
                                <path d="M3.32086 6.29603C3.24462 6.29603 3.16838 6.2785 3.10108 6.24361L0.196635 4.73341C0.0734217 4.66928 -0.000989385 4.55625 9.93989e-06 4.43475C0.00105099 4.31343 0.0775025 4.20109 0.201925 4.13864L6.87698 0.779393C7.01098 0.712335 7.17892 0.713206 7.31125 0.781937L10.2157 2.29214C10.3389 2.3563 10.4133 2.4693 10.4123 2.59083C10.4113 2.71215 10.3349 2.82449 10.2104 2.88695L3.53539 6.24619C3.46931 6.27937 3.39511 6.29603 3.32086 6.29603ZM1.21486 4.44224L3.32432 5.53908L9.19747 2.58334L7.08801 1.4865L1.21486 4.44224Z" fill="black"/>
                                </g>
                                </svg>
                                <p class="status_label">Delivered</p>
                            </div>
                        </div>
                    </div>

                    <div class="status_details_card">
                        <div class="status_info">
                            <p>Expect delivery by</p>
                            <p>5th Feb, 2020</p>
                        </div>
                        <div class="status_info mt-5 mobile-alignment">
                            <p>Track Details here</p>
                            <p><a href="#">Order History</a></p>
                        </div>
                        <div class="status_info mt-5 mobile-alignment">
                            <p>If you need help with anything pls don’t hesitate to drop us a mail:</p>
                            <p><a href="#">care@balkae.com</a></p>
                        </div>
                    </div>
                </div>
                <div class="mt-4 mobile-alignment-button">
                    <a class="checkout-button main-submit shop-color" href="{{route('homepage')}}">SHOP SOMETHING ELSE</a>
                </div>
            </div>
        </div>
        <div class="row mt-5 main-gaap-style">
            <div class="col mobile-shadow">
                <h2 class="head-summary mob-summary-head">SUMMARY</h2>
                <div class="row summary-details">
                    <div class="col-md-6">
                        <p class="orer-id only_web"><b>{{$orderDetail->order_number}}</b></p>
                        <p class="summery-head only_mobile">Order Details</p>
                    </div>
                    <div class="col-md-6 only_web">
                        <p class="order-track">
                            <a href="#">Track Order</a>
                        </p>
                    </div>
                    <div class="row only-desktop-details" style="width: 100%;">
                        <div class="col">
                            <div class="d-flex flex-row bd-highlight mb-3">
                                <div class="p-2 bd-highlight">
                                    <div class="order_info">
                                        <p class="order-info-head">Status:</p>
                                        <p class="order-status">
                                            <svg width="15" height="13" viewBox="0 0 15 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M14.56 5.96375L12.87 4.27375C12.74 4.14375 12.545 4.07876 12.415 4.07876C12.35 4.07876 12.22 4.07876 12.155 4.14376C11.895 4.20876 11.7 4.46876 11.7 4.79376V4.98875H10.985V2.84376C10.985 2.71376 10.92 2.64875 10.855 2.58375C10.855 2.58375 10.855 2.58376 10.79 2.51876L5.65501 0.04875C5.52501 -0.01625 5.46001 -0.01625 5.33001 0.04875L0.260016 2.51876C0.260016 2.51876 0.194992 2.51875 0.194992 2.58375C0.064992 2.64875 0 2.77875 0 2.90875V9.21375C0 9.34375 0.064992 9.47375 0.194992 9.53875L5.33001 12.0087H5.39499H5.46001H5.525H5.58998L10.66 9.53875C10.79 9.47375 10.855 9.34375 10.855 9.21375V8.17375H11.57C11.57 8.49875 11.83 8.69375 12.025 8.82375C12.155 8.88875 12.285 8.88875 12.35 8.88875C12.545 8.88875 12.675 8.82376 12.805 8.69376L14.495 7.00376C14.625 6.87376 14.69 6.67875 14.69 6.54875C14.755 6.22375 14.69 6.09375 14.56 5.96375ZM5.525 0.763754L9.81498 2.84376L8.125 3.62375L3.83502 1.54376L5.525 0.763754ZM2.98998 1.93375L7.28001 4.01375L5.525 4.85875L3.18502 3.68875L1.23502 2.77876L2.98998 1.93375ZM0.714984 3.42876L3.25 4.66375L5.13501 5.57375V11.0337L0.714984 8.88875V3.42876ZM10.27 8.88875L5.91498 11.0337V5.57375L10.27 3.42876V4.98875H8.90501C8.51501 4.98875 8.125 5.37876 8.125 5.76876V7.39376C8.125 7.78376 8.51501 8.10875 8.90501 8.10875H10.27V8.88875ZM12.415 8.04376V7.32876H8.90501L8.83998 7.26375V5.70376L8.90501 5.63875H12.415V4.79376L14.04 6.41876L12.415 8.04376Z" fill="black"/>
                                            </svg> &nbsp; Confirmed</p>
                                    </div>
                                </div>
                                <div class="p-2 bd-highlight">
                                    <div class="order_info">
                                        <p class="order-info-head">Expected Date of Arrival:</p>
                                        <p class="order-status">Tuesday, January 30th, 2021</p>
                                    </div>
                                </div>
                                <div class="p-2 bd-highlight">
                                    <div class="order_info">
                                        <p class="order-info-head">Order Placed on:</p>
                                        <p class="order-status">{{ date('D,M',strtotime($orderDetail->order_date)) }} {{ date('d',strtotime($orderDetail->order_date))}}th {{ date('Y',strtotime($orderDetail->order_date))}}</p>
                                    </div>
                                </div>
                                <div class="p-2 bd-highlight">
                                    <div class="order_info">
                                        <p class="order-info-head">Order Amount:</p>
                                        <p class="order-status">₹ {{$orderDetail->total_amount}}</p>
                                    </div>
                                </div>
                                <div class="p-2 bd-highlight">
                                    <div class="order_info">
                                        <p class="order-info-head">Shipped To:</p>
                                        <p class="order-status"><u>{{$user->f_name}} {{$user->l_name}}</u></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @foreach($orderDetail->orderDetails as $details)
                    <div class="row customize-row-style">
                        <div class="col-md-6">
                            <div class="d-flex flex-row bd-highlight mb-3">
                                <div class="product-image">
                                    <!-- <img src="img/small-product-image.png"> -->
                                    <img src="{{asset('Pimages/'.$details->image)}}">
                                </div>
                                <div>
                                    <p class="small-product-disc">
                                        <a class="small-details_link" href="#">{{$details->product_name}}</a>
                                    </p>
                                    <p class="product-price">
                                        <span>₹ {{$details->price}}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 only_web">
                            <p class="order-track">
                                <a href="#" onclick="returnProduct({{$details->id}})">Return or Replace</a>
                            </p>
                            <p class="order-track">
                                <a href="#">Share Review</a>
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="row mt-3">
                    <div class="col-md-6 no-left_padding">
                        <div class="card-details">
                            <div class="card-blue">
                                <p class="summery-head">Payment Summary</p>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <p class="price_and_others_label">Subtotal:</p>
                                </div>
                                <div class="col text-right">
                                    <p class="price-and-others">₹{{$subtotal}}.00</p>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <p class="price_and_others_label">GST:</p>
                                </div>
                                <div class="col text-right">
                                    <p class="price-and-others">₹{{$gst_price}}</p>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <p class="price_and_others_label">Promo Code:</p>
                                </div>
                                <div class="col text-right" style="padding-left: 0;">
                                    <p class="price-and-others"><span class="coupone-card-label">(NEWYEAR20)</span> - ₹00.00</p>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <p class="price_and_others_label">Shipping:</p>
                                </div>
                                <div class="col text-right">
                                    <p class="shipping-date">₹{{$shippingCharges}}</p>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <p class="price_and_others_label">Final Total :</p>
                                </div>
                                <div class="col text-right">
                                    <p class="price-and-others">₹{{ceil($totalAmount)}}.00</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 two-card">
                        <div class="card-details">
                            <div class="card-blue">
                                <p class="summery-head only_web">SHIPPING ADDRESS</p>
                                <p class="summery-head only_mobile">BILLING INFO</p>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <p class="price_and_others_label user_name">{{$user->name}}</p>
                                    <p class="price_and_others_label mt-3">{{$user->name}}
                                        <br> {{$user->address->address1}}
                                        <br> {{$user->address->state}},{{$user->address->city}} {{$user->address->building}}
                                        <br> {{$user->address->address2}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 only_mobile">
                            <p class="summery-head only_mobile mt-3">PAYMENT DETAILS</p>
                            <div class="d-flex justify-content-between mt-3">
                                <div>
                                    <p class="product-price">
                                        <span>₹1,100.00</span>
                                    </p>
                                </div>
                                <div>
                                    <p class="price_and_others_label">Paid via UPI</p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-start">
                                <diV><img src="img/g-pay.png"></diV>
                                <diV>
                                    <p class="price_and_others_label style-mob">sushmitapillai@okicicibank</p>
                                </diV>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')

<script>
function returnProduct(id){
    alert(id);

}
</script>
@endpush