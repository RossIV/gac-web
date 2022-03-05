<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeamRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:teams,name',
            'motto' => 'required|string',
            'accept_additional_members' => 'required|boolean',
            'owner_id' => 'integer|exists:users,id|prohibits:owner_email',
            'owner_email' => 'string|exists:users,email|prohibits:owner_id',
            'members' => 'array',
            'members.*.first_name' => 'required|string',
            'members.*.last_name' => 'required|string',
            'members.*.alt_name' => 'required|string',
            'members.*.email' => 'required|email:rfc,dns',
            'members.*.phone' => 'required|string',
            'members.*.affiliation_id' => 'required|integer|exists:affiliations,id'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.unique' => 'The team name has already been taken. Please use a different name.'
        ];
    }
}
