<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Video;
use App\Models\User;

class Comment extends Model
{
    use HasFactory;
    public $timestamps = false;
    
    public function video(){
        return $this->belongsTo(Video::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
