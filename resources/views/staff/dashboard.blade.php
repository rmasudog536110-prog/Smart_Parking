@extends('layouts.app')

@section('title', 'Staff Dashboard')

@section('content')
<div class="p-6 space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-gray-900">Staff Dashboard</h1>
        <p class="text-sm text-gray-500">Monitor parking activity and scan customer reservations.</p>
    </div>

    @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 rounded-lg p-4 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
            <p class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Reserved</p>
            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalReserved }}</p>
            <p class="text-xs text-gray-400 mt-1">Pending + Active</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
            <p class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Active Now</p>
            <p class="text-3xl font-bold text-green-600 mt-1">{{ $totalActive }}</p>
            <p class="text-xs text-gray-400 mt-1">Currently parked</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
            <p class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Completed Today</p>
            <p class="text-3xl font-bold text-blue-600 mt-1">{{ $totalCompleted }}</p>
            <p class="text-xs text-gray-400 mt-1">Checked out today</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
            <p class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Cancelled Today</p>
            <p class="text-3xl font-bold text-red-500 mt-1">{{ $totalCancelled }}</p>
            <p class="text-xs text-gray-400 mt-1">Cancelled today</p>
        </div>
    </div>

    <div class="grid lg:grid-cols-[2fr,1fr] gap-6">

        {{-- QR Scanner --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-sm font-semibold text-gray-900">QR Scanner</h2>
                <p class="text-xs text-gray-500 mt-0.5">Scan a customer's QR code to view and update their reservation.</p>
            </div>
            <div class="p-6 space-y-4">
                <div id="scanner-container" class="relative w-full rounded-xl overflow-hidden bg-gray-900" style="height: 280px;">
                    <video id="scanner-video" class="w-full h-full object-cover" playsinline></video>
                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                        <div class="w-48 h-48 border-2 border-white/60 rounded-xl relative">
                            <span class="absolute top-0 left-0 w-6 h-6 border-t-4 border-l-4 border-blue-400 rounded-tl-lg"></span>
                            <span class="absolute top-0 right-0 w-6 h-6 border-t-4 border-r-4 border-blue-400 rounded-tr-lg"></span>
                            <span class="absolute bottom-0 left-0 w-6 h-6 border-b-4 border-l-4 border-blue-400 rounded-bl-lg"></span>
                            <span class="absolute bottom-0 right-0 w-6 h-6 border-b-4 border-r-4 border-blue-400 rounded-br-lg"></span>
                        </div>
                    </div>
                    <div id="scanner-placeholder" class="absolute inset-0 flex flex-col items-center justify-center text-white bg-gray-900">
                        <i class="fa-solid fa-qrcode text-4xl mb-3 text-gray-400"></i>
                        <p class="text-sm text-gray-400">Camera not started</p>
                    </div>
                </div>

                <div class="flex gap-2">
                    <button id="start-scanner"
                        onclick="startScanner()"
                        class="flex-1 py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition">
                        <i class="fa-solid fa-camera mr-2"></i>Start Scanner
                    </button>
                    <button id="stop-scanner"
                        onclick="stopScanner()"
                        class="flex-1 py-2 px-4 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-semibold rounded-lg transition hidden">
                        <i class="fa-solid fa-stop mr-2"></i>Stop
                    </button>
                </div>

                {{-- Scan Result --}}
                <div id="scan-result" class="hidden">
                    <div class="border border-gray-200 rounded-xl overflow-hidden">
                        <div id="result-header" class="px-4 py-3 flex items-center justify-between">
                            <div>
                                <p id="result-name" class="font-semibold text-sm text-gray-900"></p>
                                <p id="result-location" class="text-xs text-gray-500 mt-0.5"></p>
                            </div>
                            <span id="result-status" class="text-[11px] font-bold px-2 py-0.5 rounded-full"></span>
                        </div>
                        <div class="px-4 pb-4 space-y-2 text-xs text-gray-600">
                            <div class="flex justify-between"><span class="text-gray-400">Vehicle</span><span id="result-vehicle" class="font-medium"></span></div>
                            <div class="flex justify-between"><span class="text-gray-400">Slot</span><span id="result-slot" class="font-medium"></span></div>
                            <div class="flex justify-between"><span class="text-gray-400">Start</span><span id="result-start" class="font-medium"></span></div>
                            <div class="flex justify-between"><span class="text-gray-400">End</span><span id="result-end" class="font-medium"></span></div>
                            <div class="flex justify-between"><span class="text-gray-400">Free Hours</span><span id="result-free-hours" class="font-medium text-green-600"></span></div>
                            <div class="flex justify-between"><span class="text-gray-400">Amount Due</span><span id="result-amount" class="font-bold text-gray-900"></span></div>
                        </div>
                        <div id="result-actions" class="px-4 pb-4 flex gap-2"></div>
                    </div>
                </div>

                <div id="scan-error" class="hidden p-3 bg-red-50 border border-red-200 text-red-700 text-xs rounded-lg"></div>
            </div>
        </div>

        {{-- Slot Overview --}}
        <div class="space-y-4">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="text-sm font-semibold text-gray-900">Slot Status</h2>
                </div>
                <div class="p-4 space-y-3">
                    @foreach(['available' => ['text-green-700', 'bg-green-50'], 'reserved' => ['text-yellow-700', 'bg-yellow-50'], 'occupied' => ['text-red-700', 'bg-red-50'], 'maintenance' => ['text-gray-600', 'bg-gray-100']] as $status => [$text, $bg])
                        <div class="flex items-center justify-between p-3 {{ $bg }} rounded-lg">
                            <span class="text-xs font-semibold {{ $text }} capitalize">{{ $status }}</span>
                            <span class="text-lg font-bold {{ $text }}">{{ $slotStats[$status] ?? 0 }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="text-sm font-semibold text-gray-900">Slot Types</h2>
                </div>
                <div class="p-4 space-y-3">
                    @forelse($slotTypes as $type => $count)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="text-xs font-semibold text-gray-700 capitalize">{{ $type }}</span>
                            <span class="text-lg font-bold text-gray-900">{{ $count }}</span>
                        </div>
                    @empty
                        <p class="text-xs text-gray-400 italic">No slot types found.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Active Reservations Table --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="text-sm font-semibold text-gray-900">Active & Pending Reservations</h2>
            <p class="text-xs text-gray-500 mt-0.5">All current reservations across all locations.</p>
        </div>
        <div class="p-4">
            @if ($reservations->isEmpty())
                <p class="text-sm text-gray-400 italic text-center py-6">No active reservations at the moment.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs">
                        <thead>
                            <tr class="text-left text-gray-400 border-b border-gray-100 uppercase tracking-wider text-[10px]">
                                <th class="py-3 pr-4 font-bold">Customer</th>
                                <th class="py-3 pr-4 font-bold">Vehicle</th>
                                <th class="py-3 pr-4 font-bold">Location</th>
                                <th class="py-3 pr-4 font-bold">Slot</th>
                                <th class="py-3 pr-4 font-bold">Time</th>
                                <th class="py-3 pr-4 font-bold">Amount</th>
                                <th class="py-3 pr-4 font-bold">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach ($reservations as $r)
                                @php
                                    $statusColor = [
                                        'pending' => 'bg-yellow-50 text-yellow-700',
                                        'active'  => 'bg-green-50 text-green-700',
                                    ][$r->status] ?? 'bg-gray-100 text-gray-600';
                                @endphp
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="py-3 pr-4 font-semibold text-gray-900">{{ $r->user?->name ?? '—' }}</td>
                                    <td class="py-3 pr-4 text-gray-600">{{ $r->vehicle?->plate_num ?? '—' }}</td>
                                    <td class="py-3 pr-4 text-gray-600">{{ $r->slot?->location?->name ?? '—' }}</td>
                                    <td class="py-3 pr-4 text-gray-600">
                                        @if($r->slot) #{{ $r->slot->slot_number }} ({{ ucfirst($r->slot->type) }}) @else — @endif
                                    </td>
                                    <td class="py-3 pr-4 text-gray-600">
                                        {{ $r->start_time?->format('h:i A') }} – {{ $r->end_time?->format('h:i A') }}
                                    </td>
                                    <td class="py-3 pr-4 text-gray-900 font-semibold">
                                        @if ($r->is_free)
                                            <span class="text-green-600">Free</span>
                                        @else
                                            ₱{{ number_format($r->total_amount, 2) }}
                                        @endif
                                    </td>
                                    <td class="py-3 pr-4">
                                        <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[10px] font-bold capitalize {{ $statusColor }}">
                                            {{ $r->status }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jsQR/1.4.0/jsQR.min.js"></script>
<script>
    let stream = null;
    let scanInterval = null;
    let currentReservationId = null;

    function startScanner() {
        navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } })
            .then(s => {
                stream = s;
                const video = document.getElementById('scanner-video');
                video.srcObject = stream;
                video.play();
                document.getElementById('scanner-placeholder').style.display = 'none';
                document.getElementById('start-scanner').classList.add('hidden');
                document.getElementById('stop-scanner').classList.remove('hidden');
                scanInterval = setInterval(scanFrame, 300);
            })
            .catch(() => showError('Camera access denied. Please allow camera permissions.'));
    }

    function stopScanner() {
        if (stream) stream.getTracks().forEach(t => t.stop());
        clearInterval(scanInterval);
        document.getElementById('scanner-placeholder').style.display = 'flex';
        document.getElementById('start-scanner').classList.remove('hidden');
        document.getElementById('stop-scanner').classList.add('hidden');
    }

    function scanFrame() {
        const video = document.getElementById('scanner-video');
        if (video.readyState !== video.HAVE_ENOUGH_DATA) return;

        const canvas = document.createElement('canvas');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        const ctx = canvas.getContext('2d');
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
        const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
        const code = jsQR(imageData.data, imageData.width, imageData.height);

        if (code) {
            stopScanner();
            processQr(code.data);
        }
    }

    function processQr(data) {
        fetch('{{ route("staff.scan") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ qr_data: data })
        })
        .then(r => r.json())
        .then(res => {
            if (!res.success) return showError(res.message);

            const r = res.reservation;
            currentReservationId = r.id;

            document.getElementById('scan-error').classList.add('hidden');
            document.getElementById('scan-result').classList.remove('hidden');

            document.getElementById('result-name').textContent = r.user ?? '—';
            document.getElementById('result-location').textContent = r.location ?? '—';
            document.getElementById('result-vehicle').textContent = r.vehicle ?? '—';
            document.getElementById('result-slot').textContent = r.slot ?? '—';
            document.getElementById('result-start').textContent = r.start_time ?? '—';
            document.getElementById('result-end').textContent = r.end_time ?? '—';
            document.getElementById('result-free-hours').textContent = r.free_hours > 0 ? r.free_hours + ' hrs' : 'None';
            document.getElementById('result-amount').textContent = r.is_free ? 'Free' : '₱' + parseFloat(r.total_amount).toFixed(2);

            const statusEl = document.getElementById('result-status');
            statusEl.textContent = r.status.charAt(0).toUpperCase() + r.status.slice(1);
            statusEl.className = 'text-[11px] font-bold px-2 py-0.5 rounded-full ' +
                (r.status === 'active' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700');

            const actions = document.getElementById('result-actions');
            actions.innerHTML = '';

            if (r.status === 'pending') {
                actions.innerHTML = `
                    <button onclick="updateStatus('active')"
                        class="flex-1 py-2 px-3 bg-green-600 hover:bg-green-700 text-white text-xs font-semibold rounded-lg transition">
                        Check In
                    </button>`;
            } else if (r.status === 'active') {
                actions.innerHTML = `
                    <button onclick="updateStatus('completed')"
                        class="flex-1 py-2 px-3 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg transition">
                        Check Out
                    </button>`;
            }
        })
        .catch(() => showError('Failed to process QR code. Please try again.'));
    }

    function updateStatus(status) {
        fetch(`/staff/reservations/${currentReservationId}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ status })
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                const statusEl = document.getElementById('result-status');
                statusEl.textContent = res.status.charAt(0).toUpperCase() + res.status.slice(1);
                statusEl.className = 'text-[11px] font-bold px-2 py-0.5 rounded-full ' +
                    (res.status === 'active' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700');
                document.getElementById('result-actions').innerHTML = '';
                setTimeout(() => location.reload(), 1200);
            }
        });
    }

    function showError(msg) {
        const el = document.getElementById('scan-error');
        el.textContent = msg;
        el.classList.remove('hidden');
        document.getElementById('scan-result').classList.add('hidden');
    }
</script>
@endsection