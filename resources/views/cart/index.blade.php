<x-app-layout>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    @php
        $calculatedTotalPrice = 0;
        foreach($cartItems as $item) {
            $start = \Carbon\Carbon::parse($item->start_date);
            $end = \Carbon\Carbon::parse($item->end_date);
            $days = $start->diffInDays($end);
            $days = $days <= 0 ? 1 : $days;
            $calculatedTotalPrice += ($item->clothe->price_per_day * $days);
        }
    @endphp

    <style>
        .mesh-gradient {
            background-color: #f8fafc;
            background-image:
                radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.1) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(192, 132, 252, 0.1) 0px, transparent 50%);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 99px;
            font-size: 9px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }
    </style>

    <div class="min-h-screen mesh-gradient py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex items-end justify-between mb-10">
                <div>
                    <h2 class="text-3xl font-black text-slate-800 uppercase tracking-tighter leading-none">
                        Keranjang <span class="text-indigo-600">Sewa</span>
                    </h2>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-[0.2em] mt-2">Hitungan otomatis berdasarkan durasi hari</p>
                </div>
                <a href="{{ route('dashboard') }}"
                    class="text-[10px] font-black text-indigo-600 hover:text-indigo-800 uppercase tracking-widest transition-all">
                    ← Kembali Belanja
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2 space-y-4">
                    <div class="glass-card p-6 rounded-[35px] shadow-sm border-2 {{ Auth::user()->address ? 'border-emerald-100' : 'border-rose-100' }}">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 italic">Informasi Pengiriman (Tracking)</h4>
                            @if(Auth::user()->address)
                                <span class="status-pill bg-emerald-50 text-emerald-600 border border-emerald-100 italic">● GPS Aktif</span>
                            @else
                                <span class="status-pill bg-rose-50 text-rose-600 border border-rose-100 italic">● GPS Mati</span>
                            @endif
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="p-3 bg-white rounded-2xl shadow-sm border border-slate-100">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div class="flex-1">
                                @if(Auth::user()->address)
                                    <p class="text-xs font-black text-slate-800 uppercase leading-relaxed">{{ Auth::user()->address }}</p>
                                    <a href="{{ route('profile.edit') }}" class="text-[9px] font-bold text-indigo-600 uppercase tracking-widest mt-2 inline-block hover:underline">Ubah Lokasi GPS →</a>
                                @else
                                    <p class="text-xs font-bold text-rose-500 italic uppercase">Alamat dan Titik GPS Belum Diatur!</p>
                                    <p class="text-[10px] text-slate-400 mt-1">Kami memerlukan titik koordinat untuk fitur pelacakan pengiriman.</p>
                                    <a href="{{ route('profile.edit') }}" class="text-[10px] font-black text-rose-600 uppercase tracking-widest mt-3 inline-block hover:text-rose-800 underline">Atur Lokasi Sekarang →</a>
                                @endif
                            </div>
                        </div>
                    </div>

                    @forelse($cartItems as $item)
                        @php
                            $start = \Carbon\Carbon::parse($item->start_date);
                            $end = \Carbon\Carbon::parse($item->end_date);
                            $duration = $start->diffInDays($end);
                            $duration = $duration == 0 ? 1 : $duration; 
                            $itemTotal = $item->clothe->price_per_day * $duration;
                        @endphp
                        <div class="glass-card p-6 rounded-[35px] shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col sm:flex-row items-center gap-6">
                            <div class="relative group">
                                <img src="{{ asset('storage/' . $item->clothe->image) }}" class="w-28 h-36 object-cover rounded-2xl shadow-lg border-2 border-white">
                            </div>
                            <div class="flex-1">
                                <p class="text-[10px] font-bold text-indigo-500 uppercase tracking-widest mb-1">{{ $item->clothe->series_name }}</p>
                                <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight">{{ $item->clothe->character_name }}</h3>
                                <div class="grid grid-cols-2 gap-y-2 my-3">
                                    <span class="text-xs font-black text-slate-700">UKURAN: {{ $item->size }}</span>
                                    <span class="text-xs font-black text-indigo-600 uppercase">{{ $duration }} Hari</span>
                                </div>
                                <div class="text-lg font-black text-slate-800">Rp {{ number_format($itemTotal, 0, ',', '.') }}</div>
                            </div>
                            <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-4 bg-rose-50 text-rose-500 rounded-2xl hover:bg-rose-500 hover:text-white transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="glass-card p-20 rounded-[50px] text-center">
                            <h3 class="text-lg font-black text-slate-800">Keranjang Kosong</h3>
                        </div>
                    @endforelse
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-slate-900 p-8 rounded-[45px] shadow-2xl sticky top-24 text-white overflow-hidden relative">
                        <div class="absolute -top-10 -right-10 w-32 h-32 bg-indigo-500/20 rounded-full blur-3xl"></div>
                        <h4 class="text-[11px] font-black uppercase tracking-[0.3em] text-indigo-400 mb-8">Ringkasan Pembayaran</h4>
                        <div class="space-y-5 mb-10">
                            <div class="flex justify-between items-center text-sm font-bold">
                                <span class="text-slate-400">Total Biaya Sewa</span>
                                <span class="text-2xl font-black text-white italic">Rp {{ number_format($calculatedTotalPrice, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <button id="pay-button" @if ($cartItems->isEmpty()) disabled @endif
                                class="w-full py-5 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-3xl font-black uppercase text-[11px] tracking-[0.2em] hover:scale-[1.03] active:scale-95 transition-all shadow-xl shadow-indigo-500/30 disabled:opacity-50">
                                Lanjut Pembayaran (Checkout)
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        const payButton = document.getElementById('pay-button');
        
        payButton.addEventListener('click', function () {
            const hasAddress = "{{ Auth::user()->address }}";
            
            if (!hasAddress || hasAddress === "") {
                Swal.fire({
                    title: 'ALAMAT BELUM DIATUR',
                    text: 'Kami memerlukan titik koordinat pengiriman untuk fitur tracking. Silakan lengkapi profil Anda.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#6366f1',
                    confirmButtonText: 'Atur Alamat Sekarang',
                    cancelButtonText: 'Nanti saja'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('profile.edit') }}";
                    }
                });
                return;
            }

            payButton.innerHTML = "Processing...";
            payButton.disabled = true;

            fetch("{{ route('checkout.process') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.snap_token) {
                    window.snap.pay(data.snap_token, {
                        onSuccess: function(result) { window.location.href = "{{ route('user.rentals') }}"; },
                        onPending: function(result) { window.location.href = "{{ route('user.rentals') }}"; },
                        onError: function(result) { 
                            Swal.fire('Error', 'Pembayaran Gagal!', 'error');
                            payButton.innerHTML = "Lanjut Pembayaran (Checkout)";
                            payButton.disabled = false;
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Info',
                        text: data.error || 'Gagal memproses pembayaran',
                        icon: 'info'
                    });
                    payButton.innerHTML = "Lanjut Pembayaran (Checkout)";
                    payButton.disabled = false;
                }
            });
        });
    </script>
</x-app-layout>