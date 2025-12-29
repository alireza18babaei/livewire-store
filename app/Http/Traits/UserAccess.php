<?php

namespace App\Http\Traits;

use function auth;

trait UserAccess
{
    public function adminPanelAccess(): bool
    {
        return auth()->user()->can('دسترسی به پنل ادمین');
    }

    public function userAccess(): bool
    {
        return auth()->user()->can('دسترسی به کاربران');
    }


}
