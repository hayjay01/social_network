<?php

namespace Mysocial\Http\Controllers;

use Auth;
use Mysocial\Models\User;
use Mysocial\Models\Profile;
use Illuminate\Http\Request;

class AuthController extends Controller
{
	public function getSignup()
	{
		return view('auth.signup');
	}

	public function postSignup(Request $request)
	{
		$this->validate($request, [
			'email'=>'required|unique:users|email|max:255',
			'username'=>'required|unique:users|alpha_dash|max:20',
			'password'=>'required|min:6',
			]);

		$user = User::create([
			'email'=>$request->input('email'),
			'username'=>$request->input('username'),
			'password'=>bcrypt($request->input('password')),
			]);

		Profile::create([
			'user_id' => $user->id,
		]);	

		return redirect()->route('home')->with('info', 'Your account has been created successfully, please proceed to login');
 
	}

	public function getSignin()
	{
		return view('auth.signin');
	}

	public function postSignin(Request $request) 
	{
		$this->validate($request, [
			'email'=>'required',
			'password'=>'required',
			]);

		if(!Auth::attempt($request->only(['email','password']), $request->has('remember'))) {

			return redirect()->back()->with('info', 'Counld not sign you in with those details!');
		}

		return redirect()->route('home');
	}

	public function getSignout()
	{
		Auth::logout();

		return redirect()->route('home');
	}
}