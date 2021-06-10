<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\AboutusController;
use App\Http\Controllers\ContactusController;
use App\Http\Controllers\OurvalueController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CartController;
use GeoAlgo\Products\Http\Controllers\VendorController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('index');
// });

Auth::routes(['register' => false]);

Route::get('/', [App\Http\Controllers\HomepageController::class, 'index'])->name('homepage');
Route::get('/send-mail', [App\Http\Controllers\MailController::class, 'sendMail'])->name('sendMail');
Route::get('/admin', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('admin.login');
Route::get('/vendor-login', [VendorController::class, 'vendorLogin'])->name('vendor.login');
Route::post('/vendor-login', [VendorController::class, 'login'])->name('vendor.login');


Route::get('/cart', [CartController::class, 'cartDetails'])->name('cart.details');
Route::get('/add-to-cart/{product?}', [CartController::class, 'addtocart'])->name('cart.add');
Route::get('/remove-product/{cart_id?}', [CartController::class, 'cartRemove'])->name('cart.remove');
Route::get('/load-cart-data', [CartController::class, 'cartloadbyajax'])->name('cart.load-cart-data');
Route::get('/delete-from-cart', [CartController::class, 'deletefromcart'])->name('cart.delete-from-cart');
Route::get('/clear-cart', [CartController::class, 'clearcart'])->name('cart.clearcart');
Route::get('/update-to-cart', [CartController::class, 'updateCart'])->name('cart.updateCart');
Route::get('/get-data', [CartController::class, 'getData'])->name('cart.get-data');
Route::get('/apply-coupan', [CartController::class, 'applyCoupan'])->name('cart.apply-coupan');

Route::group(['middleware' => ['web', 'auth']], function() {
    Route::post('/checkout_page', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::get('/check_payments', [CartController::class, 'checkPayments'])->name('check_payments');
    Route::get('/change-address', [CartController::class, 'changeAddress'])->name('payment.change_address');
    Route::get('/get-address', [CartController::class, 'getAddress'])->name('payment.get_address');
    Route::post('/checkout-page', [CartController::class, 'checkoutDetails'])->name('payment.checkout-page');
    Route::get('/cancel-order/{id?}', [CartController::class, 'cancelOrder'])->name('product.cancel-order');
}); 

//Route::get('razorpay-payment', [PaymentController::class, 'create'])->name('pay.with.razorpay'); // create payment

Route::any('payment', [CartController::class, 'payment'])->name('payment'); //accept paymetnt


Route::group(['prefix' => 'admin'], function () {

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('admin.dashboard');

Route::get('/banner',[HomepageController::class,'showBanners'])->name('banner.index');
Route::get('banner/edit/{id?}',[HomepageController::class,'editBanner'])->name('banner.edit');
Route::post('banner/update/{id}',[HomepageController::class,'updateBanner'])->name('banner.update');

Route::get('/specific',[HomepageController::class,'showSpecifics'])->name('specific.index');
Route::get('specific/edit/{id?}',[HomepageController::class,'editSpecific'])->name('specific.edit');
Route::post('specific/update/{id}',[HomepageController::class,'updateSpecific'])->name('specific.update');

Route::get('/motivation',[HomepageController::class,'showMotivation'])->name('motivation.index');
Route::get('motivation/edit/{id?}',[HomepageController::class,'editMotivation'])->name('motivation.edit');
Route::post('motivation/update/{id}',[HomepageController::class,'updateMotivation'])->name('motivation.update');

Route::get('/slider',[HomepageController::class,'showSliders'])->name('slider.index');
Route::get('slider/create',[HomepageController::class,'createSlider'])->name('slider.create');
Route::post('slider/store',[HomepageController::class,'storeSlider'])->name('slider.store');
Route::get('slider/edit/{id?}',[HomepageController::class,'editSlider'])->name('slider.edit');
Route::post('slider/update/{id}',[HomepageController::class,'updateSlider'])->name('slider.update');

Route::get('/discover',[HomepageController::class,'showDiscovers'])->name('discover.index');
Route::get('discover/edit/{id?}',[HomepageController::class,'editDiscover'])->name('discover.edit');
Route::post('discover/update/{id}',[HomepageController::class,'updateDiscover'])->name('discover.update');

Route::get('/popularproduct',[HomepageController::class,'showPopularProducts'])->name('popularproduct.index');
Route::get('popularproduct/create',[HomepageController::class,'createPopularProduct'])->name('popularproduct.create');
Route::post('popularproduct/store',[HomepageController::class,'storePopularProduct'])->name('popularproduct.store');
Route::get('popularproduct/edit/{id?}',[HomepageController::class,'editPopularProduct'])->name('popularproduct.edit');
Route::post('popularproduct/update/{id}',[HomepageController::class,'updatePopularProduct'])->name('popularproduct.update');

Route::get('/promisingpick',[HomepageController::class,'showPromisingPicks'])->name('promisingpick.index');
Route::get('promisingpick/create',[HomepageController::class,'createPromisingPick'])->name('promisingpick.create');
Route::post('promisingpick/store',[HomepageController::class,'storePromisingPick'])->name('promisingpick.store');
Route::get('promisingpick/edit/{id?}',[HomepageController::class,'editPromisingPick'])->name('promisingpick.edit');
Route::post('promisingpick/update/{id}',[HomepageController::class,'updatePromisingPick'])->name('promisingpick.update');

Route::get('/breakoutbrand',[HomepageController::class,'showBreakoutBrands'])->name('breakoutbrand.index');
Route::get('breakoutbrand/create',[HomepageController::class,'createBreakoutBrand'])->name('breakoutbrand.create');
Route::post('breakoutbrand/store',[HomepageController::class,'storeBreakoutBrand'])->name('breakoutbrand.store');
Route::get('breakoutbrand/edit/{id?}',[HomepageController::class,'editBreakoutBrand'])->name('breakoutbrand.edit');
Route::post('breakoutbrand/update/{id}',[HomepageController::class,'updateBreakoutBrand'])->name('breakoutbrand.update');

Route::get('/spotlight',[HomepageController::class,'showSpotlightcats'])->name('spotlight.index');
Route::get('spotlight/edit/{id?}',[HomepageController::class,'editSpotlightcat'])->name('spotlight.edit');
Route::post('spotlight/update/{id}',[HomepageController::class,'updateSpotlightcat'])->name('spotlight.update');
Route::get('/spotlightproduct/{id?}',[HomepageController::class,'showSpotlightCatPrdcs'])->name('spotlightproduct.index');
Route::get('/spotlightproduct/edit/{id?}',[HomepageController::class,'editSpotlightCatPrd'])->name('spotlightproduct.edit');
Route::get('/spotlightproduct/create/{id?}',[HomepageController::class,'createSpotlightCatPrd'])->name('spotlightproduct.create');
Route::post('/spotlightproduct/update/{id}',[HomepageController::class,'updateSpotlightCatPrd'])->name('spotlightproduct.update');
Route::post('/spotlightproduct/store',[HomepageController::class,'storeSpotlightCatPrd'])->name('spotlightproduct.store');

Route::get('/trending',[HomepageController::class,'showTrendings'])->name('trending.index');
Route::get('trending/edit/{id?}',[HomepageController::class,'editTrending'])->name('trending.edit');
Route::post('trending/update/{id}',[HomepageController::class,'updateTrending'])->name('trending.update');
Route::get('/trendingproduct/{id?}',[HomepageController::class,'showTrendingProducts'])->name('trendingproduct.index');
Route::get('/trendingproduct/edit/{id?}',[HomepageController::class,'editTrendingProduct'])->name('trendingproduct.edit');
Route::get('/trendingproduct/create/{id?}',[HomepageController::class,'createTrendingProduct'])->name('trendingproduct.create');
Route::post('/trendingproduct/update/{id}',[HomepageController::class,'updateTrendingProduct'])->name('trendingproduct.update');
Route::post('/trendingproduct/store',[HomepageController::class,'storeTrendingProduct'])->name('trendingproduct.store');

Route::get('/liketrending',[HomepageController::class,'showLikeTrendings'])->name('liketrending.index');
Route::get('liketrending/edit/{id?}',[HomepageController::class,'editLikeTrending'])->name('liketrending.edit');
Route::post('liketrending/update/{id}',[HomepageController::class,'updateLikeTrending'])->name('liketrending.update');
Route::get('/liketrendingproduct/{id?}',[HomepageController::class,'showLikeTrendingProducts'])->name('liketrendingproduct.index');
Route::get('/liketrendingproduct/edit/{id?}',[HomepageController::class,'editLikeTrendingProduct'])->name('liketrendingproduct.edit');
Route::get('/liketrendingproduct/create/{id?}',[HomepageController::class,'createLikeTrendingProduct'])->name('liketrendingproduct.create');
Route::post('/liketrendingproduct/update/{id}',[HomepageController::class,'updateLikeTrendingProduct'])->name('liketrendingproduct.update');
Route::post('/liketrendingproduct/store',[HomepageController::class,'storeLikeTrendingProduct'])->name('liketrendingproduct.store');

/*  Abouts us routes */
Route::get('/aboutus', [AboutusController::class, 'index'])->name('aboutus.home');
Route::get('/showaboutus',[AboutusController::class,'showAboutus'])->name('aboutus.index');
Route::get('showaboutus/edit/{id?}',[AboutusController::class,'editAboutus'])->name('aboutus.edit');
Route::post('showaboutus/update/{id}',[AboutusController::class,'updateAboutus'])->name('aboutus.update');
Route::get('/showaboutusprofile',[AboutusController::class,'showAboutusProfile'])->name('aboutusprofile.index');
Route::get('showaboutusprofile/edit/{id?}',[AboutusController::class,'editAboutusProfile'])->name('aboutusprofile.edit');
Route::post('showaboutusprofile/update/{id}',[AboutusController::class,'updateAboutusProfile'])->name('aboutusprofile.update');

/*  Contact us routes */
Route::get('/contactus', [ContactusController::class, 'index'])->name('contactus.home');
Route::get('/showcontactus',[ContactusController::class,'showContactus'])->name('contactus.index');
Route::get('showcontactus/edit/{id?}',[ContactusController::class,'editContactus'])->name('contactus.edit');
Route::post('showcontactus/update/{id}',[ContactusController::class,'updateContactus'])->name('contactus.update');
Route::get('/showcontactusimage',[ContactusController::class,'showContactusImage'])->name('contactusimage.index');
Route::get('showcontactusimage/edit/{id?}',[ContactusController::class,'editContactusImage'])->name('contactusimage.edit');
Route::post('showcontactusimage/update/{id}',[ContactusController::class,'updateContactusImage'])->name('contactusimage.update');

/*  Ourvalue page routes */
Route::get('/ourvalue', [OurvalueController::class, 'index'])->name('ourvalue.home');
Route::get('/showourvalue',[OurvalueController::class,'showOurvalue'])->name('ourvalue.index');
Route::get('showourvalue/edit/{id?}',[OurvalueController::class,'editOurvalue'])->name('ourvalue.edit');
Route::post('showourvalue/update/{id}',[OurvalueController::class,'updateOurvalue'])->name('ourvalue.update');

/*  Pages routes */
Route::get('/pages', [PageController::class, 'index'])->name('pages.index');
Route::get('/pages/create', [PageController::class, 'create'])->name('pages.create');
Route::post('/pages/store', [PageController::class, 'store'])->name('pages.store');
Route::get('/pages/edit/{id?}', [PageController::class, 'edit'])->name('pages.edit');
Route::post('/pages/update/{id}', [PageController::class, 'update'])->name('pages.update');

});

/* customer routes */
Route::get('/sign-up',[UserController::class,'showSignupForm'])->name('customer.sign-up');
Route::get('/log-in',[UserController::class,'showLoginForm'])->name('customer.log-in');
Route::post('/signup',[UserController::class,'signUp'])->name('customer.signup');
Route::post('/signin',[UserController::class,'signIn'])->name('customer.signin');
Route::get('/logout',[UserController::class,'logout'])->name('customer.logout');






Route::group(['prefix' => 'customer'], function () {
    Route::group(['middleware' => ['web', 'auth']], function() {
        Route::get('/dashborad',[UserController::class,'index'])->name('customer.dashboard');
        Route::get('/customer-orders',[UserController::class,'orderDetails'])->name('customer.orders');
        Route::get('/orders-history',[UserController::class,'getOrderHistory']);
        Route::get('/profile',[UserController::class,'showprofile'])->name('customer.profile');
        Route::post('/profile/update/{id}',[UserController::class,'updateprofile'])->name('customer.update');
        Route::post('/address/add/{id}',[UserController::class,'addAddress'])->name('address.add');
        Route::post('/address/update',[UserController::class,'updateAddress'])->name('address.update');

    });
});


/*  Pages routes for FrontEnd*/
Route::get('/pages/{name}', [PageController::class, 'show'])->name('pages.show');
Route::get('/404', function () {
    return abort(404);
})->name('404');


Route::group(['prefix' => 'product'], function () {
        Route::get('/favorite',[FavoriteController::class,'index']);
        Route::get('/product-category_id',[ProductsController::class,'categoryIdWiseProducts'])->name('product.product-category_id');

    Route::get('/product-list/{category_slug?}',[ProductsController::class,'showProductList'])->name('product.product-list');
    Route::get('/product-details/{category_slug?}',[ProductsController::class,'showProductDetails'])->name('product.product-details');
    Route::get('/get_product_details',[ProductsController::class,'getProductDetails']);
});


