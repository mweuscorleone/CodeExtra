<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:4|max:20'
        ]);

       try{ $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'status' => 'success',
             'message' => 'user created successfully!',
             'user' => $user
        ]);
    }
    catch (Exception $e) {
        Log::error('Registration error' . $e->getMessage());

        return response()->json([
            'status' => 'error',
            'message' => 'something went wrong, please try again',
            'error' => $e->getMessage()
        ]);
    }
    }

    public function update(Request $request, $id){
        $user = User::find($id);

        if(!$user){
            return response()->json([
                'status' => 'error',
                'message' => 'user not found'
            ], 404);
        }

        $fields = $request->validate([
            'name' => 'sometimes|string',
            'email' => 'sometimes|email',
            'password' => 'sometimes|min:4|max:20'
        ]);

        try{$user->update($fields);


        return response()->json([
            'status' => 'success',
            'message' => 'user details updated successfully',
            'updated fields' => array_keys($fields)
        ], 200);

        }

        catch (Exception $e) {
          Log::error('update error' . $e->getMessage());

          return response()->json([
            'status' => 'error',
            'message' => 'something went wrong, please try again later',
            'error' => $e->getMessage()
          ]);
    }
    
    }

    public function destroy(Request $request, $id){
        $user = User::find($id);
            if(!$user){
                    return response()->json([
                'status' => 'error',
                'message' => 'user not found'
            ], 404);
            }

        $user->delete();

        return reponse()->json([
            'status' => 'success',
            'message' => 'user deleted successfully!'
        ], 200);
        
        }

    

    public function login(Request $request){

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(!Auth::attempt($request->only('email','password'))){
            return response()->json([
                'status' => 'failed',
                'message' => 'Invalid credentials, please try again'
            ]);


        }
        $user = Auth::user();

        $token = $user->createToken('login-token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'logged in successfully!',
            'token' => $token
        ], 200);
    }
    
    public function logout(){
        Auth::user()->currentAccessToken()->delete;

        return response()->json([
            'status' => 'success',
            'message' => 'logout successfully'
        ], 200);
    }

    public function index(){
        $user = User::paginate(25);

        return response()->json($user);
    }



}
