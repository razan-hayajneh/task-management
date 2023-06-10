<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateReportAPIRequest;
use App\Http\Requests\API\UpdateReportAPIRequest;
use App\Models\Report;
use App\Repositories\ReportRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\ReportResource;
use Illuminate\Support\Facades\DB;

/**
 * Class ReportAPIController
 */
class ReportAPIController extends AppBaseController
{
    /** @var  ReportRepository */
    private $reportRepository;

    public function __construct(ReportRepository $reportRepo)
    {
        $this->reportRepository = $reportRepo;
    }

    /**
     * Display a listing of the Reports.
     * GET|HEAD /reports
     */
    public function index(Request $request): JsonResponse
    {
        $reports = $this->reportRepository->all(
            $request->only(['task_id', 'project_id']),
        );

        return $this->sendResponse(ReportResource::collection($reports), 'Reports retrieved successfully');
    }

    /**
     * Store a newly created Report in storage.
     * POST /reports
     */
    public function store(CreateReportAPIRequest $request): JsonResponse
    {
        $input = $request->all();
        $input['created_by']=auth()->user()->id;
        DB::beginTransaction();
        try {
            $report = $this->reportRepository->create($input);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->sendError($exception->getMessage());
        }
        return $this->sendResponse([], 'Report saved successfully');
    }

    /**
     * Display the specified Report.
     * GET|HEAD /reports/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Report $report */
        $report = $this->reportRepository->find($id);

        if (empty($report)) {
            return $this->sendError('Report not found');
        }

        return $this->sendResponse(new ReportResource($report), 'Report retrieved successfully');
    }

    /**
     * Update the specified Report in storage.
     * PUT/PATCH /reports/{id}
     */
    public function update($id, UpdateReportAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $report = $this->reportRepository->find($id);

        if (empty($report)) {
            return $this->sendError('Report not found');
        }
        if($report['created_by']!=auth()->user()->id){
            return $this->sendError('You Can not update this Report');
        }
        DB::beginTransaction();
        try {
            $report = $this->reportRepository->update($input, $id);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->sendError($exception->getMessage());
        }

        return $this->sendResponse([], 'Report updated successfully');
    }

    /**
     * Remove the specified Report from storage.
     * DELETE /reports/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Report $report */
        $report = $this->reportRepository->find($id);

        if (empty($report)) {
            return $this->sendError('Report not found');
        }

        if($report['created_by']!=auth()->user()->id){
            return $this->sendError('You Can not delete this Report');
        }
        $report->delete();

        return $this->sendSuccess('Report deleted successfully');
    }
}
