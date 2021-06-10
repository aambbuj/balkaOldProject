<?php

namespace GeoAlgo\Products\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GeoAlgo\Products\Models\Category;
use GeoAlgo\Products\Models\Attribute;
use GeoAlgo\Products\Models\CategoryAttributeValue;
use GeoAlgo\Products\Models\CategoryRelation;
use GeoAlgo\Products\Models\CategoryAttributeFilter;
use GeoAlgo\Products\Models\AttributeValue;
use DB;
use Validator;
use DataTables;
use Log;
use Auth;

class CategoryController extends Controller
{
    public function index()
    {
        try {

              return view('products::category.index');

        } catch (\Exception $e) {
            return error_json($e);
        }
    }

    public function list()
    {
        try {
          $parentCategories = Category::where("deleted", 0)->whereNotNull("parent_id")->get();
          return DataTables::of($parentCategories)
            ->addIndexColumn()
            ->addColumn('types', function($row){
                $types_ids = explode(",", $row->parent_id);
                $typess = Category::where("deleted", 0)->whereIn("id", $types_ids)->select("name")->get()->pluck("name")->toArray();
                return implode(", ", $typess);
            })
            ->rawColumns(['types'])
            ->make(true);
        } catch (\Exception $e) {
            return error_json($e);
        }
    }

    public function list_parent(Request $request){
      try {

        // if(isset($request->tree) && $request->tree == true){
            // ->select("id", "name as text")
            // $parentCategories = Category::where("categories.deleted", 0)->whereNotNull("categories.parent_id")->where("categories.name", "LIKE", "%".$request->search."%")
            //     // ->leftJoin("category_relations", function($query) use($request){
            //     //     $query->where("category_relations.deleted", 0)->on("category_relations.category_id", "=", "categories.id");
            //     // })
            //     ->with("getParentCategories")
            //     // ->leftJoin("categories as ctype", "ctype.id", "=", "getParentCategories.type_id")
            //     ->select("categories.id", DB::raw("CONCAT(categories.name, ' - ') AS text"));
            // if(isset($request->type)){
            //     // $parentCategories = $parentCategories->whereRaw("find_in_set(".$request->type.", categories.parent_id)");
            //     $parentCategories = $parentCategories->where()
            // }

            $parentCategories = CategoryRelation::where("category_relations.deleted", 0)->with("getType");
            if(isset($request->type) && $request->type > 0){
                $parentCategories = $parentCategories->where("category_relations.type_id", $request->type);
            }
                // ->with(['getName' => function($query)use($request){
                //     $query->where("name", "LIKE", "%".$request->search."%");
                // }])->whereNotNull("get_name");
            if(isset($request->category_id) && $request->category_id > 0){
                $parentCategories = $parentCategories->where("category_id", "<>", $request->category_id);
            }
            $parentCategories = $parentCategories->with("parentRecursive")
                // ->with(["parentRecursive"=> function($query) use($request){
                //     $query->where("type_id", $request->type);
                // }])
                ->join("categories", "categories.id", "=", "category_relations.category_id")
                ->where("categories.name", "LIKE", "%".$request->search."%")->select("category_relations.*", "categories.name")->get()->toArray();

            // $parentCategories = $parentCategories->select("id", "get_name as text");
            // $parentCategories = $parentCategories->select("category_relations.id", "categories.name as text", "category_relations.category_id", "category_relations.category_parent_id", "category_relations.type_id");
            // $parentCategories = $parentCategories->get();

            // Log::error($parentCategories);
            $arr = array();
            foreach($parentCategories as $key => $value){
                $strr = $value["name"];
                if($value["parent_recursive"] != null){
                    array_walk_recursive($value["parent_recursive"], function($a, $b) use(&$strr){
                        if($b == "name"){
                            $strr = $strr . " - " . $a;
                        }
                    });
                }
                $arr[] = array("id"=>$value["id"], "text"=>$strr." - ".$value["get_type"]["name"]);
            }
            // Log::error($arr);
        // }else{

        // }

        // ->groupBy(["category_id", "type_id"])

        // $relations = CategoryRelation::where("category_relations.deleted", 0)->get();
        // $relations = Category::whereNotNull("parent_id")->get();
        // foreach($relations as $key=>$value){
        //     $this->update_category_relation($value->id);
        // }
        return success_json($arr, "List Populated");

      } catch (\Exception $e) {
          Log::error($e);
          return error_json($e);
      }
    }

    private function update_category_relation($category_id = null){
        try{
            $main_relations = CategoryRelation::where("category_id", $category_id)->get()->groupBy("type_id");
            foreach($main_relations as $keyy=>$valuee){
                foreach($valuee as $key=>$value){

                }
            }
            return true;
        }catch(\Exception $e){
            return false;
        }
    }

    private function category_relation_name($category_id = null, $type_id = null, $category_parent_id = null){
        try{
            $name = "";
            while($category_parent_id != 0 && $category_parent_id != null){
                $category = Category::find($category_parent_id);
                if($category->exists()){
                    $name = $name . ", " . $category->name;
                    $category_relation = CategoryRelation::where();
                }else{
                    $category_parent_id = null;
                }
            }
        }catch(\Exception $e){
            return false;
        }
    }

    public function list_parent_category(Request $request){
      try {
        $parentCategories_ids = CategoryRelation::where("category_relations.deleted", 0)->where("category_relations.category_id", $request->id)->where("category_relations.type_id", $request->type)->get()->pluck("category_parent_id")->toArray();
        $parentCategories = CategoryRelation::whereIn("category_relations.id", $parentCategories_ids)->leftJoin("categories", "categories.id", "=", "category_relations.category_id")->leftJoin("categories as a", "a.id", "=", "category_relations.type_id")->with("parentRecursive")->select("category_relations.*", "categories.name", "categories.description as description", "categories.id as idd", "categories.image as image", "categories.banner_image as banner_image", "a.name as types")->get()->toArray();

        $arr = array();
        foreach($parentCategories as $key => $value){
            $strr = $value["name"];
            if($value["parent_recursive"] != null){
                array_walk_recursive($value["parent_recursive"], function($a, $b) use(&$strr){
                    if($b == "name"){
                        $strr = $strr . " - " . $a;
                    }
                });
            }
            $arr[] = array("id"=>$value["id"], "text"=>$strr);
        }
        return success_json($arr, "List Populated");

      } catch (\Exception $e) {
          Log::error($e);
          return error_json($e);
      }
    }

    public function list_relation(Request $request){
      try {
        $category = Category::find($request->id);
        if($request->type == "parent"){
            $plucked_array = CategoryRelation::where("category_relations.category_id", $category->id)->whereNotNull("category_relations.category_parent_id")->where("category_relations.deleted", 0)->get()->pluck("category_parent_id")->toArray();

            $parentCategories = CategoryRelation::whereIn("category_relations.id", $plucked_array)->leftJoin("categories", "categories.id", "=", "category_relations.category_id")->leftJoin("categories as a", "a.id", "=", "category_relations.type_id")->with("parentRecursive")->select("category_relations.*", "categories.name", "categories.description as description", "categories.id as idd", "categories.image as image", "categories.banner_image as banner_image", "a.name as types")->get();
            return DataTables::of($parentCategories)
                ->addIndexColumn()
                ->addColumn('value_text', function($row){
                    // $relations = CategoryRelation::find($row->id)->with("parentRecursive")->get()->toArray();
                    $vals = $row->toArray();
                    $strr = $row->name;
                    if($vals["parent_recursive"] != null){
                        array_walk_recursive($vals["parent_recursive"], function($a, $b) use(&$strr){
                            if($b == "name"){
                                $strr = $strr . " - " . $a;
                            }
                        });
                    }else{

                    }
                    // Log::error($strr);
                    return $strr;
                })
                ->rawColumns(['value_text'])
                ->make(true);

        }else{
            // $parentCategories = CategoryRelation::where("category_relations.deleted", 0)->where("category_relations.category_parent_id", $category->id)->leftJoin("categories", "categories.id", "=", "category_relations.category_id")->select("categories.*")->groupBy("categories.id")->get();
            $plucked_array = CategoryRelation::where("category_relations.category_id", $category->id)->where("category_relations.deleted", 0)->get()->pluck("id")->toArray();

            $parentCategories = CategoryRelation::whereIn("category_relations.category_parent_id", $plucked_array)->leftJoin("categories", "categories.id", "=", "category_relations.category_id")->leftJoin("categories as a", "a.id", "=", "category_relations.type_id")->with("parentRecursive")->select("category_relations.*", "categories.name", "categories.id as idd", "categories.description as description", "categories.image as image", "categories.banner_image as banner_image", "a.name as types")->get();
            return DataTables::of($parentCategories)
                ->addIndexColumn()
                ->addColumn('value_text', function($row){
                    // $relations = CategoryRelation::find($row->id)->with("parentRecursive")->get()->toArray();
                    $vals = $row->toArray();
                    $strr = $row->name;
                    if($vals["parent_recursive"] != null){
                        array_walk_recursive($vals["parent_recursive"], function($a, $b) use(&$strr){
                            if($b == "name"){
                                $strr = $strr . " - " . $a;
                            }
                        });
                    }else{

                    }
                    // Log::error($strr);
                    return $strr;
                })
                ->rawColumns(['value_text'])
                ->make(true);
        }

        return DataTables::of($parentCategories)
            ->addIndexColumn()
            ->addColumn('types', function($row) use($category){
              $types_ids = CategoryRelation::where("deleted", 0)->where("category_id", $category->id)->where("category_parent_id", $row->id)->get()->pluck("type_id")->toArray();
              $typess = Category::where("deleted", 0)->whereIn("id", $types_ids)->select("name")->get()->pluck("name")->toArray();
              return implode(", ", $typess);
            })
            ->rawColumns(['types'])
            ->make(true);

      } catch (\Exception $e) {
        Log::error($e);
        return error_json($e);
      }
    }

     public function create(Request $request)
    {
        try{
            $category = null;
            $parentList = null;
            $types = Category::whereNull('parent_id')->orderBy('id','ASC')->where("deleted", 0)->get();

            if($request->edit == true){
                $parentList = array();
                $category = Category::find($request->id);
                if(!$category->exists()){
                    return error_json("Category not exist! Try again pls");
                }
                // $parentList = CategoryRelation::where("category_relations.category_id", $category->id)->where("category_relations.deleted", 0)->leftJoin("categories", "categories.id", "=", "category_relations.category_parent_id")->select("category_relations.id", "category_relations.category_id", "category_relations.category_parent_id", "category_relations.type_id", "categories.name")->get()->groupBy("type_id");
                foreach($types as $keyy => $valuee){
                    $plucked_array = CategoryRelation::where("category_relations.category_id", $category->id)->whereNotNull("category_relations.category_parent_id")->where("category_relations.deleted", 0)->where("category_relations.type_id", $valuee->id)->get()->pluck("category_parent_id")->toArray();

                    $listing = CategoryRelation::whereIn("category_relations.id", $plucked_array)
                        ->with(["parentRecursive"=> function($query) use($valuee){
                            $query->where("type_id", $valuee->id);
                        }])
                        ->join("categories", "categories.id", "=", "category_relations.category_id")
                        ->select("category_relations.*", "categories.name")->get()->toArray();
                    $arr = array();
                    foreach($listing as $key => $value){
                        $strr = $value["name"];
                        if($value["parent_recursive"] != null){
                            array_walk_recursive($value["parent_recursive"], function($a, $b) use(&$strr){
                                if($b == "name"){
                                    $strr = $strr . " - " . $a;
                                }
                            });
                        }
                        $arr[] = (object)array("id"=>$value["id"], "text"=>$strr);
                    }
                    $parentList[$valuee->id] = (object)$arr;
                }
            }
            // Log::error($parentList);
            return view('products::category.create', ["parentCategories"=>$types, "category"=>$category, "edit"=>$request->edit, "parentList"=>$parentList]);
        }catch(\Exeption $e){
        	return error_json($e);
        }
    }

    public function parentCatStore(Request $request)
    {
      try{
          if($request->edit == true){
            $category = Category::find($request->id);
          }else{
            $category = new Category();
          }
          $category->parent_id=request('subcategory');
          if($category->save()){
           return success_json($category, "Parent Category created successfully");
         }else{
           return error_json("Parent Category cannot created!");
         }
    }catch(\Exeption $e){
      return response()->json($e->getMessage());
    }
  }

    public function createSubCategory(Request $request)
    {
        try{
          $category = array();
            if($request->edit == true){
              $category = Category::find($request->id);
            }
            $allCategories = Category::where("deleted", 0)->where('id', '!=', $request->id)->with('subCategories')->get();
        return view('products::category.create_subcategory', ["allCategories"=>$allCategories,'category'=> $category, "edit"=>$request->edit]);
      }catch(\Exeption $e){
        return response()->json($e->getMessage());
      }
    }

    public function store(Request $request)
    {
        try{
             if($request->edit == true || $request->edit == "true"){

                $validator = Validator::make($request->all(), [
                  'name'      => 'required|min:3|max:255|string',
                  'parent_id' => 'sometimes|array',
                  'description'      => 'min:3|max:255',
                  //'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                 // 'banner_image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);

                $cat = Category::find($request->id);
             }else{

                $validator = Validator::make($request->all(), [
                  'name'      => 'required|min:3|max:255|string',
                  'parent_id' => 'sometimes|array',
                  'description'      => 'min:3|max:255',
                  'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                  'banner_image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);

                $check = Category::where("name", $request->name)->where("deleted", 0);
                if($check->exists()){
                  return error_json("This category is already exist");
                }

                $cat=new Category();
             }
             if ($validator->fails()) {
                return error_json($validator->errors()->first());
             }

             

             //Category::create($validatedData);
             if($request->hasfile('image'))
             {
              $imageName = time().'.'.$request->image->getClientOriginalExtension();
                $request->image->move(public_path('images'), $imageName);
                $cat->image=$imageName;
             }

             if($request->hasfile('banner_image'))
             {
              $banImageName = time().'.'.$request->banner_image->getClientOriginalExtension();
                $request->banner_image->move(public_path('banner_image'), $banImageName);
                $cat->banner_image=$banImageName;
             }

             $cat->name=request('name');
             $cat->parent_id=implode(",", request('parent_id'));
             $cat->slug=strtolower(str_replace(' ', '_', request('name')));
             $cat->description=request('description');
             $cat->created_by=auth()->user()->id;

             if($cat->save()){
              CategoryRelation::where("category_id", $cat->id)->update(["deleted"=>1]);
                foreach($request->parent_id as $key=>$value){
                    $category_parent = "category_".$value;
                    if(isset($request->{$category_parent})){
                        foreach($request->{$category_parent} as $keyy=>$valuee){
                            $checkParent = CategoryRelation::where("category_id", $cat->id)->where("category_parent_id", $valuee)->where("type_id", $value)->latest()->first();
                            if(!empty($checkParent)){
                                $checkParent->deleted = 0;
                                $checkParent->save();
                            }else{
                                $setParent = new CategoryRelation();
                                $setParent->category_id = $cat->id;
                                $setParent->category_parent_id = $valuee;
                                $setParent->type_id = $value;
                                $setParent->created_by = Auth::id();
                                $setParent->save();
                            }
                        }
                    }else{
                        $checkParent = CategoryRelation::where("category_id", $cat->id)->whereNull("category_parent_id")->where("type_id", $value)->latest()->first();
                        if(!empty($checkParent)){
                            $checkParent->deleted = 0;
                            $checkParent->updated_by = Auth::id();
                            $checkParent->save();
                        }else{
                            $setParent = new CategoryRelation();
                            $setParent->category_id = $cat->id;
                            $setParent->category_parent_id = null;
                            $setParent->type_id = $value;
                            $setParent->created_by = Auth::id();
                            $setParent->updated_by = Auth::id();
                            $setParent->save();
                        }
                    }
                }

              return success_json($cat, "Category created successfully");
            }else{
              return error_json("Category cannot created!");
            }

        }catch(\Exeption $e){
        	return error_json($e);
        }

    }

    public function subcatShow($id = 0){
        try {
          //$subCategories = Category::where('parent_id',$id)->where("deleted", 0)->get();
          $category = Category::find($id);
          $types = Category::where("deleted", 0)->whereIn("id", explode(",", $category->parent_id))->select("id", "name")->get();
          $type_text = implode(", ", $types->pluck("name")->toArray());
          return view('products::category.subcategory', ["category"=>$category, "type"=>$types, "type_text"=>$type_text]);
        } catch (\Exception $e) {
          abort(404);
        }
    }

    public function sublist(Request $request)
    {
        try {
              $subCategories = Category::where('parent_id',$request->id)->where("deleted", 0);

              return DataTables::of($subCategories)
                  ->addIndexColumn()
                  // ->addColumn('permission', function($row){
                  //     $permission_str = "";
                  //     foreach ($row->permissions as $key=>$value){
                  //       $permission_str .= $value->name.", ";
                  //     }
                  //     return $permission_str;
                  // })
                  // ->rawColumns(['permission'])
                  ->make(true);

        } catch (\Exception $e) {
            return error_json($e);
        }
    }

     public function createsub(Request $request)
    {
        try{
            $category = array();
              if($request->edit == true){
                $category = Category::find($request->id);
              }
          $parentCategories = Category::whereNull('parent_id')->where("deleted", 0)->get();
          // print_r($category);
          return view('products::category.createsub', ["parentCategories"=>$parentCategories, "category"=>$category, "edit"=>$request->edit, "pid"=>$request->pid]);
        }catch(\Exeption $e){
          return error_json($e);
        }
    }

    public function storesub(Request $request)
    {
        try{

             if($request->edit == true || $request->edit == "true"){

                $validator = Validator::make($request->all(), [
                  'name'      => 'required|min:3|max:255|string',
                  'parent_id' => 'sometimes|nullable|numeric',
                  'slug'      => 'required|min:3|max:255|string',
                  'description'      => 'min:3|max:255',
                  'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
                ]);

                $cat = Category::find($request->id);
             }else{

                $validator = Validator::make($request->all(), [
                  'name'      => 'required|min:3|max:255|string',
                  'parent_id' => 'sometimes|nullable|numeric',
                  'slug'      => 'required|min:3|max:255|string',
                  'description'      => 'min:3|max:255',
                  'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
                ]);

                $cat=new Category();
             }
             if ($validator->fails()) {
                return error_json($validator->errors()->first());
             }
             //Category::create($validatedData);
             if($request->hasfile('image'))
             {
              $imageName = time().'.'.$request->image->getClientOriginalExtension();
              $request->image->move(public_path('images'), $imageName);
              $cat->image=$imageName;
             }

             $cat->name=request('name');
             $cat->parent_id=request('parent_id');
             $cat->slug=request('slug');
             $cat->description=request('description');
             $cat->created_by=auth()->user()->id;

             if($cat->save()){
              return success_json($cat, "Category created successfully");
            }else{
              return error_json("Category cannot created!");
            }

        }catch(\Exeption $e){
          return error_json($e);
        }

    }

    public function delete(Request $request){
        try {

            $category=Category::where('id',$request->id)->first();
            //echo $category;die();
            $category->update(['deleted'=>1]);
            if($category->subcategory){
                foreach ($category->subcategory()->get() as $subcat) {
                    $subcat->update(['deleted'=>1]);
                }
            }
            return success_json($category, "Category deleted successfully");
        } catch (\Exception $e) {
            return error_json($e);
        }
    }


    public function createAttributeValues(Request $request)
    {
      try{
          $attributValue = array();
          if($request->edit == true){
            $CategoryAttributeValue = CategoryAttributeValue::where('category_id',$request->category_id)->get();
          }
          $attributValue = Attribute::with('values')->get();

          return view('products::category.attribute_values', [ 'CategoryAttributeValue'=> $CategoryAttributeValue,"attributValue"=>$attributValue,'category_id'=>$request->category_id, "edit"=>$request->edit]);
      }catch(\Exeption $e){
        return response()->json($e->getMessage());
      }
    }

    public function storeAttributeValue(Request $request)
    {
      $data=[];
      $images = '';
      try {
          if (count($request->attribute_name) > 0) {
              foreach ($request->attribute_name as  $attrName) {
                if(count(request('attribute_value_id'.$attrName)) > 0)
                  foreach (request('attribute_value_id'.$attrName) as  $attrVal) {
                    // if($files=$request->file('att_val_image'.$attrVal)){
                    //   foreach ($files as $key =>  $image) {
                    //     $imageName[] = time().'.'.$image->getClientOriginalExtension();
                    //   }
                    //   $images = implode(",",$imageName);
                    // }

                    $data[]=[
                      'category_id'=>$request->category_id,
                      'attribute_id'=>$attrName,
                      'attribute_value_id'=>$attrVal,
                      // 'price' => request('price'.$attrVal) != null ? request('price'.$attrVal) : 0,
                      // 'att_val_image' => $images,
                    ];
                  }
              }
          }

          CategoryAttributeValue::insert($data);
          return success_json($data,'update success');
      } catch (\Exception $th) {
        //throw $th;
      }

      return success_json('',);

    }

    public function add_list_attribute(Request $request){
      try{
        $attribute_list = Attribute::where("deleted", 0)->select("id", "name as text")->where("name", "LIKE", "%".$request->search."%")->get();
        return success_json($attribute_list, "Attribute List Populated");
      }catch(\Exception $e){
        return error_json($e);
      }
    }

    public function add_list_attribute_values(Request $request){
        try{
          $attribute_list = AttributeValue::where("deleted", 0)->where("attribute_id", $request->attribute_id)->select("id", "value as text")->where("value", "LIKE", "%".$request->search."%")->get();
          return success_json($attribute_list, "Attribute List Populated");
        }catch(\Exception $e){
          return error_json($e);
        }
      }

    public function add_filter_attribute(Request $request){
      try{
        $category = Category::find($request->id);
        $typeCategory = Category::where("deleted", 0)->whereNull("parent_id")->get();
        $filter = null;
        $parentCategory = null;
        $attribute_list = null;
        $any_parent = true;
        if(isset($request->edit) && $request->edit == true){
          $filter = CategoryAttributeFilter::find($request->row_id);
          $filters_list_array = CategoryAttributeFilter::where("category_id", $filter->category_id)->where("category_parent_id", $filter->category_parent_id)->where("type_id", $filter->type_id)->get()->pluck("attribute_id")->toArray();
          // $filters = CategoryRelation::where("category_id", $filter->category_id)->where("category_parent_id", $filter->category_parent_id)->where("type_id", $filter->type_id)->with("getName")->with("parentRecursive")->get()->first();
          Log::error($filter->toArray()["category_parent_id"]);
          if($filter->toArray()["category_parent_id"] != null){
              $any_parent = true;
              $parentCategory = CategoryRelation::where("id", $filter->category_parent_id)->with("getName")->with("parentRecursive")->get()->first();
              // $filters_list_aray = CategoryAttributeFilter::where("deleted", 0)->where("category_id", $category->id)->whereNull("category_parent_id")->where("type_id", $filter->type_id)->get()->pluck("attribute_id")->toArray();
          }else{
            $any_parent = false;
            $parentCategory = null;
              // $filters_list_array = CategoryAttributeFilter::where("deleted", 0)->where("category_id", $category->id)->where("category_parent_id", $filter->id)->where("type_id", $filter->type_id)->get()->pluck("attribute_id")->toArray();
          }
          // Log::error($filters_list_array);
          $attribute_list = Attribute::where("deleted", 0)->select("id", "name as text")->whereIn("id", $filters_list_array)->get();
        }
        return view('products::category.add_attribute_filter', ["category"=>$category, "edit"=>false, "typeCategory"=>$typeCategory, "filter"=>$filter, "parentCategory"=>$parentCategory, "attribute_list"=>$attribute_list, "any_parent"=>$any_parent]);
      }catch(\Exception $e){
        Log::error($e);
        return error_json($e);
      }
    }

    public function add_filter_attribute_store(Request $request){
      try{
        $att_filters = CategoryAttributeFilter::where("category_id", $request->category_id)->where("category_parent_id", $request->category_parent_id)->where("type_id", $request->type_id)->update(["deleted"=>1]);
        // if()

        foreach($request->attribute_id as $key => $value){
          $check = CategoryAttributeFilter::where("category_id", $request->category_id)->where("category_parent_id", $request->category_parent_id)->where("type_id", $request->type_id)->where("attribute_id", $value)->first();
          if(!empty($check)){
            $check->deleted = 0;
            $check->status = 1;
            $check->updated_by = Auth::id();
            $check->save();
          }else{
            $newCheck = new CategoryAttributeFilter();
            $newCheck->type_id = $request->type_id;
            $newCheck->category_id = $request->category_id;
            if(isset($request->category_parent_id) && $request->category_parent_id != null){
                $newCheck->category_parent_id = $request->category_parent_id;
            }
            // $newCheck->category_parent_id = $request->category_parent_id;
            $newCheck->attribute_id = $value;
            $newCheck->created_by = Auth::id();
            $newCheck->updated_by = Auth::id();
            $newCheck->save();
          }
        }
        return success_json("Filter added", "Filter added successfully");
      }catch(\Exception $e){
          Log::error($e);
        return error_json($e);
      }
    }

    public function add_values_attribute(Request $request){
        try{
          $category = Category::find($request->id);
          $typeCategory = Category::where("deleted", 0)->whereNull("parent_id")->get();
          $filter = null;
          $parentCategory = null;
          $attribute_list = null;
          $value_list = null;
          $any_parent = true;
          if(isset($request->edit) && $request->edit == true){
              $filter = CategoryAttributeValue::find($request->row_id);
              if($filter->category_parent_id != null && $filter->category_parent_id != ""){
                $parentCategory_recursive = CategoryRelation::where("id", $filter->category_parent_id)->with("parentRecursive")->with("getName")->get()->first()->toArray();
              }else{
                $parentCategory_recursive = CategoryRelation::whereNull("category_parent_id")->where("type_id", $filter->type_id)->where("category_id", $filter->category_id)->with("parentRecursive")->with("getName")->get()->first()->toArray();
              }

              if($parentCategory_recursive["parent_recursive"] != null){
                $parentCategoryName = $parentCategory_recursive["get_name"]["name"];
                array_walk_recursive($parentCategory_recursive["parent_recursive"], function($a, $b) use(&$parentCategoryName){
                    if($b == "name"){
                        $parentCategoryName = $parentCategoryName . " - " . $a;
                    }
                });
              }else{
                $parentCategoryName = "No Parent";
                  $any_parent = false;
              }

            $parentCategory = (object) array("id"=>$filter->category_parent_id, "name"=>$parentCategoryName);
              $attribute_list = Attribute::find($filter->attribute_id);
              $filters_list_array = CategoryAttributeValue::where("deleted", 0)->where("category_id", $filter->category_id)->where("category_parent_id", $filter->category_parent_id)->where("type_id", $filter->type_id)->where("attribute_id", $filter->attribute_id)->get()->pluck("attribute_value_id")->toArray();
              $value_list = AttributeValue::where("deleted", 0)->select("id", "value as text")->where("value", "LIKE", "%".$request->search."%")->whereIn("id", $filters_list_array)->get();
          }
          return view('products::category.add_attribute_value', ["category"=>$category, "edit"=>false, "typeCategory"=>$typeCategory, "filter"=>$filter, "parentCategory"=>$parentCategory, "attribute_list"=>$attribute_list, "value_list"=>$value_list, "any_parent"=>$any_parent]);
        }catch(\Exception $e){
          Log::error($e);
          return error_json($e);
        }
      }

      public function add_filter_attribute_delete(Request $request){
          try{
            $filter = CategoryAttributeFilter::find($request->id);
            $att_filters = CategoryAttributeFilter::where("category_id", $filter->category_id)->where("category_parent_id", $filter->category_parent_id)->where("type_id", $filter->type_id)->update(["deleted"=>1]);
            return success_json("Deleted", "Deleted");
        }catch(\Exception $e){
              return error_json($e);
          }
      }

      public function add_values_attribute_delete(Request $request){
        try{
            $filter = CategoryAttributeValue::find($request->id);
            $att_values = CategoryAttributeValue::where("category_id", $filter->category_id)->where("type_id", $filter->type_id)->where("attribute_id", $filter->attribute_id);
            if(isset($filter->category_parent_id) && $filter->category_parent_id != null){
                $att_values = $att_values->where("category_parent_id", $filter->category_parent_id);
            }
            $att_values = $att_values->update(["deleted"=>1]);
            return success_json("Deleted", "Deleted");
      }catch(\Exception $e){
            return error_json($e);
        }
    }

      public function add_values_attribute_store(Request $request){
        try{
          $att_values = CategoryAttributeValue::where("category_id", $request->category_id)->where("type_id", $request->type_id)->where("attribute_id", $request->attribute_id);
            if(isset($request->category_parent_id) && $request->category_parent_id != null){
                $att_values = $att_values->where("category_parent_id", $request->category_parent_id);
            }
          $att_values = $att_values->update(["deleted"=>1]);
          //   Log::error($request->attribute_value_mandatory);
        //   Log::error($request->attribute_value_gallery);

          foreach($request->attribute_value_id as $key => $value){
            $check = CategoryAttributeValue::where("category_id", $request->category_id)->where("category_parent_id", $request->category_parent_id)->where("type_id", $request->type_id)->where("attribute_id", $request->attribute_id)->where("attribute_value_id", $value)->first();
            if(!empty($check)){
              $check->deleted = 0;
              $check->status = 1;
              $check->updated_by = Auth::id();
              $check->mandatory = $request->attribute_value_mandatory;
              $check->gallery_mandatory = $request->attribute_value_gallery;
              $check->save();
            }else{
              $newCheck = new CategoryAttributeValue();
              $newCheck->type_id = $request->type_id;
              $newCheck->category_id = $request->category_id;
              if(isset($request->category_parent_id) && $request->category_parent_id != null){
                $newCheck->category_parent_id = $request->category_parent_id;
              }

              $newCheck->attribute_id = $request->attribute_id;
              $newCheck->attribute_value_id = $value;
              $newCheck->mandatory = $request->attribute_value_mandatory;
              $newCheck->gallery_mandatory = $request->attribute_value_gallery;
              $newCheck->created_by = Auth::id();
              $newCheck->updated_by = Auth::id();
              $newCheck->save();
            }
          }
          return success_json("Filter added", "Filter added successfully");
        }catch(\Exception $e){
            Log::error($e);
          return error_json($e);
        }
      }

    public function add_values_attribute_list(Request $request){
      try{
        $parentCategories_1 = CategoryAttributeValue::where("category_attribute_values.deleted", 0)->where("category_attribute_values.category_id", $request->id)
            ->whereNotNull("category_attribute_values.category_parent_id")
            ->groupBy(["category_attribute_values.category_parent_id", "category_attribute_values.attribute_id", "category_attribute_values.type_id"])
            ->with("parentCategoryDetail.parentRecursive")
            ->with("parentCategoryDetail.getName")
            ->with("getType")
            ->with("getAttributeName")
            ->select("category_attribute_values.*", DB::raw('GROUP_CONCAT(attribute_value_id) as ids'))
            ->get();

        $parentCategories_2 = CategoryAttributeValue::where("category_attribute_values.deleted", 0)->where("category_attribute_values.category_id", $request->id)
            ->whereNull("category_attribute_values.category_parent_id")
            ->groupBy(["category_attribute_values.attribute_id", "category_attribute_values.type_id"])
            ->with("parentCategoryDetail.parentRecursive")
            ->with("parentCategoryDetail.getName")
            ->with("getType")
            ->with("getAttributeName")
            ->select("category_attribute_values.*", DB::raw('GROUP_CONCAT(attribute_value_id) as ids'))
            ->get();
          
        $parentCategories = $parentCategories_1->merge($parentCategories_2);
        // Log::error($parentCategories->toArray());
        return DataTables::of($parentCategories)
            ->addIndexColumn()
            ->addColumn('att_values', function($row){
                $typess = AttributeValue::where("deleted", 0)->whereIn("id", explode(",", $row->ids))->select("value")->get()->pluck("value")->toArray();
                return implode(", ", $typess);
            })
            ->addColumn('parent_category_name', function($row){
                // $relations = CategoryRelation::find($row->id)->with("parentRecursive")->get()->toArray();
                $valss = $row->toArray();
                $strr = "";
                if($valss["parent_category_detail"] != null){
                    $vals = $valss["parent_category_detail"];
                    $strr = $vals["get_name"]["name"];
                    if($vals["parent_recursive"] != null){                        
                        array_walk_recursive($vals["parent_recursive"], function($a, $b) use(&$strr){
                            if($b == "name"){
                                $strr = $strr . " - " . $a;
                            }
                        });
                    }else{
                      Log::error($strr);
                        if(trim($strr) == ""){
                          $strr = "----";
                        }
                    }
                }else{
                    $strr = "----";
                }
                return $strr;
            })
            ->rawColumns(['att_values', 'parent_category_name'])
            ->make(true);

      }catch(\Exception $e){
        Log::error($e);
        return error_json($e);
      }
    }

    public function add_filter_attribute_list(Request $request){
      try{
            // $parentCategories_idds = CategoryAttributeFilter::where("category_attribute_filters.deleted", 0)->where("category_attribute_filters.category_id", $request->id)->whereNotNull("category_attribute_filters.category_parent_id")
            //     ->groupBy("category_attribute_filters.category_parent_id")->select("category_attribute_filters.*")->get()->pluck("category_parent_id")->toArray();

            // $parentCategories_idds1 = CategoryAttributeFilter::where("category_attribute_filters.deleted", 0)->where("category_attribute_filters.category_id", $request->id)->whereNull("category_attribute_filters.category_parent_id")
            //     ->leftJoin("category_relations", function($query) use($request){
            //         $query->on("category_relations.type_id", "=", "category_attribute_filters.type_id")->whereNull("category_relations.category_parent_id")->where("category_relations.category_id", $request->id);
            //     })
            //     ->groupBy("category_relations.id")->select("category_relations.*")->get()->pluck("id")->toArray();
            // $parentCategories_ids = array_merge($parentCategories_idds, $parentCategories_idds1);

            // $parentCategories = CategoryRelation::whereIn("category_relations.id", $parentCategories_ids)->leftJoin("categories", "categories.id", "=", "category_relations.category_id")->leftJoin("categories as a", "a.id", "=", "category_relations.type_id")->with("parentRecursive")->select("category_relations.*", "categories.name", "categories.id as idd", "a.name as type_name")->get();
            // // Log::error($parentCategories->toArray());
            

        $data = CategoryAttributeFilter::where("deleted", 0)->where("category_id", $request->id)->groupBy(["category_id", "type_id", "category_parent_id"])->with("getType")->get();
        // Log::error($data->toArray());
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('attributes', function($row) use($request){
                // if($row->category_parent_id == null || $row->category_parent_id == ""){
                    $types_ids = CategoryAttributeFilter::where("deleted", 0)->where("category_id", $row->category_id)->where("type_id", $row->type_id)->where("category_parent_id", $row->category_parent_id)->get()->pluck("attribute_id")->toArray();
                // }else{
                //     $types_ids = CategoryAttributeFilter::where("deleted", 0)->where("category_id", $request->id)->where("type_id", $row->type_id)->where("category_parent_id", $row->id)->get()->pluck("attribute_id")->toArray();
                // }
                $typess = Attribute::where("deleted", 0)->whereIn("id", $types_ids)->select("name")->get()->pluck("name")->toArray();

                return implode(", ", $typess);
            })
            // ->addColumn('delete_id', function($row) use($request){
            //     // if($row->category_parent_id == null || $row->category_parent_id == ""){
            //     //     $types_ids = CategoryAttributeFilter::where("deleted", 0)->where("category_id", $request->id)->where("type_id", $row->type_id)->whereNull("category_parent_id")->get()->first();
            //     //     Log::error($request->id);
            //     // }else{
            //     //     $types_ids = CategoryAttributeFilter::where("deleted", 0)->where("category_id", $request->id)->where("type_id", $row->type_id)->where("category_parent_id", $row->id)->get()->first();
            //     // }
            //     if(empty($types_ids)){
            //         return 0;
            //     }else{
            //         return $types_ids->id;
            //     }
            // })
            ->addColumn('parent_category_name', function($row){
              // Log::error($row->parent_name);                
                $valss = $row->toArray();
                
                if($valss["category_parent_id"] != null){
                  $vals = CategoryRelation::where("category_id", $row->category_id)->where("type_id", $row->type_id)->where("category_parent_id", $row->category_parent_id)->with("getName")->with("parentRecursive")->get()->first()->toArray();
                    // $strr = $vals["get_name"];
                    $arrr = array();
                    $strr = "";
                    if($vals["parent_recursive"] != null){
                      array_walk_recursive($vals["parent_recursive"], function($a, $b) use(&$arrr){
                        if($b == "name"){
                            $arrr[] = $a;
                        }
                      });
                      Log::error($arrr);
                      $strr = implode(" - ", $arrr);
                    }
                    
                }else{
                    $strr = "----";
                }
                // Log::error($strr);
                return $strr;
                return "Nothing";
            })
            ->rawColumns(['attributes', 'parent_category_name', "delete_id"])
            ->make(true);
        
        

        return success_json("hello success", "hello success");

      }catch(\Exception $e){
          Log::error("------------------add_filter_attribute_list----------------");
        Log::error($e);
        return error_json($e);

      }
    }
}
