<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    function ProductPage():View{
        return view("pages.dashboard.product-page");
    }

    function ProductCreate(Request $request){
        $user_id = $request->header('id');

        $img = $request->file('img');

        $t = time();
        $file_name = $img->getClientOriginalName();
        $img_name = "{$user_id}-{$t}-{$file_name}";
        $img_url = "uploads/{$img_name}";

        //Upload File
        $img->move(public_path('uploads'),$img_name);

        //Save to database
        return Product::create([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'unit' =>$request->input('unit'),
            'img_url' => $img_url,
            'user_id' => $user_id,
            'category_id' => $request->input('category_id')
        ]);
    }

    function ProductList(Request $request){
        $user_id = $request->header('id');
        return Product::where('user_id',$user_id)->get();
    }

    function ProductDelete(Request $request){
        $user_id = $request->header('id');
        $product_id = $request->input('id');

        $file_path = $request->input('filePath');
        File::delete($file_path);

        return Product::where('id',$product_id)->where('user_id',$user_id)->delete();
    }

    function UpdateProduct(Request $request){
        $user_id = $request->header('id');
        $product_id = $request->input('id');

        if($request->hasFile('img')){

            //Upload New File
            $img = $request->file('img');
            $t = time();
            $file_name = $img->getClientOriginalName();
            $img_name = "{$user_id}-{$t}-{$file_name}";
            $img_url = "uploads/{$img_name}";
            $img->move(public_path('uploads'),$img_name);

            //Delete Old File
            $file_path = $request->input('file_path');
            File::delete($file_path);

            //Update Product
            return Product::where('id',$product_id)->where('user_id',$user_id)->update([
                'name'=> $request->input('name'),
                'price' => $request->input('price'),
                'unit' => $request->input('unit'),
                'img_url' => $img_url,
                'category_id' =>$request->input('category_id')
            ]);

        } else {
            return Product::where('id',$product_id)->where('user_id',$user_id)->update([
                'name'=> $request->input('name'),
                'price' => $request->input('price'),
                'unit' => $request->input('unit'),
                'category_id' =>$request->input('category_id')            
            ]);
        }
    }

    function ProductById(Request $request){
        $user_id = $request->header('id');
        $product_id = $request->input('id');
        return Product::where('id',$product_id)->where('user_id',$user_id)->first();
    }

 
}
