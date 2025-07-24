<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;

    const ID          = 'id';
    const NAME        = 'name';
    const SLUG        = 'slug';

     /*
     * Constants for Categorys.
     */
    const BROWSE_CATEGORY = 'browse_category';
    const VIEW_CATEGORY = 'view_category';
    const CREATE_CATEGORY = 'create_category';
    const UPDATE_CATEGORY = 'update_category';
    const DELETE_CATEGORY = 'delete_category';

    protected $fillable = [
        self::NAME,
        self::SLUG,
    ];

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }
}