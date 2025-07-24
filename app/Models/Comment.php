<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'article_id',
        'user_id',
        'guest_name',
        'guest_email',
        'is_approved'
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getCommenterNameAttribute()
    {
        return $this->user_id ? $this->user->name : $this->guest_name;
    }

    public function getCommenterEmailAttribute()
    {
        return $this->user_id ? $this->user->email : $this->guest_email;
    }
}
