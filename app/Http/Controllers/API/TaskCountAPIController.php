<?php

namespace App\Http\Controllers\API;

use App\Enums\TaskStatus;
use App\Repositories\TaskRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

class TaskCountAPIController extends AppBaseController
{
    private TaskRepository $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * retrieve a number of the Tasks in special project.
     * GET|HEAD /getCountOfTaskInProject
     */
    public function getCountOfTaskInProject(Request $request): JsonResponse
    {
        $numberOfTasks = $this->taskRepository->all($request->only(['project_id']))->count();

        return $this->sendResponse(['number_of_tasks'=>$numberOfTasks], 'Tasks retrieved successfully');
    }

    /**
     * retrieve a number of the finished Tasks in special project.
     * GET|HEAD /getCountOfFinishedTaskInProject
     */
    public function getCountOfFinishedTaskInProject(Request $request): JsonResponse
    {
        $numberOfFinishedTasks = $this->taskRepository->all(['project_id'=>$request['project_id'],'task_status'=> TaskStatus::FINISHED])->count();

        return $this->sendResponse(['number_of_finished_tasks'=>$numberOfFinishedTasks], 'number of the finished Tasks retrieved successfully');
    }
}
