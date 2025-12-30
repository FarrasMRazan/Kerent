<x-app-layout>
    <div class="min-h-screen bg-slate-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h2
                        class="text-3xl md:text-4xl font-black text-slate-800 uppercase italic tracking-tighter leading-none">
                        Riwayat Sewa Saya
                    </h2>
                    <p class="text-slate-500 text-[10px] font-bold uppercase tracking-[0.3em] mt-4 italic">
                        Pantau status pesanan dan selesaikan pembayaran kostum Anda
                    </p>
                </div>
                <div class="flex gap-2">
                    <span
                        class="px-3 py-1 bg-white border border-slate-200 rounded-lg text-[9px] font-black uppercase text-slate-400">
                        Total Pesanan: {{ $rentals->total() }}
                    </span>
                </div>
            </div>

            <div class="bg-white rounded-[32px] shadow-2xl shadow-slate-200/60 overflow-hidden border border-slate-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse italic">
                        <thead>
                            <tr class="bg-slate-50/80 border-b border-slate-100">
                                <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">
                                    Item Kostum</th>
                                <th
                                    class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400 text-center">
                                    Periode Sewa</th>
                                <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">
                                    Total Tagihan</th>
                                <th
                                    class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400 text-center">
                                    Status Pembayaran</th>
                                <th
                                    class="px-6 py-5 text-center text-[10px] font-black uppercase tracking-widest text-slate-400">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse ($rentals as $rental)
                                <tr class="hover:bg-slate-50/50 transition-all duration-300">
                                    <td class="px-6 py-6">
                                        <div class="flex items-center gap-4">
                                            <div class="relative group">
                                                <img src="{{ asset('storage/' . $rental->clothe->image) }}"
                                                    class="w-16 h-20 object-cover rounded-2xl shadow-md border-2 border-white group-hover:scale-105 transition-transform">
                                                <div
                                                    class="absolute -top-2 -right-2 bg-indigo-600 text-white text-[8px] font-black px-2 py-1 rounded-lg uppercase">
                                                    {{ $rental->size }}
                                                </div>
                                            </div>
                                            <div>
                                                <h4 class="font-black text-slate-800 text-sm uppercase leading-tight">
                                                    {{ $rental->clothe->character_name }}</h4>
                                                <p
                                                    class="text-[9px] text-slate-400 font-bold uppercase mt-1 tracking-wider">
                                                    Order ID: #{{ $rental->order_id }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-6 text-center">
                                        <div class="flex flex-col">
                                            <span class="text-[11px] font-black text-slate-700 uppercase leading-none">
                                                {{ \Carbon\Carbon::parse($rental->start_date)->format('d M Y') }}
                                            </span>
                                            <span
                                                class="text-[9px] font-bold text-slate-400 uppercase my-1">sampai</span>
                                            <span class="text-[11px] font-black text-slate-700 uppercase leading-none">
                                                {{ \Carbon\Carbon::parse($rental->start_date)->addDays($rental->duration)->format('d M Y') }}
                                            </span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-6">
                                        <span class="font-black text-indigo-600 text-sm tracking-tighter">
                                            Rp{{ number_format($rental->total_price, 0, ',', '.') }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-6 text-center">
                                        <span
                                            class="inline-block px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest shadow-sm border
                                            {{ $rental->status_payment == 'pending'
                                                ? 'bg-amber-100 text-amber-600 border-amber-200'
                                                : 'bg-emerald-100 text-emerald-600 border-emerald-200' }}">
                                            {{ $rental->status_payment == 'pending' ? 'Menunggu Bayar' : 'Sudah Lunas' }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-6 text-center">
                                        @if ($rental->status_payment == 'pending')
                                            <button onclick="bayarSekarang('{{ $rental->snap_token }}')"
                                                class="group relative inline-flex items-center gap-2 px-6 py-3 bg-slate-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-xl active:scale-95">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="3"
                                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                                </svg>
                                                Bayar Sekarang
                                            </button>
                                        @else
                                            <div class="flex items-center justify-center gap-1.5 text-emerald-500">
                                                <div class="bg-emerald-100 p-1 rounded-full">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                                <span
                                                    class="text-[10px] font-black uppercase tracking-widest italic">Tuntas</span>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-24 text-center">
                                        <div class="flex flex-col items-center">
                                            <p class="text-slate-400 font-black uppercase text-xs tracking-[0.2em]">
                                                Belum ada riwayat penyewaan</p>
                                            <a href="{{ route('dashboard') }}"
                                                class="mt-6 px-8 py-3 bg-indigo-600 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-900 transition-all">
                                                Cari Kostum Sekarang
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-8">
                {{ $rentals->links() }}
            </div>
        </div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    <script type="text/javascript">
        function bayarSekarang(snapToken) {
            if (!snapToken || snapToken === "") {
                // Jika token kosong di browser, beri tahu user untuk refresh atau hubungi admin
                alert("Token tidak ditemukan. Silakan coba refresh halaman atau lakukan pemesanan ulang.");
                return;
            }

            window.snap.pay(snapToken, {
                onSuccess: function(result) {
                    window.location.reload();
                },
                onPending: function(result) {
                    window.location.reload();
                },
                onError: function(result) {
                    console.log(result);
                    alert("Pembayaran gagal, token mungkin sudah kadaluwarsa.");
                }
            });
        }
    </script>
</x-app-layout>
