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
use App\Repositories\ProjectRepository;
use App\Repositories\TimelineRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Class TaskAPIController
 */
class TaskAPIController extends AppBaseController
{
    private TaskRepository $taskRepository;
    private ProjectRepository $projectRepository;
    private TimelineRepository $timelineRepository;

    public function __construct(TaskRepository $taskRepository, ProjectRepository $projectRepository, TimelineRepository $timelineRepository)
    {
        $this->taskRepository = $taskRepository;
        $this->projectRepository = $projectRepository;
        $this->timelineRepository = $timelineRepository;
    }

    /**
     * Display a listing of the Tasks.
     * GET|HEAD /tasks
     */
    public function index(Request $request): JsonResponse
    {
        if (!$this->isAuthorProjectManager($request['project_id']) && !$this->taskRepository->hasAccessPermissionOnTask($request['project_id'], auth()->user()->id)) {
            return $this->sendError('You do not permission to update this task');
        }
        $tasks = $this->taskRepository->all($request->only(['project_id','start_date']));

        return $this->sendResponse(TaskResource::collection($tasks), 'Tasks retrieved successfully');
    }

    /**
     * Store a newly created Task in storage.
     * POST /tasks
     */
    public function store(CreateTaskAPIRequest $request): JsonResponse
    {
        if (!$this->isAuthorProjectManager($request['project_id'])) {
            return $this->sendError('You are not manager for this project');
        }
        $input = $request->all();

        DB::beginTransaction();
        try {
            $task = $this->taskRepository->create($input);
            $this->storeTimeline($task->id,$input['task_status']);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->sendError($exception->getMessage());
        }
        return $this->sendResponse([], 'Task saved successfully');
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
     * PUT/PATCH /tasks/{id}
     */
    public function update($id, UpdateTaskAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Task $task */
        $task = $this->taskRepository->find($id);
        if (!$this->isAuthorProjectManager($task['project_id']) && !$this->taskRepository->hasUpdatePermissionOnTask($id, auth()->user()->id)) {
            return $this->sendError('You do not permission to update this task');
        }

        if (empty($task)) {
            return $this->sendError('Task not found');
        }
        DB::beginTransaction();
        try {
            $task = $this->taskRepository->update($input, $id);
            $this->storeTimeline($id,$input['task_status']);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->sendError($exception->getMessage());
        }

        return $this->sendResponse([], 'Task updated successfully');
    }
    function storeTimeline($taskId, $status): bool
    {
        $input = [
            'task_id' => $taskId,
            'status' => $status,
            'updated_by' => auth()->user()->id,
            'date' => Carbon::now()
        ];
        $timeline = $this->timelineRepository->create($input);
        return !empty($timeline);
    }
    public function destroy($id): JsonResponse
    {
        /** @var Task $task */
        $task = $this->taskRepository->find($id);

        if (empty($task)) {
            return $this->sendError('Task not found');
        }
        if (!$this->isAuthorProjectManager($task['project_id']) && !$this->taskRepository->hasDeletePermissionOnTask($id, auth()->user()->id)) {
            return $this->sendError('You do not permission to delete this task');
        }
        $task->delete();

        return $this->sendSuccess('Task deleted successfully');
    }
    public function isAuthorProjectManager($projectId): bool
    {
        if ($projectId == null) return false;
        $project = $this->projectRepository->find($projectId);
        return $project['manager_id'] == auth()->user()->id;
    }
}
