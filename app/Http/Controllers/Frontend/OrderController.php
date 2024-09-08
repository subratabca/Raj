<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notifications\FoodRequestNotification;
use Illuminate\Validation\ValidationException; 
use Exception;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Food;

class OrderController extends Controller
{
    public function StoreFoodRequest(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:food,id',
            ]);

            $user_id = $request->header('id');
            $food_id = $request->input('id');

            $user = User::find($user_id);
            if (!$user) {
                return response()->json([
                    'status' => 'unauthorized',
                    'message' => 'User not found. Need to login'
                ], 401);
            }

            $currentDateTime = Carbon::now();
            $order_date = $currentDateTime->format('d F Y');
            $order_time = $currentDateTime->format('h:i:s A');

            $existingOrder = Order::where('user_id', $user_id)
                                  ->where('order_date', $order_date)
                                  ->exists();

            if ($existingOrder) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'You have already created an order for today.',
                ], 400); 
            }

            $order = Order::create([
                'user_id' => $user_id,
                'food_id' => $food_id,
                'order_date' => $order_date,
                'order_time' => $order_time
            ]);

            if ($order) {
                $food = Food::with('user')->findOrFail($food_id);
                $food->update(['status' => 'processing']);
                
                if ($food->user->role === 'client') {
                    $food->user->notify(new FoodRequestNotification($food));
                }

                return response()->json([
                    'status' => 'success',
                    'message' => 'Food request accepted successfully.',
                    'data' => $order
                ], 201);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Failed to create order.',
                ], 500);
            }

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Food request failed.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function OrderPage(){
        return view('frontend.pages.dashboard.order-page');
    }

    public function OrderList(Request $request)
    {
        try {
            $id = $request->header('id');
            $order = Order::with('user','food','food.user')->where('user_id',$id)->get();
            return response()->json([
                'status' => 'success',
                'data' => $order
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Order information not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function OrderDetailsPage(){
        return view('frontend.pages.dashboard.order-details-page');
    }

    public function OrderDetailsInfo($order_id)
    {
        try {
            $order = Order::with('user','food','food.user')->where('id',$order_id)->first();
            return response()->json([
                'status' => 'success',
                'data' => $order
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Order information not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }
    

}