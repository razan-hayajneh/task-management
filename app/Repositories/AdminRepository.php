<?php

namespace App\Repositories;

use App\Models\Admin;
use App\Repositories\BaseRepository;

class AdminRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'user_id',
        'access_level'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Admin::class;
    }
}
