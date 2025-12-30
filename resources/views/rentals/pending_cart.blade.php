<x-app-layout>
    <div class="min-h-screen bg-slate-50 py-12 italic">
        <div class="max-w-4xl mx-auto px-4">
            <div class="mb-8">
                <h2 class="text-2xl font-black text-slate-800 uppercase italic leading-none">Selesaikan Pembayaran</h2>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2">Pesanan #ORD-{{ $rental->id }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="md:col-span-2">
                    <div class="bg-white p-6 rounded-[32px] shadow-sm border border-slate-100 flex gap-6">
                        <img src="{{ asset('storage/' . $rental->clothe->image) }}" class="w-24 h-32 object-cover rounded-2xl shadow-md">
                        <div class="flex-1">
                            <p class="text-[10px] font-black text-indigo-600 uppercase mb-1">{{ $rental->clothe->series_name }}</p>
                            <h3 class="text-xl font-black text-slate-800 uppercase leading-none mb-3">{{ $rental->clothe->character_name }}</h3>
                            <div class="space-y-1">
                                <p class="text-[10px] font-bold text-slate-400 uppercase">UKURAN: <span class="text-slate-700">{{ $rental->size }}</span></p>
                                <p class="text-[10px] font-bold text-slate-400 uppercase">DURASI: <span class="text-slate-700">{{ $rental->start_date }} s/d {{ $rental->end_date }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-1">
                    <div class="bg-white p-8 rounded-[32px] shadow-xl border border-slate-100">
                        <h4 class="text-xs font-black text-slate-800 uppercase mb-6 italic tracking-widest">Ringkasan</h4>
                        <div class="flex justify-between items-center mb-6">
                            <span class="text-xs font-black text-slate-800 uppercase italic">Total Bayar</span>
                            <span class="text-xl font-black text-indigo-600 italic">Rp{{ number_format($rental->total_price, 0, ',', '.') }}</span>
                        </div>
                        <button id="pay-button" class="w-full py-4 bg-slate-900 text-white rounded-2xl font-black uppercase text-[11px] tracking-widest hover:bg-indigo-600 transition-all shadow-lg">
                            Buka Jendela Pembayaran
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script type="text/javascript">
    const payButton = document.getElementById('pay-button');
    payButton.onclick = function(e) {
        e.preventDefault();
        
        window.snap.pay('{{ $rental->snap_token }}', {
            onSuccess: function(result) { window.location.href = "{{ route('user.rentals') }}"; },
            onPending: function(result) { window.location.href = "{{ route('user.rentals') }}"; },
            onError: function(result) { 
                alert("Pembayaran gagal! Token mungkin sudah expired. Silakan refresh halaman ini."); 
            },
            onClose: function() { console.log('customer closed the popup without finishing the payment'); }
        });
    };
</script>
</x-app-layout>