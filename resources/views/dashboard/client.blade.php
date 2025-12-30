<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@300;400;600;900&display=swap');

        :root {
            --primary: #6366f1;
            --primary-light: #818cf8;
            --accent: #a855f7;
            --dark: #0f172a;
            --glass-bg: rgba(255, 255, 255, 0.7);
            --glass-border: rgba(255, 255, 255, 0.8);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f8fafc;
            color: var(--dark);
        }

        .luxury-text { font-family: 'Outfit', sans-serif; }

        /* Modern Mesh Gradient Background */
        .mesh-gradient {
            background-color: #f8fafc;
            background-image: 
                radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(168, 85, 247, 0.12) 0px, transparent 50%),
                radial-gradient(at 50% 100%, rgba(244, 114, 182, 0.1) 0px, transparent 50%);
            background-attachment: fixed;
        }

        /* Glass Panel Enhanced */
        .glass-panel {
            background: var(--glass-bg);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-radius: 32px;
            border: 1px solid var(--glass-border);
            box-shadow: 
                0 4px 6px -1px rgba(0, 0, 0, 0.02),
                0 20px 40px -12px rgba(15, 23, 42, 0.08);
            position: relative;
            z-index: 40;
        }

        /* Input & Dropdown Focus Reset */
        input:focus, select:focus, button:focus, .luxury-input:focus, .category-box:focus {
            outline: none !important;
            box-shadow: none !important;
            border: none !important;
        }

        /* Improved Input Styling */
        .luxury-input {
            height: 60px; 
            border-radius: 20px;
            padding-left: 56px; 
            padding-right: 24px;
            background: rgba(255, 255, 255, 0.5);
            font-weight: 500; 
            font-size: 15px; 
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(0, 0, 0, 0.03) !important;
        }

        .luxury-input:focus {
            background: white;
            border: 1px solid rgba(99, 102, 241, 0.2) !important;
            box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.15) !important;
            transform: translateY(-1px);
        }

        /* Custom Category Dropdown Redesign */
        .category-box {
            height: 60px; 
            padding: 0 24px; 
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.5); 
            border: 1px solid rgba(0, 0, 0, 0.03); 
            display: flex;
            align-items: center; 
            justify-content: space-between;
            font-size: 12px; 
            font-weight: 700; 
            letter-spacing: 0.1em;
            text-transform: uppercase; 
            cursor: pointer; 
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .category-box.active, .category-box:hover {
            background: white; 
            box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.15);
            border: 1px solid rgba(99, 102, 241, 0.1);
        }

        .category-arrow { 
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1); 
            color: var(--primary);
        }

        .category-dropdown {
            position: absolute; 
            top: calc(100% + 12px);
            left: 0; 
            right: 0; 
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px); 
            border-radius: 24px;
            padding: 8px; 
            box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.5);
            z-index: 100;
        }

        .category-item {
            padding: 12px 18px; 
            border-radius: 16px;
            font-size: 11px; 
            font-weight: 700; 
            letter-spacing: 0.05em;
            text-transform: uppercase; 
            cursor: pointer; 
            transition: 0.2s ease;
            color: #64748b;
        }

        .category-item:hover { 
            background: rgba(99, 102, 241, 0.08); 
            color: var(--primary); 
            padding-left: 22px;
        }

        .category-item.active { 
            background: var(--primary); 
            color: white; 
            box-shadow: 0 8px 15px -3px rgba(99, 102, 241, 0.3);
        }

        /* Animation Updates */
        .reveal-up {
            animation: revealUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
            opacity: 0;
        }

        @keyframes revealUp {
            from { opacity: 0; transform: translateY(30px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* Subtle Search Icon Animation */
        .search-container:focus-within svg {
            color: var(--primary);
            transform: translateY(-50%) scale(1.1);
        }
        
        .search-container svg {
            transition: all 0.3s ease;
        }
    </style>

    <div class="min-h-screen mesh-gradient pb-24">
        <div class="max-w-7xl mx-auto pt-16 px-6">

            <div class="mb-12 reveal-up text-center md:text-left">
                <div class="inline-block px-4 py-1.5 mb-4 rounded-full bg-indigo-50 border border-indigo-100">
                    <p class="text-[10px] font-black text-indigo-600 uppercase tracking-[0.4em]">Premium Collection</p>
                </div>
                <h2 class="text-5xl font-black luxury-text text-slate-900 tracking-tight">
                    Explore <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">Catalog</span>
                </h2>
            </div>

            <div class="glass-panel p-2 flex flex-col md:flex-row gap-2 reveal-up">
                <div class="relative flex-1 search-container">
                    <svg class="absolute left-6 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 pointer-events-none"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input id="ajaxSearch" class="luxury-input w-full"
                           placeholder="Search characters or series..." autocomplete="off">
                </div>

                <div class="w-full md:w-72 relative">
                    <div id="categoryBox" class="category-box" onclick="toggleCategory()">
                        <span id="categoryLabel">Semua Koleksi</span>
                        <svg class="w-4 h-4 category-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M19 9l-7 7-7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>

                    <div id="categoryDropdown" class="category-dropdown hidden">
                        <div class="category-item active" onclick="selectCategory('', 'Semua Koleksi', this)">
                            Semua Koleksi
                        </div>
                        @foreach ($categories as $cat)
                            <div class="category-item"
                                 onclick="selectCategory('{{ $cat->id }}', '{{ $cat->name }}', this)">
                                {{ $cat->name }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div id="ajax-target" class="mt-16 transition-all duration-500 ease-in-out">
                @include('dashboard._clothes_grid')
            </div>
        </div>
    </div>

    <script>
        // LOGIC ASLI ANDA (TIDAK DIUBAH SAMA SEKALI)
        let currentCategory = '';
        let searchTimer;

        const categoryBox = document.getElementById('categoryBox');
        const categoryDropdown = document.getElementById('categoryDropdown');
        const categoryLabel = document.getElementById('categoryLabel');
        const ajaxSearch = document.getElementById('ajaxSearch');
        const ajaxTarget = document.getElementById('ajax-target');

        function toggleCategory() {
            categoryDropdown.classList.toggle('hidden');
            categoryBox.classList.toggle('active');
        }

        function selectCategory(id, label, el) {
            currentCategory = id;
            categoryLabel.innerText = label;
            document.querySelectorAll('.category-item').forEach(i => i.classList.remove('active'));
            el.classList.add('active');
            categoryDropdown.classList.add('hidden');
            categoryBox.classList.remove('active');
            runAjax();
        }

        ajaxSearch.addEventListener('input', () => {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(runAjax, 400);
        });

        function runAjax() {
            ajaxTarget.style.opacity = '0.4';
            ajaxTarget.style.transform = 'translateY(10px)';
            const searchQuery = encodeURIComponent(ajaxSearch.value);
            const url = `{{ route('dashboard') }}?category=${currentCategory}&search=${searchQuery}`;

            fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.text())
            .then(html => {
                ajaxTarget.innerHTML = html;
                ajaxTarget.style.opacity = '1';
                ajaxTarget.style.transform = 'translateY(0)';
                const reveals = ajaxTarget.querySelectorAll('.reveal-up');
                reveals.forEach((el, i) => {
                    el.style.animationDelay = `${i * 0.05}s`;
                });
            })
            .catch(err => {
                console.error("Fetch error:", err);
                ajaxTarget.style.opacity = '1';
                ajaxTarget.style.transform = 'translateY(0)';
            });
        }

        document.addEventListener('click', e => {
            if (!categoryBox.contains(e.target) && !categoryDropdown.contains(e.target)) {
                categoryDropdown.classList.add('hidden');
                categoryBox.classList.remove('active');
            }
        });
    </script>
</x-app-layout>