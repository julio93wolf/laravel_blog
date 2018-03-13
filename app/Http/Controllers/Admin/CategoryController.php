<?php

namespace Blog\Http\Controllers\Admin;

use Blog\Models\Category;
use Illuminate\Http\Request;
use Blog\Http\Controllers\Controller;
use Blog\Http\Requests\CategoryStoreRequest;
use Blog\Http\Requests\CategoryUpdateRequest;

class CategoryController extends Controller
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
        $categories = Category::orderBy('id','DESC')->paginate();
        return view('admin.categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryStoreRequest $request)
    {
        //Validar
        $category = Category::create($request->all());
        return redirect()->route('categories.edit',$category)
            ->with('info','Categoría creada con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \Blog\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $category = Category::find($category->id);
        return view('admin.categories.show',compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Blog\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Blog\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdateRequest $request, Category $category)
    {
        //Validar
        $category = Category::find($category->id);
        $category->fill($request->all())->save();
        return redirect()->route('categories.edit',$category)
            ->with('info','Categoría actualizada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Blog\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        Category::find($category->id)->delete();
        return back()->with('info','Eliminado correctamente');
    }
}
