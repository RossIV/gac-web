<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PatchUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (
            Auth::user()->hasRole('super-admin') ||
            Auth::user()->id == $this->route('user')->id
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'string',
            'last_name' => 'string',
            'alt_name' => 'string',
            'email' => 'email:rfc,dns',
            'phone' => 'string',
            'affiliation_id' => 'integer|exists:affiliations,id',
            'emergency_contact_name' => 'string',
            'emergency_contact_phone' => 'numeric',
            'emergency_contact_relationship' => 'string',
        ];
    }
}
