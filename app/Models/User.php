<?php

namespace Mysocial\Models;

use Mysocial\Models\Status;
use Mysocial\Models\Profile;
use Mysocial\Models\ImageStatus;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends Model implements AuthenticatableContract
{
    use Authenticatable;

    protected $table = 'users';


    protected $fillable = [
    'username', 
    'email', 
    'password',
    'first_name',
    'last_name',
    'location',
    ];


    protected $hidden = [
    'password', 
    'remember_token',
    ];

    public function getName()
    {
        if($this->first_name && $this->last_name){
            return "{$this->first_name} {$this->last_name}";
        }

        if($this->first_name) {
            return $this->first_name;
        }

        return null;
    }

    public function profile()
    {
        return $this->hasOne('Mysocial\Models\Profile', 'user_id');
    }

    public function getNameOrUsername() 
    {
        return $this->getName() ?: $this->username;
    }

    public function getFirstNameOrUsername() 
    {
        return $this->first_name ?: $this->username;
    }

    public function getAvatarUrl() 
    {
        return "https://www.gravatar.com/avatar/{{ md5($this->email) }}?d=mm&s=50";
    }

    public function statuses()
    {
        return $this->hasMany('Mysocial\Models\Status', 'user_id');
    }

    public function images()
    {
        return $this->hasMany('Mysocial\Models\Image', 'user_id');
    }

    public function likes()
    {
        return $this->hasMany('Mysocial\Models\Like', 'user_id');
    }

   /* public function dislikes()
    {
        return $this->hasMany('Mysocial\Models\Like', 'user_id');
    }*/

    public function friendsOfMine()
    {
        return $this->belongsToMany('Mysocial\Models\User', 'friends', 'user_id', 'friend_id');

    }

    public function friendOf()
    {
        return $this->belongsToMany('Mysocial\Models\User', 'friends', 'friend_id', 'user_id');
    }

    public function friends()
    {
       return $this->friendsOfMine()->wherePivot('accepted', true)->get()->merge($this->friendOf()->wherePivot('accepted', true)->get()); 
    }

    public function friendRequests()
    {
        return $this->friendsOfMine()->wherePivot('accepted', false)->get();
    }

    public function friendRequestsPending()
    {
        return $this->friendOf()->wherePivot('accepted', false)->get();
    }

    public function hasFriendRequestPending(User $user)
    {
        return (bool) $this->friendRequestsPending()->where('id', $user->id)->count();
    }

    public function hasFriendRequestRecieved(User $user)
    {
        return (bool) $this->friendRequests()->where('id', $user->id)->count();
    }

    public function addFriend(User $user)
    {
        $this->friendOf()->attach($user->id);
    }

    public function deleteFriend(User $user)
    {
        $this->friendsOfMine()->detach($user->id);
        $this->friendOf()->detach($user->id);
    }

    public function acceptFriendRequest(User $user)
    {
        $this->friendRequests()->where('id', $user->id)->first()->pivot->update([
            'accepted'=>true,
            ]);
    }

    public function isFriendWith(User $user)
    {
        return (bool) $this->friends()->where('id', $user->id)->count();
    }

    public function hasLikedStatus(Status $status)
    {
        return (bool) $status->likes->where('user_id', $this->id)->count();
    }

    public function hasLikedImageStatus(ImageStatus $status_image)
    {
        return (bool) $status_image->likes->where('user_id', $this->id)->count();
    }
    
}   

