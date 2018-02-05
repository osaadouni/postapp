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
     * Get all favorite posts of user
     *  
     * @return Response
     */ 
    public function myFavorites()
    {
        Log::info(__METHOD__);
        $posts = Auth::user()->favorites()->paginate(2);
        Log::info($posts);

        //return view('users.my_favorites', compact('myFavorites'));
        return response()->json($posts);

    }

}
