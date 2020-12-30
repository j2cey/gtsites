<?php

namespace App\Http\Requests\Element;

use App\Models\Element;
use Illuminate\Foundation\Http\FormRequest;

class CreateElementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Element::createRules();
    }
}
