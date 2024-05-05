<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Image;
use Carbon\Carbon;

class BlogController extends Controller
{
    public function AllBlogCategory(){

        $blogcategories = BlogCategory::latest()->get();
        return view('backend.blog.all_blog_category',compact('blogcategories'));

    }//End Method

    public function AddBlogCategory(){

        return view('backend.blog.add_blog_category');

    }//End Method

    public function StoreBlogCategory(Request $request){

        BlogCategory::insert([
            'blog_category_name' => $request->blog_category_name,
            'blog_category_slug' => strtolower(str_replace(' ','-',$request->blog_category_name)),
            'created_at' => Carbon::now(),
        ]);


        $notification = array(
            'message' => 'Blog Category Inserted Successfully',
            'alert-type' =>'success'
        );
        return redirect()->route('admin.blog.category')->with($notification);
    }//End Method

    public function EditBlogCategory($id){

        $blogcategories = BlogCategory::findOrfail($id);
        return view('backend.blog.edit_blog_category',compact('blogcategories'));

    }//End Method

    public function UpdateBlogCategory(Request $request){

        $blog_id = $request->id;


        BlogCategory::findOrfail($blog_id)->update([
            'blog_category_name' => $request->blog_category_name,
            'blog_category_slug' => strtolower(str_replace(' ','-',$request->blog_category_name)),
        ]);


        $notification = array(
            'message' => 'Blog Category Updated Successfully',
            'alert-type' =>'success'
        );
        return redirect()->route('admin.blog.category')->with($notification);

    }//End Method


    public function DeleteBlogCategory($id){

        BlogCategory::findOrfail($id)->delete();

        $notification = array(
            'message' => 'Blog Category Deleted Successfully',
            'alert-type' =>'success'
        );
        return redirect()->back()->with($notification);
    }//End Method

    //////////////////////End Post category and Start Blog Post//

    public function AllBlogPost(){

        $blogpost = BlogPost::latest()->get();
        return view('backend.blog.post.blog_post_all',compact('blogpost'));
    }//End Method

    public function AddBlogPost(){
        $category = BlogCategory::latest()->get();
        return view('backend.blog.post.blog_post_add',compact('category'));
    }//End Method


    public function StoreBlogPost(Request $request){

        $image = $request->file('post_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(1103,906)->save('upload/blog/'.$name_gen);
        $save_url = 'upload/blog/'.$name_gen;

        BlogPost::insert([
            'category_id' => $request->category_id,
            'post_title' => $request->post_title,
            'post_slug' => strtolower(str_replace(' ','-',$request->post_title)),
            'post_short_description' => $request->post_short_description,
            'post_long_description' => $request->post_long_description,
            'post_image' => $save_url,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Blog Post Inserted Successfully',
            'alert-type' =>'success'
        );
        return redirect()->route('admin.blog.post')->with($notification);
        
    }//End Method


    public function EditBlogPost($id){

        $blogcategory = BlogCategory::latest()->get();
        $blogpost = BlogPost::findOrfail($id);
        return view('backend.blog.post.blog_post_edit',compact('blogcategory','blogpost'));

    }//End Method

    public function UpdateBlogPost(Request $request){

        $post_id = $request->id;
        $old_image = $request->old_image;

        if($request->file('post_image')){

            
            $image = $request->file('post_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(1103,906)->save('upload/blog/'.$name_gen);
            $save_url = 'upload/blog/'.$name_gen;

            if(file_exists($old_image)){
                unlink($old_image);
            }
            BlogPost::findOrfail($post_id)->update([
                'category_id' => $request->category_id,
                'post_title' => $request->post_title,
                'post_slug' => strtolower(str_replace(' ','-',$request->post_title)),
                'post_short_description' => $request->post_short_description,
                'post_long_description' => $request->post_long_description,
                'post_image' => $save_url,
                'updated_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Blog Post Successfully Updated with Image',
                'alert-type' => 'success'  
            );
    
            return redirect()->route('admin.blog.post')->with($notification);
        }else{

            BlogPost::findOrfail($post_id)->update([
                'category_id' => $request->category_id,
                'post_title' => $request->post_title,
                'post_slug' => strtolower(str_replace(' ','-',$request->post_title)),
                'post_short_description' => $request->post_short_description,
                'post_long_description' => $request->post_long_description,
                'updated_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Blog Post Successfully Updated without Image',
                'alert-type' => 'success'  
            );
    
            return redirect()->route('admin.blog.post')->with($notification);

        }//End Else

    }//End Method

    public function DeleteBlogPost($id){

        $blogpost = BlogPost::findOrFail($id);
        $img = $blogpost->post_image;
        @unlink($img);
        BlogPost::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Post Deleted Successfully',
            'alert-type' => 'success'  
        );

        return redirect()->back()->with($notification);

    }//End Method


    ///////////////End Blog Post and start fontend All method


    public function AllBlog(){
        $blogcategories = BlogCategory::latest()->get();
        $blogpost = BlogPost::latest()->get();
        return view('frontend.blog.home_blog',compact('blogcategories','blogpost'));
    }//End Method

    public function BlogDetails($id,$slug){

        $blogcategories = BlogCategory::latest()->get();
        $blogdetails = BlogPost::findOrfail($id);
        $breadcat = BlogCategory::where('id', $id)->get();
        return view('frontend.blog.blog_details',compact('blogcategories','blogdetails','breadcat'));

    }//End Method

    public function CatBlogPost($id,$slug){
        $blogcategories = BlogCategory::latest()->get();
        $blogpost = BlogPost::where('category_id',$id)->latest()->get();
        $breadcat = BlogCategory::where('id', $id)->get();
        return view('frontend.blog.catwise_post',compact('blogpost','blogcategories','breadcat'));
    }//End Method



}
