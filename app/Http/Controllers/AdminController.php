<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminController extends Controller
{
    public function AdminDashboard(){

        return view('admin.index');

    }//End Method

    public function AdminLogin(){

        return view('admin.admin_login');
    }//End Method

    public function AdminDestroy(Request $request){
    
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }//End Method

    public function AdminProfile(){

        $id = Auth::user()->id;
        $adminData = User::find($id);
        return view('admin.admin_profile_view',compact('adminData'));

    }//End Method

    public function AdminProfileStore(Request $request){
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        
        if($request->file('photo')){
            $file = $request->file('photo');
            @unlink(public_path('upload/admin_images/'.$data->photo));
            $filename = date('ymdhi').$file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'),$filename);
            $data['photo'] = $filename;
        }

        $data->save();

        $notification = array(
            'message' => 'Admin Profile Updated Successfully',
            'alert-type' =>'success'
        );
        return redirect()->back()->with($notification);

    }//End Method

    public function AdminChangePassword(){

        return view('admin.admin_change_password');


    }//End Method

    public function AdminUpdatePassword(Request $request){

        //validation
        $request->validate([

            'old_password' => 'required',

            'new_password' => 'required',

            'confirmation_password' => 'required',

        ]);

        //match the old password
        if (!Hash::check($request->old_password, auth::user()->password)) {
            return back()->with("error", "Old Password Doesn't Match!!");

        }elseif ($request->new_password !== $request->confirmation_password) {
            //match the confrimation password
            return back()->with("error", "Confirmation Password Doesn't Match!!");
        } 

        //update the new password 
        User::whereId(auth()->user()->id)->update([

            'password'=>Hash::make($request->new_password)

        ]);
        return back()->with("status", "Password Changed Succesfully");
    }//End Method

    public function InactiveVendor(){
        $inActiveVendor = User::where('status','inactive')->where('role','vendor')->latest()->get();
        return view('backend.vendor.inactive_vendor',compact('inActiveVendor'));
    }//End Method

    public function ActiveVendor(){
        $activeVendor = User::where('status','active')->where('role','vendor')->latest()->get();
        return view('backend.vendor.active_vendor',compact('activeVendor'));
    }//End Method

    public function InactiveVendorDetails($id){
        $inActiveVendorDetails = User::findOrFail($id);
        return view('backend.vendor.inactive_vendor_details',compact('inActiveVendorDetails'));
    }//End Method

    public function ActiveVendorApprove(Request $request){
        $vendor_id = $request->id;
        $user = User::findOrFail($vendor_id)->update([
            'status' => 'active',
        ]);
        $notification = array(
            'message' => 'Vendor Actived Successfully',
            'alert-type' =>'success'
        );
        return redirect()->route('active.vendor')->with($notification);
    }//End Method

    public function ActiveVendorDetails($id){
        $activeVendorDetails = User::findOrFail($id);
        return view('backend.vendor.active_vendor_details',compact('activeVendorDetails'));
    }//End Method

    public function InactiveVendorApprove(Request $request){
        $vendor_id = $request->id;
        $user = User::findOrFail($vendor_id)->update([
            'status' => 'inactive',
        ]);
        $notification = array(
            'message' => 'Vendor Inactived Successfully',
            'alert-type' =>'success'
        );
        return redirect()->route('inactive.vendor')->with($notification);
    }//End Method

    public function AllAdmin(){

        $admin = User::where('role','admin')->where('status','active')->get();
        return view('backend.admin.all_admin',compact('admin'));

    }//End Method


    public function AddAdmin(){

        $roles = Role::all();
        return view('backend.admin.add_admin',compact('roles'));

    }//End Method

    public function StoreAdmin(Request $request){

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->role = 'admin';
        $user->status = 'active';
        $user->save();

        if ($request->roles) {
            $user->assignRole($request->roles);
        }
        $notification = array(
            'message' => 'Admin User Created Successfully',
            'alert-type' =>'success'
        );
        return redirect()->route('all.admin')->with($notification);

    }//End Method

    

}
