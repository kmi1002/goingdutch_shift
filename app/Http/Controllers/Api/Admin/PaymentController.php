<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\Admin\BaseApiController;
use App\Http\Resources\Admin\PaymentResource;
use Illuminate\Http\Request;

use App\Models\Payment;

class PaymentController extends BaseApiController
{
    public function index(Request $request)
    {
        try {
            $type       = $request->type;
            $page       = $request->page;
            $per_page   = $request->per_page;

            $vendors = Payment::where(function ($query) use ($request) {

                    if (!empty($request->search_text)) {
                        $query->where('vendor', 'like', "%{$request->search_text}%");
                    }

                    if (!empty($request->start_date)) {
                        $query->whereDate('created_at', '>=', $request->start_date);
                    }

                    if (!empty($request->end_date)) {
                        $query->whereDate('created_at', '<=', $request->end_date);
                    }
                })->paginate($per_page, ['*'], 'page', $page);

            return PaymentResource::collection($vendors);

        } catch (\Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
        }

        return response($msg, $code);
    }

    public function store()
    {
    }

    public function show($id)
    {
    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {
    }
}