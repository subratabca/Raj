<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Models\User;

class CustomerListController extends Controller
{
    public function CustomerPage()
    {
        return view('backend.pages.dashboard.customer-list-page');
    }

    public function CustomerList(Request $request)
    {
        try {

            $customers = User::where('role', 'user')->latest()->get();

            if ($customers->isEmpty()) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Customers not found',
                ], 404); 
            }

            return response()->json([
                'status' => 'success',
                'data' => $customers
            ], 200); 

        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'An error occurred while retrieving orders',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
}