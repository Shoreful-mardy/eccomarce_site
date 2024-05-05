<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brand;
use App\Models\MultiImg;
use App\Models\Product;
use App\Models\User;

class IndexController extends Controller
{
    public function Index(){
        $skip_category_0 = Category::skip(0)->first();
        $skip_product_0 = Product::where('status', 1)->where('category_id', $skip_category_0->id)->orderBy('id','DESC')->limit(5)->get();

        $skip_category_2 = Category::skip(2)->first();
        $skip_product_2 = Product::where('status', 1)->where('category_id', $skip_category_2->id)->orderBy('id','DESC')->limit(5)->get();

        $skip_category_6 = Category::skip(6)->first();
        $skip_product_6 = Product::where('status', 1)->where('category_id', $skip_category_6->id)->orderBy('id','DESC')->limit(5)->get();

        $hot_deals = Product::where('hot_deals',1)->where('discount_price','!=',NULL)->orderBy('id','DESC')->limit(3)->get();

        $special_offer = Product::where('special_offer',1)->orderBy('id','DESC')->limit(3)->get();

        $recent_product = Product::where('status',1)->orderBy('id','DESC')->limit(3)->get();

        $special_deals = Product::where('special_deals',1)->orderBy('id','DESC')->limit(3)->get();

        return view('frontend.index',compact('skip_category_0','skip_product_0','skip_category_2','skip_product_2','skip_category_6','skip_product_6','hot_deals','special_offer','recent_product','special_deals'));
    }//End Method

    public function ProductDetails($id,$slug){
        $product = Product::findOrFail($id);
        $color = $product->product_color;
        $product_color = explode(',', $color);
        $size = $product->product_size;
        $product_size = explode(',', $size);


        $multiImage = MultiImg::where('produt_id' , $id)->get();
        $cat_id = $product->category_id;
        $relatedProduct = Product::where('category_id',$cat_id)->where('id','!=',$id)->orderBy('id','DESC')->limit(4)->get();
        return view('frontend.product.product_details',compact('product','product_color','product_size','multiImage','relatedProduct'));
    }//End Method


    public function VendorDetails($id){
       $vendor = User::findOrFail($id);
       $vendor_product = Product::where('vendor_id',$id)->get();
       return view('frontend.vendor.vendor_details',compact('vendor','vendor_product'));
    }//End Method

    public function VendorAll(){
        $vendors = User::where('status','active')->where('role','vendor')->orderBy('id','DESC')->get();
        return view('frontend.vendor.vendor_all',compact('vendors'));
    }//End Method

    public function CatWiseProduct(Request $request,$id,$slug){
        $products = Product::where('status',1)->where('category_id',$id)->orderBy('id','DESC')->get();
        $categories = Category::orderBy('category_name','ASC')->get();
        $breadcat = Category::where('id',$id)->first();
        $newproduct = Product::orderBy('id','DESC')->limit(3)->get();
        return view('frontend.product.category_view',compact('products','categories','breadcat','newproduct'));
    }//End Method

    public function SubCatWiseProduct(Request $request,$id,$slug){
        $products = Product::where('status',1)->where('subcategory_id',$id)->orderBy('id','DESC')->get();
        $categories = Category::orderBy('category_name','ASC')->get();
        $breadsubcat = SubCategory::where('id',$id)->first();
        $newproduct = Product::orderBy('id','DESC')->limit(3)->get();
        return view('frontend.product.subcategory_view',compact('products','categories','breadsubcat','newproduct'));
    }//End Method

    public function ProductViewAjax($id){

        $product = Product::with('category','brand')->findOrFail($id);

        $color = $product->product_color;
        $product_color = explode(',', $color);

        $size = $product->product_size;
        $product_size = explode(',', $size);

        return response()->json(array(
            'product' => $product,
            'color' => $product_color,
            'size' => $product_size,
        ));

    }//End Method


    public function ProductSearch(Request $request){
        $request->validate(['search'=> "required"]);
        $item = $request->search;

        $products = Product::where('product_name','LIKE',"%$item%")->get();
        $categories = Category::orderBy('category_name','ASC')->get();
        $newproduct = Product::orderBy('id','DESC')->limit(3)->get();

        return view('frontend.product.search',compact('products','item','categories','newproduct'));
    }//End Method

    public function SearchProduct(Request $request){

        $request->validate(['search'=> "required"]);
        $item = $request->search;

        $products = Product::where('product_name','LIKE',"%$item%")->select('product_name','product_slug','product_thambnail','selling_price','id')->limit(6)->get();

        return view('frontend.product.search_product',compact('products'));
        
    }//End Method
}
