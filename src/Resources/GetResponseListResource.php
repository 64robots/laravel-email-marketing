<?php

namespace R64\LaravelEmailMarketing\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GetResponseListResource extends JsonResource
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
            'id' => $this->campaignId,
            'name' => $this->name,
            'subscribers' => 'N/A'
        ];
    }
}