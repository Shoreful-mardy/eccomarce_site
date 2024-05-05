<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use Carbon\Carbon;
use Auth;

class ReviewController extends Controller
{
    public function StoreReview(Request $request){

        $product = $request->product_id;
        $vendor = $request->hvendor_id;

        $request->validate([
            'comment' => 'required',
        ]);

        Review::insert([
            'product_id' => $product,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
            'rating' => $request->quality,
            'vandor_id' => $vendor,
            'created_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Review Will Approve By Admin',
            'alert-type' =>'success'
        );
        return redirect()->back()->with($notification);



    }//End Method

    public function PendingReview(){
        $review = Review::where('status',0)->orderBy('id','DESC')->get();
        return view('backend.review.pending_review',compact('review'));
    }//End Method

    public function ApproveReview(){
        $review = Review::where('status',1)->orderBy('id','DESC')->get();
        return view('backend.review.approve_review',compact('review'));
    }//End Method

    public function AdminApproveReview($id){

        Review::findOrfail($id)->update([
            'status' => 1,
        ]);

        $notification = array(
            'message' => 'Review Approved Successfully',
            'alert-type' =>'success'
        );
        return redirect()->back()->with($notification);
    }//End Method

    public function DeleteReview($id){


        Review::findOrfail($id)->delete();

        $notification = array(
            'message' => 'Review Deleted Successfully',
            'alert-type' =>'success'
        );
        return redirect()->back()->with($notification);
    }//End Method


    public function VendorReview(){

        $id = Auth::id();

        $review = Review::where('vandor_id', $id)->orderBy('id','DESC')->get();
        return view('vendor.backend.review.vendor_all_review',compact('review'));
    }//End Method





















}
