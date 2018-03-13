<?php

namespace Blog\Http\Controllers\Admin;

use Blog\Models\Tag;
use Illuminate\Http\Request;
use Blog\Http\Controllers\Controller;
use Blog\Http\Requests\TagStoreRequest;
use Blog\Http\Requests\TagUpdateRequest;

class TagController extends Controller
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
        $tags = Tag::orderBy('id','DESC')->paginate();
        return view('admin.tags.index',compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagStoreRequest $request)
    {
        //Validar
        $tag = Tag::create($request->all());
        return redirect()->route('tags.edit',$tag)
            ->with('info','Etiqueta creada con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \Blog\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        $tag = Tag::find($tag->id);
        return view('admin.tags.show',compact('tag'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Blog\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        return view('admin.tags.edit',compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Blog\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(TagUpdateRequest $request, Tag $tag)
    {
        //Validar
        $tag = Tag::find($tag->id);
        $tag->fill($request->all())->save();
        return redirect()->route('tags.edit',$tag)
            ->with('info','Etiqueta actualizada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Blog\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        Tag::find($tag->id)->delete();
        return back()->with('info','Eliminado correctamente');
    }
}
