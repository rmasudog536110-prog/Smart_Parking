@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="p-6 max-w-2xl mt-5 mx-auto space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-gray-900">My Profile</h1>
        <p class="text-sm text-gray-500">Update your personal information and profile picture.</p>
    </div>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Profile Picture --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
            <h2 class="text-sm font-semibold text-gray-700 mb-4 uppercase tracking-wide">
                Profile Picture
            </h2>

            <div class="flex items-center gap-6">
                <div class="relative">
                    <img id="preview"
                        src="{{ auth()->user()->profile_picture_url }}"
                        class="w-24 h-24 rounded-full object-cover border-4 border-gray-100 shadow hover:ring-2 hover:ring-blue-500 cursor-pointer"
                        alt="Profile Picture">

                    <label for="profile_picture"
                        class="absolute bottom-0 right-0 bg-blue-600 hover:bg-blue-700 text-white rounded-full w-7 h-7 flex items-center hover:w-9 hover:right-1 hover:h-9 transition justify-center cursor-pointer shadow transition">
                        <i class="fa-solid fa-pen text-[10px]"></i>
                    </label>
                </div>

                <div class="flex-1">
                    <input type="file"
                           id="profile_picture"
                           name="profile_picture"
                           accept="image/*"
                           class="hidden"
                           onchange="previewImage(event)">
                    <p class="text-xs text-gray-500">Click the pencil icon to upload a new photo.</p>
                    <p class="text-xs text-gray-400 mt-1">JPG, PNG, or WebP. Max 2MB.</p>
                </div>
            </div>
        </div>

        {{-- Info --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm space-y-4">
            <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">
                Personal Information
            </h2>

            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Full Name</label>
                <input type="text"
                       name="name"
                       required
                       value="{{ old('name', $user->name) }}"
                       class="block w-full h-10 px-3 rounded-md border-gray-300 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Email</label>
                <input type="email"
                       name="email"
                       required
                       value="{{ old('email', $user->email) }}"
                       class="block w-full h-10 px-3 rounded-md border-gray-300 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Role</label>
                <div class="h-10 px-3 flex items-center rounded-md border border-gray-200 bg-gray-50 text-sm text-gray-500 capitalize">
                    {{ $user->role ?? 'Customer' }}
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit"
                class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow transition cursor-pointer">
                Save Changes
            </button>
        </div>
    </form>
</div>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('preview').src = e.target.result;
    };
    reader.readAsDataURL(file);
}
</script>
@endsection