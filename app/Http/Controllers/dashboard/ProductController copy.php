<?php

namespace App\Http\Controllers\dashboard;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::all();

        $products = Product::when($request->search, function ($q) use ($request) {

            return $q->where('name_ar', '%' . $request->search . '%');

        })->when($request->category_id, function ($q) use ($request) {

            return $q->where('category_id', $request->category_id);

        })->latest()->paginate(5);

        return view('dashboard.products.index', compact('categories', 'products'));

    }//end of index

    public function create()
    {
        $categories = Category::all();
        return view('dashboard.products.create', compact('categories'));
    }
    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
    {
        $rules = [
            'category_id' => 'required',
            'name_ar' => 'required|unique:products,name_ar',
            'name_en' => 'required|unique:products,name_en',
            'description_ar' => 'required',
            'description_en' => 'required',
            'purchase_price' => 'required',
            'sale_price' => 'required',
            'stock' => 'required',
        ];

        $request->validate($rules);


        $productData = [
            'category_id' => $request->category_id,
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'description_ar' => $request->description_ar,
            'description_en' => $request->description_en,
            'purchase_price' => $request->purchase_price,
            'sale_price' => $request->sale_price,
            'stock' => $request->stock,
        ];

        // dd($productData);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/product_images'), $imageName);
            $productData['image'] = $imageName;
        }


        Product::create($productData);

        session()->flash('success', __('site.added_successfully'));

        return redirect()->route('dashboard.products.index');
    }




    /**
     * Display the specified resource.
     */



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('dashboard.products.edit', compact('categories','product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {


        $rules = [
            'category_id' => 'required',
            'purchase_price' => 'required',
            'sale_price' => 'required',
            'stock' => 'required',
        ];

        $request->validate($rules);

        $request_data = $request->all();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/product_images'), $imageName);
            $productData['image'] = $imageName;
        }

        $product->update($request_data);
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.products.index');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
         if ($product->image != 'default.png') {

            Storage::disk('public_uploads')->delete('product_images/' . $product->image);

        }//end of if

        $product->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.products.index');

    }
}
