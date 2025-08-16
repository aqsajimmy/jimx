<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Template extends Model
{
    use HasFactory;
    protected $table = 'templates';
    protected $guarded = [];

    function author()
    {
        return $this->belongsTo(User::class);
    }
    function categories()
    {
        return $this->belongsTo(Category::class);
    }
}
