<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePermissionAPIRequest;
use App\Models\Permission;
use App\Repositories\PermissionRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\AllPermissionResource;
use App\Http\Resources\PermissionResource;
use Illuminate\Support\Facades\DB;

/**
 * Class PermissionAPIController
 */
class PermissionAPIController extends AppBaseController
{
    /** @var  PermissionRepository */
    private $permissionRepository;

    public function __construct(PermissionRepository $permissionRepo)
    {
        $this->permissionRepository = $permissionRepo;
    }

    /**
     * Display a listing of the Permissions.
     * GET|HEAD /permissions
     */
    public function index(Request $request): JsonResponse
    {
        $permissions = $this->permissionRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(PermissionResource::collection($permissions), 'Permissions retrieved successfully');
    }
    /**
     * Display  all Permissions.
     * GET|HEAD /all-permissions
     */
    public function getAll(): JsonResponse
    {
        $permissions = $this->permissionRepository->all();

        return $this->sendResponse(AllPermissionResource::collection($permissions), 'All Permissions retrieved successfully');
    }
    /**
     * Store a newly created Permission in storage.
     * POST /permissions
     */
    public function store(CreatePermissionAPIRequest $request): JsonResponse
    {
        $input = $request->all();
        DB::beginTransaction();
        try {
            $permission = $this->permissionRepository->create($input);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->sendError($exception->getMessage());
        }
        return $this->sendResponse(new PermissionResource($permission), 'Permission saved successfully');
    }

    /**
     * Remove the specified Permission from storage.
     * DELETE /permissions/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Permission $permission */
        $permission = $this->permissionRepository->find($id);

        if (empty($permission)) {
            return $this->sendError('Permission not found');
        }

        $permission->delete();

        return $this->sendSuccess('Permission deleted successfully');
    }
}
