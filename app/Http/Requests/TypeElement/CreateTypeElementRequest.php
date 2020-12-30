<?php

namespace App\Http\Requests\TypeElement;

use App\Models\TypeElement;
use Illuminate\Foundation\Http\FormRequest;

class CreateTypeElementRequest extends FormRequest
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
        return TypeElement::createRules();
    }
}
