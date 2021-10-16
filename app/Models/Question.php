<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    // public $timestamps = false;
    protected $primaryKey = 'id';

    protected $fillable=[
        'question',
        'likes',
        'comments',
        'users_id'
    ];
}
