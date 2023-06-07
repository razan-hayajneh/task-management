<?php

namespace App\Http\Controllers\API;

use App\Enums\ProjectStatus;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\AppBaseController;

class ProjectStatusAPIController extends AppBaseController
{
    public function index():JsonResponse
    {
        $projectStatus = ProjectStatus::getInstances();
        return $this->sendResponse($projectStatus, 'All Permissions retrieved successfully');
    }
}
