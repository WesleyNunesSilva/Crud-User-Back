<?php

namespace App\Http\Controllers;

use App\Services\PermissionService;
use Illuminate\Http\JsonResponse;

class PermissionController extends Controller
{

    public function __construct(
        protected PermissionService $permissionService
    ) {}

    public function index(): JsonResponse
    {
        try {
            $permissions = $this->permissionService->getGroupedPermissions();

            return response()->json([
                'success' => true,
                'data' => $permissions,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar permissões',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
