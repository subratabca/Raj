<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Models\User;

class ClientListController extends Controller
{
    public function ClientPage()
    {
        return view('backend.pages.dashboard.client-list-page');
    }

    public function ClientList(Request $request)
    {
        try {
            $clients = User::where('role', 'client')
                ->withCount(['foods' => function ($query) {
                    $query->where('status', '!=', 'pending');
                }])
                ->latest()
                ->get();

            if ($clients->isEmpty()) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Clients not found',
                ], 404);
            }

            $clients = $clients->map(function ($client) {
                return [
                    'id' => $client->id,
                    'firstName' => $client->firstName,
                    'lastName' => $client->lastName,
                    'email' => $client->email,
                    'mobile' => $client->mobile,
                    'image' => $client->image,
                    'created_at' => $client->created_at,
                    'non_pending_food_count' => $client->foods_count,
                ];
            });

            return response()->json([
                'status' => 'success',
                'data' => $clients
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'An error occurred while retrieving clients',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    
}