<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\MercatodoModels\Category;


class AdminCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name = $request->get('name');

        $categories= Category::withTrashed('category')
            ->where('name','like',"%$name%")->orderBy('name')->paginate(5);

        return view('admin.category.index',compact('categories'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Category::create($request->all());

        return redirect()->route('admin.category.index')
            ->with('data','Record created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $cat = Category::where('slug',$slug)->firstOrFail();
        $edit = 'Si';

        return view('admin.category.show',compact('cat','edit'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $cat = Category::where('slug',$slug)->firstOrFail();
        $edit = 'Si';

        return view('admin.category.edit',compact('cat','edit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cat= Category::findOrFail($id);
        $cat-> fill($request->all())->save();

        return redirect()->route('admin.category.index')
            ->with('data','Record updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cat= Category::find($id);
        $cat->delete();

        return redirect()->route('admin.category.index')
            ->with('data','Category disabled');
    }

    public function restore(Request $request)
    {
        Category::withTrashed()->find($request->id)->restore();

        return redirect()->route('admin.category.index')
            ->with('data', 'Category  enabled');
    }
}
