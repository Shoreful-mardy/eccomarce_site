<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;


class ReturnController extends Controller
{
    public function ReturnRequest(){
        $orders = Order::where('return_order', 1)->orderBy('id','DESC')->get();

        return view('backend.return_order.return_request',compact('orders'));

    }//End Method

    public function ReturnRequestApprove($order_id){
        Order::findOrFail($order_id)->update(['return_order' => 2]);

        $notification = array(
            'message' => 'Return Order Successfully',
            'alert-type' =>'success'
        );
        return redirect()->back()->with($notification);

    }//End Method

    public function ApprovedRequest(){
        $orders = Order::where('return_order', 2)->orderBy('id','DESC')->get();
        return view('backend.return_order.approved_return_request',compact('orders'));

    }//End Method
}
