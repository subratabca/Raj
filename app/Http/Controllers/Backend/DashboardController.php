<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use App\Models\User;

class DashboardController extends Controller
{
    public function DashboardPage():View{
        return view('backend.pages.dashboard.dashboard-page');
    }

    public function Logout(){
        return redirect('/admin/login')->withCookie(cookie()->forget('token'));
    }

}
