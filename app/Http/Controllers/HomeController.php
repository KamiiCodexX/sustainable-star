<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Delegate;
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
        $users = User::whereNot("id", Auth::id())->get()->toArray();
        $owner = User::where("id", Auth::id())->first()->toArray();
        $companies = Company::with('owner', 'delegates.user', 'delegates.permissions')->where("owner_id", Auth::id())->limit(5)->get()->toArray();
        $delegatedCompanies = Delegate::with('user', 'company', 'permissions')->where("user_id", Auth::id())->limit(5)->get()->toArray();
        $posts = Post::with('user', 'company')->orderBy('id', 'desc')->limit(10)->get()->toArray();
        // dd($delegatedCompanies);
        return view('home', compact('users', 'companies', 'posts', 'owner', 'delegatedCompanies'));
    }
}
