<div
    x-data="{
        lat: null,
        lng: null,
        map: null,
        marker: null,
        geocoder: null,

        initMap() {
            // ✅ Reset container biar tidak error already initialized
            if (this.$refs.mapElement._leaflet_id) {
                this.$refs.mapElement._leaflet_id = null;
            }

            this.map = L.map(this.$refs.mapElement).setView([-6.9583186, 107.5272916], 13);
            window.LeafletPickerInstance = this.map; // simpan instance

            // Tile OSM
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
            }).addTo(this.map);

            // Geocoder (pakai Photon)
            if (L.Control.geocoder) {
                this.geocoder = L.Control.geocoder({
                    defaultMarkGeocode: false,
                    placeholder: 'Cari alamat...',
                    geocoder: new L.Control.Geocoder.Photon() // ✅ gunakan Photon
                })
                .on('markgeocode', (e) => {
                    let latlng = e.geocode.center;
                    this.lat = latlng.lat.toFixed(6);
                    this.lng = latlng.lng.toFixed(6);
                    this.updateLocation();
                    this.map.setView(latlng, 16);
                })
                .addTo(this.map);
            }

            // Klik map → pasang marker
            this.map.on('click', (e) => {
                this.lat = e.latlng.lat.toFixed(6);
                this.lng = e.latlng.lng.toFixed(6);
                this.updateLocation();
            });

            setTimeout(() => {
                this.map.invalidateSize();
            }, 400);
        },

        updateLocation() {
            if (this.marker) {
                this.map.removeLayer(this.marker);
            }
            this.marker = L.marker([this.lat, this.lng]).addTo(this.map);

            // Simpan ke Livewire state
            $wire.set('{{ $getStatePath() }}', `${this.lat},${this.lng}`, true);
        },

        updateFromInput() {
            if (this.lat && this.lng) {
                this.updateLocation();
                this.map.setView([this.lat, this.lng], 15);
            }
        },

        init() {
            this.$nextTick(() => {
                this.initMap();

                // Jika ada koordinat dari DB
                @if ($getState())
                    let coords = @js(explode(',', $getState()));
                    this.lat = coords[0];
                    this.lng = coords[1];
                    this.updateLocation();
                    this.map.setView([this.lat, this.lng], 15);
                @endif

                // ✅ perbaiki bug modal Filament
                document.addEventListener('filament-modal-opened', () => {
                    setTimeout(() => {
                        if (window.LeafletPickerInstance) {
                            window.LeafletPickerInstance.invalidateSize();
                        }
                    }, 400);
                });
            });
        }
    }"
    x-init="init"
    class="space-y-3"
>
    {{-- Map --}}
    <div wire:ignore class="w-full h-96 rounded-md overflow-hidden border" x-ref="mapElement"></div>

    {{-- Input manual --}}
    <div class="grid grid-cols-2 gap-2">
        <div>
            <label class="text-sm text-gray-700">Latitude</label>
            <input type="text" x-model="lat" @change="updateFromInput"
                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
        </div>
        <div>
            <label class="text-sm text-gray-700">Longitude</label>
            <input type="text" x-model="lng" @change="updateFromInput"
                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
        </div>
    </div>

    <p class="text-sm text-gray-600">Cari alamat atau klik di peta untuk memilih lokasi.</p>
</div>

@push('styles')
    {{-- Leaflet Control Geocoder CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
@endpush

@push('scripts')
<script>
    // ✅ Custom marker (gunakan asset lokal)
    L.Icon.Default.mergeOptions({
        iconRetinaUrl: '/images/marker-icon-2x.png',
        iconUrl: '/images/marker-icon.png',
        shadowUrl: '/images/marker-shadow.png',
    });
</script>

{{-- Leaflet Control Geocoder JS --}}
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
@endpush
