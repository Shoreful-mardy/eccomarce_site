<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function UserDashboard(){
        $id = Auth::user()->id;
        $userData = User::find($id);
        return view('index',compact('userData'));

    }//End Method

    public function UserProfileStore(Request $request){

        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->username = $request->username;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        
        if($request->file('photo')){
            $file = $request->file('photo');
            @unlink(public_path('upload/users_images/'.$data->photo));
            $filename = date('ymdhi').$file->getClientOriginalName();
            $file->move(public_path('upload/users_images'),$filename);
            $data['photo'] = $filename;
        }

        $data->save();

        $notification = array(
            'message' => 'User Profile Updated Successfully',
            'alert-type' =>'success'
        );
        return redirect()->back()->with($notification);

    }//End Method

    public function UserDestroy(Request $request){
    
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $notification = array(
            'message' => 'User Logout Successfully',
            'alert-type' =>'success'
        );

        return redirect('/login')->with($notification);
    }//End Method

    public function UserChangePassword(Request $request){

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
}
