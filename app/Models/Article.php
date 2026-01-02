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

      const  ID                 =         'id';
      const  TITLE              =         'title';
      const  SLUG               =         'slug';
      const  SUBCONTENT         =         'sub_content';
      const  CONTENT            =         'content';
      const  FEATUREDIMAGE      =         'featured_image';
      const  VIDEOFILE          =         'video_file';
      const  VIDEOTHUMBNAIL     =         'video_thumbnail';
      const  VIDEODESCRIPTION   =         'video_description';
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
       self::VIDEOFILE,
       self::VIDEOTHUMBNAIL,
       self::VIDEODESCRIPTION,
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

    /*
     * Constants for Article.
     */
    const BROWSE_ARTICLE = 'browse_article';
    const VIEW_ARTICLE = 'view_article';
    const CREATE_ARTICLE = 'create_article';
    const UPDATE_ARTICLE = 'update_article';
    const DELETE_ARTICLE = 'delete_article';

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

    public function user(): BelongsTo
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

    

    // public function getPublishedAtAttribute($value): ?string
    // {
    //     return $value ? date("d M Y", strtotime($value)) : null;
    // }
}