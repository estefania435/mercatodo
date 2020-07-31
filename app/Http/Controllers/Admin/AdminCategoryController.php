<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\MercatodoModels\Category;

/**
 * Class AdminCategoryController
 * @package App\Http\Controllers\Admin
 */
class AdminCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): \Illuminate\View\View
    {
        $name = $request->get('name');

        $categories = Category::withTrashed('category')
            ->where('name', 'like', "%$name%")->orderBy('name')->paginate(5);

        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(): \Illuminate\View\View
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        Category::create($request->all());

        return redirect()->route('admin.category.index')
            ->with('data', 'Record created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param string $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(string $slug): \Illuminate\View\View
    {
        $cat = Category::where('slug', $slug)->firstOrFail();
        $edit = 'Si';

        return view('admin.category.show', compact('cat', 'edit'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(string $slug): \Illuminate\View\View
    {
        $cat = Category::where('slug', $slug)->firstOrFail();
        $edit = 'Si';

        return view('admin.category.edit', compact('cat', 'edit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $cat = Category::findOrFail($id);
        $cat->fill($request->all())->save();

        return redirect()->route('admin.category.index')
            ->with('data', 'Record updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id): \Illuminate\Http\RedirectResponse
    {
        $cat = Category::find($id);
        $cat->delete();

        return redirect()->route('admin.category.index')
            ->with('data', 'Category disabled');
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(Request $request): \Illuminate\Http\RedirectResponse
    {
        Category::withTrashed()->find($request->id)->restore();

        return redirect()->route('admin.category.index')
            ->with('data', 'Category  enabled');
    }
}
