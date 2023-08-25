<?php
namespace App\Helper;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class JWTToken {
    //Token for Password Create
    public static function CreateToken($userEmail, $userID):string{
        $key = env('JWT_KEY');
        $payload = [
            'iss' => 'laravel-token',
            'iat' => time(),
            'exp' => time()+60*60,
            'userEmail' => $userEmail,
            'userID' => $userID
        ];

        return JWT::encode($payload,$key,'HS256');
    }

    //Token for Password Reset
    public static function CreateTokenForSetPassword($userEmail){
        $key = env('JWT_KEY');
        $payload = [
            'iss' => 'laravel-token',
            'iat' => time(),
            'exp' => time()+60*20, //20 minute 60 seconds x 20
            'userEmail' => $userEmail,
            'userID' => '0'
        ];
        return JWT::encode($payload,$key,'HS256');
    }

    //TOKEN VERIFICATION
    public static function VerifyToken($token):string|object
    {
        try{
            if($token == null){
                return 'unauthorised';
            } else {

                $key = env('JWT_KEY');
                $decode = JWT::decode($token, new Key($key,'HS256'));
                return $decode;
            }
        }
        catch(Exception $e) {
            return 'unauthorised';
        }
    }
}