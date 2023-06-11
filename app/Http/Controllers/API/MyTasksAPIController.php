<?php

namespace App\Http\Controllers\API;

use App\Repositories\TaskRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\TaskResource;

/**
 * Class TaskAPIController
 */
class MyTasksAPIController extends AppBaseController
{
    private  $taskRepository;

    public function __construct(TaskRepository $taskRepo)
    {
        $this->taskRepository = $taskRepo;
    }

    /**
     * Display a listing of the Tasks.
     * GET|HEAD /tasks
     */
    public function index(Request $request): JsonResponse
    {

        $tasks = $request['start_date'] ?
            $this->taskRepository->getMyTasksByDate(auth()->user()->id, $request['start_date']) :
            $this->taskRepository->getMyTasks(auth()->user()->id);
        $numberOfTasks= $tasks->count();
        return $this->sendResponse(['tasks'=>TaskResource::collection($tasks),'number_of_tasks'=>$numberOfTasks], 'Tasks retrieved successfully');
    }
}
