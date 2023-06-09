<?php

namespace App\Repositories;

use App\Models\TaskMember;
use App\Repositories\BaseRepository;

class TaskMemberRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'team_member_id',
        'task_id',
        'permission_id'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }
    public function model(): string
    {
        return TaskMember::class;
    }
}
