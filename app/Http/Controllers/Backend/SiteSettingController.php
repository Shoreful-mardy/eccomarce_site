<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteSetting;
use App\Models\Seo;
use Image;

class SiteSettingController extends Controller
{
    public function SiteSetting(){
        $setting = SiteSetting::find(1);

        return view('backend.setting.setting_update',compact('setting'));
    }//End Method

    public function SiteSettingUpdate(Request $request){

        $set_id = $request->id;

        if($request->file('logo')){

            
            $image = $request->file('logo');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(188,56)->save('upload/logo/'.$name_gen);
            $save_url = 'upload/logo/'.$name_gen;

            /*if(file_exists($old_image)){
                unlink($old_image);
            }*/
            SiteSetting::findOrfail($set_id)->update([
                'support_phone' => $request->support_phone,
                'phone_one' =>  $request->phone_one,
                'email' =>  $request->email,
                'company_address' =>  $request->company_address,
                'facebook' =>  $request->facebook,
                'twitter' =>  $request->twitter,
                'youtube' =>  $request->youtube,
                'copyright' =>  $request->copyright,
                'logo' => $save_url,
            ]);

            $notification = array(
                'message' => 'Setting Successfully Updated with Image',
                'alert-type' => 'success'  
            );
    
            return redirect()->back()->with($notification);
        }else{

            SiteSetting::findOrfail($set_id)->update([
                'support_phone' => $request->support_phone,
                'phone_one' =>  $request->phone_one,
                'email' =>  $request->email,
                'company_address' =>  $request->company_address,
                'facebook' =>  $request->facebook,
                'twitter' =>  $request->twitter,
                'youtube' =>  $request->youtube,
                'copyright' =>  $request->copyright,
            ]);

            $notification = array(
                'message' => 'Setting Successfully Updated without Image',
                'alert-type' => 'success'  
            );
    
            return redirect()->back()->with($notification);

        }//End Else


    }//End Method

//=====================SEO SETTING============///
    public function SiteSettingSeo(){

        $seo = Seo::find(1);
        return view('backend.seo.seo_update',compact('seo'));
    }//End Method

    public function SeoSettingUpdate(Request $request){
        $seo_id = $request->id;

        Seo::findOrfail($seo_id)->update([
            'meta_title' => $request->meta_title,
            'meta_author' => $request->meta_author,
            'meta_keyword' => $request->meta_keyword,
            'meta_description' => $request->meta_description,
        ]);

         $notification = array(
                'message' => 'Seo Setting Successfully Updated',
                'alert-type' => 'success'  
            );

        return redirect()->back()->with($notification);



    }//End Method
























}
