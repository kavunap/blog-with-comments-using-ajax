<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['blog_id','description','user_id','id'];

    // public function blog()
    // {
    //     return $this->belongsTo('App\Comment');
    // }
}
