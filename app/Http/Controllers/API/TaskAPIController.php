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
use Illuminate\Support\Facades\DB;

/**
 * Class TaskAPIController
 */
class TaskAPIController extends AppBaseController
{
    /** @var  TaskRepository */
    private $taskRepository;
    private $projectRepository;

    public function __construct(TaskRepository $taskRepository, ProjectRepository $projectRepository)
    {
        $this->taskRepository = $taskRepository;
        $this->projectRepository = $projectRepository;
    }

    /**
     * Display a listing of the Tasks.
     * GET|HEAD /tasks
     */
    public function index(Request $request): JsonResponse
    {
        if (!$this->isAuthorProjectManager($request['project_id'])) {
            return $this->sendError('You are not manager for this project');
        }
        $tasks = $this->taskRepository->all(
            ['project_id' => $request['project_id']],
            $request->get('skip'),
            $request->get('limit')
        );

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
        if (!$this->isAuthorProjectManager($task['project_id']) && !$this->taskRepository->hasUpdatePermissionOnTask($id,auth()->user()->id)) {
            return $this->sendError('You do not permission to update this task');
        }

        if (empty($task)) {
            return $this->sendError('Task not found');
        }
        DB::beginTransaction();
        try {
            $task = $this->taskRepository->update($input, $id);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->sendError($exception->getMessage());
        }

        return $this->sendResponse([], 'Task updated successfully');
    }

    /**
     * Remove the specified Task from storage.
     * DELETE /tasks/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Task $task */
        $task = $this->taskRepository->find($id);

        if (empty($task)) {
            return $this->sendError('Task not found');
        }
        if (!$this->isAuthorProjectManager($task['project_id']) && !$this->taskRepository->hasDeletePermissionOnTask($id,auth()->user()->id)) {
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
