<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return Post::all(); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required|max:255',
        ]);

        $post = new Post();
        $post->title = $request['title'];
        $post->description = $request['description'];
        $post->save();
        return $this->outputSuccessfulApi('success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);

        if ($post) {
            return $this->outputSuccessfulApi($post);
        }
        ## Post not found
        else {
            return $this->outputFailedApi('post not found', 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'max:255',
            'description' => 'max:255',
        ]);

        $post = Post::find($id);

        if ($post) {
            $post->title = $request['title'];
            $post->description = $request['description']; 
            $post->save();
            return $this->outputSuccessfulApi('success');
        }
        ## Post not found
        else {
            return $this->outputFailedApi('post not found', 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        if ($post) {
            $post->delete();
            return $this->outputSuccessfulApi('success');
        }
        ## Post not found
        else {
            return $this->outputFailedApi('post not found', 404);
        }
    }
}
