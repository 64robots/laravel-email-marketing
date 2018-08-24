<?php

namespace R64\LaravelEmailMarketing\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GetResponseMemberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->contactId,
            'name' => $this->name,
            'email' => $this->email,
            'subscribed_at' => $this->createdOn,
            'tags' => []
        ];
    }
}