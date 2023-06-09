<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTeamMemberAPIRequest;
use App\Http\Requests\API\UpdateTeamMemberAPIRequest;
use App\Models\TeamMember;
use App\Repositories\TeamMemberRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\TeamMemberAPIResource;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Class TeamMemberAPIController
 */
class TeamMemberAPIController extends AppBaseController
{
    /** @var  TeamMemberRepository */
    private TeamMemberRepository $teamMemberRepository;
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepo, TeamMemberRepository $teamMemberRepo)
    {
        $this->userRepository = $userRepo;
        $this->teamMemberRepository = $teamMemberRepo;
    }

    /**
     * Display a listing of the TeamMembers.
     * GET|HEAD /team-members
     */
    public function index(Request $request): JsonResponse
    {
        $teamMembers = $this->teamMemberRepository->all();

        return $this->sendResponse(TeamMemberAPIResource::collection($teamMembers), 'Team Members retrieved successfully');
    }


    /**
     * Store a newly created TeamMember in storage.
     * POST /team-members
     */
    public function store(CreateTeamMemberAPIRequest $request): JsonResponse
    {
        $input = $request->all();
        $input['password'] = Hash::make($request->get('password'));
        DB::beginTransaction();
        try {
            $input['user_type'] = 'team_member';
            $user = $this->userRepository->create($input);
            $input['user_id'] = $user->id;
            $teamMember = $this->teamMemberRepository->create($input);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->sendError($exception->getMessage());
        }
        return $this->sendResponse(new TeamMemberAPIResource($teamMember), 'Team Member saved successfully');
    }

    /**
     * Display the specified TeamMember.
     * GET|HEAD /team-members/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var TeamMember $teamMember */
        $teamMember = $this->teamMemberRepository->find($id);

        if (empty($teamMember)) {
            return $this->sendError('Team Member not found');
        }

        return $this->sendResponse(new TeamMemberAPIResource($teamMember), 'Team Member retrieved successfully');
    }

    /**
     * Update the specified TeamMember in storage.
     * PUT/PATCH /team-members/{id}
     */
    public function update($id, UpdateTeamMemberAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var TeamMember $teamMember */
        $teamMember = $this->teamMemberRepository->find($id);

        if (empty($teamMember)) {
            return $this->sendError('Team Member not found');
        }
        $request->get('password') ? $input['password'] = Hash::make($request->get('password')) : null;
        DB::beginTransaction();
        try {
            $teamMember = $this->teamMemberRepository->update($input, $id);
            $user = $this->userRepository->update($request->except(['user_type', 'image_url']), $teamMember?->user_id);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->sendError($exception->getMessage());
        }

        return $this->sendResponse(new TeamMemberAPIResource($teamMember), 'TeamMember updated successfully');
    }

    /**
     * Remove the specified TeamMember from storage.
     * DELETE /team-members/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var TeamMember $teamMember */
        $teamMember = $this->teamMemberRepository->find($id);

        if (empty($teamMember)) {
            return $this->sendError('Team Member not found');
        }
        DB::beginTransaction();
        try {
            $user = $this->teamMemberRepository->find($teamMember->user_id);
            $user->delete();
            $teamMember->delete();
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->sendError($exception->getMessage());
        }

        return $this->sendSuccess('Team Member deleted successfully');
    }
}
