<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
// use Illuminate\Http\Request\Request;
use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class PostsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth')
            ->only(['create', 'store', 'edit', 'updated', 'destroy']);
    }

    public function index()
    {
        $mostCommented=Cache::remember('mostCommented', now()->addSeconds(10), function(){
            return BlogPost::mostCommented()->take(5)->get();
        });
        $mostActive=Cache::remember('mostActive', now()->addSeconds(10), function(){
            return User::withMostBlogPosts()->take(5)->get();
        });
        $mostActiveLastMonth=Cache::remember('mostActiveLastMonth', now()->addSeconds(10), function(){
            return User::withMostBlogPostsLastMonth()->take(5)->get();
        });

        return view(
            'posts.index',
            ['posts' => BlogPost::latest()->withCount('comments')->with('user')->get(),
            'mostCommented' => $mostCommented,
            'mostActive' => $mostActive,
            'mostActiveLastMonth' => $mostActiveLastMonth
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $this->authorize('posts.create');
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePost $request)
    {
        $validated = $request->validated();

        $validated['user_id']=$request->user()->id;
        $post = BlogPost::create($validated);

        // $request->session()->flash('status', 'The blog post was created!');

        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // abort_if(!isset($this->posts[$id]), 404);
        return view('posts.show', [
            'post' => BlogPost::with(['comments'=> function($query){
                return $query->latest();
        }])->findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post=BlogPost::findOrFail($id);
        $this->authorize('update', $post);

        return view('posts.edit', ['post' => BlogPost::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePost $request, $id)
    {
        $post = BlogPost::findOrFail($id);
        
        $this->authorize('posts.update', $post);

        // if (Gate::denies('update-post', $post)) {
        //     abort(403, "Stop! You are not allowed to edit this blog post!");
        // } else {

            $validated = $request->validated();

            $post->fill($validated);
            $post->save();

            $request->session()->flash('status', 'Blog post was updated!');

            return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**K
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = BlogPost::findOrFail($id);

        $this->authorize( $post);

        // if(Gate::denies('delete-post', $post)){
        //     abort(403, "Stop!! You are not allowed to delete someones else's blog-post");
        // }

        $post->delete();

        session()->flash('status', 'Blog post was deleted!');

        return redirect()->route('posts.index');
    }
}
