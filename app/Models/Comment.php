<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $timestamps = true;

    protected $guarded = ['id'];

    public function User(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function HashtagList(){
        return $this->hasMany(Hastag::class,'comment_id');
    }
}
