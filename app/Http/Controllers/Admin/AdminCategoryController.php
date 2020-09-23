<?php

namespace App\Http\Controllers\Admin;

use Exception;
use PhpParser\Node\Stmt\TryCatch;
use ReflectionExtension;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\MercatodoModels\Category;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

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
    public function index(Request $request): View
    {
        try {
            $this->authorize('haveaccess', 'admin.category.index');
            $name = $request->get('name');

            $categories = Category::withTrashed('category')
            ->where('name', 'like', "%$name%")->orderBy('name')->paginate(env('PAGINATE'));
            Log::channel('contlog')->info('listar categorias');

            return view('admin.category.index', compact('categories'));
        } catch (\Exception $e) {
            Log::channel('contlog')->error("Error al listar los productos ".
                "getMessage: ".$e->getMessage().
                " - getFile: ".$e->getFile().
                " - getLine: ".$e->getLine());

            return view('welcome');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        /*$this->authorize('haveaccess', 'admin.category.create');*/

        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('haveaccess', 'admin.category.create');

        Category::create($request->all());

        return redirect()->route('admin.category.index')
            ->with('data', 'Record created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function show(string $slug): View
    {
        $this->authorize('haveaccess', 'admin.category.show');

        $cat = Category::where('slug', $slug)->firstOrFail();
        $edit = 'Si';

        return view('admin.category.show', compact('cat', 'edit'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function edit(string $slug): View
    {
        $this->authorize('haveaccess', 'admin.category.edit');

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
    public function update(Request $request, int $id): RedirectResponse
    {
        $this->authorize('haveaccess', 'admin.category.edit');

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
    public function destroy(int $id): RedirectResponse
    {
        $this->authorize('haveaccess', 'admin.category.destroy');

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
    public function restore(Request $request): RedirectResponse
    {
        Category::withTrashed()->find($request->id)->restore();

        return redirect()->route('admin.category.index')
            ->with('data', 'Category  enabled');
    }
}
