<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateTaskCategoryRequest;
use App\Models\TaskCategory;
use App\Repositories\TaskCategoryRepository;
use Illuminate\Http\Request;
use App\Http\Resources\TaskCategoryResource;
use Inertia\Inertia;

/**
 * Class TaskCategoryAPIController
 */
class TaskCategoryController extends AppBaseController
{
    /** @var  TaskCategoryRepository */
    private $taskCategoryRepository;

    public function __construct(TaskCategoryRepository $taskCategoryRepo)
    {
        $this->taskCategoryRepository = $taskCategoryRepo;
    }

    public function index(Request $request)
    {
        $taskCategories = $this->taskCategoryRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );
        return Inertia::render('Admin/Category/Index')
            ->with([
                'categories' => TaskCategoryResource::collection($taskCategories),
                'message' => $request->session()->get('message'),
                'type' => $request->session()->get('type')
            ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Category/Create');
    }

    public function store(CreateTaskCategoryRequest $request)
    {
        $input = $request->all();

        $taskCategory = $this->taskCategoryRepository->create($input);

        return redirect(route('categories.index'))->with(['message' => 'Category Saved Successfully', 'type' => 'success']);
    }

    public function edit($id)
    {
        $taskCategory = $this->taskCategoryRepository->find($id);

        if (empty($taskCategory)) {
            return redirect(route('categories.index'))->with('message', 'Category Not Found');
        }
        return Inertia::render('Admin/Category/Edit')->with(['category' => $taskCategory]);
    }
    public function update($id,CreateTaskCategoryRequest $request)
    {
        $taskCategory = $this->taskCategoryRepository->find($id);
        if (empty($taskCategory)) {
            return redirect(route('categories.index'))->with('message', 'Category Not Found');
        }
        $taskCategory = $this->taskCategoryRepository->update($request->all(), $id);
        $message = 'Task Category Updated Successfully' ;
        return redirect(route('categories.index'))->with(['message'=>$message,'type'=>'success']);
    }
    public function destroy($id)
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
