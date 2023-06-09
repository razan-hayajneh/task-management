<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeamMemberAPIResource extends JsonResource
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
            'user_details' => $this->user ? UserResource::make($this->user) : null,
            'user_id' => $this->user_id,
            'member_type' => $this->member_type,
            'created_at' => $this->created_at?date_format($this->created_at, "Y-m-d H:s"):null,
            'updated_at' => $this->updated_at?date_format($this->updated_at, "Y-m-d H:s"):null
        ];
    }
}
