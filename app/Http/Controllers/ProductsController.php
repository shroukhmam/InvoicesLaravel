<?php

namespace App\Http\Controllers;
use App\Model\Section;
use App\Model\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    //
    public function index()
    {
        $sections = Section::all();
        $products = Product::all();
        return view('products.products', compact('sections','products'));
    }
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'Product_name' => 'required|unique:products|max:255',
            'section_id'=>'required'
        ],[

            'required' =>'يرجي ادخال اسم القسم',
            'Product_name.unique' =>'اسم القسم مسجل مسبقا',


        ]);
        Product::create([
            'Product_name' => $request->Product_name,
            'section_id' => $request->section_id,
            'description' => $request->description,
        ]);
        session()->flash('Add', 'تم اضافة المنتج بنجاح ');
        return redirect('/products');
    }
    public function update(Request $request)
    {

       $id = Section::where('section_name', $request->section_name)->first()->id;

       $Products = Product::findOrFail($request->pro_id);

       $Products->update([
       'Product_name' => $request->Product_name,
       'description' => $request->description,
       'section_id' => $id,
       ]);

       session()->flash('Edit', 'تم تعديل المنتج بنجاح');
       return back();
        
    }
    public function destroy(Request $request)
    {
         $Products = Product::findOrFail($request->pro_id);
         $Products->delete();
         session()->flash('delete', 'تم حذف المنتج بنجاح');
         return back();
    }
}
