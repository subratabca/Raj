<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Models\SiteSetting;
use App\Models\Slider;
use App\Models\Food;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function HomePage()
    {
        return view('frontend.pages.home-page');
    }


public function SettingList(): JsonResponse
{
    try {
        $data = SiteSetting::first(); 

        if ($data) { 
            return response()->json([
                'status' => 'success',
                'message' => 'Request Successful',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'No data found',
                'data' => null
            ], 404); 
        }
    } catch (Exception $e) {
        return response()->json([
            'status' => 'failed',
            'message' => 'An error occurred while processing your request',
            'error' => $e->getMessage() 
        ], 500);
    }
}



    public function SliderList():JsonResponse
    {
        try {
            $data = Slider::all(); 

            if ($data->isNotEmpty()) { 
                return response()->json([
                    'status' => 'success',
                    'message' => 'Request Successful',
                    'data' => $data
                ], 200);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'No data found'
                ], 404); 
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'An error occurred'
            ], 500);
        }
    }


    public function FoodList(Request $request,$id=null)
    {
        try {
            $currentDate = Carbon::now(new \DateTimeZone('Asia/Dhaka'));
            $foods = Food::where('expire_date', '>=', $currentDate)
                        ->where('status', 'published')
                        ->orWhere('status', 'processing')
                        ->latest()
                        ->paginate(6);

            if ($foods->isNotEmpty()) { 
                return response()->json([
                    'status' => 'success',
                    'message' => 'Request Successful',
                    'foods' => $foods
                ], 200);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Food Not Found'
                ], 404); 
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'An error occurred'
            ], 500);
        }
    }


    public function getAvailableFoodByDate(Request $request, $date)
    {
        try {
            $timezone = new \DateTimeZone('Asia/Dhaka');
            $date = Carbon::parse($date, $timezone)->format('Y-m-d');

            $foods = Food::where('expire_date', '>=', $date)
                    ->whereDate('collection_date', $date)
                    ->where(function ($query) {
                        $query->where('status', 'published')
                              ->orWhere('status', 'processing');
                    })
                    ->latest()
                    ->paginate(6);

            if ($foods->isNotEmpty()) { 
                return response()->json([
                    'status' => 'success',
                    'message' => 'Request successful',
                    'foods' => $foods
                ], 200);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Food not found'
                ], 404); 
            }

        } catch (\Exception $e) {
            // Log the exception for debugging purposes
            \Log::error('Error fetching available food by date: ' . $e->getMessage());

            return response()->json([
                'status' => 'failed',
                'error' => 'An error occurred while fetching available food. Please try again later.'
            ], 500);
        }
    }



    public function searchFood(Request $request)
    {
        try {
            $query = $request->input('query');
            $currentDate = Carbon::now(new \DateTimeZone('Asia/Dhaka'));

            $foods = Food::where(function ($q) use ($query) {
                                $q->where('name', 'like', "%{$query}%")
                                  ->orWhere('address', 'like', "%{$query}%");
                            })
                            ->where('expire_date', '>=', $currentDate)
                            ->where(function ($q) {
                                $q->where('status', 'published')
                                  ->orWhere('status', 'processing');
                            })
                            ->get();

            if ($foods->isEmpty()) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'No food available matching your search criteria.'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'foods' => $foods
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'An error occurred while searching for food.'
            ], 500);
        }
    }


}