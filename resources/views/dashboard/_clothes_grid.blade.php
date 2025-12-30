<div id="clothes-grid-content" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
    @forelse ($all_clothes as $index => $item)
        <div class="reveal-up card-animate" style="animation-delay: {{ $index * 0.1 }}s">
            <div
                class="group relative bg-white rounded-[40px] p-3 border border-transparent hover:border-indigo-50 transition-all duration-500 hover:shadow-[0_40px_80px_-20px_rgba(99,102,241,0.15)] h-full flex flex-col">

                {{-- Bagian Gambar --}}
                <div class="relative aspect-[4/5] rounded-[32px] overflow-hidden bg-slate-100">
                    <img src="{{ asset('storage/' . $item->image) }}" loading="lazy"
                        class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">

                    {{-- Overlay Hover --}}
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex items-end justify-center pb-8">
                        <a href="{{ route('clothes.show', $item->id) }}"
                            class="px-8 py-3 bg-white rounded-2xl text-[10px] font-black uppercase tracking-widest text-slate-900 shadow-2xl transform translate-y-4 group-hover:translate-y-0 transition-all duration-500 hover:bg-indigo-600 hover:text-white">
                            Lihat Detail
                        </a>
                    </div>

                    {{-- BADGE KATEGORI (TAMPIL DI SINI) --}}
                    <div class="absolute top-4 left-4">
                        <span
                            class="px-4 py-2 bg-white/80 backdrop-blur-xl rounded-2xl text-[9px] font-black uppercase tracking-[0.1em] text-indigo-600 shadow-sm border border-white/50">
                            {{ $item->category->name ?? 'Uncategorized' }}
                        </span>
                    </div>
                </div>

                {{-- Detail Kostum --}}
                <div class="p-6 flex flex-col flex-1">
                    <div class="mb-6">
                        <p class="text-[10px] font-bold text-indigo-400 uppercase tracking-[0.2em] mb-2">
                            {{ $item->series_name }}</p>
                        <h4
                            class="font-extrabold text-slate-800 text-xl leading-tight group-hover:text-indigo-600 transition-colors">
                            {{ $item->character_name }}
                        </h4>
                    </div>

                    {{-- Harga & Tombol --}}
                    <div class="mt-auto pt-6 border-t border-slate-50 flex items-center justify-between">
                        <div>
                            <span class="block text-[10px] font-medium text-slate-400 uppercase mb-1">Harga Sewa</span>
                            <div class="flex items-baseline gap-1">
                                <span class="text-2xl font-black text-slate-900 tracking-tighter">
                                    <span
                                        class="text-sm font-bold mr-0.5">Rp</span>{{ number_format($item->price_per_day, 0, ',', '.') }}
                                </span>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">/
                                    Hari</span>
                            </div>
                        </div>

                        <a href="{{ route('clothes.show', $item->id) }}"
                            class="w-12 h-12 bg-slate-50 text-slate-900 rounded-2xl flex items-center justify-center group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300 group-hover:shadow-lg group-hover:shadow-indigo-200 group-hover:-rotate-12">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M14 5l7 7m0 0l-7 7m7-7H3" stroke-width="2.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full py-32 text-center">
            <p class="text-slate-400 font-bold uppercase tracking-[0.3em] text-xs">Kostum tidak ditemukan</p>
        </div>
    @endforelse
</div>

<div class="mt-16 flex justify-center ajax-pagination">
    {{ $all_clothes->appends(request()->query())->links() }}
</div>
