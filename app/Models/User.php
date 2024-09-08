<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
//use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['firstName','lastName','email','mobile','password','image','role','otp'];
    protected $attributes = ['otp' => '0'];

    public function foods()
    {
        return $this->hasMany(Food::class);
    }

    public function scopeWithNonPendingFoodCount($query)
    {
        return $query->withCount(['foods' => function ($query) {
            $query->where('status', '!=', 'pending');
        }]);
    }

}


