<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address. Accurate location is required for delivery tracking.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="address" :value="__('Alamat Lengkap Pengiriman')" />
            <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $user->address)" required placeholder="Cari alamat atau ketik di sini..." />
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
        </div>

        <div>
            <x-input-label :value="__('Titik Lokasi GPS (Geser pin ke lokasi rumah Anda)')" />
            <div id="map-profile" style="height: 350px;" class="mt-2 rounded-xl border border-gray-300 shadow-sm z-0"></div>
            <p class="mt-2 text-[10px] text-indigo-600 font-bold uppercase tracking-widest italic">
                *Klik pada peta atau cari alamat di kolom atas untuk mengunci koordinat.
            </p>
        </div>

        <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude', $user->latitude) }}">
        <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude', $user->longitude) }}">

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save Profile') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var lat = {{ $user->latitude ?? -6.9764 }};
        var lng = {{ $user->longitude ?? 107.6327 }};

        var map = L.map('map-profile').setView([lat, lng], 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);


        var marker = L.marker([lat, lng], { draggable: true }).addTo(map);

        function updateFields(newLat, newLng) {
            document.getElementById('latitude').value = newLat;
            document.getElementById('longitude').value = newLng;
        }

        marker.on('dragend', function(e) {
            var position = marker.getLatLng();
            updateFields(position.lat, position.lng);
        });

        // Event saat peta diklik
        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            updateFields(e.latlng.lat, e.latlng.lng);
        });

        var geocoder = L.Control.geocoder({
            defaultMarkGeocode: false,
            placeholder: "Cari Alamat..."
        }).on('markgeocode', function(e) {
            var center = e.geocode.center;
            map.setView(center, 17);
            marker.setLatLng(center);
            updateFields(center.lat, center.lng);
            // Isi kolom teks alamat otomatis jika user cari lewat peta
            document.getElementById('address').value = e.geocode.name;
        }).addTo(map);
    });
</script>