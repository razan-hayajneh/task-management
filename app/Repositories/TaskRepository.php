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
                $teamMember->where('user_id',$id);
            });
        })->get();
    }
    public function hasUpdatePermissionOnTask($taskId,$userId): bool
    {
        return $this->model()::whereId($taskId)->whereHas('members', function ($query) use ($userId) {
            $query->whereHas('teamMember', function ($teamMember) use ($userId) {
                $teamMember->where('user_id',$userId);
            })->whereHas('permission', function ($permission) {
                $permission->where('name','update');
            });
        })->count();
    }
    public function hasDeletePermissionOnTask($taskId,$userId): bool
    {
        return $this->model()::whereId($taskId)->whereHas('members', function ($query) use ($userId) {
            $query->whereHas('teamMember', function ($teamMember) use ($userId) {
                $teamMember->where('user_id',$userId);
            })->whereHas('permission', function ($permission) {
                $permission->where('name','delete');
            });
        })->count();
    }
    public function model(): string
    {
        return Task::class;
    }
}
