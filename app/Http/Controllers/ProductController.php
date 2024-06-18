<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Section;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = Section::all();
        $products = product::all();
        return view('products.products',compact('sections','products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_name' => ['required', 'unique:products', 'max:255'],
            'description' => 'required'
        ]);
        product::create([
            'product_name'=>$request->product_name,
            'section_id'  =>$request->section_id,
            'description' =>$request->description,
        ]);
        return redirect()->back()->with(['Add'=>'تم اضافة المنتج بنجاح']);
    }   

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
      try{  $id = Section::where('section_name', $request->section_name)->first()->id;

        $Products = Product::findOrFail($request->pro_id);
 
        $Products->update([
        'product_name' => $request->Product_name,
        'description' => $request->description,
        'section_id' => $id,
        ]);
 
        session()->flash('Edit', 'تم تعديل المنتج بنجاح');
        return back();
        }catch(Exception $e){
            session()->flash('Error', 'خطا في التعديل');
            return back();
        }
         
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $Products = Product::findOrFail($request->pro_id);
         $Products->delete();
         session()->flash('delete', 'تم حذف المنتج بنجاح');
         return back();
    }
}
