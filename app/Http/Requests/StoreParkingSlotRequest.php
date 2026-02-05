<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreParkingSlotRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->role === 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'location_id' => 'required|exists:park_loc,id',
            'slot_number' => 'required|string|max:10',
            'type' => 'required|in:compact,large,handicapped,electric',
            'status' => 'required|in:available,occupied,maintenance,reserved',
        ];
    }
}
