<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
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
            'full_name' => $this->user?->full_name,
            'phone_number' => $this->user?->phone_number,
            'email' => $this->user?->email,
            'user_type' => $this->user?->user_type,
            'image_url' => $this->user?->image_url?url('storage/'.$this->user?->image_url):null,
            'access_level' => $this->access_level,
            'created_at' => $this->created_at?date_format($this->created_at, "Y-m-d H:s"):null,
            'updated_at' => $this->updated_at?date_format($this->updated_at, "Y-m-d H:s"):null
        ];
    }
}
