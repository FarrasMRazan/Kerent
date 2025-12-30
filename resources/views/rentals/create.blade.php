<x-app-layout>
    <div class="min-h-screen bg-slate-50 py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-10 rounded-[40px] shadow-xl border border-slate-100">
                <h2 class="text-2xl font-black text-slate-800 uppercase tracking-tight mb-6">Formulir Penyewaan</h2>
                
                <div class="flex items-center gap-4 mb-8 p-4 bg-indigo-50 rounded-2xl">
                    <img src="{{ asset('storage/' . $clothe->image) }}" class="w-16 h-16 object-cover rounded-xl">
                    <div>
                        <p class="text-xs font-bold text-indigo-600 uppercase">{{ $clothe->series_name }}</p>
                        <p class="text-lg font-black text-slate-800">{{ $clothe->character_name }}</p>
                    </div>
                </div>

                <form action="{{ route('rentals.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="clothe_id" value="{{ $clothe->id }}">
                    
                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Tanggal Mulai</label>
                            <input type="date" name="start_date" class="w-full border-none bg-slate-100 rounded-xl px-4 py-3 font-bold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Tanggal Selesai</label>
                            <input type="date" name="end_date" class="w-full border-none bg-slate-100 rounded-xl px-4 py-3 font-bold">
                        </div>
                    </div>

                    <button type="submit" class="w-full py-4 bg-indigo-600 text-white rounded-2xl font-black uppercase text-xs tracking-[0.2em] shadow-lg shadow-indigo-100">
                        Konfirmasi Sewa
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>