<x-app-layout>
    <style>
        .mesh-gradient {
            background-color: #f8fafc;
            background-image:
                radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(192, 132, 252, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(251, 146, 60, 0.1) 0px, transparent 50%),
                radial-gradient(at 0% 100%, rgba(45, 212, 191, 0.1) 0px, transparent 50%);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        /* Animasi loading saat AJAX bekerja */
        .loading-overlay {
            opacity: 0.5;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }
    </style>

    <div class="min-h-screen mesh-gradient">
        <x-slot name="header">
            <div class="flex items-center justify-between py-2">
                <div class="flex items-center space-x-4">
                    <div class="p-4 bg-gradient-to-br from-indigo-600 to-purple-700 rounded-[22px] shadow-xl shadow-indigo-200">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="font-black text-2xl text-slate-800 tracking-tight uppercase leading-none">
                            {{ Auth::user()->shop_name ?? 'Nama Toko Belum Diatur' }}
                        </h2>
                        <p class="text-[11px] font-bold text-indigo-600 tracking-[0.25em] uppercase mt-1">
                            Admin Dashboard • {{ Auth::user()->name }}
                        </p>
                    </div>
                </div>

                <a href="{{ route('admin.settings') }}" class="p-3 bg-white border border-slate-200 rounded-2xl text-slate-400 hover:text-indigo-600 hover:border-indigo-200 transition-all shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </a>
            </div>
        </x-slot>

        <div class="py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                    <div class="stat-card relative overflow-hidden glass-card p-6 rounded-[35px] shadow-xl transition-all duration-300">
                        <div class="p-3 bg-indigo-600 w-fit rounded-2xl mb-4 shadow-lg shadow-indigo-100">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="text-[10px] font-black text-indigo-600 uppercase tracking-widest mb-1">Total Pendapatan</div>
                        <div class="text-2xl font-black text-slate-800">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</div>
                    </div>

                    <div class="stat-card relative overflow-hidden glass-card p-6 rounded-[35px] shadow-xl transition-all duration-300">
                        <div class="p-3 bg-emerald-500 w-fit rounded-2xl mb-4 shadow-lg shadow-emerald-100">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <div class="text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1">Total Transaksi</div>
                        <div class="text-2xl font-black text-slate-800">{{ $total_transaksi }}</div>
                    </div>

                    <div class="stat-card relative overflow-hidden glass-card p-6 rounded-[35px] shadow-xl transition-all duration-300">
                        <div class="p-3 bg-purple-500 w-fit rounded-2xl mb-4 shadow-lg shadow-purple-100">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div class="text-[10px] font-black text-purple-600 uppercase tracking-widest mb-1">Total Pelanggan</div>
                        <div class="text-2xl font-black text-slate-800">{{ $total_client }}</div>
                    </div>

                    <div class="stat-card relative overflow-hidden glass-card p-6 rounded-[35px] shadow-xl transition-all duration-300">
                        <div class="p-3 bg-orange-500 w-fit rounded-2xl mb-4 shadow-lg shadow-orange-100">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM9 7h6a2 2 0 012 2v11a2 2 0 01-2 2H9a2 2 0 01-2-2V9a2 2 0 012-2z" />
                            </svg>
                        </div>
                        <div class="text-[10px] font-black text-orange-600 uppercase tracking-widest mb-1">Katalog Baju</div>
                        <div class="text-2xl font-black text-slate-800">{{ $total_baju }}</div>
                    </div>
                </div>

                <div class="glass-card rounded-[45px] shadow-2xl overflow-hidden border border-white">
                    <div class="p-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <h3 class="font-black text-xl text-slate-800 tracking-tight">Transaksi Terakhir</h3>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-[0.2em] mt-1">Monitoring pesanan terbaru</p>
                        </div>
                        {{-- <a href="{{ route('admin.settings') }}" class="px-5 py-2.5 bg-slate-100 text-slate-600 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-200 transition-all">
                            ⚙️ Atur Toko
                        </a> --}}
                    </div>

                    <div id="transaction-table-container">
                        <div class="overflow-x-auto px-6 pb-8">
                            <table class="w-full">
                                <thead>
                                    <tr class="text-slate-400 text-[11px] uppercase tracking-[0.25em] font-black border-b border-slate-100">
                                        <th class="px-6 py-4 text-left">Invoice</th>
                                        <th class="px-6 py-4 text-left">Pelanggan</th>
                                        <th class="px-6 py-4 text-left">Kostum</th>
                                        <th class="px-6 py-4 text-left">Total</th>
                                        <th class="px-6 py-4 text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @forelse($recent_rentals as $rent)
                                        <tr class="hover:bg-white/60 transition-all duration-300">
                                            <td class="px-6 py-6 font-mono text-xs font-bold text-indigo-600">#{{ $rent->order_id }}</td>
                                            <td class="px-6 py-6 font-black text-slate-700 text-sm">{{ $rent->user->name }}</td>
                                            <td class="px-6 py-6 text-sm text-slate-500 font-bold italic">{{ $rent->clothe->character_name }}</td>
                                            <td class="px-6 py-6 text-sm font-black text-slate-800">Rp {{ number_format($rent->total_price, 0, ',', '.') }}</td>
                                            <td class="px-6 py-6 text-center">
                                                <span class="px-4 py-2 rounded-2xl text-[10px] font-black uppercase {{ $rent->status_payment == 'settlement' ? 'bg-emerald-500' : 'bg-amber-400' }} text-white shadow-lg shadow-opacity-20">
                                                    {{ $rent->status_payment == 'settlement' ? 'Sukses' : 'Pending' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-12 text-center">
                                                <p class="text-slate-400 font-bold uppercase text-[10px] tracking-widest">Belum ada transaksi</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <div class="mt-4 ajax-pagination-links">
                                {{ $recent_rentals->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Berjalan saat link pagination diklik
            $(document).on('click', '.ajax-pagination-links a', function(event) {
                event.preventDefault(); // Stop page reload
                
                let pageUrl = $(this).attr('href');
                fetchTransactions(pageUrl);
                
                // Update URL di browser tanpa reload (bagus untuk SEO/Copy-paste link)
                window.history.pushState("", "", pageUrl);
            });

            function fetchTransactions(url) {
                // Beri efek loading
                $('#transaction-table-container').addClass('loading-overlay');

                $.ajax({
                    url: url,
                    type: "get",
                    datatype: "html"
                }).done(function(data) {
                    // Ambil konten dari ID yang sama di respon HTML
                    let tableContent = $(data).find('#transaction-table-container').html();
                    
                    // Masukkan konten baru ke kontainer
                    $('#transaction-table-container').html(tableContent);
                    
                    // Hilangkan efek loading
                    $('#transaction-table-container').removeClass('loading-overlay');
                    
                    // Scroll smooth ke tabel
                    $('html, body').animate({
                        scrollTop: $("#transaction-table-container").offset().top - 100
                    }, 500);

                }).fail(function(jqXHR, ajaxOptions, thrownError) {
                    alert('Gagal memuat data. Silakan coba lagi.');
                    $('#transaction-table-container').removeClass('loading-overlay');
                });
            }
        });
    </script>
</x-app-layout>