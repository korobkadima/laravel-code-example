<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Michaeljennings\Laralastica\Searchable;
use Illuminate\Database\Eloquent\SoftDeletes;

class PhotoFace extends Model
{
    use /*Searchable,*/ SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'photos_face';

    /**
     * The attributes that are mutated to Carbon object
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'x',
        'y',
        'width',
        'photo_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /*
     | ------------------------------------------------
     | Entity relationships
     | ------------------------------------------------
     | All relationships belongs to this entity.
     |
     */

    /**
     * Photo belongs to Photo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function photo()
    {
        return $this->belongsTo('App\Entities\Photo');
    }

    /*
     | ------------------------------------------------
     | Entity exclusive methods
     | ------------------------------------------------
     | Local methods belongs to this entity.
     |
     */

    /*
     | ------------------------------------------------
     | Entity scopes
     | ------------------------------------------------
     | Local query builder scopes appended to this
     | entity.
     |
     */

    /*
     | ------------------------------------------------
     | Entity attributes
     | ------------------------------------------------
     | Setters and Getters for custom attributes.
     |
     */
}
