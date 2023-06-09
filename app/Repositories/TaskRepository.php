<?php

namespace App\Repositories;

use App\Models\Task;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
        'task_status',
        'project_id',
        'category_id',
        'start_date',
        'end_date'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function myTasks($id): Collection
    {
        return $this->model()::whereHas('members', function ($query) use ($id) {
            $query->whereHas('teamMember', function ($teamMember) use ($id) {
                $teamMember->where('user_id', $id);
            });
        })->get();
    }
    public function hasAccessPermissionOnTask($projectId, $userId): bool
    {
        return $this->model()::whereProjectId($projectId)->where(function ($query) use ($userId) {
            $query->whereHas('members', function ($member) use ($userId) {
                $member->whereHas('teamMember', function ($teamMember) use ($userId) {
                    $teamMember->where('user_id', $userId);
                });
            })->orWhereHas('project', function ($project) use ($userId) {
                $project->whereManagerId($userId)->orWhereHas('projectMembers', function ($projectMember) use ($userId) {
                    $projectMember->whereHas('teamMember', function ($teamMember) use ($userId) {
                        $teamMember->where('user_id', $userId);
                    });
                });
            });
        })->count();
    }

    public function hasCreateNewTaskPermission($taskId, $userId): bool
    {
        return $this->model()::whereId($taskId)->WhereHas('project', function ($project) use ($userId) {
            $project->whereManagerId($userId)->orWhereHas('projectMembers', function ($projectMember) use ($userId) {
                $projectMember->whereHas('teamMember', function ($teamMember) use ($userId) {
                    $teamMember->where('user_id', $userId);
                });
            });
        })->count();
    }
    public function hasUpdatePermissionOnTask($taskId, $userId): bool
    {
        return $this->model()::whereId($taskId)->where(function ($query) use ($userId) {
            $query->whereHas('members', function ($member) use ($userId) {
                $member->whereHas('teamMember', function ($teamMember) use ($userId) {
                    $teamMember->where('user_id', $userId);
                });
            })->orWhereHas('project', function ($project) use ($userId) {
                $project->whereManagerId($userId);
            });
        })->count();
    }
    public function hasUpdateStatusPermissionOnTask($taskId, $userId): bool
    {
        return $this->model()::whereId($taskId)->where(function ($query) use ($userId) {
            $query->whereHas('members', function ($member) use ($userId) {
                $member->whereHas('teamMember', function ($teamMember) use ($userId) {
                    $teamMember->where('user_id', $userId);
                });
            })->orWhereHas('project', function ($project) use ($userId) {
                $project->whereManagerId($userId)->whereHas('projectMembers', function ($projectMember) use ($userId) {
                    $projectMember->whereHas('teamMember', function ($teamMember) use ($userId) {
                        $teamMember->where('user_id', $userId);
                    });
                });
            });
        })->count();
    }
    public function hasDeletePermissionOnTask($taskId, $userId): bool
    {
        return $this->model()::whereId($taskId)->WhereHas('project', function ($project) use ($userId) {
            $project->whereManagerId($userId)->orWhereHas('projectMembers', function ($projectMember) use ($userId) {
                $projectMember->whereHas('teamMember', function ($teamMember) use ($userId) {
                    $teamMember->where('user_id', $userId);
                });
            });
        })->count();
    }

    public function isAuthorProjectManager($projectId): bool
    {
        return $this->model()::whereProjectId($projectId)->whereHas('project', function ($project) {
            $project->whereManagerId(auth()->user()->id);
        })->count();
    }
    public function model(): string
    {
        return Task::class;
    }
}
