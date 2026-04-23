<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserRating;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RantingController extends Controller
{
    public function productRating(Request $request){

        $request->validate([
            'product_id' => 'required',
            'rating' => 'required|min:1|max:5'
        ]);
        $userId = auth()->id();

        DB::table('user_ratings')->updateOrInsert(
            [
            'user_id' => $userId,
            'product_id' => $request->product_id
            
        ],
        [
            'rating' => $request->rating,
            'rate_datetime' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Product Rate added successfully!'
        ]);
    }
    public function updateRating(Request $request){
        $request->validate([
            'product_id' => 'required',
            'rating' => 'required|min:1|max:5'
        ]);
        $userId = auth()->id();

        DB::table('user_ratings')->where('user_id', $userId)->where('product_id', $request->product_id)
              ->update([
                             'product_id' => $request->product_id,
                      'rating' => $request->rating]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'rating saved successfully!'
                              ], 200);
    }
    public function removeRating($productId){
        $userId = auth()->id();
        DB::table('user_ratings')->where('user_id', $userId)->where('product_id', $productId)->delete();
       

        return response()->json([
            'status' => 'success',
            'message' => 'rating removed successfully!'
        ], 200);
    }

    public function listRating(){
        $userId = auth()->id();

        $product = DB::table('products')->leftJoin('user_ratings', 'products.id', '=', 'user_ratings.product_id')->select(
             'products.name as Product name', DB::raw('ROUND(AVG(user_ratings.rating)) as Rating'),
            DB::raw('MAX(user_ratings.rate_datetime)as `rated_time`') )->groupBy('products.name')->orderBy('Rating', 'desc')->get()
            ->map(function ($item){
               $time =  Carbon::parse($item->rated_time);

               $item->time_passed = $time->diffForHumans();

               $minutes = $time->diffInMinutes(now());

               $item->active_time = $minutes > 30 ? "active" : "inactive";

                return $item;
            });


            return response()->json($product);
    }
}
