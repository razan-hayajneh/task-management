<?php

namespace App\Repositories;

use App\Models\ProjectMember;
use App\Models\TeamMember;
use App\Repositories\BaseRepository;

class ProjectMemberRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'team_member_id',
        'project_id'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function getMembers($id): array
    {
        return TeamMember::WhereHas('projects',function ($query) use ($id) {
            $query->whereId($id);
        })->get();

    }

    public function model(): string
    {
        return ProjectMember::class;
    }
}
