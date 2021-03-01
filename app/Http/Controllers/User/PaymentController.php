<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Library\KSNET\KSPayWebHost;
use App\Models\Coupon;
use App\Models\Payment;
use App\Models\Vendor;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function ready(Request $request)
    {
        $vendor = Vendor::selectVendor($request->vendor_id);
        $order_type = $request->order_type;

        if ($request->type == "menu") {
            $order_items = json_decode($request->order_items);
            $order_count = count($order_items);
            $order_price = $request->order_price;


            $retOptions = [];
            $tmpOptions = [];
            foreach ($order_items as $item) {

                $objItem = (object)$item;

                $tmpOptions = [];
                foreach ($objItem->options as $index => $option) {

                    $select = $option->select;
                    $value = [];
                    foreach ($option->values as $item) {
                        $value[] = ['id' => $item->id, 'value' => $item->value];

                        if ($select == $item->id) {
                            $tmpOptions[] = $item->value;
                        }
                    }
                }

                $objItem->info->options = implode(' / ', $tmpOptions);
            }

        } else {
            $order_items = json_decode($request->order_items);
            $order_count = count($order_items);
            $order_price = $request->order_price;
        }

        return view('user.payment.index', [
            'vendor' => $vendor,
            'order_type' => $order_type,
            'order_count' => $order_count,
            'order_items' => $order_items,
            'order_price' => $order_price
        ]);
    }

    public function invoice(Request $request, $vendor_id, $order_no)
    {
        try {
            $payment = Payment::with('paymentItems')->where('order_no', '=', $order_no)->firstOrFail();

            $vendor = Vendor::selectVendor($vendor_id);

            $coupon = null;
            if ($payment->status == 'success') {
                $coupon = Coupon::createItem(['vendor_id' => $vendor_id, 'type' => 'invoice', 'payment_id' => $payment->id]);
            }

            return view('user.payment.invoice', [
                'payment' => $payment,
                'vendor' => $vendor,
                'status' => $payment->status,
                'coupon' => $coupon
            ]);
        } catch (\Exception $e) {

            return view('user.payment.invoice', [
                'payment' => $payment,
                'vendor' => $vendor,
                'status' => 'duplicate',
                'errMsg' => $e->getMessage()
            ]);

        }
    }

    public function easyPay(Request $request)
    {
        $vendor = Vendor::selectVendor($request->vendor_id);
        $store_id = $request->storeid;
        $currency_type = $request->currencytype;
        $order_number = $request->ordernumber;
        $interest_type = $request->interesttype;
        $count = $request->count;
        $amount = $request->amount;
        $good_name = $request->goodname;
        $order_name = $request->ordername;
        $email = $request->email;
        $phone_no = $request->phoneno;
        $order_no = $request->order_no;

        return view('user.payment.easypay', [
                'vendor' => $vendor,
                'store_id' => $store_id,
                'order_number' => $order_number,
                'interest_type' => $interest_type,
                'amount' => $amount,
                'good_name' => $good_name,
                'order_name' => $order_name,
                'email' => $email,
                'phone_no' => $phone_no,
                'currency_type' => $currency_type,
                'count' => $count,
                'price' => $amount,
                'order_no' => $order_no,
            ]
        );
    }

    public function kspay_wh_rcv(Request $request)
    {
        if (function_exists("mb_http_input")) {
            mb_http_input("euc-kr");
        }

        if (function_exists("mb_http_output")) {
            mb_http_output("euc-kr");
        }

        $rcid       = $request->reCommConId;
        $rctype     = $request->reCommType;
        $rhash      = $request->reHash;

        return view('user.payment.card.kspay_wh_rcv', compact('rcid', 'rctype', 'rhash'));
    }

    public function ksnetCallback(Request $request)
    {
        // Mobile용 으로 통합
        $rcid       = $request->reCommConId;
        $rctype     = $request->reCommType;
        $rhash      = $request->reHash;

        // rcid 없으면 결제를 끝까지 진행하지 않고 중간에 결제취소
        $ipg = new KSPayWebHost($rcid, null);

        $authyn = "";
        $trno   = "";
        $trddt  = "";
        $trdtm  = "";
        $amt    = "";
        $authno = "";
        $msg1   = "";
        $msg2   = "";
        $ordno  = "";
        $isscd  = "";
        $aqucd  = "";
        $temp_v = "";
        $result = "";

        $resultcd =  "";

        if ($ipg->sendMsg("1"))
        {
            $authyn = $ipg->getValue("authyn");
            $trno   = $ipg->getValue("trno"  );
            $trddt  = $ipg->getValue("trddt" );
            $trdtm  = $ipg->getValue("trdtm" );
            $amt    = $ipg->getValue("amt"   );
            $authno = $ipg->getValue("authno");
            $msg1   = iconv("EUC-KR","UTF-8", $ipg->getValue("msg1"));
            $msg2   = iconv("EUC-KR","UTF-8", $ipg->getValue("msg2"));
            $ordno  = $ipg->getValue("ordno" );
            $isscd  = $ipg->getValue("isscd" );
            $aqucd  = $ipg->getValue("aqucd" );
            $temp_v = "";
            $result = $ipg->getValue("result");

            // PC 용
            $halbu  = $ipg->getValue("halbu");
            $cbtrno = $ipg->getValue("cbtrno");
            $cbauthno = $ipg->getValue("cbauthno");

            if (!empty($authyn) && 1 == strlen($authyn))
            {
                if ($authyn == "O")
                {
                    $resultcd = "0000";
                }else
                {
                    $resultcd = trim($authno);
                }

                $ipg->sendMsg("3"); // 정상처리가 완료되었을 경우 호출합니다.(이 과정이 없으면 일시적으로 kspay_send_msg("1")을 호출하여 거래내역 조회가 가능합니다.)
            }
        }

        $payment = null;

        // trno : 거래번호
        // authno : 승인번호 (dpt_code)
        // isscd : 발급사 코드
        // aqucd : 매입사 (비씨카드..)

        if ($authyn == "O") {
            $data = json_encode(['trno' => $trno, 'authno' => $authno, 'isscd' => $isscd, 'aqucd' => $aqucd]);
            $message = $msg1 . $msg2;

            $payment = Payment::successPayment($request, $data, $message);
        } else {
            $payment = Payment::cancelPayment($request);
        }

        return redirect()->route('user.payment.invoice', ['vendor' => $payment->vendor_id, 'order_no' => $payment->order_no]);
    }
}