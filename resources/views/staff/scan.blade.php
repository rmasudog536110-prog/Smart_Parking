@extends('layouts.app')

@section('title', 'Scan QR Code')

@section('content')
<div class="p-6 max-w-3xl mx-auto space-y-6">

    <div class="mb-0 ml-2 p-3">
        <a href="{{ route('staff.dashboard') }}" class="flex items-center gap-2 text-sm text-gray-500 hover:text-blue-600">
        <i class="fa-solid fa-arrow-left"></i>
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="text-sm font-semibold text-black">QR Scanner</h2>
        </div>

        <div class="p-6 space-y-4">

            {{-- Scanner --}}
            <div class="relative w-full rounded-xl overflow-hidden bg-black" style="height: 320px;">
                <video id="scanner-video" class="w-full h-full object-cover" playsinline></video>

                <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                    <div class="w-56 h-56 border-2 border-white/60 rounded-xl relative">
                        <span class="absolute top-0 left-0 w-6 h-6 border-t-4 border-l-4 border-blue-500"></span>
                        <span class="absolute top-0 right-0 w-6 h-6 border-t-4 border-r-4 border-blue-500"></span>
                        <span class="absolute bottom-0 left-0 w-6 h-6 border-b-4 border-l-4 border-blue-500"></span>
                        <span class="absolute bottom-0 right-0 w-6 h-6 border-b-4 border-r-4 border-blue-500"></span>
                    </div>
                </div>

                <div id="scanner-placeholder"
                     class="absolute inset-0 flex flex-col items-center justify-center text-white bg-black">
                    <i class="fa-solid fa-qrcode text-4xl mb-3 text-gray-400"></i>
                    <p class="text-sm text-gray-400">Camera not started</p>
                </div>
            </div>

            {{-- Buttons --}}
            <div class="flex gap-3">
                <button id="start-scanner"
                        onclick="startScanner()"
                        class="flex-1 py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition cursor-pointer">
                    Start Scanner
                </button>

                <button id="stop-scanner"
                        onclick="stopScanner()"
                        class="flex-1 py-2 px-4 bg-gray-200 hover:bg-gray-300 text-black text-sm font-semibold rounded-lg transition hidden">
                    Stop
                </button>
            </div>

            {{-- Result --}}
            <div id="scan-result" class="hidden">
                <div class="border border-gray-200 rounded-xl overflow-hidden">

                    <div class="px-4 py-3 flex justify-between items-center bg-gray-50">
                        <div>
                            <p id="result-name" class="font-semibold text-sm text-black"></p>
                            <p id="result-location" class="text-xs text-gray-500"></p>
                        </div>
                        <span id="result-status"
                              class="text-[11px] font-bold px-2 py-0.5 rounded-full"></span>
                    </div>

                    <div class="px-4 py-4 space-y-2 text-xs">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Vehicle</span>
                            <span id="result-vehicle" class="font-medium text-black"></span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-500">Slot</span>
                            <span id="result-slot" class="font-medium text-black"></span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-500">Amount Due</span>
                            <span id="result-amount" class="font-bold text-black"></span>
                        </div>
                    </div>

                    <div id="result-actions" class="px-4 pb-4 flex gap-2"></div>
                </div>
            </div>

            <div id="scan-error"
                 class="hidden p-3 bg-red-50 border border-red-200 text-red-700 text-xs rounded-lg"></div>

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
        .catch(() => showError('Camera access denied.'));
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
    ctx.drawImage(video, 0, 0);
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

        document.getElementById('scan-result').classList.remove('hidden');

        document.getElementById('result-name').textContent = r.user;
        document.getElementById('result-location').textContent = r.location;
        document.getElementById('result-vehicle').textContent = r.vehicle;
        document.getElementById('result-slot').textContent = r.slot;
        document.getElementById('result-amount').textContent =
            r.is_free ? 'Free' : '₱' + parseFloat(r.total_amount).toFixed(2);

        const statusEl = document.getElementById('result-status');
        statusEl.textContent = r.status;

        statusEl.className =
            'text-[11px] font-bold px-2 py-0.5 rounded-full ' +
            (r.status === 'active'
                ? 'bg-emerald-100 text-emerald-700'
                : 'bg-blue-100 text-blue-700');

        const actions = document.getElementById('result-actions');
        actions.innerHTML = '';

        if (r.status === 'pending') {
            actions.innerHTML =
                `<button onclick="updateStatus('active')"
                    class="flex-1 py-2 px-3 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-lg">
                    Check In
                </button>`;
        } else if (r.status === 'active') {
            actions.innerHTML =
                `<button onclick="updateStatus('completed')"
                    class="flex-1 py-2 px-3 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg">
                    Check Out
                </button>`;
        }
    });
}

function showError(msg) {
    const el = document.getElementById('scan-error');
    el.textContent = msg;
    el.classList.remove('hidden');
}
</script>
@endsection