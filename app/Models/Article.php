<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model
{
    use SoftDeletes;

      const  TITLE              =         'title';
      const  SLUG               =         'slug';
      const  SUBCONTENT         =         'sub_content';
      const  CONTENT            =         'content';
      const  FEATUREDIMAGE      =         'featured_image';
      const  CATEGORYID         =         'category_id';
      const  USERID             =         'user_id';
      const  PUBLISHEDAT        =         'published_at';
      const  ISFEATURED         =         'is_featured';
      const  ISPUBLISHED        =         'is_published';
      const  ISCAROUSEL         =         'is_carousel';

      
    protected $fillable = [
       self::TITLE,
       self::SLUG,
       self::SUBCONTENT,
       self::CONTENT,
       self::FEATUREDIMAGE,
       self::CATEGORYID,
       self::USERID,
       self::PUBLISHEDAT,
       self::ISFEATURED,
       self::ISPUBLISHED,
       self::ISCAROUSEL,
    ];

    protected $casts = [
        self::PUBLISHEDAT => 'datetime',
        self::ISFEATURED => 'boolean',
        self::ISCAROUSEL => 'boolean',
        self::ISPUBLISHED => 'boolean',
    ];

    protected $appends = ['category_name', 'image'];

    /**
     * Get the category name attribute.
     *
     * @return string|null
     */
    public function getCategoryNameAttribute()
    {
        return $this->category_id ? $this->category->name : null;
    }


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function media(): HasMany
    {
        return $this->hasMany(Media::class, 'article_id');
    }

    /**
     * Get the featured image URL with storage path.
     *
     * @param  string|null  $value
     * @return string|null
     */
    public function getImageAttribute($value): ?string
    {
        return $this->featured_image ? asset('/storage/' . $this->featured_image) : null;
    }

    public function getPublishedAtAttribute($value): ?string
    {
        return $value ? date("d M Y", strtotime($value)) : null;
    }
}