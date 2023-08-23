<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Mail\OTPMail;
use App\Helper\JWTToken;
use Firebase\JWT\JWT;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

use function Laravel\Prompts\alert;

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
                //'token' => $token

            ],200)->cookie('token',$token,60*24*30);
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
    
    function VerifyOtp(Request $request){
        $email = $request->input('email');
        $otp = $request->input('otp');

        $count = User::where('email','=',$email)
            ->where('otp','=',$otp)
            ->count();
        if($count === 1){
            //OTP update in table
            //return OTP
            User::where('email','=',$email)->update(['otp' => '0']);
            //Issue a token for reset password :jwtToken.php
            $token = JWTToken::CreateTokenForSetPassword($request->input('email'));
            return response()->json([
                'status' => 'success',
                'message' => 'OTP Verification is Successful',
                //'token' => $token
            ], 200)->cookie('token',$token,60*24*30);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'OTP verification failed'
            ], 201);
        }
    }

    function ResetPassword(Request $request){
        try{
            $email = $request->header('email');
            $password = $request->input('password');
            User::where('email','=',$email)->update(['password' => $password]);
            return response()->json([
                'status' => 'success',
                'message' => 'Password Reset Successful' 
            ], 200);

        }catch(Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Something went wrong'
            ],201);
        }
    }

    function LoginPage():View{
        return view('pages.auth.login-page');
    }

    function RegistrationPage():View{
        return view('pages.auth.registration-page');
    }

    function SendOtpPage():View{
        return view('pages.auth.send-otp-page');
    }

    function VerifyOtpPage():View{
        return view('pages.auth.verify-otp-page');
    }

    function ResetPasswordPage():View{
        return view('pages.auth.reset-password-page');
    }

}


