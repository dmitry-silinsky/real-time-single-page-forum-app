<?php

namespace App\Http\Requests\Question;

use App\Models\Category;
use Auth;

/**
 * Category Update Request
 *
 * @property-read Category $question
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
        return $this->question->user_id === Auth::id();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();

        $rules['title'] = preg_replace(
            '#unique\:([^\|]+)#',
            "$0,{$this->question->id}",
            $rules['title']
        );
        $rules['category_id'] = preg_replace('#\|?required\|?#', '', $rules['category_id']);

        return $rules;
    }
}
