<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactMessageRequest;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    public function store(StoreContactMessageRequest $request)
    {
        ContactMessage::create($request->validated());

        return back()->with('success', 'Message sent successfully');
    }
}
