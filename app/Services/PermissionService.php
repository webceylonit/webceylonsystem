<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PermissionService
{
    public static function has($permissionName)
    {
        $user = Auth::user();
        if (!$user) return false;

        return DB::table('role_has_permissions')
            ->join('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->where('role_has_permissions.role_id', $user->role_id)
            ->where('permissions.name', $permissionName)
            ->exists();
    }
}
