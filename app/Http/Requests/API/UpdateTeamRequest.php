<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTeamRequest extends FormRequest
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
        return [
            'name' => ['string', Rule::unique('teams')->ignore($this->name)],
            'motto' => 'string',
            'accept_additional_members' => 'boolean',
            'owner_id' => 'integer|exists:users,id|prohibits:owner_email',
            'owner_email' => 'string|exists:users,email|prohibits:owner_id'
        ];
    }
}
