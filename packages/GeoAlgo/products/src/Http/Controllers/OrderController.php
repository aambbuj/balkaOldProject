<?php

namespace GeoAlgo\Products\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use GeoAlgo\Products\Models\Product;
use GeoAlgo\Products\Models\Category;
use GeoAlgo\Products\Models\ProductCategory;
use GeoAlgo\Products\Models\Order;
use GeoAlgo\Products\Models\Order_details;
use GeoAlgo\Products\Models\Item;
use GeoAlgo\Products\Models\Assignorder;
use App\Models\Company;
use App\Models\User;
use DB;
use Validator;
use DataTables;
use Carbon\Carbon;

class OrderController extends Controller
{

//////////////// Details of orders //////////////////////
  public function receivedOrders()
  {
     try {
             return view('products::order.index');

        } catch (\Exception $e) {
          return error_json($e);
        }
  }

  public function list()
    {
        try {
              $orders = Order::where('deleted',0)->where('status',1)->with('details','bars')->get();

              return DataTables::of($orders)
                  ->addIndexColumn()
                   ->addColumn('product_name', function($row){
                        $product_str = "";
                    foreach ($row->details as $key=>$value){
                         $product_str .= $value->product_name.", ";
                       }
                      return $product_str;
                    //return $order->details->product_name;
                  })
                   ->addColumn('bar_name', function($row){
                    return $row->bars->company_name;
                   })
                   ->rawColumns(['product_name', 'bar_name'])
                  ->make(true);

        } catch (\Exception $e) {
            return error_json($e);
        }
    }

     public function progressedOrders()
  {
     try {
             return view('products::order.index');

        } catch (\Exception $e) {
          return error_json($e);
        }
  }

  public function plist()
    {
        try {
              $orders = Order::where('deleted',0)->whereIn('status',[2,3])->with('details','bars')->get();

              return DataTables::of($orders)
                  ->addIndexColumn()
                   ->addColumn('product_name', function($row){
                        $product_str = "";
                    foreach ($row->details as $key=>$value){
                         $product_str .= $value->product_name.", ";
                       }
                      return $product_str;
                    //return $order->details->product_name;
                  })
                   ->addColumn('bar_name', function($row){
                    return $row->bars->company_name;
                   })
                   ->rawColumns(['product_name', 'bar_name'])
                  ->make(true);

        } catch (\Exception $e) {
            return error_json($e);
        }
    }

    public function orderAssign(Request $request)
    {
       try {
             $id=$request->id;
             $users = User::role('Driver')->where("deleted", 0)->get();
             return view('products::order.assign',['users'=>$users,'id'=>$id]);
       } catch (\Exception $e) {
           return error_json($e);
       }
    }

    public function assignOrderStore(Request $request)
    {
      try {
             $validator = Validator::make($request->all(), [
                  'driver_id' => 'required|numeric',
                  'comment' => 'sometimes|nullable|min:3|max:255|string'
                ]);
             if ($validator->fails()) {
                return error_json($validator->errors()->first());
             }
              $assign=new Assignorder();

              $assign->order_id=$request->id;
              $assign->driver_id=$request->driver_id;
              if(!empty($request->comment))
              {
                $assign->comment=$request->comment;
              }

              if($assign->save()){
              return success_json($assign, "Order assign  successfully");
              }else{
                return error_json("Order cannot assign!");
              }

      } catch (\Exception $e) {
        return error_json($e);
      }
    }

    public function acceptOrder(Request $request)
    {
        try {
                $productIds=Order_details::where('order_id',$request->id)->pluck('product_id');
                        $products=Product::where("deleted",0)->whereIn('id',$productIds)->get();
                        $productQtys=Order_details::where('order_id',$request->id)->pluck('qty');
                         $i=0;
                         $flag=0;
                        foreach ($products as $product) {
                          if(($product->qty_per_unit)<($productQtys[$i]))
                          {
                              $flag=1;
                          }
                          $i++;
                        }

                        if($flag==1)
                        {
                            return error_json("Products of this order are not available in Inventory!");
                         } 
                $vcode=(rand(100000,999999));
              $result = Order::where('id',$request->id)->update(['status' => 2,'vcode' => $vcode]);
                    if($result)
                    {
                        Order_details::where('order_id',$request->id)->update(['status' => 2]);
                        $productIds=Order_details::where('order_id',$request->id)->pluck('product_id');
                        $products=Product::where("deleted",0)->whereIn('id',$productIds)->get();
                        $productQtys=Order_details::where('order_id',$request->id)->pluck('qty');
                          $i=0;
                        foreach ($products as $product) {
                          $product->qty_per_unit=($product->qty_per_unit)-($productQtys[$i]);
                          $i++;
                          $product->update();
                        }
                        return success_json("Order Accepted successfully");
                    }
        } catch (\Exception $e) {
          return error_json($e);
        }
    }

    public function showCompanies()
    {
      try {
            $bars=Company::where('deleted',0)->get();
            return view('products::invoice.index',['bars'=>$bars]);
      } catch (\Exception $e) {
        return error_json($e);
      }
    }

    public function orderInvoices($id = 0)
    {
      try {
            $barname=Company::where('id',$id)->value('company_name');
            $invoices=Order::where('company_id',$id)->where('status',2)->get();
            return view('products::invoice.companyInvoices',['invoices'=>$invoices,'barname'=>$barname]);
      } catch (\Exception $e) {
        return error_json($e);
      }
    }

    public function showInvoice($id = 0)
    {
      try {
           $invoiceDetails=Order::where('id',$id)->with('details')->first();
           $bar=Company::where('id',$invoiceDetails->company_id)->first();
           //echo $invoiceDetails;die;
          return view('products::invoice.showInvoice',['invoiceDetails'=>$invoiceDetails,'bar'=>$bar]);
      } catch (\Exception $e) {
        return error_json($e);
      }
    }
    /////////////////////////////// Get all orders ///////////////////////////////////////////
    public function getAllOrders()
    {
        try {
            $companyId = '';
            $companyId=Company::where('assign_to',auth()->user()->id)->value('id');
            if($companyId == 0)
            {
                $user_id=User::where('id',auth()->user()->id)->value('parent_id');
               $companyId=Company::where('assign_to',$user_id)->value('id');
            }

            $orders = Order::where('deleted',0)->where('company_id',$companyId)->with('details')->get();
            $responce =  $this->orderInfo($orders);
            return response()->json(['data' => $responce ,'success'=> 'Success']);
        } catch (\Exception $Ex) {
            return response()->json(['error' => $Ex]);
        }
    }

    public function getAllProgressOrders()
    {
        try {

            $companyId = '';
            $companyId=Company::where('assign_to',auth()->user()->id)->value('id');
            if($companyId == 0 )
            {
              $user_id=User::where('id',auth()->user()->id)->value('parent_id');
              $companyId=Company::where('assign_to',$user_id)->value('id');
            }

            $orders = Order::where('deleted',0)->where('company_id',$companyId)->whereIn('status',[2,3])->with('details')->get();
            $responce =  $this->orderInfo($orders);
            return response()->json(['data' => $responce ,'success'=> 'Success']);
        } catch (\Exception $Ex) {
            return response()->json(['error' => $Ex]);
        }
    }

    public function orderInfo($orders)
    {
       $data=[];
       foreach($orders as $order)
       {
        $data[]=[
          'id' => $order->id,
          'order_number' => $order->order_number,
          'order_count' => $this->orderCount($order->id),
          'order_date' => date('M-d-Y',strtotime($order->order_date)),
          'status' => $this->makeStatusName($order->status),
          'details' => $this->orderInfoDetails($order->details),
        ];
       } 
       return $data;
    }

    public function makeStatusName($status)
    {
      if($status == 1){
        return 'Ordered';
      }
      if($status == 2){
        return 'In Progress';
      }
      if($status == 3){
        return 'Delivered';
      }
    }

    public function orderInfoDetails($details)
    {
      $data=[];
      foreach($details as $detail)
      {
        $data[]=[
          'product_id' => $detail->id,
          'product_name' => $detail->product_name,
          'order_qty' => $detail->pivot->qty,
          'total_amount' => $detail->pivot->total_amount,
          'image' => url('Pimages/'.$detail->image)
        ];
      }
      return $data;  

    }

    public function orderCount($order_id)
    {
      return Order_details::where('order_id',$order_id)->where('deleted',0)->count();
    }
    ////////////////////////////////////// Get all orders With order id //////////////////////
    public function getOrders($orderId = 0, $userId = 0)
    {
        if (!empty($orderId)) {
          try {
            
              $orderDetails = Order::where('id',$orderId)->where('user_id',$userId)->where('deleted',0)->with('details')->get();
              if(count($orderDetails)>0){
                return response()->json($orderDetails);
              }else{
                  return response()->json(['error' => 'Order is not avialble']);
              }

          } catch (\Exception $orderEx) {
             return response()->json(['error' => $orderEx]);
          }
                  
        } else {
            return response()->json(['error' => 'Order id Invalid']);
        }
    }
    //////////////////////////////// Order store with order details. order details must be a json object ///////////////////////
    public function store(Request $request)
    {
        $orders = $request->all();
        unset($orders['order_details']);
        try {
          $companyId = '';
          $companyId=Company::where('assign_to',auth()->user()->id)->value('id');
          if (empty($companyId) || $companyId == '' ) {
              $parent_id = User::where('id',auth()->user()->id)->value('parent_id');
              $companyId=Company::where('assign_to',$parent_id)->value('id');
          }
            
            $orders['company_id'] = $companyId;
            $orders['user_id'] = auth()->user()->id;
            $orders['order_date'] = date("Y-m-d h:i:s") ;
            $orderId  = Order::create($orders)->id;

            try {
                $details = $request->order_details;
                $orderDetailsArr= json_decode($details, true);
                    for ($i=0; $i < count($orderDetailsArr); $i++) { 
                        $orderDetailsArr[$i]['order_id'] = $orderId;
                    }
                $result  = Order_details::insert($orderDetailsArr);
                return response()->json(['order_id' => $orderId ,'success' => 'Order placed Successfully']);
            } catch (\Exception $orderDetailEx) {
                if($orderDetailEx){
                    Order::where('id',$orderId)->delete();
                    return response()->json($orderDetailEx->errorInfo);
                }
            }
        } catch (\Exception $orderCreateEx) {
            return response()->json(['error' => 'Please Contact Admin']);
        }
    }

    ////////////////////////  Deleted order with order-details //////////////////////////////
    public function delete($order_id = 0)
    { 
        if (!empty($order_id)) {
            try {
                $result = Order::where('id',$order_id)->update(['deleted' => 1]);
                    if($result)
                    {
                        Order_details::where('order_id',$order_id)->update(['deleted' => 1]);
                        return response()->json(['success'=> 'Deleted']);
                    }
            } catch (\Exception $orderdeleteEx) {
                return response()->json(['error'=>  $orderdeleteEx]);
            }
        } else {
            return response()->json(['error'=> 'Order id invalid']);
        }
    }
    //////////////////////////// Deliverd order with order-details ///////////////////////
    public function deliveredOrder(Request $request)
    {
        if (!empty($request->order_id)) {
            try {
                $result = Order::where('id',$request->order_id)->update(['status' => 3]);
                    if($result)
                    {
                        Order_details::where('order_id',$request->order_id)->update(['status' => 3]);
                        return response()->json(['success'=> 'Success']);
                    }
            } catch (\Exception $deliveredEx) {
                return response()->json(['error'=>  $deliveredEx]);
            }
        } else {
            return response()->json(['error'=> 'Order id invalid']);
        }
    }
     //////////////////////////  pending order with order-details ////////////////////////////
    public function pendingOrder(Request $request)
    {
        if (!empty($request->order_id)) {
            try {
                $result = Order::where('id',$request->order_id)->update(['status' => 2]);
                    if($result)
                    {
                        Order_details::where('order_id',$request->order_id)->update(['status' => 2]);
                        return response()->json(['success'=> 'Success']);
                    }
            } catch (\Exception $pendingOrderEx) {
                return response()->json(['error'=>  $pendingOrderEx]);
            }
        } else {
            return response()->json(['error'=> 'Order id invalid']);
        }
    }


       //////////////////////// Order Deleted only order-details //////////////////////////////
       public function deleteOrderDetails($orderDetailsId = 0)
       { 
           if (!empty($orderDetailsId)) {
               try {
                    Order_details::where('id',$orderDetailsId)->update(['deleted' => 1]);
                   return response()->json(['success'=>  'Success']);
               } catch (\Exception $orderdeleteEx) {
                   return response()->json(['error'=>  $orderdeleteEx]);
               }
           } else {
               return response()->json(['error'=> 'Order id invalid']);
           }
       }
       //////////////////////////// order deliverd only order-details /////////////////////////
       public function deliveredOrderDetails(Request $request)
       {
           if (!empty($request->order_details_id)) {
               try {
                    Order_details::where('id',$request->order_details_id)->update(['status' => 3]);
                    return response()->json(['success'=> 'Success']);
               } catch (\Exception $deliveredEx) {
                   return response()->json(['error'=>  $deliveredEx]);
               }
           } else {
               return response()->json(['error'=> 'Order id invalid']);
           }
       }
        //////////////////////////  pending order with order-details //////////////////////////
       public function pendingOrderDetails(Request $request)
       {
           if (!empty($request->order_details_id)) {
               try {
                    Order_details::where('id',$request->order_details_id)->update(['status' => 2]);
                    return response()->json(['success'=> 'Success']);
               } catch (\Exception $pendingOrderEx) {
                   return response()->json(['error'=>  $pendingOrderEx]);
               }
           } else {
               return response()->json(['error'=> 'Order id invalid']);
           }
       }


  //////////////// Recent purchase for api ///////////////////////////////

  public function getRecentPurchase(Request $request){
        if(!empty($request->user_id)){
            $companyId=[];
             $companyId=Company::where('assign_to',$request->user_id)->pluck('id');
             if (count($companyId) == 0) {
                $parent_id = User::where('id',$request->user_id)->pluck('parent_id');
                $companyId=Company::whereIn('assign_to',$parent_id)->pluck('id');
             }
              if (count($companyId) > 0) {
                  $productIds =  Item::where('company_id',$companyId)->pluck('product_id');
                    if ($productIds!=null) {
                        $categoryIds = ProductCategory::whereIn('product_id',$productIds)->pluck('category_id');
                          if ($categoryIds!=null) {
                              $categoryDetails = Category::whereIn('id',$categoryIds)->orderBy('id','DESC')->get();
                              $resentPurchased= Order::where('status',1)->with('details')->where('company_id',$companyId)->where('user_id',$request->user_id)->orderBy('id','DESC')->get();
                                //return response()->json(['sucess'=>$resentPurchased]);
                               $responce =  $this->productCategory($categoryDetails,$resentPurchased);
                              return response()->json(['data' => $responce ,'success'=> 'Success']);

                          } else {
                              return response()->json(['error' => 'Dose not metch any Category']);
                          }
                          
                    } else {
                      return response()->json(['error' => 'Dose not have any Inventory']);
                    }
              } else {

               return response()->json(['error' => 'Dose not have any Bar']);
              }
        }else{
          return response()->json(['error'=> 'please give user id']);
        }
  }

  public function productCategory($categoryDetails,$resentPurchased)
  {
    $data = [];
    $data1 = [];
    $data2 = [];

    foreach ($categoryDetails as $details) {
        $data1[]=[
          'id' => $details->id,
          'name' => $details->name,
          'image' => url('images/'.$details->image)
        ];
    }

    foreach ($resentPurchased as $key => $purchases) {

          foreach ($purchases->details as  $purchased) {
                $data2[]=[
              'id' => $purchased->id,   
              'product_name' => $purchased->product_name,
              'unit_price' => $purchased->unit_price,
              'image' => url('Pimages/'.$purchased->image)
            ];
          }
    }
      
      $data['ProductC']=$data1;
      $data['RecentP']=$data2;
    return $data;
   
  }

  public function getCategories(Request $request)
  {
    try {
          $companyId = [];
          $companyId=Company::where('assign_to',auth()->user()->id)->pluck('id');
            if(count($companyId) == 0){
              $parent_id = User::where('id',auth()->user()->id)->pluck('parent_id');
              $companyId = Company::where('assign_to',$parent_id)->pluck('id');
            }
              if ($companyId!=null) {
                  $productIds =  Item::where('company_id',$companyId)->pluck('product_id');
                    if ($productIds!=null) {
                        $categoryIds = ProductCategory::whereIn('product_id',$productIds)->pluck('category_id');
                          if ($categoryIds!=null) {
                              $categoryDetails = Category::whereIn('id',$categoryIds)->orderBy('id','DESC')->get();
                               $responce =  $this->categoryDetails($categoryDetails);
                              return response()->json(['data' => $responce ,'success'=> 'Success']);

                          } else {
                              return response()->json(['error' => 'Dose not metch any Category']);
                          }
                          
                    } else {
                      return response()->json(['error' => 'Dose not have any Inventory']);
                    }
              } else {
               return response()->json(['error' => 'Dose not have any Bar']);
              }
    } catch (\Exception $e) {
      return error_json($e);
    }
  }

  public function categoryDetails($categoryDetails)
  {
    $data = [];

    foreach ($categoryDetails as $details) {
        $data[]=[
          'id' => $details->id,
          'name' => $details->name,
          'image' => url('images/'.$details->image)
        ];
    }

    return $data;
   
  }

  //////////////////////// Get invoice details date wise or get current month ////////////////////////////////
  public function getInvoice(Request $request)
  {
    $companyId = '';
    $companyId = Company::where('assign_to',auth()->user()->id)->value('id');
    if (empty($companyId) || $companyId == '') {
        $parent_id = User::where('id',auth()->user()->id)->value('parent_id');
        $companyId = Company::where('assign_to',$parent_id)->value('id');
    }
    if (!empty($request->selectData) ) {
      $purchages = Order::where('created_at', '<=', Carbon::now())->where('created_at', '>=',$request->selectData)->where('company_id',$companyId)->get();
      return response()->json(['data' => $purchages ,'success'=> 'Success']);
    } else {
      $purchages=Order::where('deleted',0)->with('details')->where('created_at', '>=', Carbon::now()->startOfMonth())->where('company_id',$companyId)->get();
      return response()->json(['data' => $purchages ,'success'=> 'Success']);

    }
  }

  ////////////////////// Invoive details for api //////////////////////////////
  public function showInvoiceApp(Request $request)
    {
      try {
            $responce = [];
           $invoiceDetails=Order::where('id',$request->id)->with('details')->first();
           $bar=Company::where('id',$invoiceDetails->company_id)->first();
           $responce['invoiceDetails']=$invoiceDetails;
           $responce['barDetails']=$bar;
           //echo $invoiceDetails;die;
          return response()->json($responce);
      } catch (\Exception $e) {
        return error_json($e);
      }
    }

    /////////////////////////////  Get Order Status With Order Id ////////////////

  public function orderStatus(Request $request)
  {
    try {
      if(!empty($request->order_id)){
        $orderStatus  = Order::where('id',$request->order_id)->first();
        return response()->json($orderStatus);
      }
    } catch (\Exception $th) {
      return response()->json(['error' => 'Server Error']);
    }
  }

  public function acceptDriver(Request $request)
  {
    try {
      if(!empty($request->id)){
        $result  = Order::where('id',$request->id)->update(['status' => 3]);
        $order=Order::where('id',$request->id)->with('details')->first();
        $responce =  $this->acceptOrderInfo($order);
        return response()->json(['data' =>$responce, 'success' => 'Success']);
      }
      else
      {
        return response()->json(['error' => 'Please select the order']);
      }  
    } catch (\Exception $th) {
      return response()->json(['error' => 'Server Error']);
    }
  }

  public function acceptOrderInfo($order)
    {
        $data=[
          'id' => $order->id,
          'order_number' => $order->order_number,
          'order_date' => date('M-d-Y',strtotime($order->order_date)),
          'order_count' => $this->assignOrderCount($order->id),
          'status' => $order->status,
          'details' => $this->assignOrderInfoDetails($order->details),
          'company_details' => $this->companyDetails($order->company_id),
        ];
       return $data;
    }

  public function assignOrders()
  {
    try {
          $orderIds=Assignorder::where('driver_id',auth()->user()->id)->pluck('order_id');
          if(count($orderIds)==0)
          {
            return response()->json(['error' => 'No order assign to you']);
          }
          else{
                $orders=Order::where('deleted',0)->whereIn('id',$orderIds)->whereIn('status',[2,3,4])->orderBy('id','DESC')->with('details')->get();
                $responce =  $this->assignOrderInfo($orders);
                return response()->json(['data' => $responce ,'success'=> 'Success']);
          } 
    } catch (\Exception $e) {
      return error_json($e);
    }
  }

  public function assignOrderInfo($orders)
    {
       $data=[];
       foreach($orders as $order)
       {
        $data[]=[
          'id' => $order->id,
          'order_number' => $order->order_number,
          'order_date' => date('M-d-Y',strtotime($order->order_date)),
          'order_count' => $this->assignOrderCount($order->id),
          'status' => $order->status,
          'details' => $this->assignOrderInfoDetails($order->details),
          'company_details' => $this->companyDetails($order->company_id),
        ];
       } 
       return $data;
    }

    public function assignOrderInfoDetails($details)
    {
      $data=[];
      foreach($details as $detail)
      {
        $data[]=[
          'product_id' => $detail->id,
          'product_name' => $detail->product_name,
          'order_qty' => $detail->pivot->qty,
          'total_amount' => $detail->pivot->total_amount,
          'image' => url('Pimages/'.$detail->image)
        ];
      }
      return $data;  

    }

    public function companyDetails($company_id)
    {
      try {
            $userId = Company::where('id',$company_id)->value('assign_to');
            $details = Company::where('assign_to',$userId)->first();
            $userDetails = User::where('id',$userId)->first();

        $data=[
          'bar_name' => $details->company_name,
          'bar_owner_name' => $userDetails->name,
          'bar_owner_email' => $userDetails->email,
          'bar_owner_mobile' => $userDetails->mobile,
          'bar_address' => $details->address,
          'bar_pincode' => $details->pincode,
        ];
      return $data;
      } catch (\Exception $e) {
        return error_json($e);
      }
      
    }

    public function getBarAddress($user_id='')
    {
      
    }
    public function assignOrderCount($order_id)
    {
      return Order_details::where('order_id',$order_id)->where('deleted',0)->count();
    }

    public function orderDelivered(Request $request)
    {
      try {
             if(!empty($request->id) && !empty($request->vcode)){

                 $vcode=Order::where('id',$request->id)->value('vcode');
                 if($vcode==$request->vcode)
                 {
                     $result  = Order::where('id',$request->id)->update(['status' => 4]);
                     $order=Order::where('id',$request->id)->first();
                     return response()->json(['data' => '', 'status' =>$order->status, 'success' => 'Success']);
                 }
                 else
                 {
                    return response()->json(['error' => 'Code does not match']);
                 }
              }
              else
              {
                return response()->json(['error' => 'Please select the order']);
              }  

      } catch (\Exception $e) {
        return error_json($e);
      }
    }

}
