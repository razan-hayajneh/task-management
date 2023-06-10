<?php

namespace App\Repositories;

use App\Models\Report;
use App\Repositories\BaseRepository;

class ReportRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
        'content',
        'project_id',
        'task_id',
        'created_by'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Report::class;
    }
}
