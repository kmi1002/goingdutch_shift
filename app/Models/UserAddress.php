<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\UserAddress
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserAddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserAddress newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserAddress onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserAddress query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserAddress withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserAddress withoutTrashed()
 * @mixin \Eloquent
 */
class UserAddress extends Model
{
    use SoftDeletes;

    protected $fillable = [

    ];

    protected $hidden = [

    ];
}