<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\category\CategoryRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class AdminCategoryController
 * @package App\Http\Controllers\Admin
 */
class AdminCategoryController extends Controller
{
    protected $categoryRepo;

    /**
     * AdminCategoryController constructor.
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepo = $categoryRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        $categories = $this->categoryRepo->getAllCategories($request);

        return view('admin.category.index', compact('categories'));
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

        $this->categoryRepo->createCategory($request->all());

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

        $cat = $this->categoryRepo->findCategory($slug);
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

        $cat = $this->categoryRepo->findCategory($slug);
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

        $cat = $this->categoryRepo->findId($id);
        $this->categoryRepo->updateCategory($cat, $request->all());

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

        $cat = $this->categoryRepo->findId($id);
        $this->categoryRepo->delete($cat);

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
        $this->categoryRepo->restore($request);

        return redirect()->route('admin.category.index')
            ->with('data', 'Category  enabled');
    }
}
