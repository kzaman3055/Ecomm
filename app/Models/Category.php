<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guarded = ['slug'];
    protected $table = 'categories';

    public function products()
    {
        return $this->hasMany('App\Product', 'category_id');
    }
}
