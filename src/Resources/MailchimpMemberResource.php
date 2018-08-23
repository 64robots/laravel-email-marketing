<?php

namespace R64\LaravelEmailMarketing\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MailchimpMemberResource extends JsonResource
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
            'id' => $this['id'],
            'name' => $this['merge_fields']['FNAME'] . ' ' . $this['merge_fields']['LNAME'],
            'email' => $this['email_address'],
            'subscribed_at' => $this['timestamp_opt'],
            'tags' => $this['tags']
        ];
    }
}