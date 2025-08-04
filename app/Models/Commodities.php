<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commodities extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'commodities';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    const ID = 'id';
    const TITLE = 'title';
    const PRICE = 'price';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::TITLE,
        self::PRICE,
    ];

     /*
     * Constants for Article.
     */
    const BROWSE_COMMODITIES = 'browse_commodities';
    const VIEW_COMMODITIES = 'view_commodities';
    const CREATE_COMMODITIES = 'create_commodities';
    const UPDATE_COMMODITIES = 'update_commodities';
    const DELETE_COMMODITIES = 'delete_commodities';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function getCreatedAtAttribute($value): ?string
    {
        return $value ? date("d M Y", strtotime($value)) : null;
    }
}
