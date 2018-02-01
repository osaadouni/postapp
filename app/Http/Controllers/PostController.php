<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //return Post::simplePaginate();
        Log::info('index()...');

        $posts = Post::orderBy('id', 'DESC')->paginate(10);
        //Log::info($posts);

        return response()->json($posts);

        //
        //return view('posts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        Log::info('store()...');
        Log::info($request);
        // method 3
        //
        $validatedData = $this->validate($request, [
                    'title' => 'required',
                    'body' => 'required',
        ]);
        return Post::create($validatedData);
        //return response()->json(['message'=> 'Phonebook record created successfully!']);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        Log::info('update()...');
        Log::info($request);
        Log::info($post);

        // return $request;

        $validatedData = $this->validate($request, [
                    'title' => 'required',
                    'body' => 'required',
        ]);

        Post::findOrFail($request->id)->update($validatedData);

        return response()->json(['message'=> 'Post updated successfully!']);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
        Log::info('destroy()...');
        Log::info($post);
        
        $post::where('id', $post->id)->delete();
        return response()->json(['message'=> 'Post record deleted successfully!']);
    }
}
