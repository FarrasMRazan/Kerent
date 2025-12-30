<x-app-layout>
    <style>
        .mesh-gradient { 
            background: #f8fafc; 
            background-image: radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.05) 0px, transparent 50%), 
                              radial-gradient(at 100% 0%, rgba(192, 132, 252, 0.05) 0px, transparent 50%); 
        }
        .glass-card { 
            background: rgba(255, 255, 255, 0.8); 
            backdrop-filter: blur(12px); 
            border: 1px solid rgba(255, 255, 255, 0.6); 
        }
    </style>

    <div class="min-h-screen mesh-gradient py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-8 ml-4">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-bold text-slate-500 hover:text-indigo-600 transition-colors group">
                    <div class="p-2 bg-white rounded-lg shadow-sm mr-3 group-hover:bg-indigo-50 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </div>
                    KEMBALI KE KATALOG
                </a>
            </div>

            <div class="glass-card rounded-[48px] overflow-hidden grid grid-cols-1 md:grid-cols-2 gap-12 p-8 md:p-12 shadow-2xl">

                {{-- Bagian Gambar --}}
                <div class="relative group">
                    <div class="aspect-[3/4] rounded-[32px] overflow-hidden shadow-2xl bg-slate-200">
                        <img src="{{ asset('storage/' . $clothe->image) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    </div>
                    <div class="absolute top-6 left-6">
                        <span class="px-5 py-2 bg-indigo-600 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-xl">
                            {{ $clothe->category->name ?? 'Premium' }}
                        </span>
                    </div>
                </div>

                {{-- Bagian Detail & Form --}}
                <div class="flex flex-col">
                    <div class="mb-8">
                        <p class="text-indigo-600 font-black uppercase tracking-[0.3em] text-[11px] mb-2">{{ $clothe->series_name }}</p>
                        <h1 class="text-5xl font-black text-slate-900 uppercase leading-none mb-6 tracking-tighter italic">{{ $clothe->character_name }}</h1>
                    </div>

                    <div class="bg-slate-50/50 rounded-[32px] p-8 border border-slate-200 shadow-inner">
                        <form action="{{ route('cart.store') }}" method="POST" id="rental-form">
                            @csrf
                            <input type="hidden" name="clothe_id" value="{{ $clothe->id }}">
                            <input type="hidden" id="price_per_day" value="{{ $clothe->price_per_day }}">

                            {{-- 1. PILIH UKURAN --}}
                            <div class="mb-8">
                                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4 ml-1 italic">1. Pilih Ukuran Tersedia</label>

                                @php
                                    // Ambil stok awal dari tabel sizes
                                    $activeSizes = $clothe->sizes->pluck('stock', 'size')->toArray();
                                    $displaySizes = ['S', 'M', 'L', 'XL'];

                                    // Kurangi stok berdasarkan transaksi aktif
                                    foreach ($clothe->rentals as $rental) {
                                        if($rental->status_payment === 'settlement' && !in_array($rental->status_barang, ['returned','selesai'])) {
                                            $size = $rental->size;
                                            if(is_array($size)) {
                                                foreach($size as $s) {
                                                    if(isset($activeSizes[$s])) $activeSizes[$s]--;
                                                }
                                            } else {
                                                if(isset($activeSizes[$size])) $activeSizes[$size]--;
                                            }
                                        }
                                    }

                                    $totalStock = array_sum(array_map(fn($v)=>max($v,0), $activeSizes));
                                @endphp

                                <div class="grid grid-cols-4 gap-3">
                                    @foreach($displaySizes as $sz)
                                        @php $stock = max($activeSizes[$sz] ?? 0, 0); @endphp
                                        <div class="relative">
                                            <input type="radio" name="size" id="size-{{ $sz }}" value="{{ $sz }}" 
                                                   class="peer hidden" {{ $stock <= 0 ? 'disabled' : 'required' }}>
                                            
                                            <label for="size-{{ $sz }}" 
                                                   class="block text-center py-3 rounded-2xl border-2 border-white bg-white shadow-sm transition-all 
                                                   {{ $stock > 0 
                                                      ? 'cursor-pointer peer-checked:border-indigo-600 peer-checked:bg-indigo-50 peer-checked:text-indigo-600 hover:bg-slate-50' 
                                                      : 'opacity-40 cursor-not-allowed bg-slate-100' 
                                                   }}">
                                                <span class="block text-sm font-black">{{ $sz }}</span>
                                                <span class="block text-[8px] font-bold uppercase {{ $stock > 0 ? 'text-slate-400' : 'text-rose-500' }}">
                                                    {{ $stock > 0 ? 'Stok: ' . $stock : 'Habis' }}
                                                </span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- 2. DURASI --}}
                            <div class="mb-8">
                                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4 ml-1 italic">2. Durasi Penyewaan</label>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-[9px] font-bold uppercase text-slate-400 mb-2 ml-1">Mulai Sewa</label>
                                        <input type="date" name="start_date" id="start_date" required min="{{ date('Y-m-d') }}"
                                               class="w-full border-none rounded-2xl px-4 py-3 text-sm font-bold text-slate-700 shadow-sm focus:ring-2 focus:ring-indigo-500">
                                    </div>
                                    <div>
                                        <label class="block text-[9px] font-bold uppercase text-slate-400 mb-2 ml-1">Tgl Kembali</label>
                                        <input type="date" name="end_date" id="end_date" required
                                               class="w-full border-none rounded-2xl px-4 py-3 text-sm font-bold text-slate-700 shadow-sm focus:ring-2 focus:ring-indigo-500">
                                    </div>
                                </div>
                            </div>

                            {{-- RINGKASAN BIAYA --}}
                            <div class="mb-8 p-6 bg-white rounded-[24px] border border-slate-100 shadow-sm">
                                <div class="flex justify-between items-center mb-4">
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Estimasi Durasi</span>
                                    <span id="display-days" class="font-black text-indigo-600">0 Hari</span>
                                </div>
                                <div class="h-px bg-slate-100 mb-4"></div>
                                <div class="flex justify-between items-center">
                                    <span class="text-xs font-black text-slate-900 uppercase italic">Total Pembayaran</span>
                                    <span id="display-total" class="text-2xl font-black text-slate-900 tracking-tighter italic">Rp0</span>
                                </div>
                            </div>

                            {{-- TOMBOL ACTION --}}
                            @if($totalStock > 0)
                                <button type="submit" class="w-full bg-slate-900 text-white py-5 rounded-[24px] font-black uppercase tracking-[0.2em] text-[11px] shadow-xl hover:bg-indigo-600 transition-all active:scale-95">
                                    Konfirmasi Sewa & Keranjang
                                </button>
                            @else
                                <button type="button" disabled class="w-full bg-slate-200 text-slate-400 py-5 rounded-[24px] font-black uppercase tracking-[0.2em] text-[11px] cursor-not-allowed">
                                    Kostum Sedang Kosong
                                </button>
                            @endif
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        const startInput = document.getElementById('start_date');
        const endInput = document.getElementById('end_date');
        const pricePerDay = {{ $clothe->price_per_day }};

        function calculate() {
            if (startInput.value && endInput.value) {
                const start = new Date(startInput.value);
                const end = new Date(endInput.value);
                const diffTime = end - start;
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                if (diffDays > 0) {
                    const total = diffDays * pricePerDay;
                    document.getElementById('display-days').innerText = diffDays + ' Hari';
                    document.getElementById('display-total').innerText = 'Rp' + total.toLocaleString('id-ID');
                } else {
                    document.getElementById('display-days').innerText = '0 Hari';
                    document.getElementById('display-total').innerText = 'Rp0';
                }
            }
        }

        startInput.addEventListener('change', () => {
            let date = new Date(startInput.value);
            date.setDate(date.getDate() + 1);
            endInput.min = date.toISOString().split('T')[0];
            calculate();
        });
        endInput.addEventListener('change', calculate);
    </script>
</x-app-layout>
