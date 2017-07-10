<?php

namespace Mysocial\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
	protected $table = 'statuses';

	protected $fillable = [
		'body'
	];

	public function user()
	{
		return $this->belongsTo('Mysocial\Models\User', 'user_id');
	}

	public function images()
	{
		return $this->hasMany('Mysocial\Models\Image', 'status_id'); 
	}

	public function scopeNotReply($query)
	{
		return $query->whereNull('parent_id');
	}

	public function replies()
	{
		return $this->hasMany('Mysocial\Models\Status', 'parent_id');
	}

	public function likes()
	{
		return $this->morphMany('Mysocial\Models\Like', 'likeable'); 
	}

}