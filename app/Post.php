<?php

namespace App;

use App\Favorite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    //
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'body', 'user_id'];
    

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['favorite', 'owner'];

    /**
     *  Determine whether a post has been marked as favorite by a user.
     *
     *  @return boolean
     */
    public function favorited()
    {
        return (bool) Favorite::where('user_id', Auth::id())
                            ->where('post_id', $this->id)
                            ->first();
    }


    /**
     * Get The post's favorite attr
     *
     * @param nothing
     * @return string 
     */
    public function getFavoriteAttribute() 
    {
        //return $this->attributes['is_favorite'] == $this->favorited();
        return $this->favorited();
    }


    /**
     * Get The post's owner attr
     *
     * @param nothing
     * @return string 
     */
    public function getOwnerAttribute() 
    {
        return $this->user_id == Auth::id(); 
    }
}
