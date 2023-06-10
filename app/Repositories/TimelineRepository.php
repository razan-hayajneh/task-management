<?php

namespace App\Repositories;

use App\Models\Timeline;
use App\Repositories\BaseRepository;

class TimelineRepository extends BaseRepository
{

    protected $fieldSearchable = [
        'task_id',
        'status',
        'date',
        'updated_by'
    ];


    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Timeline::class;
    }
}
