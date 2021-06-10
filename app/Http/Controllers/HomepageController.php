<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomepageSetting;
use App\Models\Spotlight;
use App\Models\SpotlightProduct;
use App\Models\Trending;
use App\Models\TrendingProduct;
use App\Models\Slider;
use App\Models\Discover;
use App\Models\LikeTrending;
use App\Models\LikeTrendingProduct;
use App\Models\BeakoutBrand;
use App\Models\PopularProduct;
use App\Models\PromisingPick;
use GeoAlgo\Products\Models\Product;
use GeoAlgo\Products\Models\Brand;
use GeoAlgo\Products\Models\Category;
use DB;
use Validator;


class HomepageController extends Controller
{
    public function index()
    {
        // $banners = HomepageSetting::whereIn('id',[1,2,3])->get();
        $banners = HomepageSetting::where('deleted',0)->get();
        $spotlights = Spotlight::where('deleted',0)->with('category','products')->get();
        $trendings = Trending::where('deleted',0)->with('products')->get();
        $sliders = Slider::where('deleted',0)->with('product')->inRandomOrder()->limit(10)->get();
        $discovers = Discover::where('deleted',0)->get();
        $liketrendings = LikeTrending::where('deleted',0)->with('products')->get();
        $beakoutbrands = BeakoutBrand::where('deleted',0)->with('brand')->get();
        $popularproducts = PopularProduct::where('deleted',0)->with('product')->get();
        $promisingpicks = PromisingPick::where('deleted',0)->with('product')->get();
        $brands = Brand::where('deleted',0)->inRandomOrder()->limit(10)->get();
      //  $data = Category::with('subCategories')->get()->toArray();
      //   echo "<pre>";
      //   print_r($data);die;
        
        return view('index',['banners'=>$banners, 'spotlights'=>$spotlights, 'trendings'=>$trendings, 'sliders'=>$sliders, 'discovers'=>$discovers, 'liketrendings'=>$liketrendings, 'beakoutbrands'=>$beakoutbrands, 'popularproducts'=>$popularproducts, 'promisingpicks'=>$promisingpicks]);
    }

    public function showBanners()
    {
        $banners = HomepageSetting::whereIn('id',[1,2,3])->get();
        return view('banner.index',['banners'=>$banners]);
    }

    public function editBanner($id = 0)
    {
        $banner=HomepageSetting::find($id);
        return view('banner.edit',['banner'=>$banner]);
    }

    public function updateBanner(Request $request,$id)
    {
       try {
                $validator = Validator::make($request->all(), [
                    'text1' => 'required|min:3|max:255|string',
                    'text2' => 'required|min:3|max:255|string',
                    'url' => 'required|min:3|max:255|string',
                    'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
                  ]);

                if ($validator->fails()) {
                  //return error_json($validator->errors()->first());
                  return redirect()->route('banner.edit', $id)->withErrors($validator)->withInput();
                }
                  $banner=HomepageSetting::find($id); 

                  if($request->hasfile('image'))
                  {
                      $imageName = time().'.'.$request->image->getClientOriginalExtension();
                      $request->image->move(public_path('theme/bannerimg'), $imageName);
                      $banner->image=$imageName;
                    }  

                    $banner->text1=$request->text1;
                    $banner->text2=$request->text2;
                    $banner->url=$request->url;
                    $banner->update();

                    return redirect()->route('banner.index')->withSuccess('You have successfully updated Banner section!');
                  
       } catch (\Throwable $th) {
        return error_json($th);
       }
    }

    public function showSpecifics()
    {
        $banners = HomepageSetting::whereIn('id',[5,6,7])->get();
        return view('specific.index',['banners'=>$banners]);
    }

    public function editSpecific($id = 0)
    {
        $banner=HomepageSetting::find($id);
        return view('specific.edit',['banner'=>$banner]);
    }

    public function updateSpecific(Request $request,$id)
    {
       try {
                $validator = Validator::make($request->all(), [
                    'text1' => 'required|min:3|max:255|string',
                    'url' => 'required|min:3|max:255|string',
                  ]);

                if ($validator->fails()) {
                  //return error_json($validator->errors()->first());
                  return redirect()->route('specific.edit', $id)->withErrors($validator)->withInput();
                }
                    $banner=HomepageSetting::find($id); 

                    $banner->text1=$request->text1;
                    $banner->url=$request->url;
                    $banner->update();

                    return redirect()->route('specific.index')->withSuccess('You have successfully updated Specific section!');
                  
       } catch (\Throwable $th) {
        return error_json($th);
       }
    }

    public function showMotivation()
    {
        $banners = HomepageSetting::where('id',8)->get();
        return view('motivation.index',['banners'=>$banners]);
    }

    public function editMotivation($id = 0)
    {
        $banner=HomepageSetting::find($id);
        return view('motivation.edit',['banner'=>$banner]);
    }

    public function updateMotivation(Request $request,$id)
    {
       try {
                $validator = Validator::make($request->all(), [
                    'text1' => 'required|min:3|max:255|string',
                    'text2' => 'required|min:3|max:255|string',
                    'url' => 'required|min:3|max:255|string',
                    'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:width=1280,height=537'
                  ]);

                if ($validator->fails()) {
                  //return error_json($validator->errors()->first());
                  return redirect()->route('motivation.edit', $id)->withErrors($validator)->withInput();
                }
                  $banner=HomepageSetting::find($id); 

                  if($request->hasfile('image'))
                  {
                      $imageName = time().'.'.$request->image->getClientOriginalExtension();
                      $request->image->move(public_path('theme/motivationimg'), $imageName);
                      $banner->image=$imageName;
                    }  

                    $banner->text1=$request->text1;
                    $banner->text2=$request->text2;
                    $banner->url=$request->url;
                    $banner->update();

                    return redirect()->route('motivation.index')->withSuccess('You have successfully updated Motivation section!');
                  
       } catch (\Throwable $th) {
        return error_json($th);
       }
    }

    public function showSliders()
    {
        $sliders = Slider::where('deleted',0)->with('product')->get();
        return view('slider.index',['sliders'=>$sliders]);
    }
    
    public function createSlider()
    {
        $products=Product::where('deleted',0)->get();
        return view('slider.create',['products'=>$products]);
    }

    public function storeSlider(Request $request)
    {
       try {
                $validator = Validator::make($request->all(), [
                    'product_id' => 'required|numeric',
                  ]);

                if ($validator->fails()) {
                  //return error_json($validator->errors()->first());
                  return redirect()->route('slider.create')->withErrors($validator)->withInput();
                }
                   $slider= new Slider();

                    $slider->product_id=$request->product_id;
                    $slider->save();

                    return redirect()->route('slider.index')->withSuccess('You have successfully added the product in Slider section!');
                  
       } catch (\Throwable $th) {
        return error_json($th);
       }
    }

    public function editSlider($id = 0)
    {
        $slider=Slider::find($id);
        $products=Product::where('deleted',0)->get();
        return view('slider.edit',['slider'=>$slider, 'products'=>$products]);
    }

    public function updateSlider(Request $request,$id)
    {
       try {
                $validator = Validator::make($request->all(), [
                    'product_id' => 'required|numeric',
                  ]);

                if ($validator->fails()) {
                  //return error_json($validator->errors()->first());
                  return redirect()->route('slider.edit', $id)->withErrors($validator)->withInput();
                }
                   $slider=Slider::find($id);

                    $slider->product_id=$request->product_id;
                    $slider->update();

                    return redirect()->route('slider.index')->withSuccess('You have successfully updated Slider section!');
                  
       } catch (\Throwable $th) {
        return error_json($th);
       }
    }

    public function showDiscovers()
    {
        $discovers = Discover::where('deleted',0)->get();
        return view('discover.index',['discovers'=>$discovers]);
    }

    public function editDiscover($id = 0)
    {
        $discover=Discover::find($id);
        return view('discover.edit',['discover'=>$discover]);
    }

    public function updateDiscover(Request $request,$id)
    {
       try {
                $validator = Validator::make($request->all(), [
                    'text1' => 'required|min:3|max:255|string',
                    'text2' => 'required|min:3|max:255|string',
                    'desktoptext' => 'required|min:3|max:255|string',
                    'desktopurl' => 'required|min:3|max:255|string',
                    'mobiletext' => 'required|min:3|max:255|string',
                    'mobileurl' => 'required|min:3|max:255|string',
                  ]);

                if ($validator->fails()) {
                  //return error_json($validator->errors()->first());
                  return redirect()->route('discover.edit', $id)->withErrors($validator)->withInput();
                }
                    $discover=Discover::find($id); 

                    $discover->text1=$request->text1;
                    $discover->text2=$request->text2;
                    $discover->desktoptext=$request->desktoptext;
                    $discover->desktopurl=$request->desktopurl;
                    $discover->mobiletext=$request->mobiletext;
                    $discover->mobileurl=$request->mobileurl;
                    $discover->update();

                    return redirect()->route('discover.index')->withSuccess('You have successfully updated Discover section!');
                  
       } catch (\Throwable $th) {
        return error_json($th);
       }
    }

    public function showPopularProducts()
    {
        $popularproducts = PopularProduct::where('deleted',0)->with('product')->get();
        return view('popularproduct.index',['popularproducts'=>$popularproducts]);
    }
    
    public function createPopularProduct()
    {
        $products=Product::where('deleted',0)->get();
        return view('popularproduct.create',['products'=>$products]);
    }

    public function storePopularProduct(Request $request)
    {
       try {
                $validator = Validator::make($request->all(), [
                    'product_id' => 'required|numeric',
                  ]);

                if ($validator->fails()) {
                  //return error_json($validator->errors()->first());
                  return redirect()->route('popularproduct.create')->withErrors($validator)->withInput();
                }
                   $popularproduct= new PopularProduct();

                    $popularproduct->product_id=$request->product_id;
                    $popularproduct->save();

                    return redirect()->route('popularproduct.index')->withSuccess('You have successfully added the product in Popular Product section!');
                  
       } catch (\Throwable $th) {
        return error_json($th);
       }
    }

    public function editPopularProduct($id = 0)
    {
        $popularproduct=PopularProduct::find($id);
        $products=Product::where('deleted',0)->get();
        return view('popularproduct.edit',['popularproduct'=>$popularproduct, 'products'=>$products]);
    }

    public function updatePopularProduct(Request $request,$id)
    {
       try {
                $validator = Validator::make($request->all(), [
                    'product_id' => 'required|numeric',
                  ]);

                if ($validator->fails()) {
                  //return error_json($validator->errors()->first());
                  return redirect()->route('popularproduct.edit', $id)->withErrors($validator)->withInput();
                }
                   $popularproduct=PopularProduct::find($id);

                    $popularproduct->product_id=$request->product_id;
                    $popularproduct->update();

                    return redirect()->route('popularproduct.index')->withSuccess('You have successfully updated Popular Product section!');
                  
       } catch (\Throwable $th) {
        return error_json($th);
       }
    }
     
    public function showPromisingPicks()
    {
        $promisingpicks = PromisingPick::where('deleted',0)->with('product')->get();
        return view('promisingpick.index',['promisingpicks'=>$promisingpicks]);
    }
    
    public function createPromisingPick()
    {
        $products=Product::where('deleted',0)->get();
        return view('promisingpick.create',['products'=>$products]);
    }

    public function storePromisingPick(Request $request)
    {
       try {
                $validator = Validator::make($request->all(), [
                    'product_id' => 'required|numeric',
                  ]);

                if ($validator->fails()) {
                  //return error_json($validator->errors()->first());
                  return redirect()->route('promisingpick.create')->withErrors($validator)->withInput();
                }
                   $promisingpick= new PromisingPick();

                    $promisingpick->product_id=$request->product_id;
                    $promisingpick->save();

                    return redirect()->route('promisingpick.index')->withSuccess('You have successfully added the product in Promising Pick section!');
                  
       } catch (\Throwable $th) {
        return error_json($th);
       }
    }

    public function editPromisingPick($id = 0)
    {
        $promisingpick=PromisingPick::find($id);
        $products=Product::where('deleted',0)->get();
        return view('promisingpick.edit',['promisingpick'=>$promisingpick, 'products'=>$products]);
    }

    public function updatePromisingPick(Request $request,$id)
    {
       try {
                $validator = Validator::make($request->all(), [
                    'product_id' => 'required|numeric',
                  ]);

                if ($validator->fails()) {
                  //return error_json($validator->errors()->first());
                  return redirect()->route('promisingpick.edit', $id)->withErrors($validator)->withInput();
                }
                   $promisingpick=PromisingPick::find($id);

                    $promisingpick->product_id=$request->product_id;
                    $promisingpick->update();

                    return redirect()->route('promisingpick.index')->withSuccess('You have successfully updated Promising Pick section!');
                  
       } catch (\Throwable $th) {
        return error_json($th);
       }
    }

    public function showBreakoutBrands()
    {
        $breakoutbrands = BeakoutBrand::where('deleted',0)->with('brand')->get();
        return view('breakoutbrand.index',['breakoutbrands'=>$breakoutbrands]);
    }
    
    public function createBreakoutBrand()
    {
        $brands=Brand::where('deleted',0)->get();
        return view('breakoutbrand.create',['brands'=>$brands]);
    }

    public function storeBreakoutBrand(Request $request)
    {
       try {
                $validator = Validator::make($request->all(), [
                    'brand_id' => 'required|numeric|unique:beakout_brands,brand_id',
                  ]);

                if ($validator->fails()) {
                  //return error_json($validator->errors()->first());
                  return redirect()->route('breakoutbrand.create')->withErrors($validator)->withInput();
                }
                   $breakoutbrand= new BeakoutBrand();

                    $breakoutbrand->brand_id=$request->brand_id;
                    $breakoutbrand->save();

                    return redirect()->route('breakoutbrand.index')->withSuccess('You have successfully added the brand in Breakout Brand section!');
                  
       } catch (\Throwable $th) {
        return error_json($th);
       }
    }

    public function editBreakoutBrand($id = 0)
    {
        $breakoutbrand=BeakoutBrand::find($id);
        $brands=Brand::where('deleted',0)->get();
        return view('breakoutbrand.edit',['breakoutbrand'=>$breakoutbrand, 'brands'=>$brands]);
    }

    public function updateBreakoutBrand(Request $request,$id)
    {
       try {
                $validator = Validator::make($request->all(), [
                    'brand_id' => 'required|numeric',
                  ]);

                if ($validator->fails()) {
                  //return error_json($validator->errors()->first());
                  return redirect()->route('breakoutbrand.edit', $id)->withErrors($validator)->withInput();
                }
                   $breakoutbrand=BeakoutBrand::find($id);

                    $breakoutbrand->brand_id=$request->brand_id;
                    $breakoutbrand->update();

                    return redirect()->route('breakoutbrand.index')->withSuccess('You have successfully updated Breakout Brand section!');
                  
       } catch (\Throwable $th) {
        return error_json($th);
       }
    }

    public function showSpotlightcats()
    {
        $spotlights = Spotlight::where('deleted',0)->with('category','products')->get();
        return view('spotlight.index',['spotlights'=>$spotlights]);
    }

    public function editSpotlightcat($id = 0)
    {
        $spotlight=Spotlight::find($id);
        $categories=Category::where('deleted',0)->get();
        return view('spotlight.edit',['spotlight'=>$spotlight, 'categories'=>$categories]);
    }

    public function updateSpotlightcat(Request $request,$id)
    {
       try {
                $validator = Validator::make($request->all(), [
                    'category_id' => 'required|numeric',
                  ]);

                if ($validator->fails()) {
                  //return error_json($validator->errors()->first());
                  return redirect()->route('spotlight.edit', $id)->withErrors($validator)->withInput();
                }
                   $spotlight=Spotlight::find($id);

                    $spotlight->category_id=$request->category_id;
                    $spotlight->update();

                    return redirect()->route('spotlight.index')->withSuccess('You have successfully updated Spotlight section!');
                  
       } catch (\Throwable $th) {
        return error_json($th);
       }
    }

    public function showSpotlightCatPrdcs($id=0)
    {
      // print_r($id);die;
        $spotlightproducts =SpotlightProduct::where('category_id',$id)->with('product')->get();
        // echo "<pre>";
        // print_r($spotlightproducts[0]['category_id']);die;
        return view('spotlightproduct.index',['spotlightproducts'=>$spotlightproducts]);
    }
    
    public function createSpotlightCatPrd($id=0)
    {
        $category=Category::where('id',$id)->with('products')->first();
        return view('spotlightproduct.create',['category'=>$category,'id'=>$id]);
    }

    public function storeSpotlightCatPrd(Request $request)
    {
       try {
                $validator = Validator::make($request->all(), [
                    'product_id' => 'required|numeric',
                  ]);

                if ($validator->fails()) {
                  //return error_json($validator->errors()->first());
                  return redirect()->route('spotlightproduct.create',$request->category_id)->withErrors($validator)->withInput();
                }
                   $spotlightproduct= new SpotlightProduct();

                    $spotlightproduct->product_id=$request->product_id;
                    $spotlightproduct->category_id=$request->category_id;
                    $spotlightproduct->save();

                    return redirect()->route('spotlightproduct.index',[$spotlightproduct->category_id])->withSuccess('You have successfully added the product in Spotligt section!');
                  
       } catch (\Throwable $th) {
        return error_json($th);
       }
    }

    public function editSpotlightCatPrd($id = 0)
    {
        $spotlightproduct=SpotlightProduct::find($id);
        // echo "<pre>";
        // print_r($spotlightproduct);die;
        //$products=Product::where('deleted',0)->get();
        $category=Category::where('id',$spotlightproduct->category_id)->with('products')->first();
        // echo "<pre>";
        // print_r($category);die;
        return view('spotlightproduct.edit',['spotlightproduct'=>$spotlightproduct, 'category'=>$category]);
    }

    public function updateSpotlightCatPrd(Request $request,$id)
    {
       try {
                $validator = Validator::make($request->all(), [
                    'product_id' => 'required|numeric',
                  ]);

                if ($validator->fails()) {
                  //return error_json($validator->errors()->first());
                  return redirect()->route('spotlightproduct.edit', $id)->withErrors($validator)->withInput();
                }
                   $spotlightproduct=SpotlightProduct::find($id);

                    $spotlightproduct->product_id=$request->product_id;
                    $spotlightproduct->update();

                    return redirect()->route('spotlightproduct.index',[$spotlightproduct->category_id])->withSuccess('You have successfully updated Spotlight Product section!');
                  
       } catch (\Throwable $th) {
        return error_json($th);
       }
    }

    public function showTrendings()
    {
        $trendings = Trending::where('deleted',0)->with('products')->get();
        return view('trending.index',['trendings'=>$trendings]);
    }

    public function editTrending($id = 0)
    {
        $trending=Trending::find($id);
        return view('trending.edit',['trending'=>$trending]);
    }

    public function updateTrending(Request $request,$id)
    {
       try {
                $validator = Validator::make($request->all(), [
                    'text1' => 'required|min:3|max:255|string',
                    'text2' => 'required|min:3|max:255|string',
                    'url' => 'required|min:3|max:255|string',
                    'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
                  ]);

                if ($validator->fails()) {
                  //return error_json($validator->errors()->first());
                  return redirect()->route('trending.edit', $id)->withErrors($validator)->withInput();
                }
                  $trending=Trending::find($id); 

                  if($request->hasfile('image'))
                  {
                      $imageName = time().'.'.$request->image->getClientOriginalExtension();
                      $request->image->move(public_path('theme/trendingimg'), $imageName);
                      $trending->image=$imageName;
                    }  

                    $trending->text1=$request->text1;
                    $trending->text2=$request->text2;
                    $trending->url=$request->url;
                    $trending->update();

                    return redirect()->route('trending.index')->withSuccess('You have successfully updated Trending section!');
                  
       } catch (\Throwable $th) {
        return error_json($th);
       }
    }

    public function showLikeTrendings()
    {
        $liketrendings = LikeTrending::where('deleted',0)->with('products')->get();
        return view('liketrending.index',['liketrendings'=>$liketrendings]);
    }

    public function editLikeTrending($id = 0)
    {
        $liketrending=LikeTrending::find($id);
        return view('liketrending.edit',['liketrending'=>$liketrending]);
    }

    public function updateLikeTrending(Request $request,$id)
    {
       try {
                $validator = Validator::make($request->all(), [
                    'text' => 'required|min:3|max:255|string',
                    'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
                  ]);

                if ($validator->fails()) {
                  //return error_json($validator->errors()->first());
                  return redirect()->route('liketrending.edit', $id)->withErrors($validator)->withInput();
                }
                  $liketrending=LikeTrending::find($id); 

                  if($request->hasfile('image'))
                  {
                      $imageName = time().'.'.$request->image->getClientOriginalExtension();
                      $request->image->move(public_path('theme/liketrendingimg'), $imageName);
                      $liketrending->image=$imageName;
                    }  

                    $liketrending->text=$request->text;
                    $liketrending->update();

                    return redirect()->route('liketrending.index')->withSuccess('You have successfully updated Like Trending section!');
                  
       } catch (\Throwable $th) {
        return error_json($th);
       }
    }

    public function showTrendingProducts($id = 0)
    {
        $trendingproducts = TrendingProduct::where('trending_id',$id)->with('product')->get();
        // echo "<pre>";
        // print_r($trendingproducts);die;
        return view('trendingproduct.index',['trendingproducts'=>$trendingproducts]);
    }
    
    public function createTrendingProduct($id = 0)
    {
        $products=Product::where('deleted',0)->get();
        return view('trendingproduct.create',['products'=>$products,'id'=>$id]);
    }

    public function storeTrendingProduct(Request $request)
    {
       try {
                $validator = Validator::make($request->all(), [
                    'product_id' => 'required|numeric',
                  ]);

                if ($validator->fails()) {
                  //return error_json($validator->errors()->first());
                  return redirect()->route('trendingproduct.create')->withErrors($validator)->withInput();
                }
                   $trendingproduct= new TrendingProduct();

                    $trendingproduct->product_id=$request->product_id;
                    $trendingproduct->trending_id=$request->trending_id;
                    $trendingproduct->save();

                    return redirect()->route('trendingproduct.index')->withSuccess('You have successfully added the product in Trending Product section!');
                  
       } catch (\Throwable $th) {
        return error_json($th);
       }
    }

    public function editTrendingProduct($id = 0)
    {
        $trendingproduct=TrendingProduct::find($id);
        $products=Product::where('deleted',0)->get();
        return view('trendingproduct.edit',['trendingproduct'=>$trendingproduct, 'products'=>$products]);
    }

    public function updateTrendingProduct(Request $request,$id)
    {
       try {
                $validator = Validator::make($request->all(), [
                    'product_id' => 'required|numeric',
                  ]);

                if ($validator->fails()) {
                  //return error_json($validator->errors()->first());
                  return redirect()->route('trendingproduct.edit', $id)->withErrors($validator)->withInput();
                }
                   $trendingproduct=TrendingProduct::find($id);

                    $trendingproduct->product_id=$request->product_id;
                    $trendingproduct->update();

                    return redirect()->route('trendingproduct.index',[$trendingproduct->trending_id])->withSuccess('You have successfully updated Trending Product section!');
                  
       } catch (\Throwable $th) {
        return error_json($th);
       }
    }

    public function showLikeTrendingProducts($id = 0)
    {
        $liketrendingproducts = LikeTrendingProduct::where('like_trending_id',$id)->with('product')->get();
        // echo "<pre>";
        // print_r($trendingproducts);die;
        return view('liketrendingproduct.index',['liketrendingproducts'=>$liketrendingproducts]);
    }
    
    public function createLikeTrendingProduct($id = 0)
    {
        $products=Product::where('deleted',0)->get();
        return view('liketrendingproduct.create',['products'=>$products,'id'=>$id]);
    }

    public function storeLikeTrendingProduct(Request $request)
    {
       try {
                $validator = Validator::make($request->all(), [
                    'product_id' => 'required|numeric',
                  ]);

                if ($validator->fails()) {
                  //return error_json($validator->errors()->first());
                  return redirect()->route('liketrendingproduct.create')->withErrors($validator)->withInput();
                }
                   $trendingproduct= new LikeTrendingProduct();

                    $liketrendingproduct->product_id=$request->product_id;
                    $liketrendingproduct->like_trending_id=$request->like_trending_id;
                    $liketrendingproduct->save();

                    return redirect()->route('trendingproduct.index')->withSuccess('You have successfully added the product in Trending Product section!');
                  
       } catch (\Throwable $th) {
        return error_json($th);
       }
    }

    public function editLikeTrendingProduct($id = 0)
    {
        $liketrendingproduct=LikeTrendingProduct::find($id);
        $products=Product::where('deleted',0)->get();
        return view('liketrendingproduct.edit',['liketrendingproduct'=>$liketrendingproduct, 'products'=>$products]);
    }

    public function updateLikeTrendingProduct(Request $request,$id)
    {
       try {
                $validator = Validator::make($request->all(), [
                    'product_id' => 'required|numeric',
                  ]);

                if ($validator->fails()) {
                  //return error_json($validator->errors()->first());
                  return redirect()->route('liketrendingproduct.edit', $id)->withErrors($validator)->withInput();
                }
                   $liketrendingproduct=LikeTrendingProduct::find($id);

                    $liketrendingproduct->product_id=$request->product_id;
                    $liketrendingproduct->update();

                    return redirect()->route('trendingproduct.index',[$liketrendingproduct->trending_id])->withSuccess('You have successfully updated Trending Product section!');
                  
       } catch (\Throwable $th) {
        return error_json($th);
       }
    }
}
