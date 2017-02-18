<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'content','user_id','article_id',
    ];

    /**
     * Get the comments for the blog post.
     */

    public function article() {
        return $this->belongsTo('App\Article');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }
    
}
