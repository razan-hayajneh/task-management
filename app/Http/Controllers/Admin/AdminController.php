<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Repositories\AdminRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Admin\CreateAdminRequest;
use App\Http\Requests\Admin\UpdateAdminRequest;
use App\Http\Resources\AdminResource;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

/**
 * Class AdminAPIController
 */
class AdminController extends AppBaseController
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
    public function index(Request $request)
    {
        $admins = $this->adminRepository->paginate(10);
        return Inertia::render('Admin/Admin/Index')
            ->with([
                'admins' => AdminResource::collection($admins),
                'message' => $request->session()->get('message'),
                'type' => $request->session()->get('type')
            ]);
    }

    /**
     * Display  Create Admin Form.
     * GET|HEAD /admins
     */
    public function create()
    {
        return Inertia::render('Admin/Admin/Create');
    }

    /**
     * Store a newly created Admin in storage.
     * POST /admins
     */
    public function store(CreateAdminRequest $request)
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
            return redirect(route('admins.index'))->with(['message' => 'Failed Saving Admin', 'type' => 'error']);
        }
        return redirect(route('admins.index'))->with(['message' => 'Admin Saved Successfully', 'type' => 'success']);
    }
    /**
     * Display the specified Admin.
     * GET|HEAD /admins/{id}
     */
    public function show($id)
    {
        $admin = $this->adminRepository->find($id);
        if (empty($admin)) {
            return redirect(route('admins.index'))->with(['message' => 'Admin not found', 'type' => 'error']);
        }
        return Inertia::render('Admin/Admin/Show')->with(['admin' => new AdminResource($admin)]);
    }
    /**
     * Display the specified Admin.
     * GET|HEAD /admins/{id}/edit
     */
    public function edit($id)
    {
        $admin = $this->adminRepository->find($id);
        if (empty($admin)) {
            return redirect(route('admins.index'))->with(['message' => 'Admin not found', 'type' => 'error']);
        }
        return Inertia::render('Admin/Admin/Edit')->with(['admin' => new AdminResource($admin)]);
    }

    /**
     * Update the specified Admin in storage.
     * PUT/PATCH /admins/{id}
     */
    public function update($id, UpdateAdminRequest $request)
    {
        $input = $request->all();
        /** @var Admin $admin */
        $admin = $this->adminRepository->find($id);
        if (empty($admin)) {
            return redirect(route('admins.index'))->with(['message' => 'Admin not found', 'type' => 'error']);
        }
        $request->get('password') ? $input['password'] = Hash::make($request->get('password')) : null;
        DB::beginTransaction();
        try {
            $admin = $this->adminRepository->update($input, $id);
            $user = $this->userRepository->update($request->except(['user_type', 'image_url']), $admin?->user_id);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            return redirect(route('admins.index'))->with(['message' => 'Failed Updating Admin', 'type' => 'error']);
        }
        return redirect(route('admins.index'))->with(['message' => 'Admin Updated Successfully', 'type' => 'success']);
    }

    /**
     * Remove the specified Admin from storage.
     * DELETE /admins/{id}
     */
    public function destroy($id)
    {
        $admin = $this->adminRepository->find($id);

        if (empty($admin)) {
            return redirect(route('admins.index'))->with(['message' => 'Admin not found', 'type' => 'error']);
        }
        DB::beginTransaction();
        try {
            $user = $this->adminRepository->find($admin->user_id);
            $admin->delete();
            $user->delete();
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->sendError($exception->getMessage());
        }
        $message = 'Admin deleted successfully';
        return redirect(route('admins.index'))->with(['message' => $message, 'type' => 'success']);
    }
}
