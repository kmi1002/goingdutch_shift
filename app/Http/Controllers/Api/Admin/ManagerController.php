<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Resources\Admin\ManagerResource;

use App\Models\User;

class ManagerController extends BaseApiController
{
    public function index(Request $request)
    {
        try {
//            if (!\Auth::guard('admin')->check()) {
//                throw new \Exception('Unauthenticated', 401);
//            }

            $page       = $request->page;
            $per_page   = $request->per_page;
            $role       = $request->role;

            $managers = User::with('userLogs')
                ->withTrashed()
                ->where(function ($query) use ($request) {
                    $filter = $request->filter;

                    if (empty($role)) {
                        if (\Auth::guard('admin')->check()) {
                            $roles = ['administrator', 'manager', 'operator', 'analyst'];
                        } else {
                            $roles = ['vendor_administrator', 'vendor_manager', 'vendor_operator', 'vendor_analyst'];
                        }
                    } else {
                        $roles = [$role];
                    }

                    $query->role($roles);

                    if (!empty($filter->search_text)) {
                        $query->where('name', 'like', "%{$filter->search_text}%")
                            ->orWhere('email', 'like', "%{$filter->search_text}%");
                    }

                    if (!empty($filter->start_date)) {
                        $query->whereDate('created_at', '>=', $filter->start_date);
                    }

                    if (!empty($filter->end_date)) {
                        $query->whereDate('created_at', '<=', $filter->end_date);
                    }
                })
                ->orderBy('id', 'desc')
                ->paginate($per_page, ['*'], 'page', $page);

            return ManagerResource::collection($managers);

        } catch (\Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
        }

        return response($msg, $code);
    }

    public function store(Request $request)
    {
        try {
            $role   = $request->role;
            $email  = $request->email;
            $name   = $request->name;

            $pass   = 'iloveyou';

            $manager = User::createManager($role, $email, $name, $pass);
            if ($manager) {

                event(new \App\Events\User\RegisterUser($manager));
                return new ManagerResource($manager);
            }

            return response()->json(['msg' => 'no content'], 201);

        } catch (\Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
        }

        return response($msg, $code);
    }

    public function show($id)
    {
        try {
            $manager = User::selectManager($id);
            if ($manager) {
                return new ManagerResource($manager);
            }

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
            $role   = $request->role;
            $name   = $request->name;

            $manager = User::updateManager($id, $role, $name);
            if ($manager) {
                return new ManagerResource($manager);
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
            $manager = User::deleteManager($id);
            if ($manager) {
                return new ManagerResource($manager);
            }

            return response()->json(['msg' => 'no content'], 202);

        } catch (\Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
        }

        return response()->json(['code' => $code, 'msg' => $msg], $code);
    }

    public function emailCheck(Request $request, $email)
    {
        try {
            $manager = User::emailCheckManager($email);
            if ($manager) {
                return new ManagerResource($manager);
            }

            return response()->json(['msg' => 'no content'], 202);
        } catch (\Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
        }

        return response($msg, $code);
    }

    public function recovery(Request $request)
    {
        try {
            $id     = $request->id;
            $email  = $request->email;

            $manager = User::recoveryManager($id, $email);
            if ($manager) {
                return new ManagerResource($manager);
            }

            return response()->json(['msg' => 'no content'], 202);

        } catch (\Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
        }

        return response()->json(['code' => $code, 'msg' => $msg], $code);
    }
}