<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\PaymentItem
 *
 * @property int $id
 * @property string $count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentItem newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentItem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentItem query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentItem whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentItem withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentItem withoutTrashed()
 * @mixin \Eloquent
 * @property string $title
 * @property float $price
 * @property string|null $option_1
 * @property string|null $option_2
 * @property string|null $option_3
 * @property string|null $option_4
 * @property string|null $option_5
 * @property string|null $option_6
 * @property string|null $option_7
 * @property string|null $option_8
 * @property string|null $option_9
 * @property string|null $option_10
 * @property int $payment_id
 * @property int $menu_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentItem whereMenuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentItem whereOption1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentItem whereOption10($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentItem whereOption2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentItem whereOption3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentItem whereOption4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentItem whereOption5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentItem whereOption6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentItem whereOption7($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentItem whereOption8($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentItem whereOption9($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentItem wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentItem whereTitle($value)
 */
class PaymentItem extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'title',
        'price',
        'option_1',
        'option_2',
        'option_3',
        'option_4',
        'option_5',
        'option_6',
        'option_7',
        'option_8',
        'option_9',
        'option_10',
        'payment_id',
        'menu_id'
    ];

    protected $hidden = [

    ];

    public static function createItem($items, $payment_id)
    {
        try {
            foreach ($items as $item) {

                $ret_option = array_fill(0, 10, null);
                foreach ($item->options as $index => $option) {
                    $ret_option[$index] = self::option($option->values, $option->select);
                }

                self::create([
                    'title' => $item->info->title,
                    'price' => $item->info->price,
                    'option_1' => $ret_option[0],
                    'option_2' => $ret_option[1],
                    'option_3' => $ret_option[2],
                    'option_4' => $ret_option[3],
                    'option_5' => $ret_option[4],
                    'option_6' => $ret_option[5],
                    'option_7' => $ret_option[6],
                    'option_8' => $ret_option[7],
                    'option_9' => $ret_option[8],
                    'option_10' => $ret_option[9],
                    'payment_id' => $payment_id,
                    'menu_id' => $item->info->id
                ]);
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public static function option($values, $select)
    {
        foreach ($values as $value) {
            if ($value->id == $select) {
                return $value->value;
            }
        }
    }

    public function optionString()
    {
        $tmp = [];
        $tmp[] = $this->option_1;
        $tmp[] = $this->option_2;
        $tmp[] = $this->option_3;
        $tmp[] = $this->option_4;
        $tmp[] = $this->option_5;
        $tmp[] = $this->option_6;
        $tmp[] = $this->option_7;
        $tmp[] = $this->option_8;
        $tmp[] = $this->option_9;

        return implode(' / ', array_filter($tmp));
    }
}
