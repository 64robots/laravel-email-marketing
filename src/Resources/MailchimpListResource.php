<?php

namespace R64\LaravelEmailMarketing\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MailchimpListResource extends JsonResource
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
            'id' => (int) $this['id'],
            'name' => $this['name'],
            'subscribers' => $this['stats']['member_count']
        ];
    }
}