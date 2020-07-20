<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\MercatodoModels\Product;
use App\MercatodoModels\Category;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name = $request->get('name');

        $products= Product::with('images','category')
            ->where('name', 'like', "%$name%")->orderBy('name')->paginate(2);

        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories= Category::orderBy('name')->get();

        return view('admin.product.create', compact('categories'));
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

                $route = public_path().'/images';

                $image->move($route , $name);

                $urlimages[]['url'] = '/images/'.$name;
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

        if ($request->active)
        {
            $prod->active= 'SI';
        }
        else
        {
            $prod->active= 'NO';
        }

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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
