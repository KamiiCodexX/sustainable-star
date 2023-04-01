<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::all()->except(Auth::id())->toArray();
        $companies = Company::with('owner', 'delegates.user', 'delegates.permissions')->where("owner_id", Auth::id())->get()->toArray();
        $posts = Post::with('user', 'company')->orderBy('id', 'desc')->get()->toArray();
        // dd($companies);
        return view('home', compact('users', 'companies', 'posts'));
    }
}
