<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Vendor;
use App\Helpers\TimeHelper;

class UsersSeeder extends Seeder
{
    public function run()
    {
        // 최고 관리자
        $this->admin();

        if (env('APP_ENV') == 'local') {
            // 관리자
            $this->user(10, ['manager',  'operator', 'analyst']);

            // 점주
            $this->vendor(10, ['vendor_administrator', 'vendor_manager',  'vendor_operator', 'vendor_analyst']);

            // 사용자
            $this->user(30, ['user']);
        }
    }

    public function admin()
    {
        $user = User::create([
            'nick_name'         => 'admin',
            'email'             => 'admin@admin.com',
            'password'          => bcrypt('Admin123$'),
            'activated_at'      => TimeHelper::nowToString(),
            'gender'            => 1
        ]);

        // 권한 부여
        $user->assignRole('administrator');
    }

    public function user($count, $roles)
    {
        $faker = \Faker\Factory::create();

        $users = factory(\App\Models\User::class, $count)->create();
        foreach ($users as $user) {
            // 권한 부여
            $role = $faker->randomElement($roles);
            $user->assignRole($role);
        }
    }

    public function vendor($count, $roles)
    {
        $faker = \Faker\Factory::create();

        for ($i = 1; $i < $count; ++$i) {

            $user = User::create([
                'nick_name'         => $faker->name,
                'email'             => 'vendor00' . $i,
                'password'          => bcrypt('vendor00' . $i),
                'activated_at'      => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
                'gender'            => 1
            ]);

            // 권한 부여
            $role = $faker->randomElement($roles);
            $user->assignRole($role);

            Vendor::create([
                'email'         => $faker->unique()->safeEmail,
                'company'       => $faker->name,
                'introduce'     => $faker->text(100),
                'dpt_code'      => $i,
                'address'       => $faker->company,
                'home_url'      => $faker->url,
                'naver_url'     => $faker->url,
                'facebook_url'  => $faker->url,
                'kakaoplus_url' => $faker->url,
                'crn'           => $faker->randomNumber(),
                'user_id'       => $user->id
            ]);
        }
    }
}