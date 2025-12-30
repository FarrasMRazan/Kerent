<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-2xl rounded-2xl overflow-hidden border border-gray-100">

                <div class="bg-indigo-600 p-6 text-white flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-black uppercase tracking-wider">Tambah Kostum Baru</h2>
                        <p class="text-indigo-100 text-xs mt-1">Stok per Ukuran + Smart All Size</p>
                    </div>
                    <a href="{{ route('clothes.index') }}"
                        class="text-sm bg-indigo-500 hover:bg-indigo-400 px-4 py-2 rounded-xl font-bold transition">
                        Kembali
                    </a>
                </div>

                <form id="formTambahKostum" class="p-8 space-y-6" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-xs font-black text-gray-500 uppercase">Nama Karakter</label>
                            <input type="text" name="character_name" required
                                class="w-full border-gray-200 rounded-xl focus:ring-indigo-500 shadow-sm">
                        </div>
                        <div>
                            <label class="text-xs font-black text-gray-500 uppercase">Series</label>
                            <input type="text" name="series_name" required 
                                class="w-full border-gray-200 rounded-xl focus:ring-indigo-500 shadow-sm">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-xs font-black text-gray-500 uppercase">Kategori</label>
                            <select name="category_id" class="w-full border-gray-200 rounded-xl focus:ring-indigo-500">
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="text-xs font-black text-gray-500 uppercase">Harga / Hari</label>
                            <input type="number" name="price_per_day" required min="1"
                                class="w-full border-gray-200 rounded-xl focus:ring-indigo-500 shadow-sm">
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label class="text-xs font-black text-gray-500 uppercase">Stok per Ukuran</label>
                            <button type="button" id="btn-set-all"
                                class="text-[10px] bg-orange-100 text-orange-600 px-3 py-1 rounded-lg font-black hover:bg-orange-200 transition">
                                ⚡ All Size
                            </button>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 p-5 bg-indigo-50 rounded-xl border border-indigo-100">
                            @foreach (['S', 'M', 'L', 'XL'] as $s)
                                <div class="bg-white p-3 rounded-xl text-center shadow-sm">
                                    <span class="text-xs font-bold text-indigo-600">{{ $s }}</span>
                                    <input type="number" name="sizes[{{ $s }}]" min="0"
                                        value="0" class="size-input w-full mt-2 text-center border-gray-200 rounded-lg focus:ring-indigo-500">
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="text-xs font-black text-gray-500 uppercase">Kelengkapan</label>
                        <textarea name="include_items" rows="3" 
                            placeholder="Contoh: Wig, Kostum, Aksesoris..."
                            class="w-full border-gray-200 rounded-xl focus:ring-indigo-500 shadow-sm"></textarea>
                    </div>

                    <div class="p-6 bg-indigo-50 border-dashed border-2 border-indigo-200 rounded-xl text-center">
                        <label class="cursor-pointer">
                            <div id="preview-container" class="hidden">
                                <img id="image-preview" class="mx-auto max-h-48 mb-4 rounded-lg shadow-md border-4 border-white">
                            </div>
                            <span id="file-label-text" class="font-bold text-indigo-600 block">Klik untuk Upload Gambar</span>
                            <input type="file" name="image" id="image-input" required class="hidden" accept="image/*">
                        </label>
                    </div>

                    <button type="submit" id="btnSimpan"
                        class="w-full bg-indigo-600 text-white py-4 rounded-xl font-black uppercase tracking-widest shadow-xl hover:bg-indigo-700 transition-all active:scale-95">
                        🚀 Simpan Kostum
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        /* IMAGE PREVIEW */
        document.getElementById('image-input').onchange = e => {
            const file = e.target.files[0];
            if (!file) return;
            document.getElementById('image-preview').src = URL.createObjectURL(file);
            document.getElementById('image-preview').parentElement.classList.remove('hidden');
            document.getElementById('file-label-text').innerText = "File: " + file.name;
        };

        /* SMART ALL SIZE */
        document.getElementById('btn-set-all').onclick = async () => {
            const { value: stock } = await Swal.fire({
                title: 'Stok All Size',
                text: 'Masukkan jumlah stok untuk semua ukuran',
                input: 'number',
                inputAttributes: { min: 0 },
                showCancelButton: true,
                confirmButtonColor: '#4f46e5'
            });

            if (stock !== undefined && stock !== "") {
                document.querySelectorAll('.size-input').forEach(i => i.value = stock);
            }
        };

        /* AJAX SUBMISSION (FIX Method Not Allowed) */
        document.getElementById('formTambahKostum').onsubmit = async function(e) {
            e.preventDefault();

            // Validasi Stok Minimal
            const inputs = [...document.querySelectorAll('.size-input')];
            const hasStock = inputs.some(i => parseInt(i.value) > 0);
            if (!hasStock) {
                return Swal.fire('Error', 'Minimal satu ukuran harus memiliki stok', 'error');
            }

            const btn = document.getElementById('btnSimpan');
            btn.disabled = true;
            btn.innerText = "⏳ Sedang Menyimpan...";

            const formData = new FormData(this);

            try {
                // PERBAIKAN: Gunakan route clothes.store
                const response = await fetch("{{ route('clothes.store') }}", {
                    method: "POST",
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });

                const result = await response.json();

                if (response.ok) {
                    Swal.fire('Berhasil!', result.message, 'success').then(() => {
                        window.location.href = "{{ route('clothes.index') }}";
                    });
                } else {
                    const errorMsg = result.errors ? Object.values(result.errors).flat().join("<br>") : result.message;
                    Swal.fire('Gagal', errorMsg, 'error');
                    btn.disabled = false;
                    btn.innerText = "🚀 Simpan Kostum";
                }
            } catch (error) {
                Swal.fire('Error', 'Terjadi kesalahan sistem.', 'error');
                btn.disabled = false;
                btn.innerText = "🚀 Simpan Kostum";
            }
        };
    </script>
</x-app-layout>