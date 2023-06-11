<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTaskAPIRequest;
use App\Http\Requests\API\UpdateTaskAPIRequest;
use App\Models\Task;
use App\Repositories\TaskRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\TaskResource;
use App\Models\TeamMember;
use App\Repositories\TaskMemberRepository;
use App\Repositories\TimelineRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TaskAPIController extends AppBaseController
{
    private TaskRepository $taskRepository;
    private TaskMemberRepository $taskMemberRepository;
    private TimelineRepository $timelineRepository;

    public function __construct(TaskRepository $taskRepository, TaskMemberRepository $taskMemberRepository, TimelineRepository $timelineRepository)
    {
        $this->taskMemberRepository = $taskMemberRepository;
        $this->taskRepository = $taskRepository;
        $this->timelineRepository = $timelineRepository;
    }

    /**
     * Display a listing of the Tasks.
     * GET|HEAD /tasks
     */
    public function index(Request $request): JsonResponse
    {
        if (!$this->taskRepository->isAuthorProjectManager($request['project_id']) && !$this->taskRepository->hasAccessPermissionOnTask($request['project_id'], auth()->user()->id)) {
            return $this->sendError('You do not have permission to get tasks in this project');
        }
        $tasks = $this->taskRepository->all($request->only(['project_id', 'start_date']));
        return $this->sendResponse(TaskResource::collection($tasks), 'Tasks retrieved successfully');
    }

    /**
     * Store a newly created Task in storage.
     * POST /tasks
     */
    public function store(CreateTaskAPIRequest $request): JsonResponse
    {
        if (!$this->taskRepository->isAuthorProjectManager($request['project_id']) && !$this->taskRepository->hasCreateNewTaskPermission($request['project_id'], auth()->user()->id)) {
            return $this->sendError('You are not manager for this project');
        }
        $input = $request->all();

        DB::beginTransaction();
        try {
            $task = $this->taskRepository->create($input);
            $this->storeTaskMember($task->id);
            $this->storeTimeline($task->id, $input['task_status']);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->sendError($exception->getMessage());
        }
        return $this->sendResponse([], 'Task saved successfully');
    }
    public function storeTaskMember($taskId): bool
    {
        DB::beginTransaction();
        try {
            $teamMember = TeamMember::whereUserId(auth()->user()->id)->first();
            if (empty($teamMember)) {
                return false;
            }
            $taskMember = $this->taskMemberRepository->create(['task_id' => $taskId, 'team_member_id' => $teamMember->id]);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            return false;
        }
        return  $taskMember;
    }
    /**
     * Display the specified Task.
     * GET|HEAD /tasks/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Task $task */
        $task = $this->taskRepository->find($id);

        if (empty($task)) {
            return $this->sendError('Task not found');
        }

        return $this->sendResponse(new TaskResource($task), 'Task retrieved successfully');
    }

    /**
     * Update the specified Task in storage.
     * PUT/PATCH /task-status/{id}
     */
    public function updateStatus($id, Request $request): JsonResponse
    {
        $input = $request->all();
        $task = $this->taskRepository->find($id);
        if (!$this->taskRepository->isAuthorProjectManager($request['project_id']) && !$this->taskRepository->hasUpdateStatusPermissionOnTask($id, auth()->user()->id)) {
            return $this->sendError('You do not have permission to Create new task');
        }

        if (empty($task)) {
            return $this->sendError('Task not found');
        }
        unset($input['project_id']);
        DB::beginTransaction();
        try {
            $task = $this->taskRepository->update($request->only(['task_status']), $id);
            $this->storeTimeline($id, $input['task_status']);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->sendError($exception->getMessage());
        }
        return $this->sendResponse([], 'Task Status Updated successfully');
    }
    /**
     * Update the specified Task in storage.
     * PUT/PATCH /tasks/{id}
     */
    public function update($id, UpdateTaskAPIRequest $request): JsonResponse
    {
        $input = $request->all();
        $task = $this->taskRepository->find($id);
        if (!$this->taskRepository->isAuthorProjectManager($request['project_id']) && !$this->taskRepository->hasUpdatePermissionOnTask($id, auth()->user()->id)) {
            return $this->sendError('You do not have permission to Create new task');
        }

        if (empty($task)) {
            return $this->sendError('Task not found');
        }
        unset($input['project_id']);
        DB::beginTransaction();
        try {
            $task = $this->taskRepository->update($input, $id);
            $this->storeTimeline($id, $input['task_status']);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->sendError($exception->getMessage());
        }
        return $this->sendResponse([], 'Task updated successfully');
    }
    function storeTimeline($taskId, $status): bool
    {
        if (!empty($status)) {
            $input = [
                'task_id' => $taskId,
                'status' => $status,
                'updated_by' => auth()->user()->id,
                'date' => Carbon::now()
            ];
            $timeline = $this->timelineRepository->create($input);
            return !empty($timeline);
        }
        return true;
    }
    public function destroy($id): JsonResponse
    {
        /** @var Task $task */
        $task = $this->taskRepository->find($id);

        if (empty($task)) {
            return $this->sendError('Task not found');
        }
        if (!$this->taskRepository->isAuthorProjectManager($id) && !$this->taskRepository->hasDeletePermissionOnTask($id, auth()->user()->id)) {
            return $this->sendError('You do not have permission to delete this task');
        }
        $task->delete();

        return $this->sendSuccess('Task deleted successfully');
    }
}
