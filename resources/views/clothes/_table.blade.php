<div class="glass-card rounded-[45px] shadow-2xl overflow-hidden border border-white">
    <div class="overflow-x-auto px-6 py-8">
        <table class="w-full">
            <thead>
                <tr class="text-slate-400 text-[11px] uppercase tracking-[0.25em] font-black border-b border-slate-100">
                    <th class="px-6 py-4 text-left">Produk</th>
                    <th class="px-6 py-4 text-left">Kategori & Size (Stok)</th>
                    <th class="px-6 py-4 text-left">Total Stok</th>
                    <th class="px-6 py-4 text-left">Harga / Hari</th>
                    <th class="px-6 py-4 text-center">Tindakan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse ($clothes as $clothe)
                    <tr class="hover:bg-white/60 transition-all duration-300">
                        <td class="px-6 py-6">
                            <div class="flex items-center gap-4">
                                <img src="{{ asset('storage/' . $clothe->image) }}"
                                     class="w-16 h-16 object-cover rounded-2xl shadow-lg border-2 border-white">
                                <div>
                                    <div class="font-black text-slate-700 text-sm">{{ $clothe->character_name }}</div>
                                    <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">{{ $clothe->series_name }}</div>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-6">
                            <div class="flex flex-col gap-2">
                                <span class="w-fit px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-[9px] font-black uppercase">
                                    {{ $clothe->category->name ?? 'Umum' }}
                                </span>
                                <div class="flex flex-wrap gap-1">
                                    {{-- Mengambil data dari relasi sizes --}}
                                    @foreach ($clothe->sizes as $sz)
                                        <span class="px-2 py-0.5 bg-indigo-50 text-indigo-600 rounded-md text-[8px] font-black border border-indigo-100 uppercase">
                                            {{ $sz->size }}: {{ $sz->stock }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-6">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-slate-700">{{ $clothe->sizes->sum('stock') }} Unit</span>
                                @if ($clothe->sizes->sum('stock') <= 3)
                                    <span class="text-[9px] font-bold text-amber-500 uppercase tracking-tighter">Hampir Habis</span>
                                @endif
                            </div>
                        </td>

                        <td class="px-6 py-6 text-sm font-black text-slate-800 leading-none">
                            Rp {{ number_format($clothe->price_per_day, 0, ',', '.') }}
                        </td>

                        <td class="px-6 py-6 text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('clothes.edit', $clothe->id) }}"
                                    class="p-3 bg-white text-slate-600 rounded-xl shadow-sm border border-slate-100 hover:bg-indigo-600 hover:text-white transition-all shadow-indigo-100">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" stroke-width="2.5"></path></svg>
                                </a>
                                <button type="button" onclick="deleteClothe({{ $clothe->id }})"
                                    class="p-3 bg-white text-rose-500 rounded-xl shadow-sm border border-slate-100 hover:bg-rose-500 hover:text-white transition-all shadow-rose-100">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2.5"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400 font-bold uppercase text-[10px]">Belum ada kostum</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
        {{ $clothes->links() }}
    </div>
</div>