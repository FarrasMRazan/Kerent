<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
        .loading-state {
            opacity: 0.5;
            pointer-events: none;
        }
    </style>

    <div class="min-h-screen mesh-gradient">
        <x-slot name="header">
            <div class="flex items-center justify-between py-2">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-gradient-to-br from-indigo-600 to-purple-700 rounded-2xl shadow-xl shadow-indigo-200">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="font-black text-2xl text-slate-800 tracking-tight uppercase leading-none">Manajemen Kostum</h2>
                        <p class="text-[11px] font-bold text-indigo-600 tracking-[0.25em] uppercase mt-1">Katalog Asset Toko</p>
                    </div>
                </div>

                <a href="{{ route('clothes.create') }}"
                    class="group relative inline-flex items-center px-8 py-4 bg-slate-900 rounded-2xl font-black text-[10px] text-white uppercase tracking-[0.2em] shadow-xl hover:bg-indigo-600 transition-all active:scale-95">
                    Tambah Kostum
                </a>
            </div>
        </x-slot>

        <div class="py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div id="clothes-table-wrapper">
                    @include('clothes._table')
                </div>
            </div>
        </div>
    </div>

    <script>
        // Logika AJAX Pagination
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');
            
            $('#clothes-table-wrapper').addClass('loading-state');

            $.ajax({
                url: url,
                success: function(data) {
                    $('#clothes-table-wrapper').html(data);
                    $('#clothes-table-wrapper').removeClass('loading-state');
                    window.history.pushState({}, "", url);
                }
            });
        });

        // Logika SweetAlert Delete
        function deleteClothe(id) {
            Swal.fire({
                title: 'Hapus Kostum?',
                text: "Data stok ukuran juga akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/clothes/${id}`,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire('Terhapus!', response.message, 'success');
                            // Refresh tabel secara otomatis setelah hapus
                            location.reload(); 
                        },
                        error: function() {
                            Swal.fire('Error', 'Gagal menghapus data', 'error');
                        }
                    });
                }
            })
        }
    </script>
</x-app-layout>