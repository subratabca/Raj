<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException; 
use Exception;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Food;

class UserDashboardController extends Controller
{
    public function DashboardPage():View
    {
        return view('frontend.pages.dashboard.dashboard-page');
    }


public function DashboardOrderDetailsInfo(Request $request)
{
    try {
        $id = $request->header('id');
        
        if (!$id) {
            return response()->json([
                'status' => 'failed',
                'message' => 'ID header is missing'
            ], 404);
        }

        // Fetch all orders that match the given ID
        $orders = Order::with('user', 'food', 'food.user')->where('user_id', $id)->get();

        // Check if any orders were found
        if ($orders->isEmpty()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Order information not found'
            ], 404);
        }

        // Calculate order statistics
        $totalRequest = $orders->count();
        $pendingOrder = $orders->where('status', 'pending')->count();
        $completedOrder = $orders->where('status', 'completed')->count();
        $canceledOrder = $orders->where('status', 'canceled')->count();

        return response()->json([
            'status' => 'success',
            'data' => [
                'totalRequest' => $totalRequest,
                'pendingOrder' => $pendingOrder,
                'completedOrder' => $completedOrder,
                'canceledOrder' => $canceledOrder
            ]
        ], 200);
    } catch (Exception $e) {
        return response()->json([
            'status' => 'failed',
            'message' => 'An error occurred while fetching the order details',
            'error' => $e->getMessage()
        ], 500);
    }
}





    public function Logout()
    {
        return redirect('/')->withCookie(cookie()->forget('token'));
    }

}