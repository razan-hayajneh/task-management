<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
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
           'created_at' => $this->created_at?date_format($this->created_at, "Y-m-d H:s"):null,
            'updated_at' => $this->updated_at?date_format($this->updated_at, "Y-m-d H:s"):null
        ];
    }
}
