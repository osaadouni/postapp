<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// remember to use
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UsersController extends Controller
{
    //


    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //return Post::simplePaginate();
        Log::info(__METHOD__);
        return view('users.my_favorites');
    }

    /**
     * Display a listing of the user posts.
     *
     * @return \Illuminate\Http\Response
     */
    public function posts()
    {
        //
        //return Post::simplePaginate();
        Log::info(__METHOD__);
        return view('users.posts');
    }
    /**
     * Get all favorite posts of user
     *  
     * @return Response
     */ 
    public function myFavorites()
    {
        Log::info(__METHOD__);
        $posts = Auth::user()->favorites()->paginate(5);
        Log::info($posts);

        //return view('users.my_favorites', compact('myFavorites'));
        return response()->json($posts);

    }

    /**
     * Get all posts of user
     *  
     * @return Response
     */ 
    public function myPosts()
    {
        Log::info(__METHOD__);

        $posts = Auth::user()->posts()->orderBy('id', 'DESC')->paginate(10);
        Log::info($posts);

        Log::info(Auth::user()->id);

        return response()->json($posts);

    }
}
