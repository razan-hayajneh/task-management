<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAdminAPIRequest;
use App\Http\Requests\API\UpdateAdminAPIRequest;
use App\Models\Admin;
use App\Repositories\AdminRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\AdminResource;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Class AdminAPIController
 */
class AdminAPIController extends AppBaseController
{
    /** @var  AdminRepository */
    private UserRepository $userRepository;
    private AdminRepository $adminRepository;

    public function __construct(UserRepository $userRepo, AdminRepository $adminRepo)
    {
        $this->userRepository = $userRepo;
        $this->adminRepository = $adminRepo;
    }

    /**
     * Display a listing of the Admins.
     * GET|HEAD /admins
     */
    public function index(Request $request): JsonResponse
    {
        $admins = $this->adminRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(AdminResource::collection($admins), 'Admins retrieved successfully');
    }

    /**
     * Store a newly created Admin in storage.
     * POST /admins
     */
    public function store(CreateAdminAPIRequest $request): JsonResponse
    {
        $input = $request->all();
        $input['password'] = Hash::make($request->get('password'));
        DB::beginTransaction();
        try {
        $input['user_type'] = 'admin';
            $user = $this->userRepository->create($input);
            $input['user_id'] = $user->id;

            $admin = $this->adminRepository->create($input);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->sendError($exception->getMessage());
        }
        return $this->sendResponse(new AdminResource($admin), 'Admin saved successfully');
    }

    /**
     * Display the specified Admin.
     * GET|HEAD /admins/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Admin $admin */

        $admin = $this->adminRepository->find($id);
        if (empty($admin)) {
            return $this->sendError('Admin not found');
        }

        return $this->sendResponse(new AdminResource($admin), 'Admin retrieved successfully');
    }

    /**
     * Update the specified Admin in storage.
     * PUT/PATCH /admins/{id}
     */
    public function update($id, UpdateAdminAPIRequest $request): JsonResponse
    {
        $input = $request->all();
        /** @var Admin $admin */
        $admin = $this->adminRepository->find($id);
        if (empty($admin)) {
            return $this->sendError('Admin not found');
        }
        $request->get('password') ? $input['password'] = Hash::make($request->get('password')) : null;
        DB::beginTransaction();
        try {
            $admin = $this->adminRepository->update($input, $id);
            $user = $this->userRepository->update($request->except(['user_type', 'image_url']), $admin?->user_id);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->sendError($exception->getMessage());
        }
        return $this->sendResponse(new AdminResource($admin), 'Admin updated successfully');
    }

    /**
     * Remove the specified Admin from storage.
     * DELETE /admins/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Admin $admin */
        $admin = $this->adminRepository->find($id);

        if (empty($admin)) {
            return $this->sendError('Admin not found');
        }
        DB::beginTransaction();
        try {
            $user = $this->adminRepository->find($admin->user_id);
            $user->delete();
            $admin->delete();
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->sendError($exception->getMessage());
        }
        return $this->sendSuccess('Admin deleted successfully');
    }
}
