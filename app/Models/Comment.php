<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

//use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = ['_token'];

    //===در موردش بیشتر مطالعه شود واقعا کاربردی بود
    public function scopeConfirmed($query)
    {
        return $query->where('confirmed', 1);
    }


    /**
     * Get the post that owns the Comment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
//    public function post(): BelongsTo
//    {
//        return $this->belongsTo(Post::class, 'post_id', 'id');
//    }

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }
}
