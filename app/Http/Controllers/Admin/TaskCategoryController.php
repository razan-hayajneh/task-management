<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Admin\CreateCategoryRequest;
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
    /**
     * Display a listing of the categories.
     * GET|HEAD /categories
     */
    public function index(Request $request)
    {
        $taskCategories = $this->taskCategoryRepository->paginate(10);
        return Inertia::render('Admin/Category/Index')
            ->with([
                'categories' => TaskCategoryResource::collection($taskCategories),
                'message' => $request->session()->get('message'),
                'type' => $request->session()->get('type')
            ]);
    }
    /**
     * Display a form to create a new category.
     * GET|HEAD /categories/create
     */
    public function create()
    {
        return Inertia::render('Admin/Category/Create');
    }
    /**
     * Store a newly created Admin in storage.
     * POST /categories
     */
    public function store(CreateCategoryRequest $request)
    {
        $input = $request->all();

        $taskCategory = $this->taskCategoryRepository->create($input);

        return redirect(route('categories.index'))->with(['message' => 'Category Saved Successfully', 'type' => 'success']);
    }
    /**
     * Display a form to update the category.
     * GET|HEAD /categories/{id}/edit
     */
    public function edit($id)
    {
        $taskCategory = $this->taskCategoryRepository->find($id);

        if (empty($taskCategory)) {
            return redirect(route('categories.index'))->with('message', 'Category Not Found');
        }
        return Inertia::render('Admin/Category/Edit')->with(['category' => $taskCategory]);
    }
    /**
     * Update the specified category in storage.
     * PUT/PATCH /categories/{id}
     */
    public function update($id, CreateCategoryRequest $request)
    {
        $taskCategory = $this->taskCategoryRepository->find($id);
        if (empty($taskCategory)) {
            return redirect(route('categories.index'))->with('message', 'Category Not Found');
        }
        $taskCategory = $this->taskCategoryRepository->update($request->all(), $id);
        $message = 'Task Category Updated Successfully';
        return redirect(route('categories.index'))->with(['message' => $message, 'type' => 'success']);
    }
    /**
     * Remove the specified category from storage.
     * DELETE /categories/{id}
     */
    public function destroy($id)
    {
        $taskCategory = $this->taskCategoryRepository->find($id);

        if (empty($taskCategory)) {
            return $this->sendError('Task Category not found');
        }

        $taskCategory->delete();

        $message = 'Task Category deleted successfully';
        return redirect(route('categories.index'))->with(['message' => $message, 'type' => 'success']);
    }
}
