<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\{LoginAPIRequest, RegisterAPIRequest};
use App\Http\Resources\UserResource;
use App\Repositories\{TeamMemberRepository, UserRepository};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Hash};
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthAPIController extends AppBaseController
{

    public bool $token = true;
    private TeamMemberRepository $teamMemberRepository;
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepo, TeamMemberRepository $teamMemberRepo)
    {
        $this->userRepository = $userRepo;
        $this->teamMemberRepository = $teamMemberRepo;
    }

    public function register(RegisterAPIRequest $request)
    {
        $input = $request->all();
        $input['password'] = Hash::make($request->get('password'));
        DB::beginTransaction();
        try {
            $user = $this->userRepository->create($input);
            $input['user_id'] = $user->id;
            $teamMember = $this->teamMemberRepository->create($input);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->sendError($exception->getMessage());
        }
        return $this->sendResponse([], 'You have signed up successfully');
    }

    public function login(LoginAPIRequest $request)
    {
        $userToken = null;
        $credentials = $request->only(['email', 'password']);
        if (!$userToken = auth()->attempt($credentials)) {
            return $this->sendError('Invalid Email or Password');
        }
        return $this->sendResponse([
            'token' => $userToken,
            'user_type' => auth()->user()->user_type
        ], 'You have logged in successfully');
    }

    public function logout(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);
        try {
            auth()->logout();
            return $this->sendResponse([], 'You logged out successfully');
        } catch (JWTException $exception) {


            return $this->sendError('Sorry, the user cannot be logged out');
        }
    }

    public function getUser(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);
        $user = auth()->user();
        return $this->sendResponse(['user' => UserResource::make($user)], 'You logged out successfully');
    }
}
