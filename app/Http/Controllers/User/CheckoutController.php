<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\ShipDivision;
use App\Models\ShipDistricts;
use App\Models\Shipstate;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Auth;

class CheckoutController extends Controller
{
    public function DistrictGetAjax($division_id){
        $ship = ShipDistricts::where('division_id', $division_id)->orderBy('district_name','ASC')->get();
        return json_encode($ship);
    }//End Method


    public function StateGetAjax($district_id){
        $ShipState = Shipstate::where('district_id', $district_id)->orderBy('state_name','ASC')->get();
        return json_encode($ShipState);
    }//End Method

    public function CheckOutStore(Request $request){
        $data = array();
        $data['shipping_name'] = $request->shipping_name;
        $data['shipping_email'] = $request->shipping_email;
        $data['shipping_phone'] = $request->shipping_phone;
        $data['division_id'] = $request->division_id;
        $data['district_id'] = $request->district_id;
        $data['state_id'] = $request->state_id;
        $data['post_code'] = $request->post_code;
        $data['shipping_address'] = $request->shipping_address;
        $data['notes'] = $request->notes;
        $cartTotal = Cart::total();


        if($request->payment_option == 'stripe'){

            return view('frontend.payment.srtipe',compact('data','cartTotal'));

        }elseif($request->payment_option == 'card'){

            return view('frontend.payment.card',compact('data','cartTotal'));

        }elseif($request->payment_option == 'cash'){

            return view('frontend.payment.cash',compact('data','cartTotal'));

        }
        

    }//End Method 


}
