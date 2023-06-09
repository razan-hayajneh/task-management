<?php

namespace App\Repositories;

use App\Models\Timeline;
use App\Repositories\BaseRepository;

/**
 * Class TimelineRepository
 * @package App\Repositories
 * @version June 9, 2023, 12:20 am EEST
 */

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
