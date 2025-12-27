<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {

        $count = 2;

        $baseNames = [
            'علیرضا رضایی',
            'سارا احمدی',
            'محمد کاظمی',
            'مهدی موسوی',
            'زهرا کریمی',
            'کامران شریفی',
            'مهسا سلطانی',
            'علی حسینی',
            'ندا اکبری',
        ];

        for ($i = 1; $i <= $count; $i++) {
            foreach ($baseNames as $fullName) {
                $numberedName = $fullName . $i;

                $user = User::create([
                    'name' => $numberedName,
                    'email' => Str::slug($numberedName) . '@example.com',
                    'phone' => '09' . random_int(100000000, 999999999),
                    'password' => Hash::make('123123123'),
                    'is_admin' => false,
                ]);

                $user->assignRole('کاربر عادی');

            }
        }
    }
}
