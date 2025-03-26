<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{


    protected $fillable = [
        'comment',
        'user_id',
        'commentable_id',
        'commentable_type',
        'parent_id',

    ];
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }
}
