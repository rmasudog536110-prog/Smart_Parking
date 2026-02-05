<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Allow all users to send contact messages
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|max:255',
            'message' => 'required|string|min:10|max:2000',
        ];
    }
}
