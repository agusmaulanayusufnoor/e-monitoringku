<div
    x-data="{
        lat: null,
        lng: null,
        map: null,
        marker: null,
        geocoder: null,
        customIcon: null,

        initMap() {
            if (this.$refs.mapElement._leaflet_id) {
                this.$refs.mapElement._leaflet_id = null;
            }

            this.map = L.map(this.$refs.mapElement).setView([-6.9583186, 107.5272916], 13);
            window.LeafletPickerInstance = this.map;

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
            }).addTo(this.map);

            if (L.Control.geocoder) {
                this.geocoder = L.Control.geocoder({
                    defaultMarkGeocode: false,
                    placeholder: 'Cari alamat...',
                    geocoder: new L.Control.Geocoder.Photon()
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

            this.marker = L.marker([this.lat, this.lng], {
                icon: this.customIcon
            }).addTo(this.map);

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
                // ✅ Buat custom icon dulu
                this.customIcon = L.icon({
                    iconUrl: `${window.location.origin}/images/marker-icon.png`,
                    iconRetinaUrl: `${window.location.origin}/images/marker-icon-2x.png`,
                    shadowUrl: `${window.location.origin}/images/marker-shadow.png`,
                    iconSize: [25, 41],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34],
                    shadowSize: [41, 41],
                });

                this.initMap();

                @if ($getState())
                    let coords = @js(explode(',', $getState()));
                    this.lat = coords[0];
                    this.lng = coords[1];
                    this.updateLocation();
                    this.map.setView([this.lat, this.lng], 15);
                @endif

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
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
@endpush