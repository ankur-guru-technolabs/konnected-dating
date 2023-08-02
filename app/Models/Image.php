<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_id',
        'file_name',
        'type'
    ];

    protected $appends = ['image_url'];

    // ACCESSOR

    public function getImageUrlAttribute()
    {
        if($this->type == 'category_image'){
            return asset('/category_image/' . $this->file_name);
        }
        if($this->type == 'test_user'){
            return asset('/test_user/' . $this->file_name);
        }
        return null;
    }
}
