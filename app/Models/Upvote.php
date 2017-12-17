<?php

namespace App\Models;

class Upvote extends Model
{
    protected $fillable = ['topic_id', 'user_id'];
    protected $table = 'topics_upvotes';

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}