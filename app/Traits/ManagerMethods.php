<?php
namespace App\Traits;

use App\Models\User;
use Spatie\Permission\Models\Role as SpatieRole;


trait ManagerMethods
{
    public function isAdmin()
    {
        return $this->hasRole('administrator|manager|operator|analyst');
    }

    public static function createManager($role, $email, $name, $pass)
    {
        try {
            $manager = self::create([
                'nick_name'         => $name,
                'email'             => $email,
                'password'          => bcrypt($pass),
                'activation_code'   => str_random(64),
                'gender'            => 1
            ]);

            // 권한 부여
            $manager->assignRole($role);

        } catch (\Exception $e) {

        }

        return null;
    }

    public static function selectManager($id)
    {
        try {
            $roles = ['manager', 'operator', 'analyst'];

            return User::role($roles)->where('id', $id)->firstOrFail();

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return null;
    }

    public static function updateManager($id, $role, $name)
    {
        try {
            $roles = ['manager', 'operator', 'analyst'];

            $manager = User::role($roles)->where('id', $id)->firstOrFail();

            // 코드 중복 체크
            if ($manager->name != $name) {
            }

            $manager->syncRoles($role);

            $manager->nick_name  = $name;
            $manager->save();

            return $manager;

        } catch (\Exception $e) {

        }

        return null;
    }

    public static function deleteManager($id)
    {
        try {
            $roles = ['manager', 'operator', 'analyst'];

            $manager = User::role($roles)->where('id', $id)->firstOrFail();

            if ($manager) {
                $manager->delete();
            }

            return $manager;

        } catch (\Exception $e) {

        }

        return null;
    }

    public static function emailCheckManager($email)
    {
        try {
            $manager = self::where('email', $email)->firstOrFail();

            return $manager;

        } catch (\Exception $e) {

        }

        return null;
    }

    public static function recoveryManager($id, $email)
    {
        try {
            $roles = ['manager', 'operator', 'analyst'];

            $manager = User::role($roles)
                ->onlyTrashed()
                ->where('id', $id)
                ->where('email', $email)
                ->firstOrFail();

            if ($manager) {
                $manager->restore();
            }

            return $manager;

        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return null;
    }


    public static function rolesCount($roles)
    {
        $ret = null;
        try {
            $ret = SpatieRole::whereIn('name', $roles)
                ->withCount('users')
                ->get()
                ->map(function ($item, $key) {
                    return [
//                        'id'    => $item->id,
                        'name'  => $item->name,
                        'count' => $item->users_count,
                    ];
                })
            ;
        } catch (\Exception $e) {
        }

        return $ret;
    }

}