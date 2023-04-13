<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Delegate;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
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

    public function store(Request $request)
    {
        try {

            $request->validate([
                'owner_id' => 'bail|required',
                'posted_by' => 'required',
                'text' => 'required|max:5000',
            ]);

            $post = Post::create($request->except('_token'));
            $html = view('posts.partials.view', compact('post'))->render();

            if ($post) {
                return response()->json(['success' => true, 'title' => 'success', 'type' => 'success', 'message' => 'Posted Successfully.', 'html' => $html]);
            } else {
                return response()->json(['success' => false, 'title' => 'success', 'type' => 'error', 'message' => 'Something went Wrong.']);
            }
        } catch (\Throwable $ex) {
            return response()->json(['success' => false, 'message' => $ex->getMessage() . ' on line ' . $ex->getLine() . ' on file ' . $ex->getFile()]);
        }
    }


    // public function index()
    // {
    //     $posts = Company::with('owner')->where("owner_id", Auth::id())->get()->toArray();
    //     return view('posts.list', compact('posts'));
    // }

    // public function add()
    // {
    //     $users = User::all()->except(Auth::id())->toArray();
    //     return view('posts.add', compact('users'));
    // }

    // public function getPosts(Request $request)
    // {
    //     try {
    //         $posts = Company::with('owner')->get()->toArray();
    //         return response()->json(['success' => true, 'title' => 'Success', 'type' => 'success', 'message' => "Received Posts", 'data' => $posts]);
    //     } catch (\Throwable $th) {
    //         return response()->json(['success' => false, 'title' => 'Error', 'type' => 'error', 'message' => $th->getMessage()]);
    //     }
    // }

    // public function deletePosts(Request $request)
    // {
    //     try {
    //         $id = $request['id'];
    //         $delete = Company::where('id', $id)->delete();
    //         if ($delete) {
    //             $delete = Delegate::where('post_id', $id)->delete();
    //             return response()->json(['success' => true, 'message' => 'Company Deleted Successfully!', 'type' => 'success', 'title' => 'Success!']);
    //         }

    //         return response()->json(['success' => false, 'message' => 'Unable to Delete Company!', 'type' => 'danger', 'title' => 'Error!']);
    //     } catch (\Throwable $th) {
    //         return response()->json(['success' => false, 'message' => 'Something went wrong in deleting Company', 'type' => 'danger', 'title' => 'Error!']);
    //     }
    // }
}
