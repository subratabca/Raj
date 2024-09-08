<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Validation\ValidationException; 
use Exception;
use App\Models\Slider;


class SliderController extends Controller
{
    function SliderPage(){
        return view('backend.pages.dashboard.slider-page');
    }

    function SliderList()
    {
        return Slider::latest()->get();
    }

    function SliderCreate(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $manager = new ImageManager(new Driver());
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $img = $manager->read($image);

                $img->resize(1920, 800)->save(base_path('public/upload/slider/' . $imageName));
                $uploadPath = $imageName;
            } else {
                $uploadPath = null;
            }

            $slider = Slider::create([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'image' => $uploadPath
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Slider created successfully.',
                'data' => $slider
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Failed',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Slider creation failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    function SliderByID(Request $request)
    {
        $slider_id = $request->input('id');
        return Slider::where('id',$slider_id)->first();
    }


    function UpdateSlider(Request $request)
    {
        try {
            $request->validate([
                'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $slider_id = $request->input('id');

            $slider = Slider::findOrFail($slider_id);

            if ($request->hasFile('image')) {
                $image_path = base_path('public/upload/slider/');

                if (!empty($slider->image)) {
                    if (file_exists($image_path . $slider->image)) {
                        unlink($image_path . $slider->image);
                    }
                }

                $image = $request->file('image');
                $manager = new ImageManager(new Driver());
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $img = $manager->read($image);

                $img->resize(1920, 800)->save($image_path . $imageName);

                $uploadPath = $imageName;
            } else {
                $uploadPath = $slider->image;
            }

            $slider->update([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'image' => $uploadPath
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Slider updated successfully.',
                'data' => $slider
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Failed',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Slider update failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    function DeleteSlider(Request $request)
    {
        try {
            $slider_id = $request->input('id');
            $slider = Slider::findOrFail($slider_id);
            
            $image_path = base_path('public/upload/slider/');

            if (!empty($slider->image)) {
                if (file_exists($image_path . $slider->image)) {
                    unlink($image_path . $slider->image);
                }
            }

            Slider::where('id', $slider_id)->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Slider deleted successfully.'
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Slider not found',
                'error' => $e->getMessage()
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Deletion failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
}