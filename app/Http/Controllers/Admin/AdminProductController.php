<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\MercatodoModels\Product;
use App\MercatodoModels\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminProductController extends Controller
{
    public function __construct() {

        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name = $request->get('name');

        $products= Product::withTrashed('images','category')
            ->where('name', 'like', "%$name%")->orderBy('name')->paginate(10);

        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $status_products = $this->status_products();


        $categories= Category::orderBy('name')->get();

        return view('admin.product.create', compact('categories','status_products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:products,name',
            'slug' => 'required|unique:products,slug',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $urlimages = [];
        if ($request->hasFile('images'))
        {
            $images = $request->file('images');

            foreach ($images as $image)
            {
                $name = time().'_'.$image->getClientOriginalName();

                $route = public_path().env('IMAGES_PRODUCTS');

                $image->move($route , $name);

                $urlimages[]['url'] = env('IMAGES_PRODUCTS').$name;
            }

           // return $urlimages;
        }

        $prod = new Product;

        $prod->name=                  $request->name;
        $prod->slug=                  $request->slug;
        $prod->category_id=           $request->category_id;
        $prod->quantity=              $request->quantity;
        $prod->price=                 $request->price;
        $prod->description=           $request->description;
        $prod->specifications=        $request->specifications;
        $prod->data_of_interest=      $request->data_of_interest;
        $prod->status=                $request->status;

        $prod->save();

        $prod->images()->createMany($urlimages);

        return redirect()->route('admin.product.index')
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
        $product = Product::with('images', 'category')->where('slug', $slug)->firstOrFail();

        $categories = Category::orderBy('name')->get();

        $status_products = $this->status_products();


        return view('admin.product.show', compact('product', 'categories','status_products'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $product = Product::with('images', 'category')->where('slug', $slug)->firstOrFail();

        $categories = Category::orderBy('name')->get();

        $status_products = $this->status_products();


        return view('admin.product.edit', compact('product', 'categories','status_products'));
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
        $request->validate([
            'name' => 'required|unique:products,name,'.$id,
            'slug' => 'required|unique:products,slug,'.$id,
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $urlimages = [];
        if ($request->hasFile('images'))
        {
            $images = $request->file('images');

            foreach ($images as $image)
            {
                $name = time().'_'.$image->getClientOriginalName();

                $route = public_path().env('IMAGES_PRODUCTS');

                $image->move($route , $name);

                $urlimages[]['url'] = env('IMAGES_PRODUCTS').$name;
            }

            // return $urlimages;
        }

        $prod = Product::findOrFail($id);

        $prod->name=                  $request->name;
        $prod->slug=                  $request->slug;
        $prod->category_id=           $request->category_id;
        $prod->quantity=              $request->quantity;
        $prod->price=                 $request->price;
        $prod->description=           $request->description;
        $prod->specifications=        $request->specifications;
        $prod->data_of_interest=      $request->data_of_interest;
        $prod->status=                $request->status;

        $prod->save();

        $prod->images()->createMany($urlimages);

        return redirect()->route('admin.product.edit',$prod->slug)
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
        $product = Product::find($id);
        $product->delete();

        return redirect()->route('admin.product.index')
            ->with('data','Record updated successfully!');
    }

    public function restore(Request $request)
    {
        Product::withTrashed()->find($request->id)->restore();

        return redirect()->route('admin.product.index')
            ->with('data', 'user  enabled');
    }

    public function status_products(){

        return [
            '',
            'New',
            'Offer'
        ];
    }
}
