<?php

namespace App\Http\Requests\Replies;

use App\Models\{Question, Reply};

/**
 * Update Request
 *
 * @property-read Question $question
 */
class UpdateRequest extends CreateRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->reply()->user_id === auth()->id();
    }

    /**
     * @return Reply
     */
    private function reply()
    {
        return $this->question->replies()->findOrFail($this->reply);
    }
}
