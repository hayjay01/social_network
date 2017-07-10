<?php

namespace Mysocial\Http\Controllers;

use Auth;
use Input;
use Mysocial\Models\User;
use Mysocial\Models\Image;
use Mysocial\Models\Like;
use Mysocial\Models\Status;
use Illuminate\Http\Request;
use Validator;

//use App\Http\Requests\StatusRequest;

class StatusController extends Controller
{
	public function postStatus(Request $request)
	{	
		
			if($request->hasFile('image'))
			{
				if(count($request->image) > 3)
				{
					return redirect()->back()->with('info', 'You cannot upload more than 3 images per post');
				}
				else
				{
					
					// getting all of the post data
					$files = Input::file('image');

					// Making counting of uploaded images
					$file_count = count($files);

					// start count how many uploaded
					$uploadcount = 0;

					$status = Auth::user()->statuses()->create([
						'body'=>$request->input('status'),
						]);

					foreach($files as $file) {
						$rules = array('file' => 'required|image|max:1000'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
						$validator = Validator::make(array('file'=> $file), $rules);
							if($validator->passes()){
								$destinationPath = base_path() . '/public/status/';
									$filename = $file->getClientOriginalName();
									$upload_success = $file->move($destinationPath, $filename);
									$uploadcount ++;
								
								Image::create([
									'user_id' => Auth::user()->id,
									'status_id' => $status->id,
									'image' => 'status/' . $filename,
								]);

							}
					}

					if($uploadcount == $file_count){
						return redirect()->back()->with('info', 'Status uploaded successfilly');
					}
					else {
						return redirect()->back()->with('info', 'Please make sure the file is of image type and the maximum side should not exceed 1MB');
					}
				}
			}else
			{
				//dd($request->all());
				$this->validate($request, [
				'status' => 'required|max:1000'
				]);

				Auth::user()->statuses()->create([
					'body'=>$request->input('status'),
					]);
				return redirect()->route('home')->with('info', 'Status posted.');
			}

			
		
	}

	public function postReply(Request $request, $statusId)
	{
		$this->validate($request, [
			"reply-{$statusId}"=>'required|max:1000',
			], [
			'required'=>'The reply body is required.' 
			]);

		$status = Status::notReply()->find($statusId);

		if (!$status) {
			return redirect()->route('home');
		}

		if (!Auth::user()->isFriendWith($status->user) && Auth::user()->id !==$status->user->id ) {
			return redirect()->route('home');
		}

		$reply = Status::create([
			'body'=>$request->input("reply-{$statusId}"), 
			])->user()->associate(Auth::user());

		$status->replies()->save($reply);

		return redirect()->back();
	}

	public function getLike($statusId) 
	{
		$status = Status::find($statusId);

		if(!$status){
			return redirect()->route('home');
		}

		if (!Auth::user()->isFriendWith($status->user)){
			return redirect()->route('home');
		}

		if (Auth::user()->hasLikedStatus($status)){
			return redirect()->route('home');
		}

		$like = $status->likes()->create([]);
		Auth::user()->likes()->save($like);

		return redirect()->intended();
	}

	public function getDisLike($statusId)
	{
		
		$status = Status::find($statusId);

		$like = $status->likes()->delete([]);

		return redirect()->back();
	}

}