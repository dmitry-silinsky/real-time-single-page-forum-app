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
            'id' => $this->resource->id,
            'body' => $this->resource->body,
            'created_at' => $this->resource->created_at->diffForHumans(),
            'user' => [
                'id' => $this->resource->user->id,
                'name' => $this->resource->user->name,
            ],
            'question_slug' => $this->resource->question->slug,
        ];
    }
}
