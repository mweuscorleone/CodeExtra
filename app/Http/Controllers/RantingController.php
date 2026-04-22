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
            'message' => 'Product Rate Saved!'
        ]);
    }
}
