<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Helpers\DebugHelpers;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Controllers\Api\Vendor\BaseApiController;
use Illuminate\Http\Request;
use App\Http\Resources\Admin\UserResource;

use App\Models\User;

class UserController extends BaseApiController
{
    public function index(Request $request)
    {
        try {
//            if (!\Auth::guard('admin')->check()) {
//                throw new \Exception('Unauthenticated', 401);
//            }

            $page           = $request->page;
            $per_page       = $request->per_page;

            $users = User::role('user')
                ->with('userLogs')
                ->where(function ($query) use ($request) {

                    $filter = $request->filter;

                    $type = $request->type;

                    if ($type == 'withdrawal') {
                        $query->onlyTrashed();
                    }

                    if (!empty($request->search)) {
                        $query->where('name', 'like', "%{$filter->search_text}%")
                            ->orWhere('email', 'like', "%{$filter->search_text}%");
                    }

                    if (!empty($request->gender)) {
                        $query->where('gender', '=', $request->gender == 'male' ? 0 : 1);
                    }

                    if (!empty($filter->start_date)) {
                        $query->whereDate('created_at', '>=', $request->start_date);
                    }

                    if (!empty($request->end_date)) {
                        $query->whereDate('created_at', '<=', $request->end_date);
                    }
                })->paginate($per_page, ['*'], 'page', $page);

            return UserResource::collection($users);

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