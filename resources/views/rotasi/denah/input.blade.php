<!DOCTYPE html>
<html lang="en">

<head>
    @include('components/head')
    <title>Air Mutasi | Rotasi</title>
</head>

<body class="bg-[#CED0FF] font-poppins">
    @include('rotasi.components.header', ['static' => true])
    @include('components.modal-component')
    <main class="min-h-[90vh] flex justify-center items-center p-4">
        <form action="/rotasi/denah/input" method="post" class="w-2/3 flex flex-col gap-1 bg-white p-4 rounded-lg"
            enctype="multipart/form-data">
            @csrf
            <label for="nama" class="font-semibold">Nama Cabang</label>
            <input type="text" name="nama" id="nama" placeholder="Nama Cabang ..."
                class="resize-none w-full p-2 mt-1 border-2 border-slate-400 rounded-md" value="{{ old('nama') }}">
            <label for="alamat" class="font-semibold">Alamat Cabang</label>
            <textarea name="alamat" id="alamat" cols="30" rows="10" placeholder="Alamat ..."
                class="resize-none w-full p-2 mt-1 border-2 border-slate-400 rounded-md">{{ old('alamat') }}</textarea>
            <label for="thumbnail" class="font-semibold">Foto Tower</label>
            <input type="text" name="thumbnail_url" id="thumbnail"
                class="resize-none w-full p-2 mt-1 border-2 border-slate-400 rounded-md" placeholder="URL Foto"
                value="{{ old('thumbnail_url') }}">
            <label for="jumlah_personel" class="font-semibold">Jumlah Personel Terkini</label>
            <input type="number" name="jumlah_personel" id="jumlah_personel" placeholder="Jumlah Personel ..."
                class="resize-none w-full p-2 mt-1 border-2 border-slate-400 rounded-md"
                value="{{ old('jumlah_personel') }}">
            <label for="formasi" class="font-semibold">Formasi</label>
            <input type="number" name="formasi" id="formasi" placeholder="Formasi ..."
                class="resize-none w-full p-2 mt-1 border-2 border-slate-400 rounded-md" value="{{ old('formasi') }}">
            <label for="frms" class="font-semibold">FRMS</label>
            <input type="number" name="frms" id="frms" placeholder="FRMS ..."
                class="resize-none w-full p-2 mt-1 border-2 border-slate-400 rounded-md" value="{{ old('frms') }}">
            <label class="select-none">
                <input type="checkbox" name="induk" id="induk" {{ old('induk') ? 'checked' : '' }}>
                Cabang Induk
            </label>
            <div id="map" class="h-0">
                <div class="w-full h-full flex items-center justify-center" id="loading">
                    <img src="/images/icons/ripples.svg" alt="loading" class="w-20 h-20 z-40 p-2 bg-white rounded-full">
                </div>
            </div>
            <div class="hidden" id="latlng">
                <label for="latitude" class="font-semibold">Coordinate</label>
                <div class="flex gap-2">
                    <input type="text" name="latitude" id="latitude" value="{{ old('latitude') }}"
                        class="resize-none w-full p-2 mt-1 border-2 border-slate-400 rounded-md" placeholder="Latitude"
                        step=".00000001">
                    <input type="text" name="longitude" id="longitude"
                        value="{{ old('longitude') }}"class="resize-none w-full p-2 mt-1 border-2 border-slate-400 rounded-md"
                        placeholder="Longitude" step=".00000001">
                </div>
            </div>
            <button type="submit" class="bg-[#383A83] text-white py-2 rounded-lg font-semibold">Simpan</button>
        </form>
    </main>
    @include('components.footer')
    <script src="/script/nav.js"></script>
    <script src="/script/map.js"></script>
    <script>
        var marker;
        const setInduk = () => {
            if (document.getElementById("induk").checked) {
                document.getElementById("map").classList.remove("h-0");
                document.getElementById("map").classList.add("h-[50vh]");
                document.getElementById("latlng").classList.remove("hidden");
                map = InitMap();
                map.on('click', function(e) {
                    var lat = e.latlng.lat;
                    var lng = e.latlng.lng;
                    document.getElementById("latitude").value = lat;
                    document.getElementById("longitude").value = lng;
                    if (marker) {
                        marker.remove();
                    }
                    marker = new L.marker([lat, lng], {
                        icon: L.icon({
                            iconUrl: '/images/icons/marker.svg',
                            iconSize: [30, 30],
                            iconAnchor: [15, 30],
                            popupAnchor: [0, -30],
                        }),
                    }).addTo(map);
                });
            } else {
                document.getElementById("map").classList.remove("h-[50vh]");
                document.getElementById("map").classList.add("h-0");
                document.getElementById("latlng").classList.add("hidden");
            }
        }
        const setMarkerFromCoord = () => {
            var lat = document.getElementById("latitude").value;
            var lng = document.getElementById("longitude").value;
            if (lat && lng) {
                if (marker) marker.remove();
                marker = new L.marker([lat, lng], {
                    icon: L.icon({
                        iconUrl: '/images/icons/marker.svg',
                        iconSize: [30, 30],
                        iconAnchor: [15, 30],
                        popupAnchor: [0, -30],
                    }),
                }).addTo(map);
            }
        }
        document.getElementById("induk").addEventListener("change", setInduk);
        document.getElementById("latitude").addEventListener("input", setMarkerFromCoord);
        document.getElementById("longitude").addEventListener("input", setMarkerFromCoord);
        setInduk();
        setMarkerFromCoord();
    </script>
</body>

</html>
