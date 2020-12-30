<?php

namespace App\Http\Requests\Attribut;

use App\Models\Attribut;
use App\Traits\Request\RequestTraits;
use Illuminate\Foundation\Http\FormRequest;

class CreateAttributRequest extends FormRequest
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
        return Attribut::createRules();
    }
}
