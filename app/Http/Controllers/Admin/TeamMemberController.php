<?php

namespace App\Http\Controllers\Admin;

use App\Models\TeamMember;
use App\Repositories\TeamMemberRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Admin\{CreateTeamMemberRequest, UpdateTeamMemberRequest};
use App\Http\Resources\TeamMemberResource;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class TeamMemberController extends AppBaseController
{
    private UserRepository $userRepository;
    private TeamMemberRepository $teamMemberRepository;

    public function __construct(UserRepository $userRepository, TeamMemberRepository $teamMemberRepository)
    {
        $this->userRepository = $userRepository;
        $this->teamMemberRepository = $teamMemberRepository;
    }

    /**
     * Display a listing of the Team Members.
     * GET|HEAD /teamMembers
     */
    public function index(Request $request)
    {
        $teamMembers = $this->teamMemberRepository->paginate(10);
        return Inertia::render('Admin/TeamMember/Index')
            ->with([
                'teamMembers' => TeamMemberResource::collection($teamMembers),
                'message' => $request->session()->get('message'),
                'type' => $request->session()->get('type')
            ]);
    }

    /**
     * Display the specified TeamMember.
     * GET|HEAD /teamMembers/{id}/edit
     */
    public function edit($id)
    {
        $TeamMember = $this->teamMemberRepository->find($id);
        if (empty($TeamMember)) {
            return redirect(route('teamMembers.index'))->with(['message' => 'TeamMember not found', 'type' => 'error']);
        }
        return Inertia::render('Admin/TeamMember/Edit')->with(['teamMember' => new TeamMemberResource($TeamMember)]);
    }

    /**
     * Update the specified TeamMember in storage.
     * PUT/PATCH /teamMembers/{id}
     */
    public function update($id, UpdateTeamMemberRequest $request)
    {
        $input = $request->all();
        $teamMember = $this->teamMemberRepository->find($id);
        if (empty($teamMember)) {
            return redirect(route('teamMembers.index'))->with(['message' => 'TeamMember not found', 'type' => 'error']);
        }
        $request->get('password') ? $input['password'] = Hash::make($request->get('password')) : null;
        DB::beginTransaction();
        try {
            $teamMember = $this->teamMemberRepository->update($input, $id);
            $user = $this->userRepository->update($request->except(['user_type', 'image_url']), $teamMember?->user_id);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            return redirect(route('teamMembers.index'))->with(['message' => 'Failed Updating TeamMember', 'type' => 'error']);
        }
        return redirect(route('teamMembers.index'))->with(['message' => 'TeamMember Updated Successfully', 'type' => 'success']);
    }

    /**
     * Remove the specified TeamMember from storage.
     * DELETE /teamMembers/{id}
     */
    public function destroy($id)
    {
        $teamMember = $this->teamMemberRepository->find($id);

        if (empty($teamMember)) {
            return redirect(route('teamMembers.index'))->with(['message' => 'TeamMember not found', 'type' => 'error']);
        }
        DB::beginTransaction();
        try {
            $user = $this->teamMemberRepository->find($teamMember->user_id);
            $teamMember->delete();
            $user->delete();
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->sendError($exception->getMessage());
        }
        $message = 'TeamMember deleted successfully';
        return redirect(route('teamMembers.index'))->with(['message' => $message, 'type' => 'success']);
    }
}
