<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil 4 item menu secara acak
        $popularMenus = Menu::inRandomOrder()->take(4)->get();

        return view('home', compact('popularMenus'));
    }
}
