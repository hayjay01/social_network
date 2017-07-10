<?php

namespace Mysocial\Http\Controllers;

use Auth;
use Mysocial\Models\Status;
use Mysocial\Models\Image;

class HomeController extends Controller
{
	public function index()
	{
		
		if(Auth::check()){
			$statuses = Status::notReply()->where(function($query) {
				return $query->where('user_id', Auth::user()->id)->orWhereIn('user_id', Auth::user()->friends()->lists('id'));
			})->orderBy('created_at', 'desc')->paginate(5);

			//$image = Image::where([ ['user_id', Auth::user()->id], ['status_id', $statuses->id] ])->get()
			// $html = '';

			return view('timeline.index')->with('statuses', $statuses); 
		}

		return view('home'); 
	}
}