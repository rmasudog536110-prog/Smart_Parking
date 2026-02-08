@extends('layouts.app')

@section('title', 'My vehicles')

@section('content')

    <section class="space-y-6 p-6">
        <div class="p-6 mb-0">
            <div>
                <h1 class="text-4xl font-semibold text-gray-900">
                    My vehicles
                </h1>
                <p class="text-xs text-gray-500">
                    Manage the vehicles you use for reservations.
                </p>
            </div>
        </div>

        <div class="p-6 ml-0 grid gap-6 lg:grid-cols-[3fr,2fr] items-start">
            <section class="bg-white rounded-lg border border-gray-200 p-4">
                <h2 class="text-sm font-semibold text-gray-900 mb-2">
                    Registered vehicles
                </h2>

                @if ($vehicles->isEmpty())
                    <p class="text-xs text-gray-500">
                        You have no vehicles registered yet.
                    </p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-xs">
                            <thead>
                            <tr class="text-left text-gray-500 border-b">
                                <th class="py-2 pr-4">Plate number</th>
                                <th class="py-2 pr-4">Brand / model</th>
                                <th class="py-2 pr-4">Color</th>
                                <th class="py-2 pr-4"></th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                            @foreach ($vehicles as $vehicle)
                                <tr>
                                    <td class="py-2 pr-4 font-semibold text-gray-900">
                                        {{ $vehicle->plate_num }}
                                    </td>
                                    <td class="py-2 pr-4 text-gray-700">
                                        {{ $vehicle->brand ?? '—' }} {{ $vehicle->model }}
                                    </td>
                                    <td class="py-2 pr-4 text-gray-700">
                                        {{ $vehicle->color ?? '—' }}
                                    </td>
                                    <td class="py-2 pr-0 text-right">
                                        <form action="{{ route('vehicles.destroy', $vehicle) }}" method="POST"
                                            onsubmit="return confirm('Remove this vehicle?');"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-[11px] text-red-600 hover:text-red-700 font-medium">
                                                Remove
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </section>
        </div>
    
        <section class="p-6 space-y-6 ml-0">
            <div class=" bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-3">
                    Add a vehicle
                </h2>

                <form action="{{ route('vehicles.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1" for="plate_num">
                            Plate number
                        </label>
                        <input
                            id="plate_num"
                            type="text"
                            name="plate_num"
                            required
                            class="block w-full h-10 px-3 rounded-md border-gray-300 text-sm shadow-sm focus:border-orange-500 focus:ring-orange-500"
                            placeholder="ABC-1234"
                            value="{{ old('plate_num') }}"
                        >
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1" for="brand">
                                Brand
                            </label>
                            <input
                                id="brand"
                                type="text"
                                name="brand"
                                class="block w-full h-10 px-3 rounded-md border-gray-300 text-sm shadow-sm focus:border-orange-500 focus:ring-orange-500"
                                placeholder="Toyota"
                                value="{{ old('brand') }}"
                            >
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1" for="model">
                                Model
                            </label>
                            <input
                                id="model"
                                type="text"
                                name="model"
                                class="block w-full h-10 px-3 rounded-md border-gray-300 text-sm shadow-sm focus:border-orange-500 focus:ring-orange-500"
                                placeholder="Vios"
                                value="{{ old('model') }}"
                            >
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1" for="color">
                            Color
                        </label>
                        <input
                            id="color"
                            type="text"
                            name="color"
                            class="block w-full h-10 px-3 rounded-md border-gray-300 text-sm shadow-sm focus:border-orange-500 focus:ring-orange-500"
                            placeholder="White"
                            value="{{ old('color') }}"
                        >
                    </div>

                    <button type="submit"
                            class="w-full inline-flex justify-center items-center px-3 py-2 rounded-md bg-gray-900 text-white text-sm font-semibold shadow-sm hover:bg-black">
                        Save vehicle
                    </button>
                </form>
            </div>
        </section>
    </section>
@endsection

