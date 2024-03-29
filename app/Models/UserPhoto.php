<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'type',
    ];

    protected $appends = ['profile_photo'];

    // ACCESSOR

    // public function getProfilePhotoAttribute()
    // {
    //     return asset('/user_profile/' . $this->name);
    // }

    public function getProfilePhotoAttribute()
    {
        return $this->name;
    }
}
