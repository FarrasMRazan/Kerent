<x-app-layout>
    <style>
        .mesh-gradient {
            background-color: #f8fafc;
            background-image: 
                radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(192, 132, 252, 0.15) 0px, transparent 50%);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
    </style>

    <div class="min-h-screen mesh-gradient py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="glass-card rounded-[45px] shadow-2xl overflow-hidden border border-white">
                <div class="p-10">
                    <div class="flex items-center gap-4 mb-10">
                        <div class="p-4 bg-slate-900 rounded-3xl shadow-xl">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-black text-2xl text-slate-800 tracking-tight uppercase">Pengaturan Toko</h3>
                            <p class="text-xs font-bold text-indigo-600 uppercase tracking-[0.2em] mt-1">Identitas Brand & Alamat</p>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="mb-8 p-5 bg-emerald-500 rounded-3xl shadow-lg shadow-emerald-100 flex items-center gap-3 animate-fade-in">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-white font-black text-xs uppercase tracking-widest">{{ session('success') }}</span>
                        </div>
                    @endif

                    <form action="{{ route('admin.shop.update') }}" method="POST" class="space-y-8">
                        @csrf
                        <div class="grid grid-cols-1 gap-8">
                            <div>
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] ml-4 mb-3 block italic">Nama Brand Toko</label>
                                <div class="relative">
                                    <input type="text" name="shop_name" value="{{ $user->shop_name }}" 
                                        class="w-full border-none bg-slate-100/50 rounded-[25px] focus:ring-2 focus:ring-indigo-500 font-bold px-8 py-5 text-slate-700 transition-all"
                                        placeholder="Masukkan nama brand Anda...">
                                </div>
                            </div>

                            <div>
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] ml-4 mb-3 block italic">Alamat Pengembalian Kostum</label>
                                <div class="relative">
                                    <textarea name="shop_address" rows="5" 
                                        class="w-full border-none bg-slate-100/50 rounded-[25px] focus:ring-2 focus:ring-indigo-500 font-bold px-8 py-5 text-slate-700 transition-all"
                                        placeholder="Masukkan alamat lengkap toko untuk pengembalian...">{{ $user->shop_address }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end pt-4">
                            <button type="submit" class="group relative inline-flex items-center px-12 py-5 bg-slate-900 rounded-[25px] font-black text-[11px] text-white uppercase tracking-[0.25em] shadow-2xl hover:bg-indigo-600 transition-all active:scale-95">
                                <span class="mr-3">Simpan Perubahan</span>
                                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>