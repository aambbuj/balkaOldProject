<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use \GeoAlgo\Products\Models\Category;
use \GeoAlgo\Products\Models\CategoryRelation;
use App\Models\Cart;
use Session;
use Illuminate\Support\Facades\Cookie;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // $machin_ip = getHostByName(getHostName()); //////Get machin Ip Address////////////////
        // $carts  = Cart::where('machin_ip',$machin_ip)->get();
        // $cart_data=[];
        //     foreach ($carts as $key => $cart) {
        //         $item_array = array(
        //         'item_id' => $cart->id,
        //         'user_id' => $cart->user_id,
        //         'vendor_id' => $cart->vendor_id,
        //          'product_id' => $cart->id,
        //          'machin_ip' => $cart->machin_ip,
        //          'category_id' => $cart->category_id,
        //          'attribute_id' => $cart->attribute_id,
        //          'attribute_value_id' => $cart->attribute_value_id,
        //          'total_price' => $cart->total_price,
        //          'product_name' => $cart->product_name,
        //          'created_by' => $cart->created_by,
        //          'qty' => $cart->qty,
        //          'price' => $cart->price,
        //          'image' => $cart->image
        //         );
        //         $cart_data[] = $item_array;
        //         // unset($item_array['item_id']);
        //         $item_data = json_encode($cart_data);
        //         $minutes = time() + (10 * 365 * 24 * 60 * 60);
        //         Cookie::queue(Cookie::make('shopping_cart', $item_data,$minutes));
        //        // return true;
        //     }



        view()->composer('layouts.frontend.partials.header', function($view){
           $Men =  CategoryRelation::where("type_id", 1)->whereNull("category_parent_id")->with("getName")->with('childRecursive')->get();
           $Women =  CategoryRelation::where("type_id", 2)->whereNull("category_parent_id")->with("getName")->with('childRecursive')->get();
           $Unisex =  CategoryRelation::where("type_id", 3)->whereNull("category_parent_id")->with("getName")->with('childRecursive')->get();
           $Beuty =  CategoryRelation::where("type_id", 4)->whereNull("category_parent_id")->with("getName")->with('childRecursive')->get();
           $categories['Men']=$Men;
           $categories['Women']=$Women;
           $categories['Unisex']=$Unisex;
           $categories['Beuty']=$Beuty;
            $view->with('categories',$categories);
        });
        //
    }
}
