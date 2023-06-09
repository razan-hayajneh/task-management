<?php

namespace App\Http\Controllers\API;

use App\Repositories\TimelineRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\TimelineResource;

/**
 * Class TimelineController
 */

class TimelineAPIController extends AppBaseController
{
    /** @var  TimelineRepository */
    private $timelineRepository;

    public function __construct(TimelineRepository $timelineRepo)
    {
        $this->timelineRepository = $timelineRepo;
    }

    /**
     * Display a listing of the Timeline.
     * GET|HEAD /timelines
     */
    public function index(Request $request)
    {
        $timelines = $this->timelineRepository->all(
            ['task_id'=>$request['task_id']]
        );

        return $this->sendResponse(TimelineResource::collection($timelines), 'Timelines retrieved successfully');
    }

}
