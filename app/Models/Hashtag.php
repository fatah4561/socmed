<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hashtag extends Model
{
    protected $guarded = ['id'];

    public function Post(){
        return $this->belongsTo(Post::class,'post_id');
    }

    public function Comment(){
        return $this->belongsTo(Comment::class,'comment_id');
    }
}
