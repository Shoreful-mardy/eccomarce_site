<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShipDistricts;
use App\Models\ShipDivision;
use App\Models\Shipstate;
use Carbon\Carbon;
class ShippingAreaController extends Controller
{
//////////////////////////////Shipping Division Method Start/////////////////////////////////
    public function AllDivision(){
        $division = ShipDivision::latest()->get();
        return view('backend.ship.division.division_all',compact('division'));
    }//End Method

    public function AddDivision(){
        return view('backend.ship.division.division_add');
    }//End Method

    public function StoreDivision(Request $request){
        ShipDivision::insert([
            'division_name' => $request->division_name,
        ]);

        $notification = array(
            'message' => 'Division Inserted Successfully',
            'alert-type' => 'success'  
        );
        return redirect()->route('all.division')->with($notification);
    }//End Method

    public function EditDivision($id){
        $division = ShipDivision::findOrfail($id);
        return view('backend.ship.division.division_edit',compact('division'));
    }//End Method

    public function UpdateDivision(Request $request){


       ShipDivision::findOrfail($request->id)->update([
       'division_name' => $request->division_name,
       ]);

       $notification = array(
            'message' => 'Division Edited Successfully',
            'alert-type' => 'success'  
        );
        return redirect()->route('all.division')->with($notification);
    }//End Method

    public function DeleteDivision($id){

        ShipDivision::findOrfail($id)->delete();

         $notification = array(
            'message' => 'Division Deleted Successfully',
            'alert-type' => 'success'  
        );
        return redirect()->route('all.division')->with($notification);
    }//End Metho

//////////////////////////////Shipping District Method Start/////////////////////////////////

    public function AllDistrict(){
        $district = ShipDistricts::latest()->get();
        return view('backend.ship.district.district_all',compact('district'));
    }//End Method

    public function AddDistrict(){
        $division = ShipDivision::orderBy('division_name', 'ASC')->get();
        return view('backend.ship.district.district_add',compact('division'));
    }//End Method

    public function StoreDistrict(Request $request){

        ShipDistricts::insert([
            'division_id' => $request->division_id,
            'district_name' => $request->district_name,
        ]);

        $notification = array(
            'message' => 'District Inserted Successfully',
            'alert-type' => 'success'  
        );
        return redirect()->route('all.district')->with($notification);
    }//End Method

    public function EditDistrict($id){
        $division = ShipDivision::orderBy('division_name', 'ASC')->get();
        $district = ShipDistricts::findOrfail($id);
        return view('backend.ship.district.district_edit',compact('district','division'));
    }//End Method

    public function UpdateDistrict(Request $request){

       $district_id = $request->id;
       ShipDistricts::findOrfail($district_id)->update([
            'division_id' => $request->division_id,
            'district_name' => $request->district_name,
       ]);

       $notification = array(
            'message' => 'District Updated Successfully',
            'alert-type' => 'success'  
        );
        return redirect()->route('all.district')->with($notification);
    }//End Method


    public function DeleteDistrict($id){

        ShipDistricts::findOrfail($id)->delete();

         $notification = array(
            'message' => 'District Deleted Successfully',
            'alert-type' => 'success'  
        );
        return redirect()->route('all.district')->with($notification);
    }//End Metho

//////////////////////////////Shipping State Method Start/////////////////////////////////
    public function AllState(){

        $state = Shipstate::latest()->get();
        return view('backend.ship.state.state_all',compact('state'));
    }//End Method

    public function AddState(){

        $division = ShipDivision::orderBy('division_name', 'ASC')->get();
        $district = ShipDistricts::orderBy('district_name', 'ASC')->get();

        return view('backend.ship.state.state_add',compact('division','district'));
    }//End Method

    public function GetDistrict($division_id){

        $dist = ShipDistricts::where('division_id', $division_id)->orderBy('district_name','ASC')->get();
        return json_encode($dist);
    }//End Method

    public function StoreState(Request $request){

        Shipstate::insert([
            'division_id' => $request->division_id,
            'district_id' => $request->district_id,
            'state_name' => $request->state_name,
        ]);

        $notification = array(
            'message' => 'State Inserted Successfully',
            'alert-type' => 'success'  
        );
        return redirect()->route('all.state')->with($notification);
    }//End Method

    public function EditState($id){
        $division = ShipDivision::orderBy('division_name', 'ASC')->get();
        $district = ShipDistricts::orderBy('district_name', 'ASC')->get();
        $state = Shipstate::findOrfail($id);
        return view('backend.ship.state.state_edit',compact('division','district','state'));
    }//End Method

    public function UpdateState(Request $request){

       $state_id = $request->id;

       Shipstate::findOrfail($state_id)->update([
            'division_id' => $request->division_id,
            'district_id' => $request->district_id,
            'state_name' => $request->state_name,
       ]);

       $notification = array(
            'message' => 'State Updated Successfully',
            'alert-type' => 'success'  
        );
        return redirect()->route('all.state')->with($notification);
    }//End Method

    public function DeleteState($id){

        Shipstate::findOrfail($id)->delete();

         $notification = array(
            'message' => 'State Deleted Successfully',
            'alert-type' => 'success'  
        );
        return redirect()->route('all.state')->with($notification);
    }//End Metho






}
