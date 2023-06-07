<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTaskCategoryAPIRequest;
use App\Models\TaskCategory;
use App\Repositories\TaskCategoryRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\TaskCategoryResource;

/**
 * Class TaskCategoryAPIController
 */
class TaskCategoryAPIController extends AppBaseController
{
    /** @var  TaskCategoryRepository */
    private $taskCategoryRepository;

    public function __construct(TaskCategoryRepository $taskCategoryRepo)
    {
        $this->taskCategoryRepository = $taskCategoryRepo;
    }

    /**
     * Display a listing of the TaskCategories.
     * GET|HEAD /task-categories
     */
    public function index(Request $request): JsonResponse
    {
        $taskCategories = $this->taskCategoryRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(TaskCategoryResource::collection($taskCategories), 'Task Categories retrieved successfully');
    }

    /**
     * Store a newly created TaskCategory in storage.
     * POST /task-categories
     */
    public function store(CreateTaskCategoryAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $taskCategory = $this->taskCategoryRepository->create($input);

        return $this->sendResponse(new TaskCategoryResource($taskCategory), 'Task Category saved successfully');
    }

    /**
     * Remove the specified TaskCategory from storage.
     * DELETE /task-categories/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var TaskCategory $taskCategory */
        $taskCategory = $this->taskCategoryRepository->find($id);

        if (empty($taskCategory)) {
            return $this->sendError('Task Category not found');
        }

        $taskCategory->delete();

        return $this->sendSuccess('Task Category deleted successfully');
    }
}
