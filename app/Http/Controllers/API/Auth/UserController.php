<?php

namespace App\Http\Controllers\API\Auth;

use Validator;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ],401);
        }

        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();
                $token = $user->createToken('MyAppToken')->accessToken;
            }
        } else {
            if (Auth::attempt(['username' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();
                $token = $user->createToken('MyAppToken')->accessToken;
            }
        }
        if(!empty($token))
        {
            return response()->json([
                'status' => 'success',
                'token' => $token,
                'data' => $user,
            ],200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Invalid username or password'
        ],401);
    }

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ],401);
        }

        $token = Str::random(64);

          DB::table('password_resets')->insert([
              'email' => $request->email,
              'token' => $token,
              'created_at' => Carbon::now()
            ]);

          Mail::send('email.forgetPassword', ['token' => $token,'email' => $request->email], function($message) use($request){
              $message->to($request->email);
              $message->subject('Reset Password');
          });

        return response()->json([
            'status' => 'success',
            "message" => 'Reset password link sent on your email id.',
            'token' => $token,
            'email' => $request->email
        ]);

    }

    public function resetPassword(Request $request) {
        $credentials = $request->all();
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
            'token' => 'required|string',
            'password' => 'required|string|min:6|same:confirm_password',
            'confirm_password' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ],401);
        }

        $updatePassword = DB::table('password_resets')->where([
            'email' => $request->email,
            'token' => $request->token
        ])->first();

          if(!$updatePassword){
              return response()->json([
                'status' => 'error',
                'message' => 'Invalid token!'
            ],401);
          }

        User::where('email', $request->email)
            ->update([
                'password' => Hash::make($request->password)
            ]);

        DB::table('password_resets')->where(['email'=> $request->email])->delete();

        return response()->json([
            "status" => "success",
            "message" => "Password has been successfully changed"
        ],200);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        return response()->json(['message' => 'Successfully logged out.']);
    }
}
