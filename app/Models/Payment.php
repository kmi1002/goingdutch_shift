<?php

namespace App\Models;

use App\Helpers\IPHelper;
use App\Helpers\TimeHelper;
use Browser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Payment
 *
 * @property int $id
 * @property string $dpt_code
 * @property string $no
 * @property string $name
 * @property string|null $email
 * @property string|null $tel
 * @property string|null $address
 * @property string $table_no
 * @property string $currency
 * @property float $price
 * @property string $ip
 * @property string $device
 * @property string $type
 * @property string $data
 * @property string $status
 * @property string $result
 * @property string|null $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Payment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereDevice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereDptCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereOrderAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereOrderEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereOrderName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereOrderNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereOrderTel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereTableNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Payment withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Payment withoutTrashed()
 * @mixin \Eloquent
 * @property string $order_no
 * @property string|null $today_no
 * @property string $item
 * @property int $count
 * @property int $vendor_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PaymentItem[] $paymentItems
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereItem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereTel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereTodayNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereVendorId($value)
 */
class Payment extends Model
{
    protected $fillable = [
        'dpt_code',
        'order_no',
        'today_no',
        'name',
        'email',
        'tel',
        'address',
        'table_no',
        'item',
        'count',
        'currency',
        'price',
        'ip',
        'device',
        'type',
        'data',
        'status',
        'result',
        'message',
        'vendor_id',
        'user_id',
    ];

    protected $hidden = [

    ];

    public function paymentItems()
    {
        return $this->hasMany('App\Models\PaymentItem');
    }

    public static function readyPayment($request)
    {
        try {
            $order_type = $request->order_type;
            $user_id    = \Auth::check() ? \Auth::user()->id : null;
            $vendor_id  = $request->vendor_id;
            $pay_type   = $request->pay_type;
            $items      = json_decode($request->items);
            $price      = $request->price;

            $order_no   = "gd_".$vendor_id.time();
            $item       = '';
            $count      = count($items);
            if ($count > 0) {
                $item   = $items[0]->info->title;

                if ($count > 1) {
                    $item   = $item.' 외 ('.($count-1).')';
                }
            }

            if (!Payment::priceCheck($items, $price)) {
                throw new \Exception('상품과 값이 틀림');
            }

            if ($order_type == 'delivery') {
                $name       = $request->name;
                $email      = $request->email;
                $tel        = $request->tel;
                $address    = $request->address;
                $table_no   = null;
            } else {
                $name       = '고잉더치';
                $email      = null;
                $tel        = '000-0000-0000';
                $address    = null;
                $table_no   = $request->table_no;
            }

            $payment = Payment::create([
                'dpt_code'          => $request->dpt_code,
                'order_no'          => $order_no,
                'name'              => $name,
                'email'             => $email,
                'tel'               => $tel,
                'address'           => $address,
                'table_no'          => $table_no,
                'item'              => $item,
                'count'             => $count,
                'price'             => $price,
                'currency'          => $request->currency ?? 'WON',
                'ip'                => IPHelper::realIP(),
                'device'            => Browser::platformName(),
                'type'              => $pay_type,
                'status'            => 'ready',
                'vendor_id'         => $vendor_id,
                'user_id'           => $user_id,
            ]);

            PaymentItem::createItem($items, $payment->id);

            return $payment;

        } catch (\Exception $e) {
            throw $e;
        }

        return null;   
    }
    
    public static function successPayment($request, $data = null, $message = null)
    {
        try {
            $vendor_id  = $request->vendor_id;
            $order_no   = $request->order_no;

            $payment = Payment::where('order_no', '=', $order_no)->firstOrFail();

//            $today = TimeHelper::nowToString();

            $count = Payment::where('vendor_id', $vendor_id)
//                ->where(function ($query) use ($today) {
//                        $query->whereDate('created_at', '>=', $today);
//                        $query->whereDate('created_at', '<=', $today);
//                })
                ->where('status', '=', 'success')
                ->get()
                ->count();

            $payment->today_no  = 'G-'.($count + 1);
            $payment->status    = 'success';
            $payment->result    = 'ready';
            $payment->data      = $data;
            $payment->message   = $message;
            $payment->save();

            return $payment;

        } catch (\Exception $e) {

            dd($e, $data, $message);

        }

        return null;
    }

    public static function updatePayment($request)
    {
        try {
            $order_no  = $request->order_no;
            $result   = $request->result;

            $payment = Payment::where('order_no', '=', $order_no)->firstOrFail();
            $payment->result    = $result;
            $payment->save();

            return $payment;

        } catch (\Exception $e) {

        }

        return null;
    }

    public static function refundPayment($request)
    {
        try {
            $order_id   = $request->order_no;
            $message   = $request->message;

            $payment = Payment::where('order_no', '=', $order_id)->firstOrFail();
            $payment->status    = 'refund';
            $payment->message    = $message;
            $payment->save();

            return $payment;

        } catch (\Exception $e) {

        }

        return null;
    }

    
    public static function cancelPayment($request, $data = null, $message = null)
    {
        try {
            $vendor_id  = $request->vendor_id;
            $order_no   = $request->order_no;

            $payment = Payment::where('order_no', '=', $order_no)->firstOrFail();

//            $today = TimeHelper::nowToString();

            $count = Payment::where('vendor_id', $vendor_id)
//                ->where(function ($query) use ($today) {
//                        $query->whereDate('created_at', '>=', $today);
//                        $query->whereDate('created_at', '<=', $today);
//                })
                ->where('status', '=', 'success')
                ->get()
                ->count();

            $payment->today_no  = null;
            $payment->status    = 'cancel';
            $payment->result    = null;
            $payment->save();

            return $payment;

        } catch (\Exception $e) {

        }

        return null;
    }

    public static function priceCheck($items, $price)
    {
        return true;
    }

    public function type()
    {
        switch ($this->type) {
            case 'card_auth_pay':   return '카드 인증 결제';
            case 'card_safe_pay':   return '카드 안전 결제';
            case 'kakao_pay':       return '카카오 페이 결제';
            case 'naver_pay':       return '네이버 페이 결제';
            default:                return 'EASY 페이 결제';
        }
    }
}
