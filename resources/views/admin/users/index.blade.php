@extends('layouts.app')

@section('title', 'Admin – Users')

@section('content')
    <div class="mb-4 flex items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-semibold text-gray-900">
                Users
            </h1>
            <p class="text-xs text-gray-500">
                View and manage all registered users.
            </p>
        </div>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 p-4">
        @if ($users->isEmpty())
            <p class="text-xs text-gray-500">
                No users found.
            </p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full text-xs">
                    <thead>
                    <tr class="text-left text-gray-500 border-b">
                        <th class="py-2 pr-4">Name</th>
                        <th class="py-2 pr-4">Email</th>
                        <th class="py-2 pr-4">Role</th>
                        <th class="py-2 pr-4">Joined</th>
                        <th class="py-2 pr-4"></th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                    @foreach ($users as $user)
                        <tr>
                            <td class="py-2 pr-4 text-gray-900">
                                {{ $user->name }}
                            </td>
                            <td class="py-2 pr-4 text-gray-700">
                                {{ $user->email }}
                            </td>
                            <td class="py-2 pr-4 text-gray-700">
                                {{ ucfirst($user->role) }}
                            </td>
                            <td class="py-2 pr-4 text-gray-700">
                                {{ $user->created_at?->format('Y-m-d') }}
                            </td>
                            <td class="py-2 pr-0 text-right space-x-2">
                                <a href="{{ route('admin.users.show', $user) }}"
                                   class="text-[11px] text-orange-600 hover:text-orange-700 font-medium">
                                    View
                                </a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                      onsubmit="return confirm('Delete this user?');"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-[11px] text-red-600 hover:text-red-700 font-medium">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection

