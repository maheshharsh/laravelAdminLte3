<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'media';

    const ID            = 'id';
    const FILE_NAME     = 'file_name';
    const PATH          = 'path';
    const DISK          = 'disk';
    const USER_ID       = 'user_id';
    const ARTICLE_ID    = 'article_id';

    /*
     * Constants for Categorys.
     */
    const BROWSE_MEDIA = 'browse_media';
    const VIEW_MEDIA = 'view_media';
    const CREATE_MEDIA = 'create_media';
    const UPDATE_MEDIA = 'update_media';
    const DELETE_MEDIA = 'delete_media';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::FILE_NAME,
        self::PATH,
        self::DISK,
        self::USER_ID,
        self::ARTICLE_ID,
    ];

    protected $appends = ['url'];

    /**
     * Get the featured image URL with storage path.
     *
     * @param  string|null  $value
     * @return string|null
     */
    public function getUrlAttribute(): ?string
    {
        if ($this->path && $this->file_name) {
            // file_path = "path/filename.ext"
            return route('admin.file.serve', [
                'file_path' => ltrim($this->file_name)
            ]);
        }
        return null;
    }
}

