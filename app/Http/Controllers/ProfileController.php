<?php

namespace Mysocial\Http\Controllers;

use Auth;
use Mysocial\Models\User;
use Mysocial\Models\Profile; 
use Illuminate\Http\Request;
use Storage;

class ProfileController extends Controller
{
	public function getProfile($username)
	{
		$user = User::where('username', $username)->first();

		if(!$user){
			abort(404);
		}

		$statuses = $user->statuses()->notReply()->get();

		return view('profile.index')
		->with('user', $user)->with('statuses', $statuses)->with('authUserIsFriend', Auth::user()->isFriendWith($user));
	}

	public function getEdit()
	{
		return view('profile.edit');
	}

	public function postEdit(Request $request)
	{
		$profile = Profile::where('user_id', Auth::user()->id)->first();

		$this->validate($request, [
			'first_name'=>'alpha|max:50',
			'last_name'=>'alpha|max:50',
			'location'=>'max:20',
			'profile_image' => 'image',
			'department' => 'max:50',
			'phone_number' => 'numeric|phone',
			]);

		Auth::user()->update([
			'first_name'=>$request->input('first_name'),
			'last_name'=>$request->input('last_name'),
			'location'=>$request->input('location'),
			]);

		if($request->hasFile('profile_picture'))
		{ 
			$destinationPath = base_path() . '/public/profile/'; 

			$profile_image = $request->profile_picture;

			$profile_new_name = time().$profile_image->getClientOriginalName();

			$profile_image->move($destinationPath, $profile_new_name);

			//Storage::disk('uploads')->put('profile_image', $profile_new_name);

			$profile->profile_image = 'profile/' . $profile_new_name;

			$profile->save();
		}

			$profile->department = $request->department;
			$profile->phone_number = $request->phone_number;
			$profile->level = $request->level;
			$profile->address = $request->address;

			$profile->save();


		return redirect()->route('profile.edit')->with('info', 'Your profile has been updated successfully');
	}
}