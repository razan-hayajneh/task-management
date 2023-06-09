<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\UpdateUserAPIRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\UpdateUserImageAPIRequest;
use App\Http\Resources\UserResource;
use App\Traits\UploadTrait;

/**
 * Class UserAPIController
 */
class ProfileAPIController extends AppBaseController
{
    use UploadTrait;

    /** @var  UserRepository */
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    /**
     * Display the specified User.
     * GET|HEAD /users/{id}
     */
    public function show(): JsonResponse
    {
        $id = auth()->user()->id;
        /** @var User $user */
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        return $this->sendResponse(new UserResource($user), 'User retrieved successfully');
    }

    /**
     * Update the specified User in storage.
     * PUT/PATCH /user
     */
    public function update(UpdateUserAPIRequest $request): JsonResponse
    {
        $input = $request->all();
        $id = auth()->user()->id;
        /** @var User $user */
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        $user = $this->userRepository->update($input, $id);

        return $this->sendResponse([], 'User updated successfully');
    }
    /**
     * Update the specified User in storage.
     * PUT/PATCH /user
     */
    public function updateImage(UpdateUserImageAPIRequest $request): JsonResponse
    {
        $input = $request->all();
        $id = auth()->user()->id;
        /** @var User $user */
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }
        if ($request->has('image_url')) {
            if (!empty($user['image_url'])) {
                $this->deleteFile($user['image_url'], 'profile');
            }
            $input['image_url'] = $this->uploadFile($request['image_url'], 'profile');
        }

        $user = $this->userRepository->update($input, $id);

        return $this->sendResponse([], 'User Image updated successfully');
    }
}
