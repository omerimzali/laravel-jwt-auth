<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
  
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255|min:3',
        ]);

        if ($validator->fails()) {

            return response()->json(['status' => 'failed', 'reuqest is not valid' => 'Request is not valid', 'failed' => $validator->errors()->first()], 500);
        }

           // Retrieve the authenticated user
           $user = Auth::user();

           // Update the user's email
           if($request->name){
           $user->name = $request->name;
           }

           $user->save();

           return response()->json([
            'status' => 'success',
            'message' => 'User updated successfully.',
        ]);

    }

    public function updateEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
        ]);

        if ($validator->fails()) {

            return response()->json(['status' => 'failed', 'message' => 'Email is not valid', 'failed' => $validator->errors()->first()], 500);
        }


        // Retrieve the authenticated user
        $user = Auth::user();

        // Update the user's email
        $user->email = $request->email;
        $user->email_verified_at = null;
        $user->save();

        // Return a response to confirm that the email has been updated
        return response()->json([
            'status' => 'success',
            'message' => 'Email updated successfully. Email account must be verified again.',
        ]);
    }


}
