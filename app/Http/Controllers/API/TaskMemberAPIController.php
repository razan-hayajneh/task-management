<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTaskMemberAPIRequest;
use App\Models\TaskMember;
use App\Repositories\TaskMemberRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\TaskMemberResource;
use Illuminate\Support\Facades\DB;

/**
 * Class TaskMemberAPIController
 */
class TaskMemberAPIController extends AppBaseController
{
    /** @var  TaskMemberRepository */
    private $taskMemberRepository;

    public function __construct(TaskMemberRepository $taskMemberRepo)
    {
        $this->taskMemberRepository = $taskMemberRepo;
    }

    /**
     * Display a listing of the TaskMembers.
     * GET|HEAD /task-members
     */
    public function index(Request $request): JsonResponse
    {
        $taskMembers = $this->taskMemberRepository->all(
            ['task_id' => $request['task_id']],
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(TaskMemberResource::collection($taskMembers), 'Task Members retrieved successfully');
    }
    /**
     * Store a newly created TaskMember in storage.
     * POST /task-members
     */
    public function store(CreateTaskMemberAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        DB::beginTransaction();
        try {
            $taskMember = $this->taskMemberRepository->create($input);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->sendError($exception->getMessage());
        }
        return $this->sendResponse([], 'Task Member saved successfully');
    }

    /**
     * Remove the specified TaskMember from storage.
     * DELETE /task-members/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var TaskMember $taskMember */
        $taskMember = $this->taskMemberRepository->find($id);

        if (empty($taskMember)) {
            return $this->sendError('Task Member not found');
        }

        $taskMember->delete();

        return $this->sendSuccess('Task Member deleted successfully');
    }
}
