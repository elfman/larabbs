<?php

namespace App\Models;

class Topic extends Model
{
    protected $fillable = ['title', 'body', 'last_reply_user_id', 'order', 'excerpt', 'slug'];
}
