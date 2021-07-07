<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Post model
 */
class Post extends Model
{
    protected $fillable = ['title', 'body'];
}
