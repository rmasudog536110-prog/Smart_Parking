@extends('layouts.app')

@section('title', 'Analytics – Smart Parking')

@section('content')
<div class="px-6 py-4 space-y-6">

    {{-- Back --}}
    <div>
        <a href="{{ route('admin.dashboard') }}"
            class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors">
            <i class="fa-solid fa-arrow-left text-xs"></i> Dashboard
        </a>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 mb-1">Revenue</p>
                <p class="text-xs text-gray-400 mt-1">Last 6 months</p>
            </div>
            <p class="text-3xl font-bold text-gray-900">
                ₱{{ number_format($revenueMonthly->sum('total'), 2) }}
            </p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 mb-1">Available</p>
                <p class="text-xs text-gray-400 mt-1">Free slots</p>
            </div>
            <p class="text-3xl font-bold text-gray-900">
                {{ $occupancyData['Available'] ?? 0 }}
            </p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 mb-1">Occupied</p>
                <p class="text-xs text-gray-400 mt-1">In use</p>
            </div>
            <p class="text-3xl font-bold text-gray-900">
                {{ $occupancyData['Occupied'] ?? 0 }}
            </p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 mb-1">Reserved</p>
                <p class="text-xs text-gray-400 mt-1">Pending</p>
            </div>
            <p class="text-3xl font-bold text-gray-900">
                {{ $occupancyData['Reserved'] ?? 0 }}
            </p>
        </div>
    </div>

    {{-- Charts --}}
    <div class="grid gap-6 lg:grid-cols-2">

        {{-- Line --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="font-bold text-gray-900">Revenue</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Last 6 months</p>
                </div>
                <span class="text-xs font-semibold px-2 py-1 bg-blue-50 text-blue-600 rounded-full">Monthly</span>
            </div>
            <div class="relative h-64">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        {{-- Doughnut --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="font-bold text-gray-900">Status</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Distribution</p>
                </div>
                @php
                    $total = array_sum($occupancyData);
                    $occupiedPct = $total > 0 ? round(($occupancyData['Occupied'] ?? 0) / $total * 100) : 0;
                @endphp
                <span class="text-xs font-semibold px-2 py-1 rounded-full {{ $occupiedPct > 75 ? 'bg-red-50 text-red-600' : 'bg-emerald-50 text-emerald-600' }}">
                    {{ $occupiedPct }}% Occupied
                </span>
            </div>
            <div class="relative h-64 flex items-center justify-center">
                <canvas id="occupancyChart"></canvas>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Revenue
    const revCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($revenueMonthly->pluck('month')) !!},
            datasets: [{
                label: 'Revenue (₱)',
                data: {!! json_encode($revenueMonthly->pluck('total')) !!},
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37, 99, 235, 0.08)',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#2563eb',
                pointRadius: 5,
                pointHoverRadius: 7,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ' ₱' + Number(ctx.raw).toLocaleString('en-PH', { minimumFractionDigits: 2 })
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { callback: val => '₱' + Number(val).toLocaleString('en-PH') },
                    grid: { color: 'rgba(0,0,0,0.04)' }
                },
                x: { grid: { display: false } }
            }
        }
    });

    // Occupancy
    const occCtx = document.getElementById('occupancyChart').getContext('2d');
    new Chart(occCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(array_keys($occupancyData)) !!},
            datasets: [{
                data: {!! json_encode(array_values($occupancyData)) !!},
                backgroundColor: ['#10b981', '#111827', '#2563eb'],
                borderWidth: 2,
                borderColor: '#fff',
                hoverOffset: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 16,
                        usePointStyle: true,
                        pointStyleWidth: 8,
                        font: { size: 12 }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: ctx => ' ' + ctx.label + ': ' + ctx.raw + ' slots'
                    }
                }
            }
        }
    });
});
</script>
@endpush