<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\SiteSetting;

class SiteSettingController extends Controller
{
    function SettingPage(){
        return view('backend.pages.dashboard.site-setting-page');
    }

    function SettingList(Request $request){
        $admin_id=$request->header('id');
        return SiteSetting::get();
    }

    function SettingCreate(Request $request)
    {
        $admin_id=$request->header('id');

        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $manager = new ImageManager(new Driver());
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $img = $manager->read($image);

            $img->resize(276,55)->save(base_path('public/upload/site-setting/'.$imageName));
            $uploadPath = $imageName;
        }else{
            $uploadPath = null; 
        }

        return SiteSetting::create([
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'phone1'=>$request->input('phone1'),
            'phone2'=>$request->input('phone2'),
            'logo'=>$uploadPath,

            'address'=>$request->input('address'),
            'city'=>$request->input('city'),
            'country'=>$request->input('country'),
            'zip_code'=>$request->input('zip_code'),

            'facebook'=>$request->input('facebook'),
            'linkedin'=>$request->input('linkedin'),
            'youtube'=>$request->input('youtube'),

            'description'=>$request->input('description'),
            'refund'=>$request->input('refund'),
            'terms'=>$request->input('terms'),
            'privacy'=>$request->input('privacy')
        ]);
    }


    function SettingByID(Request $request)
    {
        $admin_id=$request->header('id');
        $setting_id=$request->input('id');
        return SiteSetting::where('id',$setting_id)->first();
    }


    function UpdateSetting(Request $request)
    {
        $admin_id=$request->header('id');
        $setting_id=$request->input('id');

        $siteSetting = SiteSetting::findOrFail($setting_id);

        if($request->hasFile('logo')) {
            $image_path = base_path('public/upload/site-setting/');

            if(!empty($siteSetting->logo)){
                if(file_exists($image_path.$siteSetting->logo)){
                    unlink($image_path.$siteSetting->logo);
                }
            }

            $image = $request->file('logo');
            $manager = new ImageManager(new Driver());
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $img = $manager->read($image);

            $img->resize(276,55)->save($image_path.$imageName);

            $uploadPath = $imageName;
        }else{
            $uploadPath = $siteSetting->logo;
        }

        return SiteSetting::where('id',$setting_id)->update([
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'phone1'=>$request->input('phone1'),
            'phone2'=>$request->input('phone2'),
            'logo'=>$uploadPath,

            'address'=>$request->input('address'),
            'city'=>$request->input('city'),
            'country'=>$request->input('country'),
            'zip_code'=>$request->input('zip_code'),

            'facebook'=>$request->input('facebook'),
            'linkedin'=>$request->input('linkedin'),
            'youtube'=>$request->input('youtube'),

            'description'=>$request->input('description'),
            'refund'=>$request->input('refund'),
            'terms'=>$request->input('terms'),
            'privacy'=>$request->input('privacy')
        ]);


    }


    function DeleteSetting(Request $request)
    {
        $admin_id=$request->header('id');
        $setting_id=$request->input('id');

        $siteSetting = SiteSetting::findOrFail($setting_id);
        $image_path = base_path('public/upload/site-setting/');

        if(!empty($siteSetting->logo)){
            if(file_exists($image_path.$siteSetting->logo)){
                unlink($image_path.$siteSetting->logo);
            }
        }
        
        return SiteSetting::where('id',$setting_id)->delete();

    }
    
}