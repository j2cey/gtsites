<?php

namespace App\Http\Requests\SubtypeElement;

use App\Models\SubtypeElement;
use App\Traits\Request\RequestTraits;
use Illuminate\Foundation\Http\FormRequest;

class CreateSubtypeElementRequest extends FormRequest
{
    use RequestTraits;

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
        return SubtypeElement::createRules();
    }
}
