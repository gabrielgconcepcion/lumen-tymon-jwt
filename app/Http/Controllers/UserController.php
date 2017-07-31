<?php
namespace App\Http\Controllers;
use App\User;
class UserController extends Controller{
	public function show($id){
		return User::findOrFail($id);
	}
}