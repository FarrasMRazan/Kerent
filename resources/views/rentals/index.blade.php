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
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.03);
        }
        .status-badge {
            font-size: 9px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 4px 10px;
            border-radius: 8px;
        }
    </style>

    <div class="min-h-screen mesh-gradient py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-indigo-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-indigo-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-black text-slate-800 uppercase leading-none">Status Sewa</h2>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Order Tracking System</p>
                    </div>
                </div>
                <a href="{{ route('dashboard') }}" class="inline-flex items-center text-[10px] font-black text-indigo-600 uppercase tracking-widest bg-indigo-50 px-4 py-2 rounded-xl hover:bg-indigo-100 transition-all">
                    ← Katalog
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                <div class="lg:col-span-8">
                    <div class="flex items-center gap-2 mb-6">
                        <div class="h-1 w-4 bg-indigo-600 rounded-full"></div>
                        <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Penyewaan Aktif</h3>
                    </div>
                    
                    <div class="space-y-4">
                        @forelse ($active_rentals as $rent)
                        <div class="glass-card rounded-3xl p-5 transition-all hover:scale-[1.01]">
                            <div class="flex flex-col sm:flex-row gap-6">
                                <div class="relative w-full sm:w-28 flex-shrink-0">
                                    <img src="{{ asset('storage/' . $rent->clothe->image) }}" class="w-full h-36 object-cover rounded-2xl">
                                    <div class="absolute top-2 right-2 bg-white/90 backdrop-blur px-2 py-1 rounded-lg shadow-sm">
                                        <span class="text-[9px] font-black text-slate-800">{{ $rent->size }}</span>
                                    </div>
                                </div>

                                <div class="flex-1 flex flex-col justify-between">
                                    <div>
                                        <div class="flex justify-between items-start mb-1">
                                            <p class="text-[9px] font-black text-indigo-500 uppercase tracking-widest">{{ $rent->clothe->series_name }}</p>
                                            <span class="text-[9px] font-bold text-slate-300">#ORD-{{ $rent->order_id }}</span>
                                        </div>
                                        <h4 class="font-black text-slate-800 uppercase text-lg mb-3">{{ $rent->clothe->character_name }}</h4>
                                        
                                        <div class="flex flex-wrap gap-2">
                                            @if($rent->status_payment == 'settlement')
                                                <span class="status-badge bg-emerald-100 text-emerald-700">💳 PAID</span>
                                            @else
                                                <span class="status-badge bg-amber-100 text-amber-700">⌛ PENDING</span>
                                            @endif
                                            
                                            <span class="status-badge bg-slate-900 text-white">
                                                📦 {{ strtoupper(str_replace('_', ' ', $rent->status_barang)) }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between">
                                        <div>
                                            <p class="text-[8px] font-black text-slate-400 uppercase leading-none mb-1">Estimasi Kembali</p>
                                            <p class="font-black text-slate-700 text-xs">{{ \Carbon\Carbon::parse($rent->end_date)->format('d M Y') }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-[8px] font-black text-slate-400 uppercase leading-none mb-1">Total Biaya</p>
                                            <p class="font-black text-indigo-600 text-sm italic">Rp{{ number_format($rent->total_price, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="bg-white/40 rounded-3xl p-12 text-center border-2 border-dashed border-slate-200">
                            <p class="text-slate-400 font-bold uppercase tracking-widest text-[10px]">Belum ada pesanan aktif</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <div class="lg:col-span-4">
                    <div class="flex items-center gap-2 mb-6">
                        <div class="h-1 w-4 bg-slate-400 rounded-full"></div>
                        <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">History</h3>
                    </div>
                    
                    <div class="space-y-3">
                        @forelse ($history_rentals as $history)
                        <div class="bg-white/60 rounded-2xl p-4 border border-slate-100 flex items-center gap-4 group">
                            <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <div class="flex-1 overflow-hidden">
                                <p class="font-black text-slate-800 text-[10px] uppercase truncate">{{ $history->clothe?->character_name ?? 'Kostum Dihapus' }}</p>
                                <p class="text-[9px] font-bold text-slate-400 mt-0.5">{{ $history->updated_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8 bg-slate-50/50 rounded-2xl border border-dashed border-slate-200">
                            <p class="text-[9px] font-black text-slate-300 uppercase">Riwayat Kosong</p>
                        </div>
                        @endforelse
                    </div>

                    <div class="mt-8 p-6 bg-slate-900 rounded-3xl relative overflow-hidden">
                        <div class="relative z-10">
                            <h4 class="text-white font-black uppercase text-xs mb-1">Ada Masalah?</h4>
                            <p class="text-[10px] text-slate-400 font-medium mb-4">Tim support kami siap membantu pengambilan barang.</p>
                            <a href="#" class="block w-full py-2 bg-indigo-600 text-white text-center text-[9px] font-black uppercase tracking-tighter rounded-xl hover:bg-indigo-500 transition-colors">
                                Hubungi Support
                            </a>
                        </div>
                        <div class="absolute -bottom-6 -right-6 w-20 h-20 bg-indigo-500/10 rounded-full blur-2xl"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>