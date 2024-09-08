<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Notifications\FoodPublishNotification;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB; 
use Exception;
use App\Models\Food;
use App\Models\FoodImage;


class FoodController extends Controller
{
    public function FoodPage()
    {
        return view('backend.pages.dashboard.food-page');
    }
    

    public function index(Request $request)
    {
        try {
            $foods = Food::latest()->get();

            if ($foods->isEmpty()) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Food not found',
                ], 404); 
            }

            return response()->json([
                'status' => 'success',
                'data' => $foods
            ], 200); 

        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'An error occurred while retrieving foods',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function create(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'name' => 'required|string|min:3|max:255',
                'gradients' => 'required|string',
                'expire_date' => 'required|date',
                'description' => 'required|string',
                'collection_date' => 'required|date',
                'start_collection_time' => 'required|date_format:H:i',
                'end_collection_time' => 'required|date_format:H:i',
                'address' => 'required|string|min:3|max:255',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'multi_images' => 'required|array',
                'multi_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', 
            ]);

            $user_id = $request->header('id');
            $uploadPath = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $manager = new ImageManager(new Driver());
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $img = $manager->read($image);
                $img->resize(798, 370)->save(base_path('public/upload/food/large/' . $imageName));
                $img->resize(570, 380)->save(base_path('public/upload/food/medium/' . $imageName));
                $img->resize(80, 75)->save(base_path('public/upload/food/small/' . $imageName));
                $uploadPath = $imageName;
            }

            // Create food entry
            $food = Food::create([
                'name' => $request->input('name'),
                'gradients' => $request->input('gradients'),
                'expire_date' => $request->input('expire_date'),
                'description' => $request->input('description'),
                'collection_date' => $request->input('collection_date'),
                'start_collection_time' => $request->input('start_collection_time'),
                'end_collection_time' => $request->input('end_collection_time'),
                'address' => $request->input('address'),
                'image' => $uploadPath,
                'user_id' => $user_id,
            ]);

            // Process and save multiple images
            if ($request->hasFile('multi_images')) {
                foreach ($request->file('multi_images') as $file) {
                    $multiImageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $img = $manager->read($file);
                    $img->resize(388, 472)->save(base_path('public/upload/food/multiple/' . $multiImageName));

                    FoodImage::create([
                        'food_id' => $food->id,
                        'image' => $multiImageName,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Food created successfully.',
                'data' => $food,
            ], 201);

        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'failed',
                'message' => 'Food creation failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function show($id)
    {
        try {
            $food = Food::with('user','foodImages')->findOrFail($id);
            return response()->json([
                'status' => 'success',
                'data' => $food
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Food not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    function edit(Request $request)
    {
        $user_id = $request->header('id');
        $food_id = $request->input('id');
        return Food::where('id',$food_id)->first();
    }


    public function update(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|min:3|max:255',
                'gradients' => 'required|string',
                'expire_date' => 'required|date',
                'description' => 'required|string',
                'collection_date' => 'required|date',
                'start_collection_time' => 'required',
                'end_collection_time' => 'required',
                'address' => 'required|string|min:3|max:255',
                'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $user_id = $request->header('id');
            $food_id = $request->input('id');

            $food = Food::findOrFail($food_id);

            if ($request->hasFile('image')) {
                $large_image_path = base_path('public/upload/food/large/');
                $medium_image_path = base_path('public/upload/food/medium/');
                $small_image_path = base_path('public/upload/food/small/');

                if (!empty($food->image)) {
                    if (file_exists($large_image_path . $food->image)) {
                        unlink($large_image_path . $food->image);
                    }
                    if (file_exists($medium_image_path . $food->image)) {
                        unlink($medium_image_path . $food->image);
                    }
                    if (file_exists($small_image_path . $food->image)) {
                        unlink($small_image_path . $food->image);
                    }
                }

                $image = $request->file('image');
                $manager = new ImageManager(new Driver());
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $img = $manager->read($image);

                $img->resize(798, 370)->save($large_image_path . $imageName);
                $img->resize(570, 380)->save($medium_image_path . $imageName);
                $img->resize(80, 75)->save($small_image_path . $imageName);

                $uploadPath = $imageName;
            } else {
                $uploadPath = $food->image;
            }

            $food->update([
                'name' => $request->input('name'),
                'gradients' => $request->input('gradients'),
                'expire_date' => $request->input('expire_date'),
                'description' => $request->input('description'),
                'collection_date' => $request->input('collection_date'),
                'start_collection_time' => $request->input('start_collection_time'),
                'end_collection_time' => $request->input('end_collection_time'),
                'address' => $request->input('address'),
                'image' => $uploadPath
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Food updated successfully.',
                'data' => $food
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
                'message' => 'Food update failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    function delete(Request $request)
    {
        try {
            $user_id = $request->header('id');
            $food_id = $request->input('id');

            $food = Food::findOrFail($food_id);

            $large_image_path = base_path('public/upload/food/large/');
            $medium_image_path = base_path('public/upload/food/medium/');
            $small_image_path = base_path('public/upload/food/small/');

            if (!empty($food->image)) {
                if (file_exists($large_image_path . $food->image)) {
                    unlink($large_image_path . $food->image);
                }
                if (file_exists($medium_image_path . $food->image)) {
                    unlink($medium_image_path . $food->image);
                }
                if (file_exists($small_image_path . $food->image)) {
                    unlink($small_image_path . $food->image);
                }
            }

            Food::where('id', $food_id)->where('user_id', $user_id)->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Food deleted successfully.'
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Food not found',
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


    public function status(Request $request)
    {
        try {
            $user_id = $request->header('id');
            $food_id = $request->input('id');
            $food = Food::with('user')->findOrFail($food_id);
            $result = $food->update([
                'status' => 'published'
            ]);

            if ($food->user->role === 'client') {
                $food->user->notify(new FoodPublishNotification($food));
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Food status updated successfully.'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Food not found',
                'error' => $e->getMessage()
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Status update failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}