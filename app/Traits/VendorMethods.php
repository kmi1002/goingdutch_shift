<?php
namespace App\Traits;

use App\Helpers\TimeHelper;
use App\Models\User;
use App\Models\Vendor;

trait VendorMethods
{
    public function isVendor()
    {
        return $this->hasRole('vendor_administrator|vendor_manager|vendor_operator|vendor_analyst');
    }

    public static function createVendor($row)
    {
        try {
            // 점주는 이메일로 가입한것이 아니라 발급하는 것이다.
            $user = User::create([
                'nick_name'      => $row['name'],
                'email'          => $row['code'],
                'password'       => bcrypt($row['password']),
                'activated_at'   => TimeHelper::nowToString()
            ]);

            // 유저 권한
            $user->assignRole('vendor_administrator');

            $vender = Vendor::create([
                'email'             => $row['email'],
                'company'           => $row['company'],
                'crn'               => $row['crn'],
                'introduce'         => $row['introduce'],
                'dpt_code'          => $row['dpt_code'],
                'address'           => $row['address'],
                'home_url'          => $row['home_url'],
                'naver_url'         => $row['naver_url'],
                'facebook_url'      => $row['facebook_url'],
                'kakaoplus_url'        => $row['kakaoplus_url'],
                'youtube_url'       => $row['youtube_url'],
                'instagram_url'     => $row['instagram_url'],
                'user_id'           => $user->id
            ]);

            return $vender;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return null;
    }

    public static function selectVendor($id)
    {
        try {
            $roles = ['vendor_administrator', 'vendor_manager', 'vendor_operator', 'vendor_analyst'];

            $vendor = Vendor::with('user', 'user.userLogs')
                ->whereHas('user', function ($query) use ($roles) {
                    $query->role($roles);
                    $query->withTrashed();
                })
                ->where('id', $id)
                ->first();

            return $vendor;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return null;
    }

    public static function updateVendor($id, $request)
    {
        try {
            $vendor = User::selectVendor($id);

            $vendor->user->nick_name    = $request->name;
//            $vendor->email              = $request->email; // 회원 아이디여서 삭제할 수 없음
            $vendor->company            = $request->company;
            $vendor->crn                = $request->crn;
            $vendor->introduce          = $request->introduce;
            $vendor->address            = $request->address;
            $vendor->home_url           = $request->home_url;
            $vendor->youtube_url        = $request->youtube_url;
            $vendor->facebook_url       = $request->facebook_url;
            $vendor->instagram_url      = $request->instagram_url;
            $vendor->kakaoplus_url      = $request->kakaoplus_url;
            $vendor->naver_url          = $request->naver_url;
            $vendor->save();

            return $vendor;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return null;
    }

    public static function deleteVendor($id)
    {
        try {
            $vendor = User::selectVendor($id);
            if ($vendor) {
                $vendor->user()->delete();
            }

            return $vendor;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return null;
    }

    public static function recoveryVendor($id)
    {
        try {
            $vendor = User::selectVendor($id);
            if ($vendor) {
                $vendor->user()->restore();
            }

            return $vendor;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return null;
    }
}