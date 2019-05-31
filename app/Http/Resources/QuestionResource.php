<?php

namespace App\Http\Resources;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Question Resource
 *
 * @property-read Question $resource
 */
class QuestionResource extends JsonResource
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
            'title' => $this->resource->title,
            'slug' => $this->resource->slug,
            'path' => $this->resource->path,
            'body' => $this->resource->body,
            'created_at' => $this->resource->created_at->diffForHumans(),
            'user' => [
                'id' => $this->resource->user->id,
                'name' => $this->resource->user->name,
            ],
            'category' => [
                'id' => $this->resource->category->id,
                'name' => $this->resource->category->name,
            ],
            'replies' => ReplyResource::collection($this->resource->replies),
        ];
    }
}
