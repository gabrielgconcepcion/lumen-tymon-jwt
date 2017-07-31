<?php
namespace App\Http\Controllers;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;
class AuthController extends Controller{
	public function __construct(JWTAuth $jwt){
		$this->jwt = $jwt;
	}
	public function postLogin(Request $request){
		$this->validate($request,[
			'email'=>'required|email|max:255'
			, 'password'=>'required'
		]);
		try {
			if(!$token = $this->jwt->attempt($request->only('email','password'))){
				return response()->json(['user_not_found'],404);
			}
		}catch(\Tymon\JWTAuth\Exceptions\TokenExpiredException $e){
			return response()->json(['token_expired'],500);
		}catch(\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
			return response()->json(['token_invalid'],500);
		}catch(\Tymon\JWTAuth\Exceptions\JWTException $e){
			return response()->json(['token_absent'=>$e->getMessage()],500);
		}
		$user = $this->jwt->user();
		return response()->json(compact('token','user'));
	}
}