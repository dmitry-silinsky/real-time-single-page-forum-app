<?php

namespace App\Http\Resources;

use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Reply Resource
 * @property-read Reply $resource
 */
class ReplyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'body' => $this->resource->body,
            'user' => $this->resource->user->name,
            'created_at' => $this->resource->created_at->diffForHumans(),
        ];
    }
}
