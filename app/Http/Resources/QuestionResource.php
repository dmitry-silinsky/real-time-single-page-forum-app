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
            'path' => $this->resource->path,
            'body' => $this->resource->body,
            'created_at' => $this->resource->created_at->diffForHumans(),
            'user' => $this->resource->user->name,
        ];
    }
}
