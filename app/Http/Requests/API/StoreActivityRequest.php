<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreActivityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'log_name' => 'required|string',
            'description' => 'required|string',
            'event' => 'required|string',
            'causer_type' => 'string',
            'causer_id' => 'numeric',
            'subject_type' => 'string',
            'subject_id' => 'numeric',
            'created_at' => 'date',
        ];
    }
}
