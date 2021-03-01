<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\MessageLog
 *
 * @property int $id
 * @property string $email
 * @property string $success
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int $message_id
 * @property int $user_id
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MessageLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MessageLog newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MessageLog onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MessageLog query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MessageLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MessageLog whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MessageLog whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MessageLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MessageLog whereMessageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MessageLog whereSuccess($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MessageLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MessageLog whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MessageLog withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MessageLog withoutTrashed()
 * @mixin \Eloquent
 */
class MessageLog extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'email',
        'success',
        'message_id',
        'user_id',
    ];

    protected $hidden = [

    ];
}