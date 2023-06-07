<?php

namespace App\Repositories;

use App\Models\TeamMember;
use App\Repositories\BaseRepository;

class TeamMemberRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'user_id',
        'member_type'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return TeamMember::class;
    }
}
