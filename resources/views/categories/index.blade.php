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
        @keyframes click-pulse {
            0% { transform: scale(1); }
            50% { transform: scale(0.95); }
            100% { transform: scale(1); }
        }
        .animate-click {
            animation: click-pulse 0.2s ease-out;
        }
    </style>

    <div class="min-h-screen mesh-gradient py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="mb-6 p-5 glass-card border-l-4 border-emerald-500 rounded-3xl shadow-xl">
                    <div class="flex items-center">
                        <div class="bg-emerald-500 p-2 rounded-xl mr-4 text-white">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span class="text-emerald-700 font-black uppercase text-[10px] tracking-widest">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-5 glass-card border-l-4 border-rose-500 rounded-3xl shadow-xl">
                    <div class="flex items-center">
                        <div class="bg-rose-500 p-2 rounded-xl mr-4 text-white">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </div>
                        <span class="text-rose-700 font-black uppercase text-[10px] tracking-widest">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            {{-- Main Management Card --}}
            <div class="glass-card rounded-[45px] shadow-2xl overflow-hidden border border-white">
                
                {{-- Header --}}
                <div class="bg-slate-900 p-10 text-white relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-indigo-500/20 rounded-full blur-3xl"></div>
                    <div class="relative z-10 flex items-center gap-5">
                        <div class="p-4 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl shadow-lg">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-3xl font-black uppercase tracking-tighter italic leading-none">Manajemen Kategori</h2>
                            <p class="text-slate-400 text-[10px] mt-2 uppercase tracking-[0.3em] font-bold">Tambah atau hapus kategori kostum global</p>
                        </div>
                    </div>
                </div>

                <div class="p-10">
                    {{-- Input Form --}}
                    <form action="{{ route('categories.store') }}" method="POST" class="flex flex-col md:flex-row gap-4 mb-12">
                        @csrf
                        <div class="flex-1">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-4 mb-2 block">Nama Kategori Baru</label>
                            <input type="text" name="name" placeholder="Masukkan Nama Kategori..." required 
                                class="w-full border-none bg-slate-100/50 rounded-[25px] focus:ring-2 focus:ring-indigo-500 font-bold text-sm px-8 py-5 transition-all shadow-inner">
                            @error('name')
                                <p class="text-rose-500 text-[10px] font-black mt-2 ml-4 uppercase">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex items-end">
                            <button type="submit" onclick="this.classList.add('animate-click')" 
                                class="w-full md:w-auto bg-slate-900 text-white px-10 py-5 rounded-[25px] font-black uppercase text-[10px] tracking-[0.2em] hover:bg-indigo-600 transition-all shadow-xl hover:shadow-indigo-200 active:scale-95">
                                Simpan Kategori
                            </button>
                        </div>
                    </form>

                    {{-- Categories List --}}
                    <div class="space-y-4">
                        <div class="flex items-center justify-between px-2 mb-4">
                            <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.25em]">Daftar Kategori Saat Ini</label>
                            <span class="bg-indigo-50 text-indigo-600 text-[10px] font-black px-4 py-1.5 rounded-full uppercase border border-indigo-100">
                                {{ count($categories) }} Kategori
                            </span>
                        </div>

                        <div class="grid grid-cols-1 gap-3">
                            @forelse($categories as $cat)
                                <div class="group relative overflow-hidden glass-card p-6 rounded-[30px] flex justify-between items-center transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                                    {{-- Content --}}
                                    <div class="flex items-center gap-5 relative z-10">
                                        <div class="w-3 h-3 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                                        <span class="font-black text-slate-700 uppercase text-sm tracking-wider">{{ $cat->name }}</span>
                                    </div>
                                    
                                    {{-- Action: Delete --}}
                                    <div class="relative z-50"> {{-- Z-index tinggi agar tombol selalu bisa diklik --}}
                                        <form action="{{ route('categories.destroy', $cat->id) }}" method="POST" 
                                              onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                            @csrf 
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="p-4 text-rose-400 hover:text-rose-600 hover:bg-rose-50 rounded-2xl transition-all transform active:scale-90 group-hover:rotate-6">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>

                                    {{-- Decoration Layer --}}
                                    <div class="absolute right-0 top-0 w-32 h-full bg-gradient-to-l from-indigo-50/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
                                </div>
                            @empty
                                <div class="text-center py-20 border-4 border-dashed border-slate-100 rounded-[45px]">
                                    <div class="bg-slate-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                                        <svg class="w-10 h-10 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                        </svg>
                                    </div>
                                    <p class="text-slate-400 font-black uppercase text-[10px] tracking-[0.3em]">Belum Ada Data Kategori</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>