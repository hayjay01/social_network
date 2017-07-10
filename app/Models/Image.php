<?php

namespace Mysocial\Models;

use Illuminate\Database\Eloquent\Model; 

class Image extends Model
{
    protected $fillable = ['user_id', 'status_id', 'image'];

    public function user()
    {
        return $this->belongsTo('Mysocial\Models\User', 'user_id');
    }

    public function status()
    {
        return $this->belongsTo('Mysocial\Models\Status', 'status_id');
    }
}
