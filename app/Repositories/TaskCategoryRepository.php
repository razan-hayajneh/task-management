<?php

namespace App\Repositories;

use App\Models\TaskCategory;
use App\Repositories\BaseRepository;

class TaskCategoryRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return TaskCategory::class;
    }
}
