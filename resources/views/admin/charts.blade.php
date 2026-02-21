@extends('layouts.app')

@section('title', 'Admin Dashboard – Smart Parking')

@section('content')

    <div class="grid gap-6 lg:grid-cols-2 mt-5 mb-1 px-6">
        {{-- Line Chart: Revenue Trend --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            <h3 class="font-bold text-gray-900 mb-4">Revenue Trend (Last 6 Months)</h3>
            <div class="h-50">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        {{-- Pie Chart: Parking Occupancy --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            <h3 class="font-bold text-gray-900 mb-4">Parking Status Distribution</h3>
            <div class="h-50 flex justify-center">
                <canvas id="occupancyChart"></canvas>
            </div>
        </div>
    </div>

    <div class="mt-2 mb-0 flex items-center justify-start gap-4 mt-1 mb-2 px-6">
        <a href="{{ route('admin.dashboard') }}" class="bg-blue-500 text-white px-4 py-2 text-right rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
            <i class="fa-solid fa-arrow-left"></i> Return to Dashboard
        </a>
    </div>
@endsection

<script>

                const revCtx = document.getElementById('revenueChart').getContext('2d');
            new Chart(revCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($revenueMonthly->pluck('month')) !!},
                    datasets: [{
                        label: 'Monthly Revenue (₱)',
                        data: {!! json_encode($revenueMonthly->pluck('total')) !!},
                        borderColor: '#ea580c', // orange-600
                        backgroundColor: 'rgba(234, 88, 12, 0.1)',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });

            // Pie Chart Logic
            const occCtx = document.getElementById('occupancyChart').getContext('2d');
            new Chart(occCtx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode(array_keys($occupancyData)) !!},
                    datasets: [{
                        data: {!! json_encode(array_values($occupancyData)) !!},
                        backgroundColor: ['#22c55e', '#ef4444', '#f59e0b'], // green, red, amber
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });
</script>

