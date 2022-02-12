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
            'terms_agreed' => 'boolean',
            'members' => 'array',
            'members.*.first_name' => 'string',
            'members.*.last_name' => 'string',
            'members.*.alt_name' => 'string',
            'members.*.email' => 'email:rfc,dns|unique:users,email',
            'members.*.phone' => 'string',
            'members.*.affiliation_id' => 'integer|exists:affiliations,id'
        ];
    }
}
