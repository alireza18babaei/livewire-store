<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Clear the permission cache (very important)
        app()[PermissionRegistrar::class]->forgetCachedPermissions();


        $permissions = [
            'دسترسی به پنل ادمین',

            'دسترسی به کاربران',
            'ایجاد کاربر',
            'ویرایش کاربران',
            'ویرایش نقش کاربران ادمین',
            'دسترسی به تمام نقش کاربران',

            'ایجاد',
            'ویرایش',
            'حذف',

            'دسترسی به دسته‌بندی‌ها',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // define permissions
        $member = Role::firstOrCreate(['name' => 'کاربر عادی']);
        $owner = Role::firstOrCreate(['name' => 'مالک']);
        $manager = Role::firstOrCreate(['name' => 'مدیر']);
        $admin = Role::firstOrCreate(['name' => 'ادمین']);



        // bind permissions to roles
        $owner->givePermissionTO(Permission::query()->pluck('name'));
        $manager->givePermissionTo(
            Permission::whereNotIn('name', ['دسترسی به تمام نقش کاربران'])->pluck('name')
        );
        $admin->givePermissionTo([
            'دسترسی به پنل ادمین',
            'ایجاد',
            'ویرایش',
            'حذف',
        ]);

    }
}
