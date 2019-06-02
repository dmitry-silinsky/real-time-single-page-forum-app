<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Notifications\DatabaseNotification;

/**
 * Class NotificationResource
 *
 * @property DatabaseNotification $resource
 */
class NotificationResource extends JsonResource
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
            'id' => $this->resource->id,
            'replyBy' => $this->resource->data['replyBy'],
            'question' => $this->resource->data['question'],
            'path' => $this->resource->data['path'],
        ];
    }
}
