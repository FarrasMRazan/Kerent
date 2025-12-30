<x-app-layout>
    <style>
        .mesh-gradient {
            background-color: #f8fafc;
            background-image: 
                radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(192, 132, 252, 0.15) 0px, transparent 50%);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
    </style>

    <div class="min-h-screen mesh-gradient py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="glass-card rounded-[50px] p-10 mb-12 flex flex-col md:flex-row items-center justify-between shadow-2xl">
                <div class="flex items-center space-x-8">
                    <div class="w-24 h-24 bg-gradient-to-br from-slate-800 to-slate-900 rounded-[35px] flex items-center justify-center shadow-xl border-4 border-white text-white text-4xl font-black italic uppercase">
                        {{ substr($shop->name, 0, 1) }}
                    </div>
                    <div>
                        <h1 class="text-4xl font-black text-slate-800 uppercase tracking-tighter">{{ $shop->name }}</h1>
                        <p class="text-indigo-600 font-bold text-[11px] uppercase tracking-[0.3em] mt-1 italic">Official Costume Vendor</p>
                    </div>
                </div>
                <div class="mt-8 md:mt-0 px-8 py-4 bg-white/50 rounded-[30px] border border-white text-center">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Koleksi Baju</p>
                    <p class="text-4xl font-black text-indigo-600">{{ $clothes->count() }}</p>
                </div>
            </div>

            <div class="mb-8 ml-2 flex justify-between items-center">
                <div>
                    <h3 class="text-xl font-black text-slate-800 tracking-tight uppercase italic">Koleksi Tersedia</h3>
                    <div class="h-1.5 w-16 bg-indigo-600 rounded-full mt-2"></div>
                </div>
                <a href="{{ route('dashboard') }}" class="text-[10px] font-black uppercase text-slate-400 hover:text-indigo-600 tracking-widest transition">
                    ← Kembali ke Mall
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                @forelse ($clothes as $item)
                <div class="glass-card rounded-[40px] overflow-hidden group hover:-translate-y-2 transition-all duration-500 border border-white">
                    <div class="relative h-72 overflow-hidden">
                        <img src="{{ asset('storage/' . $item->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    </div>
                    
                    <div class="p-7">
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">{{ $item->series_name }}</p>
                        <h4 class="font-black text-xl text-slate-800 uppercase leading-tight truncate">{{ $item->character_name }}</h4>
                        
                        <div class="mt-5 flex items-center justify-between border-t border-slate-50 pt-5">
                            <div>
                                <p class="text-[8px] font-black text-slate-400 uppercase tracking-tighter">Harga / Hari</p>
                                <p class="text-xl font-black text-indigo-600 italic">Rp{{ number_format($item->price_per_day, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <a href="{{ route('clothes.show', $item->id) }}" class="block w-full mt-6 py-4 bg-slate-900 text-white text-center rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-indigo-600 transition-colors">
                            Lihat Detail
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-span-full glass-card p-20 rounded-[50px] text-center border-dashed border-2 border-slate-200">
                    <p class="text-slate-400 font-bold uppercase tracking-widest italic">Belum ada koleksi di toko ini.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>