<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'post_id',
        'user_id',
    ];
}
