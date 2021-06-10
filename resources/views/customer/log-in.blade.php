@extends('layouts.frontend.masterf')
@section('title')
Balkae || Log-In
@endsection
@section('content')
    <!--sign-up-->
    <section class="sign-up">
        <div class="modal__item">
            <a href="#" target="_blank">
                <svg width="199" height="438" viewBox="0 0 199 438" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M6.00002 432.303L6 6" stroke="black" stroke-width="11" stroke-linecap="round"/>
      <path d="M161.057 275.577L7.80999 177.201C7.14444 176.774 6.26978 177.252 6.26978 178.043L6.26978 430.881C6.26978 431.687 7.17392 432.161 7.83732 431.704L161.877 325.523C179.522 313.36 179.092 287.154 161.057 275.577Z" stroke="black" stroke-width="11" stroke-linecap="round"/>
      <path d="M106.044 240.784L7.8131 177.211C7.14774 176.781 6.26978 177.258 6.26978 178.051L6.26978 358.598C6.26978 359.406 7.17736 359.88 7.84044 359.419L106.864 290.605C124.383 278.43 123.954 252.375 106.044 240.784Z" stroke="black" stroke-width="11" stroke-linecap="round"/>
      <path d="M108.666 311.417L7.54081 246.399C6.8753 245.971 6 246.449 6 247.24L6 430.879C6 431.686 6.9048 432.16 7.56815 431.702L109.486 361.339C127.107 349.174 126.677 322.997 108.666 311.417Z" stroke="black" stroke-width="11" stroke-linecap="round"/>
      </svg>
            </a>
        </div>
        <div class="modal__item">
            <div class="modal__title">
                Login
            </div>
            <div class="login-social">
                <ul class="login-social__list">
                    <li class="login-social__item">
                        <a class="login-social__link" href="#">
                            <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="google" class="svg-inline--fa fa-google fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 488 512">
                        <path fill="currentColor"
                            d="M488 261.8C488 403.3 391.1 504 248 504 110.8 504 0 393.2 0 256S110.8 8 248 8c66.8 0 123 24.5 166.3 64.9l-67.5 64.9C258.5 52.6 94.3 116.6 94.3 256c0 86.5 69.1 156.6 153.7 156.6 98.2 0 135-70.4 140.8-106.9H248v-85.3h236.1c2.3 12.7 3.9 24.9 3.9 41.4z">
                        </path>
                    </svg>
                            <span>Google</span>
                        </a>
                    </li>
                    <li class="login-social__item">
                        <a class="login-social__link" href="#">
                            <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="facebook-messenger" class="svg-inline--fa fa-facebook-messenger fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path fill="currentColor"
                            d="M256.55 8C116.52 8 8 110.34 8 248.57c0 72.3 29.71 134.78 78.07 177.94 8.35 7.51 6.63 11.86 8.05 58.23A19.92 19.92 0 0 0 122 502.31c52.91-23.3 53.59-25.14 62.56-22.7C337.85 521.8 504 423.7 504 248.57 504 110.34 396.59 8 256.55 8zm149.24 185.13l-73 115.57a37.37 37.37 0 0 1-53.91 9.93l-58.08-43.47a15 15 0 0 0-18 0l-78.37 59.44c-10.46 7.93-24.16-4.6-17.11-15.67l73-115.57a37.36 37.36 0 0 1 53.91-9.93l58.06 43.46a15 15 0 0 0 18 0l78.41-59.38c10.44-7.98 24.14 4.54 17.09 15.62z">
                        </path>
                    </svg>
                            <span>Facebook</span>
                        </a>
                    </li>
                    <li class="login-social__item">
                        <a class="login-social__link" href="#">
                            <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="twitter" class="svg-inline--fa fa-twitter fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path fill="currentColor"
                            d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z">
                        </path>
                    </svg>
                            <span>Twitter</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="login-info">
                <p>
                    Don't have any account?
                    <a class="login-info__item" href="{{route('customer.sign-up')}}">
            Sign up
        </a>
                </p>
                <a class="login-info__item" href="#">
            Forgot your password
        </a>
            </div>
            <form class="login-form" action="{{route('customer.signin')}}" method="POST">
            @csrf
                <input class="login-form__input" type="text" name="email" placeholder="email">
                <input class="login-form__input" type="password" name="password" placeholder="password">
                <input class="login-form__btn" type="submit" value="log in">
            </form>
            <!-- <div class="close-btn">
        <div class="close-btn__inner">
            <span></span>
            <span></span>
        </div>
    </div> -->
        </div>
    </section>
    <!--sign-up-->
    @endsection 