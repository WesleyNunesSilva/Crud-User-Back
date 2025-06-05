<?php

namespace App\Services;

use App\Models\Permission;

class PermissionService
{
    public function getGroupedPermissions()
    {
        return Permission::with('children')
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();
    }
}
