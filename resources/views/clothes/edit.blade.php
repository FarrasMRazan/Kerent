<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-2xl rounded-2xl overflow-hidden border border-gray-100">
                
                <div class="bg-amber-500 p-6 text-white flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-black uppercase tracking-wider">Edit Data Kostum</h2>
                        <p class="text-amber-100 text-xs mt-1">Update: {{ $clothe->character_name }}</p>
                    </div>
                    <a href="{{ route('clothes.index') }}" class="text-sm bg-amber-600 hover:bg-amber-700 px-4 py-2 rounded-xl font-bold transition"> Kembali </a>
                </div>

                <form id="formEditKostum" class="p-8 space-y-6" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <label class="text-xs font-black text-gray-500 uppercase">Nama Karakter</label>
                            <input type="text" name="character_name" value="{{ $clothe->character_name }}" required class="w-full border-gray-200 rounded-xl focus:ring-amber-500 shadow-sm">
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-black text-gray-500 uppercase">Seri Anime/Game</label>
                            <input type="text" name="series_name" value="{{ $clothe->series_name }}" required class="w-full border-gray-200 rounded-xl focus:ring-amber-500 shadow-sm">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <label class="text-xs font-black text-gray-500 uppercase">Kategori</label>
                            <select name="category_id" class="w-full border-gray-200 rounded-xl focus:ring-amber-500">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $clothe->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-black text-gray-500 uppercase">Harga Sewa / Hari (Rp)</label>
                            <input type="number" name="price_per_day" value="{{ $clothe->price_per_day }}" required class="w-full border-gray-200 rounded-xl focus:ring-amber-500 shadow-sm">
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <label class="text-xs font-black text-gray-500 uppercase tracking-widest">Atur Stok Per Ukuran</label>
                            <button type="button" id="btn-set-all" class="text-[10px] bg-orange-100 text-orange-600 px-3 py-1 rounded-lg font-black uppercase hover:bg-orange-200 transition shadow-sm">
                                ⚡ Set All Size
                            </button>
                        </div>
                        
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 p-5 border border-amber-100 rounded-2xl bg-amber-50/30">
                            @foreach(['S', 'M', 'L', 'XL'] as $s)
                                @php
                                    // Mengambil stok lama dari tabel relasi sizes
                                    $oldStock = $clothe->sizes->where('size', $s)->first()->stock ?? 0;
                                @endphp
                                <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm flex flex-col items-center">
                                    <span class="text-[10px] font-black text-amber-600 uppercase mb-2">Ukuran {{ $s }}</span>
                                    <input type="number" 
                                           name="sizes[{{ $s }}]" 
                                           min="0" 
                                           value="{{ $oldStock }}" 
                                           class="size-input w-full text-center border-gray-200 rounded-lg focus:ring-amber-500 text-sm font-bold"
                                           placeholder="0">
                                </div>
                            @endforeach
                        </div>
                        <p class="text-[10px] text-gray-400 italic mt-1">*Jika stok diubah ke 0, ukuran tersebut tidak akan tampil di katalog.</p>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-black text-gray-500 uppercase">Kelengkapan Item</label>
                        <textarea name="include_items" rows="3" class="w-full border-gray-200 rounded-xl focus:ring-amber-500 shadow-sm">{{ $clothe->include_items }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4 p-6 bg-amber-50 rounded-2xl border-2 border-dashed border-amber-200">
                        <div class="text-center">
                            <p class="text-[10px] font-black uppercase text-amber-600 mb-2">Gambar Saat Ini</p>
                            <div class="h-32 flex items-center justify-center bg-white rounded-xl shadow-sm border border-amber-100 overflow-hidden">
                                <img src="{{ asset('storage/' . $clothe->image) }}" class="max-h-full object-contain">
                            </div>
                        </div>
                        <div class="text-center">
                            <label class="cursor-pointer group">
                                <p class="text-[10px] font-black uppercase text-amber-600 mb-2">Ganti Gambar (Opsional)</p>
                                <div class="h-32 flex items-center justify-center bg-white rounded-xl shadow-sm border border-amber-100 overflow-hidden group-hover:border-amber-400 transition-all">
                                    <img id="image-preview" src="#" class="hidden max-h-full object-contain">
                                    <span id="label-text" class="text-xs text-amber-400 font-bold px-4">Klik untuk Upload Baru</span>
                                </div>
                                <input type="file" name="image" id="image-input" class="hidden" accept="image/*">
                            </label>
                        </div>
                    </div>

                    <button type="submit" id="btnUpdate" class="w-full bg-amber-500 text-white py-4 rounded-xl font-black uppercase tracking-widest shadow-xl hover:bg-amber-600 transition-all">
                        💾 Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Preview Image Logic
        document.getElementById('image-input').onchange = function (e) {
            const [file] = this.files;
            if (file) {
                document.getElementById('image-preview').src = URL.createObjectURL(file);
                document.getElementById('image-preview').classList.remove('hidden');
                document.getElementById('label-text').classList.add('hidden');
            }
        };

        // Smart All Size Logic
        document.getElementById('btn-set-all').addEventListener('click', async function() {
            const { value: stockCount } = await Swal.fire({
                title: 'Set Stok All Size',
                text: 'Masukkan jumlah stok untuk SEMUA ukuran',
                input: 'number',
                inputPlaceholder: 'Contoh: 5',
                showCancelButton: true,
                confirmButtonColor: '#f59e0b',
                inputValidator: (value) => {
                    if (!value || value < 0) return 'Harap masukkan angka yang valid!'
                }
            });

            if (stockCount) {
                document.querySelectorAll('.size-input').forEach(input => {
                    input.value = stockCount;
                });
                
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000
                });
                Toast.fire({ icon: 'success', title: 'Stok semua ukuran diperbarui' });
            }
        });

        // Submit via AJAX
        document.getElementById('formEditKostum').onsubmit = function(e) {
            e.preventDefault();
            const btn = document.getElementById('btnUpdate');
            btn.disabled = true;
            btn.innerText = "Processing...";

            let formData = new FormData(this);
            formData.append('_method', 'PUT'); // Method spoofing untuk update

            fetch("{{ route('clothes.update', $clothe->id) }}", {
                method: "POST", // Tetap POST karena FormData tidak support PUT secara native
                body: formData,
                headers: { 
                    'X-CSRF-TOKEN': '{{ csrf_token() }}', 
                    'Accept': 'application/json' 
                }
            })
            .then(async response => {
                const data = await response.json();
                if (!response.ok) {
                    let errorMessage = data.errors ? Object.values(data.errors).flat().join("<br>") : "Terjadi kesalahan.";
                    Swal.fire('Error', errorMessage, 'error');
                    btn.disabled = false;
                    btn.innerText = "💾 Simpan Perubahan";
                } else {
                    Swal.fire('Berhasil!', data.message, 'success').then(() => { 
                        window.location.href = "{{ route('clothes.index') }}"; 
                    });
                }
            })
            .catch(error => {
                Swal.fire('Error', 'Gagal menghubungi server', 'error');
                btn.disabled = false;
                btn.innerText = "💾 Simpan Perubahan";
            });
        };
    </script>
</x-app-layout>