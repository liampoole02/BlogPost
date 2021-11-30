<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
// use Illuminate\Http\Request\Request;
use App\Models\BlogPost;
use App\Models\User;
use App\Models\Image;
use App\Services\Counter;
use Illuminate\Support\Facades\Cache;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage as FacadesStorage;
use League\CommonMark\Extension\CommonMark\Node\Inline\Strong;
use Storage;

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

        return view(
            'posts.index',
            [
                'posts' => BlogPost::latestWithRelations()->get(),
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
        $validated['user_id'] = $request->user()->id;
        $post = BlogPost::create($validated);

        // $hasFile=$request->hasFile('thumbnail');
        // dump($hasFile);

        if($request->hasFile('thumbnail')){
            $path=$request->file('thumbnail')->store('thumbnails');
            $post->image()->save(
                Image::make(['path'=>$path])
            );
        }
            // dump($file);
            // dump($file->getClientMimeType());
            // dump($file->getClientOriginalExtension());

            // dump($file->store('thumbnails'));
            // dump(Storage::disk('public')->putFile('thumbnails', $file));

            // $name1=$file->storeAs('thumbnails', $post->id . '.'. $file->guessExtension());
            // $name2=Storage::disk('local')->putFileAs('thumbnails', $file, $post->id . '.' . $file->guessExtension());

            // dump(Storage::url($name1));
            // dump(Storage::disk('local')->url($name2));

        $request->session()->flash('status', 'Blog Post was created');

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

        $blogPost = Cache::tags(['blog-post'])->remember("blog-post-{$id}", 600, function () use ($id) {
            return BlogPost::with('comments', 'tags', 'user', 'comments.user')
                ->findOrFail($id);
        });

        $counter=new Counter();

       

        return view('posts.show', [
            'post' => $blogPost,
            'counter' => $counter->increment("blog-post-{$id}", ['blog-post']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);
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

        if($request->hasFile('thumbnail')){
            $path=$request->file('thumbnail')->store('thumbnails');

            if($post->image){
                Storage::delete($post->image->path);
                $post->image->path=$path;
                $post->image->save();
            }else{
                $post->image()->save(
                    Image::make(['path'=>$path])
                );
            }

           
        }

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

        $this->authorize($post);

        $post->delete();

        session()->flash('status', 'Blog post was deleted!');

        return redirect()->route('posts.index');
    }
}
