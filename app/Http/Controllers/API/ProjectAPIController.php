<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateProjectAPIRequest;
use App\Http\Requests\API\UpdateProjectAPIRequest;
use App\Models\Project;
use App\Repositories\ProjectRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\ProjectResource;
use Illuminate\Support\Facades\DB;

/**
 * Class ProjectAPIController
 */
class ProjectAPIController extends AppBaseController
{
    /** @var  ProjectRepository */
    private $projectRepository;

    public function __construct(ProjectRepository $projectRepo)
    {
        $this->projectRepository = $projectRepo;
    }

    /**
     * Display a listing of the Projects.
     * GET|HEAD /projects
     */
    public function index(Request $request): JsonResponse
    {
        $projects = $this->projectRepository->all(
            ['manager_id' => auth()->user()->id],
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(ProjectResource::collection($projects), 'Projects retrieved successfully');
    }

    /**
     * Store a newly created Project in storage.
     * POST /projects
     */
    public function store(CreateProjectAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        DB::beginTransaction();
        try {
            $input['manager_id'] = auth()->user()->id;
            $project = $this->projectRepository->create($input);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->sendError($exception->getMessage());
        }
        return $this->sendResponse([], 'Project saved successfully');
    }

    /**
     * Display the specified Project.
     * GET|HEAD /projects/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Project $project */
        $project = $this->projectRepository->find($id);

        if (empty($project)) {
            return $this->sendError('Project not found');
        }

        return $this->sendResponse(new ProjectResource($project), 'Project retrieved successfully');
    }

    /**
     * Update the specified Project in storage.
     * PUT/PATCH /projects/{id}
     */
    public function update($id, UpdateProjectAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $project = $this->projectRepository->find($id);

        if (empty($project)) {
            return $this->sendError('Project not found');
        }
        if (!$this->isAuthorProjectManager($id)) {
            return $this->sendError('You do not have permission to update this task');
        }
        DB::beginTransaction();
        try {
            $project = $this->projectRepository->update($request->except(['manager_id']), $id);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->sendError($exception->getMessage());
        }

        return $this->sendResponse([], 'Project updated successfully');
    }

    /**
     * Remove the specified Project from storage.
     * DELETE /projects/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Project $project */
        $project = $this->projectRepository->find($id);

        if (empty($project)) {
            return $this->sendError('Project not found');
        }
        if (!$this->isAuthorProjectManager($id)) {
            return $this->sendError('You do not have permission to update this task');
        }
        $project->delete();

        return $this->sendSuccess('Project deleted successfully');
    }
    public function isAuthorProjectManager($projectId): bool
    {
        if ($projectId == null) return false;
        $project = $this->projectRepository->find($projectId);
        return $project ? $project['manager_id'] == auth()->user()->id : false;
    }
}
