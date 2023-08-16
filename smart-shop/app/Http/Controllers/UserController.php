<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Mail\OTPMail;
use App\Helper\JWTToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    function UserRegistration(Request $request){

        try{
            User::Create([
                'firstName' => $request->input('firstName'),
                'lastName' =>$request->input('lastName'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
                'password' => $request->input('password'),
                //'password' => Hash::make($request->input('password')),
            ]);
    
            return response()->json([
                'status' => 'success',
                'message' => 'User Registration Successful'
            ],200);
            
        } catch (Exception $e){
            return response()->json([
                'status' => 'failed',
                'message' => 'User Registration is not Successful'
                //'message' => $e->getMessage()
            ],201);

        }
            
        
    }

    function UserLogin(Request $request) {
        $count = User::where('email','=',$request->input('email'))
            ->where('password','=',$request->input('password'))
            ->count();
        if($count === 1) {
            $token = JWTToken::CreateToken($request->input('email'));
            return response()->json([
                'status' => 'success',
                'message' => 'User login successful',
                'token' => $token

            ],200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'unauthorised'
            ],201);
        }
    }

    function SendOTPCode(Request $request){
        $email = $request->input('email');
        $otp = rand(1000,9999);
        $count = User::where('email','=',$email)->count();

        if($count == 1){
            //OTP send to users email
            Mail::to($email)->send(new OTPMail($otp));
            //OTP to be update in users table
            User::where('email','=',$request->input('email'))->update(['otp' => $otp]);

            return response()->json([
                'status' => 'success',
                'message' => '4 diit OTP code has been sent to your email'
            ], 200);

        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'otp not sent'
            ], 201);
        }
    }
    
}


