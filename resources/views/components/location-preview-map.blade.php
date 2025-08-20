<div
    x-data="{
        map: null,
        marker: null,

        init() {
            this.$nextTick(() => {
                let coords = @js($location ? explode(',', $location) : null);
                if (!coords) return;

                let lat = coords[0];
                let lng = coords[1];

                // ✅ Reset container biar tidak error already initialized
                if (this.$refs.mapElement._leaflet_id) {
                    this.$refs.mapElement._leaflet_id = null;
                }

                this.map = L.map(this.$refs.mapElement).setView([lat, lng], 15);
                window.LeafletPreviewInstance = this.map;

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                }).addTo(this.map);

                this.marker = L.marker([lat, lng]).addTo(this.map);

                setTimeout(() => {
                    this.map.invalidateSize();
                }, 400);
            });
        }
    }"
    x-init="init"
    class="space-y-2"
>
    <div class="w-full h-96 rounded-md overflow-hidden border" x-ref="mapElement"></div>
</div>

@push('scripts')
<script
    src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-o9N1jXlJ+jU7b7y6Nypzv5sdHmsBo33+Z/5T9TJ3nEo="
    crossorigin=""
></script>

<script>
    // ✅ Fix default marker path
    L.Icon.Default.mergeOptions({
        iconRetinaUrl: '/images/marker-icon-2x.png',
        iconUrl: '/images/marker-icon.png',
        shadowUrl: '/images/marker-shadow.png',
    });

    // ✅ Re-render jika dipanggil dari modal Filament
    document.addEventListener('filament-modal-opened', () => {
        setTimeout(() => {
            if (window.LeafletPreviewInstance) {
                window.LeafletPreviewInstance.invalidateSize();
            }
        }, 400);
    });
</script>
@endpush

@push('styles')
<link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-oH+m3D6myEnHlv9TZzjLp6F68MWVnE9oV4Vm7xyS3fQ="
    crossorigin=""
/>
@endpush
