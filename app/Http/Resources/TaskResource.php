<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'task_status' => $this->task_status,
            'project_id' => $this->project_id,
            'category_id' => $this->category_id,
            'category_name' => $this->category?->name,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'start_date' => $this->start_date?date_format($this->start_date,"Y-m-d H:s"):null,
            'end_date' => $this->end_date?date_format($this->end_date,"Y-m-d H:s"):null,
            'created_at' => $this->created_at?date_format($this->created_at, "Y-m-d H:s"):null,
            'updated_at' => $this->updated_at?date_format($this->updated_at, "Y-m-d H:s"):null
        ];
    }
}
