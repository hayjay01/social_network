<?php

namespace Mysocial\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
	protected $table = 'likeable';

	public function likeable()
	{
		return $this->morhpTo();
	}

	public function user()
	{ 
		return $this->belongsTo('Mysocial\Models\User', 'user_id');
	}
}