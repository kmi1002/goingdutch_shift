<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Helpers\DebugHelpers;
use App\Http\Controllers\Api\Vendor\BaseApiController;
use App\Http\Resources\Admin\ManagerResource;
use App\Http\Resources\Admin\MenuItemResource;
use App\Models\Imports\VendorImport;
use Illuminate\Http\Request;
use App\Http\Resources\Admin\VendorResource;

use App\Models\Vendor;
use App\Models\User;
use App\Models\MenuItem;

use Maatwebsite\Excel\Facades\Excel;

class VendorController extends BaseApiController
{
    public function index(Request $request)
    {
        try {

//            if (!\Auth::guard('admin')->check()) {
//                throw new \Exception('Unauthenticated', 401);
//            }
            $roles = ['vendor_administrator', 'vendor_manager', 'vendor_operator', 'vendor_analyst'];

            $type       = $request->type;
            $page       = $request->page;
            $per_page   = $request->per_page;

            $vendors = Vendor::with(['user' => function ($query) {
                    $query->withTrashed();
                }], 'user.userLogs')
                ->whereHas('user', function ($query) use ($request, $roles) {

                    $filter = $request->filter;

                    $query->role($roles);
                    $query->withTrashed();

                    if (!empty($filter->search_text)) {
                        $query->where('company', 'like', "%{$filter->search_text}%")
                            ->orWhere('nick_name', 'like', "%{$filter->search_text}%")
                            ->orWhere('email', 'like', "%{$filter->search_text}%");
                    }

                    if (!empty($filter->start_date)) {
                        $query->whereDate('created_at', '>=', $filter->start_date);
                    }

                    if (!empty($filter->end_date)) {
                        $query->whereDate('created_at', '<=', $filter->end_date);
                    }
                })
                ->where(function ($query) use ($request) {

                    $filter = $request->filter;

                    if (!empty($filter->search_text)) {
                        $query->where('company', 'like', "%{$filter->search_text}%");
                    }
                })
                ->orderByDesc('id')
                ->paginate($per_page, ['*'], 'page', $page);

            return VendorResource::collection($vendors);

        } catch (\Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
        }

        return response($msg, $code);
    }

    public function store(Request $request)
    {
        try {
            // 로컬 테스트용
//            $file = \Storage::path('vendor_sample.xlsx');

            // 실제 서비스용
            $file = $request->file;

            $import = new VendorImport();
            $import->onlySheets(['매장 정보', '메뉴 정보', '메뉴 옵션']);

            if (Excel::import($import, $file)) {
                return response()->json(['msg' => 'ok'], 200);

            }

            return response()->json(['msg' => 'no content'], 202);

        } catch (\Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
        }

        return response($msg, $code);
    }

    public function show($id)
    {
        try {
            $vendor = User::selectVendor($id);
            if ($vendor) {
                return new VendorResource($vendor);
            }

            dd($vendor);
            return response()->json(['msg' => 'no content'], 202);

        } catch (\Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
        }

        return response($msg, $code);
    }

    public function update(Request $request, $id)
    {
        try {
            $vendor = User::updateVendor($id, $request);
            if ($vendor) {
                return new VendorResource($vendor);
            }

            return response()->json(['msg' => 'no content'], 202);

        } catch (\Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
        }

        return response()->json(['code' => $code, 'msg' => $msg], $code);
    }

    public function destroy($id)
    {
        try {
            $vendor = User::deleteVendor($id);
            if ($vendor) {
                return new VendorResource($vendor);
            }

            return response()->json(['msg' => 'no content'], 202);

        } catch (\Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
        }

        return response()->json(['code' => $code, 'msg' => $msg], $code);
    }

    public function recovery(Request $request)
    {
        try {
            $id     = $request->id;

            $vendor = User::recoveryVendor($id);
            if ($vendor) {
                return new VendorResource($vendor);
            }

            return response()->json(['msg' => 'no content'], 202);

        } catch (\Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
        }

        return response()->json(['code' => $code, 'msg' => $msg], $code);
    }

}