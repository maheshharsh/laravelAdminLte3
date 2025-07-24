<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advertisement extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'advertisements';
    const ID        = 'id';
    const TITLE     = 'title';
    const ADV_IMAGE = 'adv_image';

    /*
     * Constants for Categorys.
     */
    const BROWSE_ADVERTISEMENT = 'browse_advertisement';
    const VIEW_ADVERTISEMENT = 'view_advertisement';
    const CREATE_ADVERTISEMENT = 'create_advertisement';
    const UPDATE_ADVERTISEMENT = 'update_advertisement';
    const DELETE_ADVERTISEMENT = 'delete_advertisement';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::TITLE,
        self::ADV_IMAGE,
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
