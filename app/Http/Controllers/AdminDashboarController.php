<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = 'Dashboard';
        $name = $request->name;
        $rol = $request->rol;
        $links = $request->links;
        $photo = $request->photo;
        return view('academia.admin.dashboard', compact('title', 'name', 'rol', 'links', 'photo'));
    }

}
