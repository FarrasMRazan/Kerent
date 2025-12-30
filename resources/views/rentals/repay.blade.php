<x-app-layout>
    <div class="min-h-screen py-12 bg-slate-50">
        <div class="max-w-3xl mx-auto px-4">
            <div class="glass-card p-8 rounded-[40px] bg-white shadow-xl border border-slate-100">
                <h2 class="text-2xl font-black text-slate-800 uppercase italic mb-6">Lanjutkan Pembayaran</h2>
                
                <div class="flex items-center gap-6 mb-8 p-6 bg-slate-50 rounded-3xl">
                    <img src="{{ asset('storage/'.$rental->clothe->image) }}" class="w-24 h-24 object-cover rounded-2xl">
                    <div>
                        <p class="text-[10px] font-black text-indigo-600 uppercase">{{ $rental->clothe->series_name }}</p>
                        <h3 class="text-xl font-black text-slate-800 uppercase">{{ $rental->clothe->character_name }}</h3>
                        <p class="text-sm font-bold text-slate-500">Size: {{ $rental->size }} | {{ $rental->start_date }}</p>
                    </div>
                </div>

                <div class="flex justify-between items-center mb-10">
                    <span class="font-black text-slate-400 uppercase tracking-widest text-xs">Total yang harus dibayar</span>
                    <span class="text-3xl font-black text-slate-900 italic">Rp{{ number_format($rental->total_price, 0, ',', '.') }}</span>
                </div>

                <button id="pay-button" class="w-full py-5 bg-indigo-600 text-white rounded-[24px] font-black uppercase tracking-widest hover:bg-indigo-700 shadow-lg shadow-indigo-100 transition-all">
                    Bayar Sekarang via Midtrans
                </button>
            </div>
        </div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script type="text/javascript">
        const payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function (result) { window.location.href = "{{ route('user.rentals') }}"; },
                onPending: function (result) { window.location.href = "{{ route('user.rentals') }}"; },
                onError: function (result) { alert("Pembayaran gagal!"); },
                onClose: function () { alert('Anda menutup layar pembayaran sebelum selesai.'); }
            });
        });
    </script>
</x-app-layout>