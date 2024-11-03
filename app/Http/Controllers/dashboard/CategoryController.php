<?php

namespace App\Http\Controllers\dashboard;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;





class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */



     public function __construct()
     {
         $this->middleware(['permission:users_read'])->only(methods: 'index');
         $this->middleware(['permission:users_create'])->only(methods: 'create');
         $this->middleware(['permission:users_update'])->only(methods: 'edit');
         $this->middleware(['permission:users_delete'])->only(methods: 'destroy');
     }




    public function index(Request $request)
    {
        $categories = Category::when($request->search, function($q) use ($request){

            return $q->where('name', 'like', '%'. $request->search. '%');
        })->latest()->paginate(5);
        return view('dashboard.categories.index', compact('categories'));
    } //end of index





    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.categories.create');
    } //end of create




    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ar.name' => 'required|unique:categories,name',
            // 'en.name' => 'required',
        ]);

        $categoryData = [
            'name' => $request->input('ar.name'),

        ];

        Category::create($categoryData);

        session()->flash('success', __('site.added_successfully'));

        return redirect()->route('dashboard.categories.index');
    }




    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {

        return view('dashboard.categories.edit',compact('category'));
    } //end of edity





    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {

        $request->validate([
            'ar.name' => 'required|unique:categories,name',
            // 'en.name' => 'required',
        ]);

        $categoryData = [
            'name' => $request->input('ar.name'),

        ];

        $category->update($categoryData);


        session()->flash('success', __('site.updated_successfuly'));
        return redirect()->route('dashboard.categories.index');


    } //end of update





    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.categories.index');
    }
} // end of destroy
