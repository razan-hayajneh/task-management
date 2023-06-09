<?php

namespace App\Http\Controllers\API;

use App\Repositories\TaskCategoryRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\TaskCategoryResource;

class TaskCategoryAPIController extends AppBaseController
{
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
        $taskCategories = $this->taskCategoryRepository->all();
        return $this->sendResponse(TaskCategoryResource::collection($taskCategories), 'Task Categories retrieved successfully');
    }

}
