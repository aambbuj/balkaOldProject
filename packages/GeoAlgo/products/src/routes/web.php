<?php

use Illuminate\Support\Facades\Route;

use GeoAlgo\Products\Http\Controllers\VendorController;
use GeoAlgo\Products\Http\Controllers\CategoryController;
use GeoAlgo\Products\Http\Controllers\BrandController;
use GeoAlgo\Products\Http\Controllers\ProductController;
use GeoAlgo\Products\Http\Controllers\ExportController;
use GeoAlgo\Products\Http\Controllers\ItemController;
use GeoAlgo\Products\Http\Controllers\OrderController;
use GeoAlgo\Products\Http\Controllers\AttributeController;
use GeoAlgo\Products\Http\Controllers\CartController;
use GeoAlgo\Products\Http\Controllers\SizeChartController;
use GeoAlgo\Products\Http\Controllers\SettingController;
use GeoAlgo\Products\Http\Controllers\SpecificationController;
use GeoAlgo\Products\Http\Controllers\ValueIconController;
use App\Http\Controllers\API\LoginController;


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
Route::group(['middleware' => ['web', 'auth']], function() {
	// Route::get('/product', function () {
	//     return 'product';
	// });

    //////////////////// Routes for Category /////////////////
	/*Route::resource('category', CategoryController::class);*/
  	Route::get('category', [CategoryController::class,'index'])->name('category.index');
  	Route::get('category/edit/{id?}', [CategoryController::class,'edit'])->name('category.edit');
    Route::post('category/create', [CategoryController::class,'create'])->name('category.create');
  	Route::post('category/create-subCategory', [CategoryController::class,'createSubCategory'])->name('category.create-subCategory');
  	Route::post('category/parent-cat-store', [CategoryController::class,'parentCatStore'])->name('category.parent-cat-store');
  	Route::post('category/store', [CategoryController::class,'store'])->name('category.store');
  	Route::post("category/list", [CategoryController::class, "list"])->name("category.list");
	Route::post("category/list/parent", [CategoryController::class, "list_parent"])->name("category.list.parent");
	Route::post("category/list/parent/category", [CategoryController::class, "list_parent_category"])->name("category.list.parent.category");
	Route::post("category/list/relation", [CategoryController::class, "list_relation"])->name("category.list.relation");
    Route::post("category/delete/{id?}", [CategoryController::class, "delete"])->name("category.delete");
    Route::post("category/create-attribute-values", [CategoryController::class, "createAttributeValues"])->name("category.create-attribute-values");
    Route::post("category/store-attribute-value", [CategoryController::class, "storeAttributeValue"])->name("category.store-attribute-value");
	Route::post('category/add/attribute/list', [CategoryController::class,'add_list_attribute'])->name('category.add.attribute.list');
	Route::post('category/add/attribute/filter', [CategoryController::class,'add_filter_attribute'])->name('category.add.attribute.filter');
	Route::post('category/add/attribute/filter/list', [CategoryController::class,'add_filter_attribute_list'])->name('category.add.attribute.filter.list');
	Route::post('category/add/attribute/filter/store', [CategoryController::class,'add_filter_attribute_store'])->name('category.add.attribute.filter.store');
    Route::post('category/add/attribute/filter/deleted', [CategoryController::class,'add_filter_attribute_delete'])->name('category.add.attribute.filter.delete');

    Route::post('category/add/attribute/values/list/data', [CategoryController::class,'add_list_attribute_values'])->name('category.add.attribute.list.values');
    Route::post('category/add/attribute/values', [CategoryController::class,'add_values_attribute'])->name('category.add.attribute.values');
    Route::post('category/add/attribute/values/list', [CategoryController::class,'add_values_attribute_list'])->name('category.add.attribute.values.list');
	Route::post('category/add/attribute/values/store', [CategoryController::class,'add_values_attribute_store'])->name('category.add.attribute.values.store');
    Route::post('category/add/attribute/values/delete', [CategoryController::class,'add_values_attribute_delete'])->name('category.add.attribute.values.delete');

	Route::get('brand', [BrandController::class,'index'])->name('brand.index');
	Route::post('brand/create', [BrandController::class,'create'])->name('brand.create');
	Route::post('brand/store', [BrandController::class,'store'])->name('brand.store');
	Route::post("brand/list", [BrandController::class, "list"])->name("brand.list");
  	Route::post("brand/delete/{id?}", [BrandController::class, "delete"])->name("brand.delete");


    Route::get('settings', [SettingController::class,'index'])->name('settings.index');
    Route::get('vendor/settings', [SettingController::class,'vendor_index'])->name('settings.vendor.index');
    Route::post('vendor/settings/store', [SettingController::class,'vendor_store'])->name('settings.vendor.store');
    // Route::post('settings/specification/save', [SettingController::class,'save'])->name('settings.specification.index');

	Route::get('/edit-profile',[BrandController::class,'editProfile'])->name('edit-profile');
	Route::post('profile/store', [BrandController::class,'profileStore'])->name('profile.store');


    // SpecificationController
    Route::post('secification/create', [SpecificationController::class,'create'])->name('secification.create');
    Route::post('secification/store', [SpecificationController::class,'store'])->name('secification.store');
    Route::post("secification/list", [SpecificationController::class, "list"])->name("secification.list");
    Route::post("secification/delete", [SpecificationController::class, "delete"])->name("secification.delete");

	// Route::post('category/edit/{id?}', [CategoryController::class,'edit'])->name('category.edit');
	// Route::post('category/update/{id}', [CategoryController::class,'update'])->name('category.update');
	// Route::get('category/delete/{id}', [CategoryController::class,'delete'])->name('category.delete');
    Route::get('size_chart', [SizeChartController::class,'index'])->name('size_chart.index');
    Route::post('size_chart', [SizeChartController::class,'store'])->name('size_chart.store');

	Route::get('coupone', [CartController::class,'index'])->name('coupone.index');
	Route::post('coupone/create', [CartController::class,'create'])->name('coupone.create');
	Route::post('coupone/store', [CartController::class,'store'])->name('coupone.store');
	Route::post("coupone/list", [CartController::class, "list"])->name("coupone.list");
	Route::post("coupone/delete/{id?}", [CartController::class, "delete"])->name("coupone.delete");
	Route::get("coupone/get_product/{id?}", [CartController::class, "getProduct"])->name("coupone.get_product");


	  // Route::post('category/edit/{id?}', [CategoryController::class,'edit'])->name('category.edit');
	  // Route::post('category/update/{id}', [CategoryController::class,'update'])->name('category.update');
	  // Route::get('category/delete/{id}', [CategoryController::class,'delete'])->name('category.delete');

    ////////////////////// Routes for Subcategory /////////////////

  	Route::get('category/{id?}', [CategoryController::class,'subcatShow'])->name('subcategory');
  	Route::post("subcategory/list", [CategoryController::class, "sublist"])->name("subcategory.list");
  	Route::post('subcategory/create', [CategoryController::class,'createsub'])->name('subcategory.create');
  	Route::post('subcategory/store', [CategoryController::class,'storesub'])->name('subcategory.store');


     ///////////////////// Routes for Products /////////////////////
	  Route::get('product', [ProductController::class,'index'])->name('product.index');
	  Route::post("product/list", [ProductController::class, "list"])->name("product.list");
	  Route::get('product/create', [ProductController::class,'create'])->name('product.create');
	  Route::post('product/store', [ProductController::class,'store'])->name('product.store');
	  Route::post('product/attribute', [ProductController::class,'addAttribute'])->name('product.attribute');
	  Route::get('product/edit/{id?}', [ProductController::class,'edit'])->name('product.edit');
	  Route::post('product/update', [ProductController::class,'update'])->name('product.update');
	  Route::post('product/delete/{id?}', [ProductController::class,'delete'])->name('product.delete');
	   Route::post('product/addqty', [ProductController::class,'addQty'])->name('product.addqty');
	   Route::post('product/qtystore', [ProductController::class,'qtyStore'])->name('product.qtystore');
       Route::post('product/category/select/list', [ProductController::class,'category_select_list'])->name('product.category.select.list');

	   Route::post('product/add-attributs', [AttributeController::class,'addAttributs'])->name('product.add-attributs');
	   Route::post('product/add-attributs-image', [ProductController::class,'addAttributsImagePrice'])->name('product.add-attributs-image');
	   Route::post('product/product-attribute-value', [ProductController::class,'updateProductAttributeValue'])->name('product.product-attribute-value');

	//    Export Controller
		
	Route::post('product/export/sample_product', [ExportController::class,'exportBulkProductFormat'])->name('product.sample.export');
	Route::get('product/export/sample_product', [ExportController::class,'exportBulkProductFormat'])->name('product.sample.export.get');

///////////////////// Routes for Product attributes /////////////////////
	  Route::get('attribute', [AttributeController::class,'index'])->name('attribute.index');
	  Route::post("attribute/list", [AttributeController::class, "list"])->name("attribute.list");
	  Route::post("attribute/create", [AttributeController::class, "create"])->name("attribute.create");
      Route::post("attribute/delete", [AttributeController::class, "delete"])->name("attribute.delete");
	  Route::post("attribute/store", [AttributeController::class, "store"])->name("attribute.store");
      Route::get("attribute/value/{id?}", [AttributeController::class, "getValue"])->name("attribute.getValue");
      Route::post("attribute/value/list/{id?}", [AttributeController::class, "getValueList"])->name("attribute.getValueList");
      Route::post("attribute/value/edit", [AttributeController::class, "editValue"])->name("attribute.editValue");
      Route::post("attribute/value/delete", [AttributeController::class, "deleteValue"])->name("attribute.deleteValue");
	  Route::post("attribute/value/{id?}", [AttributeController::class, "addValue"])->name("attribute.value");
	   Route::post("attribute/storeValue", [AttributeController::class, "storeValue"])->name("attribute.storeValue");
/*Route::get("list", [AttributeController::class, "list"])->name("attribute.list");*/

        Route::get('value_icons', [ValueIconController::class,'index'])->name('value_icons.index');
        Route::post("value_icons/list", [ValueIconController::class, "list"])->name("value_icons.list");
        Route::post("value_icons/list/selected", [ValueIconController::class, "list_selected"])->name("value_icons.list.selected");
        Route::post("value_icons/create", [ValueIconController::class, "create"])->name("value_icons.create");
        Route::post("value_icons/delete", [ValueIconController::class, "delete"])->name("value_icons.delete");
        Route::post("value_icons/store", [ValueIconController::class, "store"])->name("value_icons.store");


     //////////////////// Routes for Inventory ////////////////////
	  Route::get('inventory', [ItemController::class,'index'])->name('inventory.index');
	  Route::post("inventory/list", [ItemController::class, "list"])->name("inventory.list");
	  Route::post("inventory/create", [ItemController::class, "create"])->name("inventory.create");
	  Route::post("inventory/store", [ItemController::class, "store"])->name("inventory.store");
	  Route::post("inventory/delete/{id?}", [ItemController::class, "delete"])->name("inventory.delete");

	 ////////////////// Routes for Orders ///////////////////////
	  Route::get('order/received', [OrderController::class,'receivedOrders'])->name('order.received');
	  Route::post('order/list', [OrderController::class,'list'])->name('order.list');
	  Route::post('order/assign/{id?}', [OrderController::class,'orderAssign'])->name('order.assign');
	  Route::post('order/assign_store', [OrderController::class,'assignOrderStore'])->name('order.assign_store');
	  Route::post('order/acceptOrder', [OrderController::class,'acceptOrder'])->name('order.acceptOrder');

	  ////////////////// Routes for Orders ///////////////////////
     Route::get('invoice', [OrderController::class,'showCompanies'])->name('invoice.index');
     Route::get('invoice/get/{id?}', [OrderController::class,'orderInvoices'])->name('invoice.get');
     Route::get('invoice/show/{id?}', [OrderController::class,'showInvoice'])->name('invoice.show');

	 //////////////////////////    Vendor Section /////////////////////////////////////////

	Route::get('/vendor', [VendorController::class, 'show'])->name('vendor.show');
	Route::post('/vendor-store', [VendorController::class, 'store'])->name('vendor.store');

});



 /////////Routs For Api //////////////////////////////////////////////////////////////

//  Route::group(['prefix' => 'auth'], function () {
// 	Route::post('login', [LoginController::class,'login']);
//     Route::post('register', [LoginController::class, 'register']);
// });


 Route::group(['prefix' => 'order'], function () {

    Route::middleware('auth:api')->group(function () {
		Route::get('order', [OrderController::class,'getAllOrders']);
        Route::get('get-orders/{id?}/{uid?}', [OrderController::class,'getOrders']);
        Route::post('store', [OrderController::class,'store']);
        Route::get('delete/{order_id?}', [OrderController::class,'delete']);
        Route::post('delivered-order', [OrderController::class,'deliveredOrder']);
		Route::post('pending-order', [OrderController::class,'pendingOrder']);
		 //order details manage routes ........
		Route::get('delete-order-details/{order_details_id?}', [OrderController::class,'deleteOrderDetails']);
		Route::post('delivered-order-details', [OrderController::class,'deliveredOrderDetails']);
		 Route::post('pending-order-details', [OrderController::class,'pendingOrderDetails']);

	});
});



/*Route::group(['prefix' => 'bar-owner'], function () {

    Route::middleware('auth:api')->group(function () {
		Route::get('purchase', [OrderController::class,'getRecentPurchase']);

	});
});*/

