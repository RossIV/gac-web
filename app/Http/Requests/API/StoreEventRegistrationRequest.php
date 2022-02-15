<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreEventRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(Request $request)
    {
        return (
            Auth::user()->hasRole('super-admin') ||
            Auth::user()->isOwnerOfTeam($request->input('team_id'))
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
            'event_id' => 'required|integer|exists:events,id',
            'team_id' => 'required|integer|exists:teams,id',
            'user_id' => 'integer|exists:users,id',
            'payment_method_id' => 'integer,exists:payment_methods:id'
        ];
    }
}
