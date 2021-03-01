<?php

namespace App\Http\Controllers\Api\User\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ManagerResource;
use App\Http\Resources\Frontend\v1\PaymentResource;
use App\Models\Payment;
use Illuminate\Http\Request;

use App\Library\KSNET\KSPayWebHost;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        try {
            $payment = Payment::readyPayment($request);
            if ($payment) {
                return new PaymentResource($payment);
            }

            return response()->json($payment, 202);

        } catch (\Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
        }

        return response($msg, $code);
    }

    public function success(Request $request)
    {
        try {
            $payment = Payment::successPayment($request);
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

    public function easyPay(Request $request)
    {
        $order_no = $request->order_no;
        return response()->json(['order_no' => $order_no], 200);
    }

    public function ksnetCallback(Request $request)
    {

        dd($request);
        $rcid       = $request->reCommConId;
        $rctype     = $request->reCommType;
        $rhash      = $request->reHash;

        // rcid 없으면 결제를 끝까지 진행하지 않고 중간에 결제취소
        $ipg = new KSPayWebHost($rcid, null);

        $authyn		= "";
        $trno		= "";
        $trddt		= "";
        $trdtm		= "";
        $amt		= "";
        $authno		= "";
        $msg1		= "";
        $msg2		= "";
        $ordno		= "";
        $isscd		= "";
        $aqucd		= "";
        $temp_v		= "";
        $result		= "";

        $resultcd =  "";

        if ($ipg->send_msg("1")) {
            $authyn	 = $ipg->getValue("authyn");
            $trno	 = $ipg->getValue("trno"  );
            $trddt	 = $ipg->getValue("trddt" );
            $trdtm	 = $ipg->getValue("trdtm" );
            $amt	 = "￦".number_format($ipg->getValue("amt"));
            $authno	 = $ipg->getValue("authno");
            $msg1	 = $ipg->getValue("msg1"  );
            $msg1 = iconv("euc-kr","utf-8",$msg1 );
            $msg2	 = $ipg->getValue("msg2"  );
            $msg2 = iconv("euc-kr","utf-8",$msg2 );
            $ordno	 = $ipg->getValue("ordno" );
            $isscd	 = $ipg->getValue("isscd" );
            $aqucd	 = $ipg->getValue("aqucd" );
            //$temp_v	 = $ipg->getValue("temp_v");
            $result	 = $ipg->getValue("result");

            if (!empty($authyn) && 1 == strlen($authyn))
            {
                if ($authyn == "O")
                {
                    $resultcd = "0000";
                }else
                {
                    $resultcd = trim($authno);
                }

                $ipg->send_msg("3");
            }
        }

        if ($authyn == "O") {
            $order_result = "success";
        } else {
            $order_result = "cancel";
        }

        dd($ordno, $order_result, $trno);

        //  여기서 데이터 저장하고 리턴 시키기~
////        pay_update_status($ordno, $order_result, $trno, $ret_msg);
    }
}