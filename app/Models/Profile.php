<?php

namespace Mysocial\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['user_id', 'department', 'phone_number', 'level', 'address', 'profile_image'];

    public function user()
    {
        return $this->belongsTo('Mysocial\Models\User');
    }
}
