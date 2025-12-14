<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(RolePermissionSeeder::class);

        $user = User::create([
            'name' => 'علیرضا',
            'email' => 'alireza@gmail.com',
            'phone' => '09370675182',
            'password' => Hash::make('123123123'),
        ]);
        $user->assignRole('صاحب فروشگاه');


        $this->call(CategorySeeder::class);
        $this->call(BrandSeeder::class);
        $this->call(ColorsSeeder::class);
        $this->call(GuarantySeeder::class);
        $this->call(ProductSeeder::class);

    }
}
