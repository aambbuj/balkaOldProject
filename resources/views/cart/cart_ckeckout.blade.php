@extends('layouts.frontend.master')
@section('title')
Balkae || Checkout
@endsection
@section('content')

        @if($message = Session::get('error'))
        <div class="alert alert-danger" role="alert"> 
        <small>{{ $message }}</small>
        </div>
        @endif

        @if($message = Session::get('success'))
        <div class="alert alert-success" role="alert"> 
        <small>{{ $message }}</small>
        </div>
        @endif

    <section style="background: #FFE15B;">
        <div class="container alignment-mob-style">
            <div class="row">
                <div class="col">
                    <div class="py-2">
                        <div class="status-timeline d-flex justify-content-center">
                            <div class="text-center">

                                <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.08535 14.2C4.21133 14.2 4.33215 14.15 4.42123 14.0609C4.51031 13.9718 4.56035 13.851 4.56035 13.725V10.495C4.56035 10.369 4.51031 10.2482 4.42123 10.1591C4.33215 10.0701 4.21133 10.02 4.08535 10.02C3.95937 10.02 3.83856 10.0701 3.74948 10.1591C3.6604 10.2482 3.61035 10.369 3.61035 10.495V13.725C3.61035 13.851 3.6604 13.9718 3.74948 14.0609C3.83856 14.15 3.95937 14.2 4.08535 14.2Z" fill="black"/>
                                <path d="M6.55508 14.2C6.68106 14.2 6.80188 14.15 6.89096 14.0609C6.98004 13.9718 7.03008 13.851 7.03008 13.725V10.495C7.03008 10.369 6.98004 10.2482 6.89096 10.1591C6.80188 10.0701 6.68106 10.02 6.55508 10.02C6.4291 10.02 6.30828 10.0701 6.2192 10.1591C6.13012 10.2482 6.08008 10.369 6.08008 10.495V13.725C6.08008 13.851 6.13012 13.9718 6.2192 14.0609C6.30828 14.15 6.4291 14.2 6.55508 14.2Z" fill="black"/>
                                <path d="M9.02481 14.2C9.15078 14.2 9.2716 14.15 9.36068 14.0609C9.44976 13.9718 9.49981 13.851 9.49981 13.725V10.495C9.49981 10.369 9.44976 10.2482 9.36068 10.1591C9.2716 10.0701 9.15078 10.02 9.02481 10.02C8.89883 10.02 8.77801 10.0701 8.68893 10.1591C8.59985 10.2482 8.5498 10.369 8.5498 10.495V13.725C8.5498 13.851 8.59985 13.9718 8.68893 14.0609C8.77801 14.15 8.89883 14.2 9.02481 14.2Z" fill="black"/>
                                <path d="M11.4955 14.2C11.6215 14.2 11.7423 14.15 11.8314 14.0609C11.9205 13.9718 11.9705 13.851 11.9705 13.725V10.495C11.9705 10.369 11.9205 10.2482 11.8314 10.1591C11.7423 10.0701 11.6215 10.02 11.4955 10.02C11.3695 10.02 11.2487 10.0701 11.1596 10.1591C11.0706 10.2482 11.0205 10.369 11.0205 10.495V13.725C11.0205 13.851 11.0706 13.9718 11.1596 14.0609C11.2487 14.15 11.3695 14.2 11.4955 14.2Z" fill="black"/>
                                <path d="M15.58 8.79061V6.32061C15.5808 6.25776 15.569 6.19538 15.5455 6.13709C15.522 6.0788 15.4871 6.02576 15.4429 5.98105C15.3987 5.93633 15.3461 5.90084 15.2881 5.87661C15.2301 5.85238 15.1679 5.83991 15.105 5.83991H13.775L11.9491 2.22991C11.9491 2.21661 11.9358 2.20331 11.9282 2.19191C11.7854 1.96888 11.5887 1.78545 11.3562 1.65859C11.1237 1.53173 10.863 1.46553 10.5982 1.46611H10.4994C10.4264 1.19414 10.2659 0.953761 10.0427 0.782068C9.8195 0.610374 9.546 0.516915 9.2644 0.516113H6.3156C6.034 0.516915 5.7605 0.610374 5.5373 0.782068C5.3141 0.953761 5.15361 1.19414 5.0806 1.46611H4.997C4.72779 1.46572 4.46279 1.53303 4.2264 1.66185C3.99001 1.79067 3.7898 1.97687 3.6442 2.20331C3.63796 2.21637 3.63099 2.22906 3.6233 2.24131L1.7993 5.83991H0.469301C0.344314 5.84141 0.224955 5.89212 0.137104 5.98104C0.0492534 6.06996 -7.93953e-06 6.18992 1.06053e-06 6.31491V8.78491C-7.3203e-05 8.81818 0.00375299 8.85134 0.0114011 8.88371L1.3889 14.8459C1.47699 15.2561 1.70353 15.6235 2.03047 15.8865C2.35741 16.1494 2.76485 16.2919 3.1844 16.2899H12.3956C12.8134 16.2927 13.2195 16.1519 13.546 15.8911C13.8725 15.6304 14.0995 15.2654 14.1892 14.8573L15.5686 8.89131C15.5764 8.85833 15.5803 8.82452 15.58 8.79061ZM5.985 1.80051C5.985 1.71283 6.01983 1.62874 6.08183 1.56674C6.14383 1.50474 6.22792 1.46991 6.3156 1.46991H9.2644C9.35208 1.46991 9.43617 1.50474 9.49817 1.56674C9.56017 1.62874 9.595 1.71283 9.595 1.80051V1.89931C9.595 1.98699 9.56017 2.07108 9.49817 2.13308C9.43617 2.19508 9.35208 2.22991 9.2644 2.22991H6.3156C6.22792 2.22991 6.14383 2.19508 6.08183 2.13308C6.01983 2.07108 5.985 1.98699 5.985 1.89931V1.80051ZM4.465 2.69731C4.52486 2.61173 4.60446 2.54183 4.69707 2.49354C4.78968 2.44525 4.89256 2.41999 4.997 2.41991H5.1471C5.24786 2.64577 5.41177 2.83768 5.61909 2.97252C5.8264 3.10736 6.06829 3.17939 6.3156 3.17991H9.2644C9.51171 3.17939 9.7536 3.10736 9.96092 2.97252C10.1682 2.83768 10.3321 2.64577 10.4329 2.41991H10.5982C10.6992 2.41874 10.799 2.44238 10.8888 2.48876C10.9786 2.53513 11.0556 2.60283 11.1131 2.68591L12.7167 5.83991H2.8633L4.465 2.69731ZM0.950001 6.78991H14.63V8.30991H0.950001V6.78991ZM13.2639 14.6464C13.2204 14.8439 13.1105 15.0206 12.9524 15.1468C12.7944 15.273 12.5978 15.3412 12.3956 15.3399H3.1844C2.98163 15.341 2.78466 15.2723 2.62656 15.1453C2.46845 15.0183 2.35883 14.8408 2.3161 14.6426L1.0716 9.25991H14.5084L13.2639 14.6464Z" fill="black"/>
                                </svg>

                                <p class="status_label active-statsu">Order Details</p>
                            </div>
                            <div class="text-center">
                                <div class="line-dotter line-dotter_active line-dotter_active_mobile"></div>
                            </div>
                            <div class="text-center">

                                <svg width="18" height="17" viewBox="0 0 18 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.6695 3.2564L16.3949 1.92417C16.2279 1.11519 15.5043 0.525146 14.673 0.525146C14.5543 0.525146 14.4355 0.536279 14.3205 0.562256L2.31934 3.04116H1.75527C0.786719 3.04116 0 3.82788 0 4.79272V14.7269C0 15.6955 0.786719 16.4822 1.75527 16.4822H15.8309C16.7994 16.4822 17.5861 15.6955 17.5861 14.7269V11.3017V8.21792V4.79272C17.5824 4.13218 17.215 3.55327 16.6695 3.2564ZM14.4281 1.07065C14.5098 1.0521 14.5914 1.04468 14.6768 1.04468C15.2594 1.04468 15.7715 1.45659 15.8865 2.02808L16.1018 3.05972C16.0721 3.05601 16.0461 3.05229 16.0164 3.04858C16.009 3.04858 16.0053 3.04858 15.9979 3.04858C15.9756 3.04487 15.9533 3.04487 15.9311 3.04487C15.9236 3.04487 15.9199 3.04487 15.9125 3.04487C15.8865 3.04487 15.8568 3.04116 15.8309 3.04116H4.89102L14.4281 1.07065ZM15.8309 15.9626H1.75527C1.07617 15.9626 0.519531 15.4097 0.519531 14.7269V4.79643C0.519531 4.11733 1.07246 3.5644 1.75527 3.5644H15.8309C15.868 3.5644 15.9051 3.56811 15.9422 3.56811C15.9459 3.56811 15.9533 3.56811 15.957 3.56811C15.9719 3.56811 15.983 3.57183 15.9979 3.57183C16.0053 3.57183 16.0127 3.57554 16.0238 3.57554C16.035 3.57554 16.0461 3.57925 16.0535 3.58296C16.0646 3.58667 16.0758 3.58667 16.0869 3.59038C16.0943 3.59038 16.1018 3.59409 16.1092 3.59409C16.124 3.5978 16.1389 3.60151 16.15 3.60522C16.1537 3.60522 16.1574 3.60894 16.1611 3.60894C16.1797 3.61265 16.1982 3.62007 16.2131 3.62378C16.2539 3.63862 16.2947 3.65347 16.3355 3.67202C16.3393 3.67202 16.3393 3.67202 16.343 3.67573C16.7697 3.8687 17.0666 4.29917 17.0666 4.79643V7.95815H11.7006C10.7023 7.95815 9.89336 8.76714 9.89336 9.76538C9.89336 10.7636 10.7061 11.5726 11.7006 11.5726H17.0666V14.7343C17.0629 15.4097 16.51 15.9626 15.8309 15.9626ZM17.0629 11.0494H11.7006C10.9918 11.0494 10.4129 10.4705 10.4129 9.76167C10.4129 9.05288 10.9918 8.47397 11.7006 8.47397H17.0666L17.0629 11.0494Z" fill="black"/>
                                <path d="M11.248 9.76152C11.248 10.2736 11.6674 10.693 12.1795 10.693C12.6953 10.693 13.1109 10.2736 13.1109 9.76152C13.1109 9.24941 12.6916 8.83008 12.1795 8.83008C11.6674 8.83008 11.248 9.24941 11.248 9.76152ZM12.1832 9.34961C12.4096 9.34961 12.5951 9.53516 12.5951 9.76152C12.5951 9.98789 12.4096 10.1734 12.1832 10.1734C11.9568 10.1734 11.7713 9.98789 11.7713 9.76152C11.7676 9.53516 11.9531 9.34961 12.1832 9.34961Z" fill="black"/>
                                <path d="M4.33789 14.4968H2.81641C2.67168 14.4968 2.55664 14.6119 2.55664 14.7566C2.55664 14.9013 2.67168 15.0164 2.81641 15.0164H4.33789C4.48262 15.0164 4.59766 14.9013 4.59766 14.7566C4.59766 14.6119 4.47891 14.4968 4.33789 14.4968Z" fill="black"/>
                                <path d="M7.81543 14.4968H6.29395C6.14922 14.4968 6.03418 14.6119 6.03418 14.7566C6.03418 14.9013 6.14922 15.0164 6.29395 15.0164H7.81543C7.96016 15.0164 8.0752 14.9013 8.0752 14.7566C8.0752 14.6119 7.95645 14.4968 7.81543 14.4968Z" fill="black"/>
                                <path d="M11.292 14.4968H9.77051C9.62578 14.4968 9.51074 14.6119 9.51074 14.7566C9.51074 14.9013 9.62578 15.0164 9.77051 15.0164H11.292C11.4367 15.0164 11.5518 14.9013 11.5518 14.7566C11.5518 14.6119 11.4367 14.4968 11.292 14.4968Z" fill="black"/>
                                <path d="M14.7695 14.4968H13.248C13.1033 14.4968 12.9883 14.6119 12.9883 14.7566C12.9883 14.9013 13.1033 15.0164 13.248 15.0164H14.7695C14.9143 15.0164 15.0293 14.9013 15.0293 14.7566C15.0293 14.6119 14.9143 14.4968 14.7695 14.4968Z" fill="black"/>
                                </svg>

                                <p class="status_label">Payment Details</p>
                            </div>
                            <div class="text-center">
                                <div class="line-dotter line-dotter_active_mobile"></div>
                            </div>
                            <div class="text-center">

                                <svg width="14" height="18" viewBox="0 0 14 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.5" d="M11.1291 8.73834C11.044 8.73834 10.9598 8.74395 10.8768 8.75509C10.888 8.67242 10.8936 8.58847 10.8936 8.50378C10.8936 7.68937 10.3788 6.97455 9.61258 6.72518C9.25989 6.61032 8.72133 6.47998 8.09457 6.47998H8.08267C8.29284 6.13372 8.58898 5.67591 8.94923 5.19916C9.6612 4.25697 9.59545 3.31888 8.77317 2.68987C8.40138 2.4054 7.6828 2.09536 6.70101 2.76185C6.71021 2.70076 6.71986 2.63713 6.73053 2.56799C6.91474 1.37319 6.15055 0.671385 5.36262 0.524883C4.4814 0.360651 3.71181 1.06972 3.5041 1.82031C3.41416 2.14539 3.29106 2.66253 3.15922 3.30243C2.9685 3.24105 2.72654 3.20892 2.4 3.23566C1.71458 3.292 0.892699 3.79186 0.832021 5.01547C0.758797 6.49483 1.52205 10.5163 2.36299 13.046C2.47053 13.4518 2.61807 13.8599 2.81332 14.2684C3.72469 16.175 5.25392 17.1993 7.48826 17.3999C7.6385 17.4133 7.80564 17.4221 7.9861 17.4221C9.18726 17.4221 10.9748 17.0317 12.2382 15.0299C13.0889 13.6819 13.3826 11.4805 12.9067 10.0183C12.6574 9.25272 11.9431 8.73834 11.1291 8.73834ZM4.24257 2.02471C4.35786 1.60774 4.80169 1.19983 5.22256 1.27816C5.64036 1.35583 6.0877 1.70964 5.97338 2.45126C5.87051 3.11832 5.83437 3.42133 5.82157 3.55371C5.15983 4.25169 4.14013 5.45247 3.34075 6.94714C3.59148 4.82686 4.02042 2.82733 4.24257 2.02471ZM2.38927 9.34614C2.34935 9.50296 2.31324 9.66121 2.28201 9.821C1.8499 7.89838 1.55296 5.94781 1.59727 5.05332C1.64262 4.13754 2.27118 4.01497 2.46271 3.99926C2.74602 3.97593 2.89941 4.01015 3.00948 4.06608C2.72388 5.59469 2.43967 7.56141 2.38767 9.32348C2.38744 9.33122 2.38904 9.33851 2.38927 9.34614ZM11.5902 14.6209C10.4164 16.4808 8.74857 16.7435 7.55677 16.6368C6.36385 16.5297 4.68075 16.1534 3.62418 14.1735C3.61763 14.1458 3.6087 14.1182 3.59553 14.0916C3.43464 13.7654 3.26919 13.3413 3.1056 12.8541C2.04276 8.83343 5.48317 4.96761 6.64635 3.80443C7.09325 3.35761 7.49128 3.13353 7.83589 3.13353C8.00641 3.13353 8.16391 3.18845 8.30771 3.29836C8.48287 3.43237 9.01587 3.84012 8.33793 4.73721C7.73295 5.53792 7.30572 6.27617 7.13364 6.58816C6.17782 6.81054 5.14353 7.4194 4.292 8.80378C4.18112 8.98395 4.23739 9.21993 4.41762 9.33073C4.59771 9.44161 4.83369 9.38535 4.94457 9.20511C6.36875 6.88975 8.33194 7.11369 9.37538 7.45366C9.89484 7.62275 10.1274 8.10286 10.1274 8.50374C10.1274 8.79898 10.011 9.07828 9.8005 9.2895C9.50662 9.58264 9.07071 9.6912 8.68996 9.56634C7.97557 9.33199 7.11397 9.58093 6.49446 10.2003C5.60328 11.0915 5.47721 12.4227 6.20738 13.2308C6.66258 13.7344 7.35398 14.0458 8.05684 14.0636C8.61499 14.0761 9.10237 13.907 9.42641 13.5829C10.2095 12.7999 10.3117 11.6917 10.0655 10.9407C9.94034 10.5593 10.0487 10.1241 10.3419 9.83157C10.5529 9.62064 10.8324 9.50445 11.1291 9.50445C11.6179 9.50445 12.0297 9.79924 12.1781 10.2553C12.5847 11.5047 12.321 13.4631 11.5902 14.6209ZM9.33754 11.1795C9.51067 11.7077 9.4378 12.4881 8.88474 13.0412C8.71303 13.2129 8.41974 13.3062 8.07623 13.2977C7.57912 13.2851 7.09303 13.068 6.77587 12.7171C6.27317 12.1608 6.51963 11.2587 7.03624 10.7421C7.35625 10.4221 7.75765 10.2441 8.12704 10.2441C8.23904 10.2441 8.34821 10.2605 8.45117 10.2943C8.71753 10.3817 8.99398 10.4053 9.26176 10.3696C9.22637 10.6372 9.25015 10.9133 9.33754 11.1795Z" fill="black"/>
                                </svg>

                                <p class="status_label">Confirmation</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
        @if($message = Session::get('error'))
            <div class="alert alert-danger alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <strong>Error!</strong> {{ $message }}
            </div>
        @endif
        @if($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade {{ Session::has('success') ? 'show' : 'in' }}" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <strong>Success!</strong> {{ $message }}
            </div>
        @endif


    <section class="cart-items-counts pb-5 mb-5">
        <div class="container-fluid">
            <div class="row extra-gaap">
                <div class="col-md-6 no-padding-mob">
                    <div class="payment-option">
                        <div class="row">
                            <div class="col">
                                <div class="offer-part ">
                                    <div class="liselblk nice-select-main_select">
                                        <select style="display: none;">
                                          <option value="hidden">OFFERS</option>
                                          <option value="">Option 1</option>
                                        </select>
                                        <div class="nice-select custom-nice-select" tabindex="0">
                                            <span class="current summery-head">OFFERS</span>
                                            <ul class="list" style="width: 100%;">
                                                <li data-value="hidden" class="option selected focus">OFFERS</li>
                                                <li data-value="" class="option">Option 1</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col">
                                <div class="pm-head">
                                    <p class="summery-head">Choose payment mode</p>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col">
                                <div class="already-select">
                                    <p class="price_and_others_label already-head">preffered method</p>
                                    <div class="already_select_pay_methord mt-2">
                                        <label for="selected-item-0" class="selected-label half-cart">
                                            <input type="radio" checked name="selected-item" id="selected-item-0">
                                            <span class="icon"></span>
                                            <div class="selected-content ">
                                                <h4><img src="img/g-pay.png"> &nbsp; {{$user ? $user->email : 'exampale@exam.com'}}</h4>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col">
                                <div class=" mt-4 already-select">
                                    <p class="price_and_others_label already-head">SAVED CARDS</p>
                                    <!-- // only for desktop -->
                                    <div class="my-2 only_web">
                                        <div class="payment-card card-one">
                                            <div class="text-right">
                                                <img src="img/visa.png">
                                            </div>
                                            <div class="cart-info">
                                                <p>09/21</p>
                                                <p>4323 3321 7342 9821</p>
                                            </div>
                                        </div>
                                        <div class="payment-card card-two">
                                            <div class="text-right">
                                                <img src="img/amex.png">
                                            </div>
                                            <div class="cart-info">
                                                <p>05/22</p>
                                                <p>4323 3321 7342 9821</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- // only for mobile -->
                                    <div class="only_mobile">
                                        <div class="owl-carousel owl-theme bank-card-details owl-loaded owl-drag">
                                            <div class="owl-stage-outer">
                                                <div class="owl-stage del_space" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 1884px;">
                                                    <div class="owl-item product-cart-parent active del-cart">
                                                        <div class="item ">
                                                            <div class="payment-card card-one">
                                                                <div class="text-right">
                                                                    <img class="style-responsive" src="img/visa.png">
                                                                </div>
                                                                <div class="cart-info">
                                                                    <p>09/21</p>
                                                                    <p>4323 3321 7342 9821</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="owl-item product-cart-parent active del-cart">
                                                        <div class="item ">
                                                            <div class="payment-card card-two">
                                                                <div class="text-right">
                                                                    <img class="style-responsive" src="img/amex.png">
                                                                </div>
                                                                <div class="cart-info">
                                                                    <p>05/22</p>
                                                                    <p>4323 3321 7342 9821</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="owl-item product-cart-parent active del-cart">
                                                        <div class="item ">
                                                            <div class="payment-card card-one">
                                                                <div class="text-right">
                                                                    <img class="style-responsive" src="img/visa.png">
                                                                </div>
                                                                <div class="cart-info">
                                                                    <p>09/21</p>
                                                                    <p>4323 3321 7342 9821</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="select-payments ">
                            <label for="selected-item-1" class="selected-label" id="wallet_upi">
                                <input type="radio" name="selected-item" id="selected-item-1" value="1">
                                <span class="icon"></span>
                                <div class="selected-content">
                                    <h4>Wallet / UPI</h4>
                                </div>
                            </label>

                            <label for="selected-item-2" class="selected-label" id="netbanking">
                                <input type="radio" name="selected-item" id="selected-item-2" value="1">
                                <span class="icon"></span>
                                <div class="selected-content">
                                    <h4>Netbanking</h4>
                                </div>
                            </label>

                            <label for="selected-item-3" class="selected-label" id="craditDebAtm">
                                <input type="radio" name="selected-item" id="selected-item-3" value="1">
                                <span class="icon"></span>
                                <div class="selected-content">
                                    <h4>Credit / Debt / ATM Card</h4>
                                </div>
                            </label>
                            @if($isAvalableCOD ==1)
                            <label for="selected-item-4" class="selected-label">
                                <input type="radio" name="selected-item" id="selected-item-4" value="1">
                                <span class="icon"></span>
                                <div class="selected-content">
                                    <h4>Cash on Delivery</h4>
                                </div>
                            </label>
                            @endif
                        </div>
                    </div>

                </div>
                <div class="col-md-6 ">
                    <div class="card-details only_web">
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
                            <div class="col text-right">
                                <p class="price-and-others"><span class="coupone-card-label">(NEWYEAR20)</span> - ₹ {{$coupon_value}}</p>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <p class="price_and_others_label">Shipping:</p>
                            </div>
                            <div class="col text-right">
                                <p class="shipping-date">₹{{$shipping_charge}}.00</p>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <p class="price_and_others_label">Final Total :</p>
                            </div>
                            <div class="col text-right">
                                <p class="price-and-others">₹{{$totalPrict}}.00</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-details mt-3 only_web">
                        <div class="card-blue">
                            <p class="summery-head">SHIPPING ADDRESS</p>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <p class="price_and_others_label user_name">{{$user ? $user->name : ''}}</p>
                                <p class="price_and_others_label mt-3">{{$user->name}}
                                <span id="changeAddress">
                                    <!-- <br> {{$user->address->address1}}
                                    <br> {{$user->address->state}} {{$user->address->city}} {{$user->address->building}} 
                                    <br> {{$user->address->address2}} -->
                                    </span>
                                    </p>
                                <p class="address-change" ><a href="#" data-target=".bd-example-modal-lg" data-toggle="modal">Change Address</a></p>
                                <div class="background-diff-address">
                                    <p class="delivery-information" >Cash on Delivery available for this address! &nbsp;
                                        <svg width="15" height="16" viewBox="0 0 15 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13.9245 2.49921C13.8688 2.44343 13.8026 2.39917 13.7297 2.36898C13.6569 2.33878 13.5788 2.32324 13.5 2.32324C13.4211 2.32324 13.3431 2.33878 13.2702 2.36898C13.1974 2.39917 13.1312 2.44343 13.0755 2.49921L7.49998 8.07472L5.52448 6.09922C5.41189 5.98663 5.25919 5.92338 5.09998 5.92338C4.94076 5.92338 4.78806 5.98663 4.67548 6.09922C4.56289 6.2118 4.49964 6.3645 4.49964 6.52372C4.49964 6.68293 4.56289 6.83563 4.67548 6.94822L7.07547 9.34822C7.1312 9.404 7.19737 9.44826 7.27021 9.47845C7.34305 9.50865 7.42113 9.52419 7.49998 9.52419C7.57882 9.52419 7.6569 9.50865 7.72974 9.47845C7.80258 9.44826 7.86875 9.404 7.92448 9.34822L13.9245 3.34821C13.9803 3.29249 14.0245 3.22632 14.0547 3.15348C14.0849 3.08064 14.1004 3.00256 14.1004 2.92371C14.1004 2.84487 14.0849 2.76679 14.0547 2.69395C14.0245 2.62111 13.9803 2.55494 13.9245 2.49921Z" fill="#359E9E"/>
                                        <path d="M13.968 6.40073C13.9522 6.32351 13.9214 6.25016 13.8773 6.18485C13.8332 6.11954 13.7766 6.06356 13.7109 6.0201C13.6451 5.97664 13.5715 5.94656 13.4941 5.93157C13.4167 5.91658 13.3372 5.91697 13.26 5.93273C13.1827 5.94849 13.1094 5.9793 13.0441 6.02341C12.9788 6.06752 12.9228 6.12406 12.8793 6.18981C12.8359 6.25555 12.8058 6.32921 12.7908 6.40658C12.7758 6.48395 12.7762 6.56351 12.792 6.64073C13.0392 7.84794 12.8661 9.1034 12.3014 10.1987C11.7367 11.2939 10.8144 12.1631 9.68757 12.6619C8.56078 13.1607 7.29727 13.2591 6.10683 12.9408C4.91639 12.6225 3.87062 11.9066 3.14315 10.912C2.41568 9.91736 2.05027 8.70385 2.10759 7.47291C2.1649 6.24198 2.64149 5.06768 3.45824 4.14496C4.27498 3.22225 5.38275 2.60662 6.59762 2.40031C7.81249 2.19399 9.06138 2.40938 10.137 3.01073C10.2762 3.0887 10.4407 3.10817 10.5943 3.06485C10.6703 3.0434 10.7414 3.00718 10.8035 2.95826C10.8655 2.90934 10.9173 2.84868 10.956 2.77973C10.9946 2.71079 11.0192 2.63491 11.0285 2.55644C11.0378 2.47797 11.0315 2.39844 11.0101 2.32239C10.9886 2.24634 10.9524 2.17526 10.9035 2.1132C10.8546 2.05115 10.7939 1.99934 10.725 1.96073C9.46072 1.2527 7.99862 0.980387 6.56426 1.18581C5.1299 1.39124 3.803 2.06299 2.78832 3.09741C1.77364 4.13182 1.12757 5.47141 0.949811 6.90946C0.772049 8.34752 1.07247 9.8041 1.80472 11.0545C2.53698 12.3048 3.66036 13.2795 5.00152 13.828C6.34268 14.3765 7.82709 14.4684 9.22567 14.0895C10.6243 13.7107 11.8593 12.8821 12.7402 11.7316C13.6211 10.5811 14.099 9.17273 14.1 7.72373C14.0997 7.27946 14.0555 6.83629 13.968 6.40073Z" fill="#359E9E"/>
                                        </svg>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                             <!-- address modal -->
                    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                            <form action="#" method="post">
                            <input type="hidden" name="address_id" value="{{$user ? $user->address->id : ''}}" class="form-control">

                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Room no:</label>
                                        <input type="text" name="room_no" value="{{$user ? $user->address->room_no : ''}}" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Building:</label>
                                        <input type="text" name="building" value="{{$user ? $user->address->building : ''}}" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">City:</label>
                                        <input type="text" name="city" value="{{$user ? $user->address->city : ''}}" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">State:</label>
                                        <input type="text" name="state" value="{{$user ? $user->address->state : ''}}" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Postal Code:</label>
                                        <input type="text" name="postal_code" value="{{$user ? $user->address->postal_code : ''}}" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Address1:</label>
                                        <textarea class="form-control" name="address1">{{$user ? $user->address->address1 : ''}}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Address2:</label>
                                        <textarea class="form-control" name="address2">{{$user ? $user->address->address2 : ''}}</textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" id="submit" class="btn btn-primary">Change Address</button>
                                </div>
                                </div>
                            </form>
                        </div>
                    </div>
                        <!-- end address modal -->
                    <div class="row mt-4">
                        <div class="col">
                            <p class="summery-head">Total <span class="only_web">Price:</span></p>
                        </div>
                        <div class="col text-right">
                            <p class="summery-head">₹{{$totalPrict}}.00</p>
                        </div>
                    </div>
                    <div>
                        <p class="summery-head only_mobile"><a href="#">View Order Details</a></p>
                    </div>
                    <div class="row mt-5">
                        <div class="col main-button-submit" >
                        <form action="{{route('payment.checkout-page')}}" method="post">
                        @csrf
                            <input type="hidden" name="order_ids[]" id="order_ids" value=""> 
                            <input type="hidden" name="paymentmathod" id="paymentmathod" value=""> 
                            <input type="hidden" name="subtotal" id="subtotal" value="{{$subtotal}}"> 
                            <input type="hidden" name="gst_price" id="gst_price" value="{{$gst_price}}"> 
                            <input type="hidden" name="shipping_charge" id="shipping_charge" value="{{$shipping_charge}}"> 
                            <input type="hidden" name="totalPrict" id="totalPrict" value="{{$totalPrict}}"> 
                            <button type="submit" class="main-submit">PROCEED TO CHECKOUT</button>
                        </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection

@push('js')

<!-- <button id="rzp-button1">Pay</button> -->




<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>

        $(document).ready(function () {
            
        // window.location.reload();
        $('.main-submit').prop('disabled', true);
                    var address_id = $('[name=address_id]').val();
                    $.ajax({
                        url: '/get-address',
                        data : {address_id:address_id},
                        type: 'GET',
                        success: function (data) {
                            let response = data.userAddress;
                            var orderIds = data.order_id;
                            $('#order_ids').val(orderIds);
                            console.log(orderIds)   
                            var data = `<br> ${response.address1}<br> ${response.state} ${response.city} ${response.building} <br> ${response.address2}`;
                            $('#changeAddress').html(data);
                        }
                    });
        });



        $(document).ready(function () {
            $('#submit').click(function (e) {
                e.preventDefault();
                var address_id = $('[name=address_id]').val();
                var room_no = $('[name=room_no]').val();
                var building = $('[name=building]').val();
                var city = $('[name=city]').val();
                var state = $('[name=state]').val();
                var postal_code = $('[name=postal_code]').val();
                var address1 = $('[name=address1]').val();
                var address2 = $('[name=address2]').val();
            //  alert(address_id);
                $.ajax({
                    url: '/change-address',
                    data : {address_id:address_id,room_no:room_no,building:building,city:city,state:state,postal_code:postal_code,address1:address1,address2:address2},
                    type: 'GET',
                    success: function (response) {
                        console.log(response)
                        var data = `<br> ${response.address1}<br> ${response.state} ${response.city} ${response.building} <br> ${response.address2}`;
                        $('#changeAddress').html(data);
                        $('[name=room_no]').val(response.room_no);
                        $('[name=building]').val(response.building);
                        $('[name=city]').val(response.city);
                        $('[name=state]').val(response.state);
                        $('[name=postal_code]').val(response.postal_code);
                        $('[name=address1]').val(response.address1);
                        $('[name=address2]').val(response.address2);
                        $('.modal').modal('hide');
                    // window.location.reload();
                        // alertify.set('notifier','position','top-right');
                        // alertify.success(response.status);
                    }
                });

            });
        });
</script>

<script>
$('input[name="selected-item"]').click(function(){
    $('#paymentmathod').val('cod');
    $('.main-submit').prop('disabled', false);
    $('.main-submit').addClass("checkout-button");

})
</script>
        <!-- Upi and Wellate -->
<script>
    var options = {
        "key": "{{ env('RAZOR_KEY') }}", 
        "amount": "{{Session::get('amount')}}",
        "currency": "INR",
        "name": "Acme Corp",
        "accept_partial": true,
        "description": "Test Transaction",
        "image": "https://example.com/your_logo",
        "order_id": "{{Session::get('order_id')}}",
        "handler": function (response){
            $.ajax({
                url: '/check_payments',
                type: 'GET',
                data: {razorpay_payment_id : response.razorpay_payment_id , razorpay_order_id : response.razorpay_order_id, razorpay_signature : response.razorpay_signature },
                success: function (response) {
                    console.log(response) 
                    $('#selected-item-1').attr('checked', true);
                    $('#paymentmathod').val(response.payment_id);
                    $('.main-submit').prop('disabled', false);
                    $('.main-submit').addClass("checkout-button");
                    alert(response.success);
                }
            });
            // alert(response.razorpay_payment_id);
            // alert(response.razorpay_order_id);
            // alert(response.razorpay_signature)
        },
        "method": {
            "upi":true,
            "netbanking": false,
            "wallet":true,
            "card": false,
        },  
        "prefill": {
            "name": "Gaurav Kumar",
            "email": "gaurav.kumar@example.com",
            "contact": "9999999999",
            'method': 'upi', //card|upi|wallet
        },
        "notes": {
            "address": "Razorpay Corporate Office"
        },
        "theme": {
            "color": "#3399cc"
        },
        "reminder_enable": true,
    };
    var rzp1 = new Razorpay(options);
    rzp1.on('payment.failed', function (response){
            alert(response.error.code);
            alert(response.error.description);
            alert(response.error.source);
            alert(response.error.step);
            alert(response.error.reason);
            alert(response.error.metadata.order_id);
            alert(response.error.metadata.payment_id);
    });
    document.getElementById('wallet_upi').onclick = function(e){
        rzp1.open();
        e.preventDefault();
    }
</script>


       <!-- Netbanking -->

<script>
    var options = {
        "key": "{{ env('RAZOR_KEY') }}", 
        "amount": "{{Session::get('amount')}}",
        "currency": "INR",
        "name": "Acme Corp",
        "accept_partial": true,
        "description": "Test Transaction",
        "image": "https://example.com/your_logo",
        "order_id": "{{Session::get('order_id')}}",
        "handler": function (response){
            $.ajax({
                url: '/check_payments',
                type: 'GET',
                data: {razorpay_payment_id : response.razorpay_payment_id , razorpay_order_id : response.razorpay_order_id, razorpay_signature : response.razorpay_signature },
                success: function (response) {
                    console.log(response) 
                    $('#selected-item-2').attr('checked', true);
                    $('#paymentmathod').val(response.payment_id);
                    $('.main-submit').prop('disabled', false);
                    $('.main-submit').addClass("checkout-button");
                    alert(response.success);
                }
            });
            // alert(response.razorpay_payment_id);
            // alert(response.razorpay_order_id);
            // alert(response.razorpay_signature)
        },
        "method": {
            "upi":false,
            "netbanking": true,
            "wallet":false,
            "card": false,
        },  
        "prefill": {
            "name": "Gaurav Kumar",
            "email": "gaurav.kumar@example.com",
            "contact": "9999999999",
            'method': 'netbanking', //card|upi|wallet
        },
        "notes": {
            "address": "Razorpay Corporate Office"
        },
        "theme": {
            "color": "#3399cc"
        },
        "reminder_enable": true,
    };
    var rzp2 = new Razorpay(options);
    rzp2.on('payment.failed', function (response){
            alert(response.error.code);
            alert(response.error.description);
            alert(response.error.source);
            alert(response.error.step);
            alert(response.error.reason);
            alert(response.error.metadata.order_id);
            alert(response.error.metadata.payment_id);
    });
    document.getElementById('netbanking').onclick = function(e){
        rzp2.open();
        e.preventDefault();
    }
</script>


<!-- Cart Debit and Atm -->



<script>
    var options = {
        "key": "{{ env('RAZOR_KEY') }}", 
        "amount": "{{Session::get('amount')}}",
        "currency": "INR",
        "name": "Acme Corp",
        "accept_partial": true,
        "description": "Test Transaction",
        "image": "https://example.com/your_logo",
        "order_id": "{{Session::get('order_id')}}",
        "handler": function (response){
            $.ajax({
                url: '/check_payments',
                type: 'GET',
                data: {razorpay_payment_id : response.razorpay_payment_id , razorpay_order_id : response.razorpay_order_id, razorpay_signature : response.razorpay_signature },
                success: function (response) {
                    console.log(response)   
                    $('#selected-item-3').attr('checked', true);
                    $('#paymentmathod').val(response.payment_id);
                    $('.main-submit').prop('disabled', false);
                    $('.main-submit').addClass("checkout-button");
                    alert(response.success);
                }
            });
            // alert(response.razorpay_payment_id);
            // alert(response.razorpay_order_id);
            // alert(response.razorpay_signature)
        },
        "method": {
            "upi":false,
            "netbanking": false,
            "wallet":false,
            "card": true,
        },  
        "prefill": {
            "name": "Gaurav Kumar",
            "email": "gaurav.kumar@example.com",
            "contact": "9999999999",
            'method': 'netbanking', //card|upi|wallet
        },
        "notes": {
            "address": "Razorpay Corporate Office"
        },
        "theme": {
            "color": "#3399cc"
        },
        "reminder_enable": true,
    };
    var rzp3 = new Razorpay(options);
    rzp3.on('payment.failed', function (response){
            alert(response.error.code);
            alert(response.error.description);
            alert(response.error.source);
            alert(response.error.step);
            alert(response.error.reason);
            alert(response.error.metadata.order_id);
            alert(response.error.metadata.payment_id);
    });
    document.getElementById('craditDebAtm').onclick = function(e){
        rzp3.open();
        e.preventDefault();
    }
</script>

@endpush
