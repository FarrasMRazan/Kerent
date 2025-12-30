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

        .task-row:hover {
            background: rgba(255, 255, 255, 0.6);
            transform: translateX(8px);
        }

        [x-cloak] {
            display: none !important;
        }
    </style>

    <div class="min-h-screen mesh-gradient" x-data="rentalModal()">
        <x-slot name="header">
            <div class="flex items-center justify-between py-2">
                <div class="flex items-center space-x-4">
                    <div
                        class="p-3 bg-gradient-to-br from-indigo-600 to-purple-700 rounded-2xl shadow-xl shadow-indigo-200">
                        <svg class="w-8 h-8 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M2 4l3 12h14l3-12-6 7-4-7-4 7-6-7zm3 16h14" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="font-black text-2xl text-slate-800 tracking-tight uppercase leading-none">
                            {{ __('Staff Dashboard') }}
                        </h2>
                        <p class="text-[11px] font-bold text-indigo-600 tracking-[0.25em] uppercase mt-1">Operasional
                            Logistik</p>
                    </div>
                </div>
            </div>
        </x-slot>

        <div class="py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                @if (session('success'))
                    <div
                        class="mb-4 p-4 bg-emerald-100 text-emerald-700 rounded-2xl font-bold text-sm border border-emerald-200">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                    {{-- Section: Ready to Pickup --}}
                    <div class="glass-card rounded-[40px] shadow-2xl overflow-hidden border border-white">
                        <div class="p-8 border-b border-indigo-50 flex items-center space-x-3 bg-indigo-50/30">
                            <div class="p-2 bg-blue-500 rounded-xl shadow-lg">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="font-black text-lg text-slate-800 tracking-tight">Ready to Pickup</h3>
                        </div>

                        <div class="p-6 space-y-4">
                            @forelse($pickups as $item)
                                <div
                                    class="task-row p-4 rounded-3xl transition-all duration-300 flex justify-between items-center bg-white/40">
                                    <div class="flex items-center space-x-4">
                                        <div
                                            class="w-10 h-10 rounded-2xl bg-blue-100 flex items-center justify-center text-blue-600 font-black text-xs">
                                            {{ strtoupper(substr($item->user->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="font-black text-slate-800 text-sm">{{ $item->user->name }}</p>
                                            <p class="text-[11px] font-bold text-slate-400">
                                                {{ $item->clothe->character_name }} (Size: {{ $item->size }})</p>
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-black {{ $item->status_payment == 'settlement' ? 'bg-emerald-100 text-emerald-600' : 'bg-rose-100 text-rose-600 animate-pulse' }} uppercase mt-1">
                                                {{ $item->status_payment == 'settlement' ? 'LUNAS' : 'BELUM BAYAR' }}
                                            </span>
                                        </div>
                                    </div>

                                    <form action="{{ route('rentals.updateStatus', $item->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status_barang" value="picked_up">
                                        <button type="submit" @if ($item->status_payment !== 'settlement') disabled @endif
                                            class="px-5 py-2 rounded-2xl text-[10px] font-black uppercase tracking-tighter shadow-lg transition-all 
                                            {{ $item->status_payment == 'settlement' ? 'bg-blue-600 hover:bg-blue-700 text-white active:scale-95' : 'bg-slate-200 text-slate-400 cursor-not-allowed shadow-none' }}">
                                            Confirm Pickup
                                        </button>
                                    </form>
                                </div>
                            @empty
                                <div
                                    class="py-10 text-center text-slate-400 font-bold text-xs uppercase tracking-widest italic">
                                    No items to pickup</div>
                            @endforelse
                        </div>
                        <div class="px-6 py-4 border-t border-indigo-50">{{ $pickups->links() }}</div>
                    </div>

                    {{-- Section: Pending Returns dengan Modal --}}
                    <div class="glass-card rounded-[40px] shadow-2xl overflow-hidden border border-white">
                        <div class="p-8 border-b border-emerald-50 flex items-center space-x-3 bg-emerald-50/30">
                            <div class="p-2 bg-emerald-500 rounded-xl shadow-lg">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v14a2 2 0 002 2h12a2 2 0 002-2z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="font-black text-lg text-slate-800 tracking-tight">Pending Returns</h3>
                        </div>

                        <div class="p-6 space-y-4">
                            @forelse($returns as $item)
                                <div
                                    class="task-row p-4 rounded-3xl transition-all duration-300 flex justify-between items-center bg-white/40">
                                    <div class="flex items-center space-x-4">
                                        <div
                                            class="w-10 h-10 rounded-2xl bg-emerald-100 flex items-center justify-center text-emerald-600 font-black text-xs">
                                            {{ strtoupper(substr($item->user->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="font-black text-slate-800 text-sm">{{ $item->user->name }}</p>
                                            <p class="text-[11px] font-bold text-slate-400">
                                                {{ $item->clothe->character_name }}</p>
                                            <p class="text-[9px] font-black text-indigo-500 uppercase">Deadline:
                                                {{ \Carbon\Carbon::parse($item->end_date)->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                    <button
                                        @click="openModal('{{ $item->id }}', '{{ $item->end_date }}', '{{ $item->user->name }}')"
                                        class="bg-emerald-500 hover:bg-emerald-600 text-white px-5 py-2 rounded-2xl text-[10px] font-black uppercase tracking-tighter shadow-lg active:scale-95 transition-all">
                                        Confirm Return
                                    </button>
                                </div>
                            @empty
                                <div
                                    class="py-10 text-center text-slate-400 font-bold text-xs uppercase tracking-widest italic">
                                    No pending returns</div>
                            @endforelse
                        </div>
                        <div class="px-6 py-4 border-t border-emerald-50">{{ $returns->links() }}</div>
                    </div>
                </div>

                {{-- Tabel Manajemen Stok Produk --}}
                {{-- <div class="glass-card rounded-[45px] shadow-2xl overflow-hidden border border-white">
                    <div class="overflow-x-auto px-6 py-8">
                        <table class="w-full">
                            <thead>
                                <tr
                                    class="text-slate-400 text-[11px] uppercase tracking-[0.25em] font-black border-b border-slate-100">
                                    <th class="px-6 py-4 text-left">Produk</th>
                                    <th class="px-6 py-4 text-left">Kategori & Stok</th>
                                    <th class="px-6 py-4 text-left">Harga / Hari</th>
                                    <th class="px-6 py-4 text-center">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach ($clothes as $clothe)
                                    <tr class="hover:bg-white/60 transition-all duration-300">
                                        <td class="px-6 py-6">
                                            <div class="flex items-center gap-4">
                                                <img src="{{ asset('storage/' . $clothe->image) }}"
                                                    class="w-16 h-16 object-cover rounded-2xl shadow-lg border-2 border-white">
                                                <div>
                                                    <div class="font-black text-slate-700 text-sm">
                                                        {{ $clothe->character_name }}</div>
                                                    <div
                                                        class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">
                                                        {{ $clothe->series_name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-6">
                                            <div class="flex flex-col gap-2">
                                                <span
                                                    class="w-fit px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-[9px] font-black uppercase">{{ $clothe->category->name ?? 'Umum' }}</span>
                                                <div class="flex flex-wrap gap-1">
                                                    @foreach ($clothe->sizes as $sz)
                                                        <span
                                                            class="px-2 py-0.5 bg-indigo-50 text-indigo-600 rounded-md text-[8px] font-black border border-indigo-100 uppercase">{{ $sz->size }}:
                                                            {{ $sz->stock }}</span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-6 text-sm font-black text-slate-800">Rp
                                            {{ number_format($clothe->price_per_day, 0, ',', '.') }}</td>
                                        <td class="px-6 py-6 text-center">
                                            <div class="flex justify-center gap-2">
                                                <a href="{{ route('clothes.edit', $clothe->id) }}"
                                                    class="p-3 bg-white text-slate-600 rounded-xl shadow-sm border border-slate-100 hover:bg-indigo-600 hover:text-white transition-all"><svg
                                                        class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path
                                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
                                                            stroke-width="2.5"></path>
                                                    </svg></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div> --}}
            </div>
        </div>

        {{-- MODAL REVIEW PENALTY --}}
        <div x-show="isModalOpen"
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm" x-cloak
            x-transition>
            <div class="bg-white rounded-[40px] p-8 max-w-md w-full mx-4 shadow-2xl border border-white">
                <h3 class="text-2xl font-black text-slate-900 mb-2 uppercase italic leading-none">Review Penalty</h3>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-6">Konfirmasi pengembalian
                    untuk <span class="text-indigo-600" x-text="selectedName"></span></p>

                <div class="p-6 bg-slate-50 rounded-[32px] border border-slate-100 mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-[10px] font-black text-slate-400 uppercase">Estimasi Denda</span>
                        <span class="text-lg font-black text-rose-600" x-text="formattedPenalty"></span>
                    </div>
                    <p class="text-[10px] text-slate-400 italic font-medium leading-relaxed">*Denda Rp 50.000 / hari
                        keterlambatan dihitung otomatis dari sistem.</p>
                </div>

                <form :action="'/rentals/' + selectedId + '/update-status'" method="POST">
                    @csrf
                    <input type="hidden" name="status_barang" value="returned">
                    <div class="grid grid-cols-2 gap-4">
                        <button type="button" @click="isModalOpen = false"
                            class="py-4 bg-slate-100 text-slate-500 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-200 transition-all">Cancel</button>
                        <button type="submit"
                            class="py-4 bg-emerald-500 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-emerald-600 shadow-xl shadow-emerald-100 transition-all">Confirm
                            & Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- SCRIPT ALPINE.JS UNTUK MODAL --}}
    <script>
        function rentalModal() {
            return {
                isModalOpen: false,
                selectedId: '',
                selectedDeadline: '',
                selectedName: '',
                estimatedPenalty: 0,

                openModal(id, deadline, name) {
                    this.selectedId = id;
                    this.selectedDeadline = deadline;
                    this.selectedName = name;

                    const today = new Date();
                    today.setHours(0, 0, 0, 0);
                    const deadlineDate = new Date(deadline);
                    deadlineDate.setHours(0, 0, 0, 0);

                    if (today > deadlineDate) {
                        const diffTime = Math.abs(today - deadlineDate);
                        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                        this.estimatedPenalty = diffDays * 50000; // Hitung otomatis denda
                    } else {
                        this.estimatedPenalty = 0;
                    }
                    this.isModalOpen = true;
                },

                get formattedPenalty() {
                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(this.estimatedPenalty);
                }
            }
        }
    </script>
</x-app-layout>
