<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'description' => $this->description,
            'start_date' => $this->start_date?date_format($this->start_date,"Y-m-d H:s"):null,
            'end_date' => $this->end_date?date_format($this->end_date,"Y-m-d H:s"):null,
            'project_status' => $this->project_status,
            'manager_id' => $this->manager_id,
            'manager_name' => $this->manager?->full_name,
           'created_at' => $this->created_at?date_format($this->created_at, "Y-m-d H:s"):null,
            'updated_at' => $this->updated_at?date_format($this->updated_at, "Y-m-d H:s"):null
        ];
    }
}
