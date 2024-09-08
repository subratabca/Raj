<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Carbon\Carbon;
use App\Models\Order;

class AdminOrderController extends Controller
{
    public function OrderPage()
    {
        return view('backend.pages.dashboard.order-page');
    }

    public function OrderList(Request $request)
    {
        try {
            $user_id = $request->header('id');
            $orders = Order::with('user', 'food')->latest()->get();

            if ($orders->isEmpty()) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Order information not found',
                ], 404); 
            }

            return response()->json([
                'status' => 'success',
                'data' => $orders
            ], 200); 

        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'An error occurred while retrieving orders',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function OrderDetails($id)
    {
        try {
            $order = Order::with('user','food','food.user','food.foodImages')->findOrFail($id);
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