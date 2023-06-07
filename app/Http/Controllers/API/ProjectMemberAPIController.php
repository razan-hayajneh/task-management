<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateProjectMemberAPIRequest;
use App\Models\ProjectMember;
use App\Repositories\ProjectMemberRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\ProjectMemberResource;
use App\Http\Resources\ProjectMembersResource;
use Illuminate\Support\Facades\DB;

/**
 * Class ProjectMemberAPIController
 */
class ProjectMemberAPIController extends AppBaseController
{
    /** @var  ProjectMemberRepository */
    private ProjectMemberRepository $projectMemberRepository;

    public function __construct(ProjectMemberRepository $projectMemberRepo)
    {
        $this->projectMemberRepository = $projectMemberRepo;
    }

    /**
     * Display a listing of the ProjectMembers.
     * GET|HEAD /project-members
     */
    public function index(Request $request): JsonResponse
    {
        $projectMembers = $this->projectMemberRepository->all(
            ['project_id' => $request['id']],
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(ProjectMemberResource::collection($projectMembers), 'Project Members retrieved successfully');
    }

    /**
     * Display a listing of the TaskMembers.
     * GET|HEAD /task-members
     */
    public function getProjectTeamMembers(Request $request): JsonResponse
    {
        $teamMembers = $this->projectMemberRepository->all(['project_id'=>$request['id']]);

        return $this->sendResponse(ProjectMembersResource::collection($teamMembers), 'Task Members retrieved successfully');
    }
    /**
     * Store a newly created ProjectMember in storage.
     * POST /project-members
     */
    public function store(CreateProjectMemberAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        DB::beginTransaction();
        try {
            $projectMember = $this->projectMemberRepository->create($input);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->sendError($exception->getMessage());
        }


        return $this->sendResponse([], 'Project Member saved successfully');
    }


    /**
     * Remove the specified ProjectMember from storage.
     * DELETE /project-members/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var ProjectMember $projectMember */
        $projectMember = $this->projectMemberRepository->find($id);

        if (empty($projectMember)) {
            return $this->sendError('Project Member not found');
        }

        $projectMember->delete();

        return $this->sendSuccess('Project Member deleted successfully');
    }
}
