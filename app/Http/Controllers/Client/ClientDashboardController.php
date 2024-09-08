<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use App\Models\User;

class ClientDashboardController extends Controller
{
    public function DashboardPage():View{
        return view('client.pages.dashboard.dashboard-page');
    }


    public function Logout(){
        return redirect('/client/login')->withCookie(cookie()->forget('token'));
    }

}
