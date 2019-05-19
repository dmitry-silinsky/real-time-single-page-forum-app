<?php

namespace App\Http\Requests\Category;

use App\Models\Category;

/**
 * Question Update Request
 *
 * @property-read Category $category
 */
class UpdateRequest extends CreateRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();

        $rules['name'] = preg_replace(
            '#unique\:([^\|]+)#',
            "$0,{$this->category->id}",
            $rules['name']
        );

        return $rules;
    }
}
