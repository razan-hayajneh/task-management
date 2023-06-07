<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateNotificationAPIRequest;
use App\Repositories\NotificationRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\NotificationResource;

/**
 * Class NotificationAPIController
 */
class NotificationAPIController extends AppBaseController
{
    /** @var  NotificationRepository */
    private $notificationRepository;

    public function __construct(NotificationRepository $notificationRepo)
    {
        $this->notificationRepository = $notificationRepo;
    }

    /**
     * Display a listing of the Notifications.
     * GET|HEAD /notifications
     */
    public function index(Request $request): JsonResponse
    {
        $notifications = $this->notificationRepository->all(
            ['user_id' => auth()->user()->id],
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(NotificationResource::collection($notifications), 'Notifications retrieved successfully');
    }

    /**
     * Store a newly created Notification in storage.
     * POST /notifications
     */
    public function store(CreateNotificationAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $notification = $this->notificationRepository->create($input);

        return $this->sendResponse([], 'Notification saved successfully');
    }
}
