<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// remember to use
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    //
    /**
     * Get all favorite posts of user
     *  
     * @return Response
     */ 
    public function myFavorites()
    {
        $myFavorites = Auth::user()->favorites;

        return view('users.my_favorites', compact('myFavorites'));
    }

}
