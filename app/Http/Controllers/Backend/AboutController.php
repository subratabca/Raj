<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\About;

class AboutController extends Controller
{
    function AboutPage(){
        return view('backend.pages.dashboard.about-page');
    }

    function AboutList(Request $request){
        $admin_id=$request->header('id');
        return About::latest()->get();
    }

    function AboutCreate(Request $request)
    {
        $admin_id=$request->header('id');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $img = $manager->read($image);

            $img->resize(354,400)->save(base_path('public/upload/about/'.$imageName));
            $uploadPath = $imageName;
        }else{
            $uploadPath = null; 
        }

        return About::create([
            'title'=>$request->input('title'),
            'description'=>$request->input('description'),
            'image'=>$uploadPath
        ]);
    }


    function AboutByID(Request $request)
    {
        $admin_id=$request->header('id');
        $about_id=$request->input('id');
        return About::where('id',$about_id)->first();
    }


    function UpdateAbout(Request $request)
    {
        $admin_id=$request->header('id');
        $about_id=$request->input('id');

        $about = About::findOrFail($about_id);

        if($request->hasFile('img')) {
            $image_path = base_path('public/upload/about/');

            if(!empty($about->image)){
                if(file_exists($image_path.$about->image)){
                    unlink($image_path.$about->image);
                }
            }

            $image = $request->file('img');
            $manager = new ImageManager(new Driver());
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $img = $manager->read($image);

            $img->resize(354,400)->save($image_path.$imageName);

            $uploadPath = $imageName;
        }else{
            $uploadPath = $about->image;
        }

        return About::where('id',$about_id)->update([
            'title'=>$request->input('title'),
            'description'=>$request->input('description'),
            'image'=>$uploadPath
        ]);

    }


    function DeleteAbout(Request $request)
    {
        $admin_id=$request->header('id');
        $about_id=$request->input('id');
        $about = About::findOrFail($about_id);

        $image_path = base_path('public/upload/about/');

        if(!empty($about->image)){
            if(file_exists($image_path.$about->image)){
                unlink($image_path.$about->image);
            }
        }

        return About::where('id',$about_id)->delete();
    }

}