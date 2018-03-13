<?php

namespace Blog\Http\Controllers\Admin;

use Blog\Models\Post;
use Blog\Models\Category;
use Blog\Models\Tag;
use Illuminate\Http\Request;
use Blog\Http\Controllers\Controller;
use Blog\Http\Requests\PostStoreRequest;
use Blog\Http\Requests\PostUpdateRequest;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //dd(auth()->user());
        $posts = Post::orderBy('id','DESC')
            ->where('user_id',auth()->user()->id)
            ->paginate();
        return view('admin.posts.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('name','ASC')->pluck('name','id');
        $tags       = Tag::orderBy('name','ASC')->get();
        return view('admin.posts.create',compact('post','categories','tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostStoreRequest $request)
    {
        //Validar
        $post = Post::create($request->all());

        //Image
        if($request->file('file')){
            $path = Storage::disk('public')->put('image',$request->file('file'));
            $post->fill(['file' => asset($path)])->save();
        }

        //Tabs
        $post->tags()->attach($request->get('tags'));

        return redirect()->route('posts.edit',$post)
            ->with('info','Entrada creada con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \Blog\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $this->authorize('pass',$post);
        $post = Post::find($post->id);
        return view('admin.posts.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Blog\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $this->authorize('pass',$post);
        $categories = Category::orderBy('name','ASC')->pluck('name','id');
        $tags       = Tag::orderBy('name','ASC')->get();
        return view('admin.posts.edit',compact('post','categories','tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Blog\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostUpdateRequest $request, Post $post)
    {
        $this->authorize('pass',$post);
        //Validar
        $post = Post::find($post->id);
        $post->fill($request->all())->save();
        
        //Image
        if($request->file('file')){
            $path = Storage::disk('public')->put('image',$request->file('file'));
            $post->fill(['file' => asset($path)])->save();
        }

        //Tabs
        $post->tags()->sync($request->get('tags'));

        return redirect()->route('posts.edit',$post)
            ->with('info','Entrada actualizada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Blog\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $this->authorize('pass',$post);
        Post::find($post->id)->delete();
        return back()->with('info','Eliminado correctamente');
    }
}
