<x-app-layout>
    {{-- Midtrans Snap.js --}}
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>

    {{-- Leaflet Maps Assets --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&family=Outfit:wght@300;400;600;900&display=swap');

        :root { --primary: #6366f1; --accent: #a855f7; --dark: #0f172a; }

        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f8fafc; }
        .luxury-text { font-family: 'Outfit', sans-serif; }

        .mesh-gradient {
            background: #f8fafc;
            background-image: radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.08) 0px, transparent 50%),
                              radial-gradient(at 100% 0%, rgba(192, 132, 252, 0.08) 0px, transparent 50%);
            min-height: 100vh;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.7);
            transition: all 0.5s cubic-bezier(0.2, 0.8, 0.2, 1);
        }

        .status-badge {
            display: inline-flex; align-items: center; padding: 8px 20px; border-radius: 99px;
            font-size: 10px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.15em;
        }

        .status-settlement { background: #ecfdf5; color: #059669; border: 1px solid #10b98130; }
        .status-pending { background: #fff7ed; color: #ea580c; border: 1px solid #f9731630; }

        .leaflet-container { border-radius: 24px; z-index: 1; filter: contrast(1.1); }
    </style>

    <div class="mesh-gradient py-16 px-4 md:px-8">
        <div class="max-w-5xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-10 mb-20">
                <h2 class="text-4xl font-black text-slate-900 tracking-tighter luxury-text uppercase leading-none">
                    MY <span class="text-indigo-600">HISTORY</span>
                </h2>
                <a href="{{ route('dashboard') }}" class="px-8 py-4 bg-white rounded-2xl text-[11px] font-black uppercase tracking-widest text-slate-600 border border-slate-100 shadow-sm hover:border-indigo-100 transition-all">
                    ← Back to Archive
                </a>
            </div>

            <div class="space-y-10">
                @forelse ($rentals as $rental)
                    <div class="glass-card rounded-[48px] p-4 md:p-8">
                        <div class="flex flex-col md:flex-row items-start gap-10">

                            {{-- Image Section --}}
                            <div class="relative w-36 h-48 rounded-[32px] overflow-hidden shadow-2xl border-[6px] border-white flex-shrink-0">
                                @if ($rental->clothe && $rental->clothe->image)
                                    <img src="{{ asset('storage/' . $rental->clothe->image) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-slate-100 flex items-center justify-center italic text-[10px] text-slate-400 uppercase">No Image</div>
                                @endif
                            </div>

                            <div class="flex-1">
                                <div class="inline-flex items-center gap-3 px-3 py-1 bg-indigo-50 rounded-full mb-4">
                                    <span class="text-[9px] font-black text-indigo-600 uppercase tracking-widest">{{ $rental->clothe->series_name ?? 'Collection' }}</span>
                                </div>
                                <h3 class="text-3xl font-black text-slate-800 uppercase mb-6 luxury-text leading-none">
                                    {{ $rental->clothe->character_name ?? 'Kostum Dihapus' }}
                                </h3>

                                {{-- Penalty UI Section --}}
                                @if ($rental->penalty_fee > 0)
                                    <div class="p-5 bg-rose-50 border border-rose-100 rounded-[32px] flex flex-col md:flex-row justify-between items-center gap-4 mb-6 transition-all">
                                        <div class="text-center md:text-left">
                                            <p class="text-[10px] font-black text-rose-600 uppercase tracking-widest mb-1">Denda Terdeteksi</p>
                                            <p class="text-xs text-rose-500 italic">Terlambat mengembalikan kostum.</p>
                                        </div>
                                        <div class="flex flex-col items-center md:items-end gap-2">
                                            <p class="text-2xl font-black text-rose-600 luxury-text">IDR {{ number_format($rental->penalty_fee, 0, ',', '.') }}</p>
                                            <button onclick="payPenalty('{{ $rental->id }}')" class="px-6 py-2 bg-rose-600 text-white text-[10px] font-black rounded-full uppercase tracking-widest hover:bg-rose-700 shadow-lg shadow-rose-200 transition-all active:scale-95">
                                                Pay Penalty Now
                                            </button>
                                        </div>
                                    </div>
                                @endif

                                {{-- Info Grid --}}
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                                    <div class="px-4 py-3 bg-white/90 rounded-2xl border border-white">
                                        <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Spec</p>
                                        <p class="text-sm font-black text-slate-900 uppercase">SIZE: {{ $rental->size }}</p>
                                    </div>
                                    <div class="px-4 py-3 bg-white/90 rounded-2xl border border-white">
                                        <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Duration</p>
                                        <p class="text-sm font-black text-slate-900 uppercase">{{ $rental->duration ?? '0' }} DAYS</p>
                                    </div>
                                    <div class="px-4 py-3 bg-white/90 rounded-2xl border border-white col-span-2 md:col-span-1">
                                        <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Paid</p>
                                        <p class="text-sm font-black text-indigo-600">IDR {{ number_format($rental->total_price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Status & Map --}}
                            <div class="w-full md:w-64 flex flex-col items-center md:items-end gap-6">
                                <div class="status-badge {{ $rental->status_payment === 'settlement' ? 'status-settlement' : 'status-pending' }}">
                                    {{ $rental->status_payment === 'settlement' ? '• Settlement' : '• Waiting' }}
                                </div>

                                <div class="w-full text-right">
                                    <p class="text-[10px] font-black text-slate-700 uppercase mb-2 tracking-widest">{{ str_replace('_', ' ', $rental->status_barang) }}</p>
                                    <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden flex mb-4">
                                        @php
                                            $progress = 'w-1/4';
                                            if ($rental->status_payment === 'settlement' && $rental->status_barang === 'waiting') $progress = 'w-2/4';
                                            if ($rental->status_barang === 'picked_up') $progress = 'w-3/4';
                                            if (in_array($rental->status_barang, ['returned', 'selesai'])) $progress = 'w-full';
                                        @endphp
                                        <div class="h-full bg-gradient-to-r from-indigo-500 to-purple-500 transition-all duration-1000 {{ $progress }}"></div>
                                    </div>

                                    {{-- Map Tracking (Hanya muncul jika sudah bayar dan barang belum balik) --}}
                                    @if ($rental->status_payment === 'settlement' && in_array($rental->status_barang, ['waiting', 'picked_up']))
                                        <div class="w-full mt-6 rounded-3xl overflow-hidden shadow-inner border border-slate-100">
                                            <div id="map-{{ $rental->id }}" class="w-full h-64 md:h-72"></div>
                                        </div>
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                var shopPos = [-6.9764, 107.6327]; // Koordinat Toko
                                                
                                                // MENGGUNAKAN DATA DARI TABEL RENTAL (SNAPSHOT)
                                                var targetLat = {{ $rental->user_lat ?? 'null' }};
                                                var targetLng = {{ $rental->user_lng ?? 'null' }};
                                                var courierLat = {{ $rental->current_lat ?? -6.9764 }};
                                                var courierLng = {{ $rental->current_lng ?? 107.6327 }};

                                                if (targetLat && targetLng) {
                                                    var targetPos = [targetLat, targetLng];
                                                    var courierPos = [courierLat, courierLng];

                                                    var map = L.map('map-{{ $rental->id }}', {
                                                        zoomControl: true, attributionControl: false
                                                    }).setView(courierPos, 13);

                                                    L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png').addTo(map);

                                                    // Ikon Kustom
                                                    var redIcon = new L.Icon({
                                                        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                                                        iconSize: [25, 41], iconAnchor: [12, 41]
                                                    });

                                                    // Marker Toko
                                                    L.circleMarker(shopPos, { radius: 6, color: '#6366f1', fillOpacity: 1 }).addTo(map).bindPopup("Studio K-RENT");
                                                    
                                                    // Marker Alamat User (SNAPSHOT)
                                                    L.marker(targetPos, { icon: redIcon }).addTo(map).bindPopup("Alamat Tujuan");

                                                    // Marker Kurir
                                                    var courierMarker = L.marker(courierPos).addTo(map).bindPopup("Posisi Paket");

                                                    // Garis pandu
                                                    L.polyline([shopPos, targetPos], { color: '#6366f1', weight: 1, dashArray: '5', opacity: 0.4 }).addTo(map);

                                                    // Focus semua titik
                                                    var group = new L.featureGroup([L.circleMarker(shopPos), L.marker(targetPos), courierMarker]);
                                                    map.fitBounds(group.getBounds(), { padding: [40, 40] });
                                                }
                                            });
                                        </script>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="glass-card rounded-[60px] py-40 text-center">
                        <h4 class="text-xl font-bold text-slate-400 uppercase tracking-[0.4em] italic leading-none mb-4">No History</h4>
                        <p class="text-xs text-slate-300 uppercase tracking-widest font-black">Mulai sewa kostum pertamamu hari ini</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Midtrans AJAX Script --}}
    <script>
        function payPenalty(rentalId) {
            fetch(`/rental/pay-penalty/${rentalId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                } else {
                    window.snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            alert("Denda Berhasil Dilunasi!");
                            location.reload();
                        },
                        onPending: function(result) { alert("Selesaikan pembayaran denda Anda."); },
                        onError: function(result) { alert("Pembayaran gagal diproses."); }
                    });
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
</x-app-layout>