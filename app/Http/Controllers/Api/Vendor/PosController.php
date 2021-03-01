<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Helpers\DebugHelpers;
use App\Helpers\TimeHelper;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Controllers\Api\Vendor\BaseApiController;
use App\Http\Resources\Admin\PaymentResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Resources\Admin\UserResource;

use App\Models\Payment;

class PosController extends BaseApiController
{
    public function index(Request $request)
    {
        try {
            $page       = $request->page;
            $per_page   = $request->per_page;

            $vendors = Payment::with('paymentItems')
            ->where(function ($query) use ($request) {

                $query->where('status', 'success');

                $query->where('result', $request->pay_status);

                $date = Carbon::now()->toDateString();
                $query->whereDate('created_at', '>=', $date);

                $query->whereDate('created_at', '<=', $date);
            })->paginate($per_page, ['*'], 'page', $page);

            return PaymentResource::collection($vendors);

        } catch (\Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
        }

        return response($msg, $code);
    }

    public function change(Request $request)
    {
        try {
            $payment = Payment::updatePayment($request);

            if ($payment) {
                return new PaymentResource($payment);
            }

            return response()->json('a', 202);

        } catch (\Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
        }

        return response()->json(['code' => $code, 'msg' => $msg], $code);
    }

    public function refund(Request $request)
    {
        try {
            $payment = Payment::refundPayment($request);

            if ($payment) {
                return new PaymentResource($payment);
            }

            return response()->json('a', 202);

        } catch (\Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
        }

        return response()->json(['code' => $code, 'msg' => $msg], $code);
    }
}