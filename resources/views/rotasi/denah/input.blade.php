<!DOCTYPE html>
<html lang="en">

<head>
    @include('components/head')
    <title>Air Mutasi | Rotasi</title>
</head>

<body class="bg-[#CED0FF] font-sans tracking-wider text-lg">
    @include('components.header', ['static' => true])
    @include('components.modal-component')
    <main class="min-h-[90vh] flex justify-center items-center p-4">
        <form action="/rotasi/denah/input" method="post"
            class="w-full rounded-md bg-white md:w-2/3 p-8 flex flex-col gap-4" enctype="multipart/form-data">
            <h1 class="font-semibold text-2xl text-center">Tambah Data Cabang</h1>
            @csrf
            <section id="section-1" class="sections flex flex-col gap-1 bg-slate-200 p-2 rounded-md">
                <label for="nama" class="font-semibold">Nama Cabang</label>
                <input type="text" name="nama" id="nama" placeholder="Nama Cabang ..."
                    class="w-full p-2 border-2 border-slate-400 rounded-md" value="{{ old('nama') }}">
                <label for="alamat" class="font-semibold">Alamat Cabang</label>
                <textarea name="alamat" id="alamat" cols="30" rows="5" placeholder="Alamat ..."
                    class="resize-none w-full p-2 border-2 border-slate-400 rounded-md">{{ old('alamat') }}</textarea>
                <label for="thumbnail" class="font-semibold">Foto Tower</label>
                <button class="bg-[#7186F3] hover:bg-[#435EEF] duration-200 text-white px-2 py-1 rounded-md font-medium"
                    type="button" popovertarget="thumbnail-popover">Pilih file</button>
                <img id="thumbnail-preview" src="" alt="default" class="hidden">
                <div id="thumbnail-popover" class="border-2 rounded-lg p-4 w-1/2 max-h-[90vh]" popover>
                    <div class="flex flex-col items-center gap-2">
                        <div class="flex w-full">
                            <input type="text" name="thumbnail_url" id="thumbnail_url"
                                class="resize-none flex-grow p-2 border-2 border-slate-400 rounded-s-md"
                                placeholder="URL Foto" value="{{ old('thumbnail_url') }}">
                            <button id="thumbnail_url_set" type="button"
                                class="bg-[#383A83] text-white p-2 rounded-e-lg font-semibold">Set</button>
                        </div>
                        atau
                        <label class="bg-blue-300 px-2 py-1 rounded-md font-medium text-white hover:cursor-pointer">
                            Upload Foto (max 2MB)
                            <input type="file" name="thumbnail" id="thumbnail" class="h-0 w-0"
                                accept=".jpg,.jpeg,.png">
                        </label>
                    </div>
                </div>
                <div class="mt-3 flex justify-end gap-4 w-full">
                    <button type="button"
                        class="bg-[#7186F3] hover:bg-[#435EEF] duration-200 text-white px-4 py-2 rounded-lg font-semibold"
                        onclick="changeSection(2)">
                        Selanjutnya
                    </button>
                </div>
            </section>
            <section id="section-2" class="sections hidden flex-col gap-1 bg-slate-200 p-2 rounded-md">
                <label class="font-semibold">Kelas</label>
                <div id="kelas" class="w-full my-1">
                    @if (old('kelas'))
                        @foreach (old('kelas') as $index => $kelas)
                            @include('rotasi.components.kelas-item', [
                                'index' => $index,
                                'db_id' => $kelas,
                            ])
                        @endforeach
                    @else
                        @include('rotasi.components.kelas-item', ['index' => 1])
                    @endif
                </div>
                <button
                    class="bg-[#7186F3] hover:bg-[#435EEF] duration-200 text-white py-2 rounded-lg font-semibold w-full mt-1"
                    type="button" id="kelas_tambah">Tambah +</button>
                <div class="mt-3 flex justify-end gap-4 w-full">
                    <button type="button"
                        class="bg-gray-300 hover:bg-gray-400 duration-200 text-gray-950 px-4 py-2 rounded-lg font-semibold"
                        onclick="changeSection(1)">
                        Kembali
                    </button>
                    <button type="button"
                        class="bg-[#7186F3] hover:bg-[#435EEF] duration-200 text-white px-4 py-2 rounded-lg font-semibold"
                        onclick="changeSection(3)">
                        Selanjutnya
                    </button>
                </div>
            </section>
            <section id="section-3" class="sections hidden flex-col gap-1 bg-slate-200 p-2 rounded-md">
                <label for="jumlah_personel" class="font-semibold">Jumlah Eksisting ATC</label>
                <input type="number" name="jumlah_personel" id="jumlah_personel" placeholder="Jumlah Eksisting ..."
                    class="resize-none w-full p-2 mt-1 border-2 border-slate-400 rounded-md"
                    value="{{ old('jumlah_personel') }}">
                <label for="formasi" class="font-semibold">Jumlah Optimal ATC</label>
                <input type="number" name="formasi" id="formasi" placeholder="Jumlah Optimal ..."
                    class="resize-none w-full p-2 mt-1 border-2 border-slate-400 rounded-md"
                    value="{{ old('formasi') }}">
                <label for="frms" class="font-semibold">FRMS ATC</label>
                <input type="number" name="frms" id="frms" placeholder="FRMS ..."
                    class="resize-none w-full p-2 mt-1 border-2 border-slate-400 rounded-md"
                    value="{{ old('frms') }}">
                <div class="mt-3 flex justify-end gap-4 w-full">
                    <button type="button"
                        class="bg-gray-300 hover:bg-gray-400 duration-200 text-gray-950 px-4 py-2 rounded-lg font-semibold"
                        onclick="changeSection(2)">
                        Kembali
                    </button>
                    <button type="button"
                        class="bg-[#7186F3] hover:bg-[#435EEF] duration-200 text-white px-4 py-2 rounded-lg font-semibold"
                        onclick="changeSection(4)">
                        Selanjutnya
                    </button>
                </div>
            </section>
            <section id="section-4" class="sections hidden flex-col gap-1 bg-slate-200 p-2 rounded-md">
                <label for="jumlah_personel_aco" class="font-semibold">Jumlah Eksisting ACO</label>
                <input type="number" name="jumlah_personel_aco" id="jumlah_personel_aco"
                    placeholder="Jumlah Eksisting ..."
                    class="resize-none w-full p-2 mt-1 border-2 border-slate-400 rounded-md"
                    value="{{ old('jumlah_personel_aco') }}">
                <label for="formasi_aco" class="font-semibold">Jumlah Optimal ACO</label>
                <input type="number" name="formasi_aco" id="formasi_aco" placeholder="Jumlah Optimal ..."
                    class="resize-none w-full p-2 mt-1 border-2 border-slate-400 rounded-md"
                    value="{{ old('formasi_aco') }}">
                <div class="mt-3 flex justify-end gap-4 w-full">
                    <button type="button"
                        class="bg-gray-300 hover:bg-gray-400 duration-200 text-gray-950 px-4 py-2 rounded-lg font-semibold"
                        onclick="changeSection(3)">
                        Kembali
                    </button>
                    <button type="button"
                        class="bg-[#7186F3] hover:bg-[#435EEF] duration-200 text-white px-4 py-2 rounded-lg font-semibold"
                        onclick="changeSection(5)">
                        Selanjutnya
                    </button>
                </div>
            </section>
            <section id="section-5" class="sections hidden flex-col gap-1 bg-slate-200 p-2 rounded-md">
                <label for="jumlah_personel_ais" class="font-semibold">Jumlah Eksisting AIS</label>
                <input type="number" name="jumlah_personel_ais" id="jumlah_personel_ais"
                    placeholder="Jumlah Eksisting ..."
                    class="resize-none w-full p-2 mt-1 border-2 border-slate-400 rounded-md"
                    value="{{ old('jumlah_personel_ais') }}">
                <label for="formasi_ais" class="font-semibold">Jumlah Optimal AIS</label>
                <input type="number" name="formasi_ais" id="formasi_ais" placeholder="Jumlah Optimal ..."
                    class="resize-none w-full p-2 mt-1 border-2 border-slate-400 rounded-md"
                    value="{{ old('formasi_ais') }}">
                <div class="mt-3 flex justify-end gap-4 w-full">
                    <button type="button"
                        class="bg-gray-300 hover:bg-gray-400 duration-200 text-gray-950 px-4 py-2 rounded-lg font-semibold"
                        onclick="changeSection(4)">
                        Kembali
                    </button>
                    <button type="button"
                        class="bg-[#7186F3] hover:bg-[#435EEF] duration-200 text-white px-4 py-2 rounded-lg font-semibold"
                        onclick="changeSection(6)">
                        Selanjutnya
                    </button>
                </div>
            </section>
            <section id="section-6" class="sections hidden flex-col gap-1 bg-slate-200 p-2 rounded-md">
                <label for="jumlah_personel_atfm" class="font-semibold">Jumlah Eksisting ATFM</label>
                <input type="number" name="jumlah_personel_atfm" id="jumlah_personel_atfm"
                    placeholder="Jumlah Eksisting ..."
                    class="resize-none w-full p-2 mt-1 border-2 border-slate-400 rounded-md"
                    value="{{ old('jumlah_personel_atfm') }}">
                <label for="formasi_atfm" class="font-semibold">Jumlah Optimal ATFM</label>
                <input type="number" name="formasi_atfm" id="formasi_atfm" placeholder="Jumlah Optimal ..."
                    class="resize-none w-full p-2 mt-1 border-2 border-slate-400 rounded-md"
                    value="{{ old('formasi_atfm') }}">
                <div class="mt-3 flex justify-end gap-4 w-full">
                    <button type="button"
                        class="bg-gray-300 hover:bg-gray-400 duration-200 text-gray-950 px-4 py-2 rounded-lg font-semibold"
                        onclick="changeSection(5)">
                        Kembali
                    </button>
                    <button type="button"
                        class="bg-[#7186F3] hover:bg-[#435EEF] duration-200 text-white px-4 py-2 rounded-lg font-semibold"
                        onclick="changeSection(7)">
                        Selanjutnya
                    </button>
                </div>
            </section>
            <section id="section-7" class="sections hidden flex-col gap-1 bg-slate-200 p-2 rounded-md">
                <label for="jumlah_personel_tapor" class="font-semibold">Jumlah Eksisting TAPOR</label>
                <input type="number" name="jumlah_personel_tapor" id="jumlah_personel_tapor"
                    placeholder="Jumlah Eksisting ..."
                    class="resize-none w-full p-2 mt-1 border-2 border-slate-400 rounded-md"
                    value="{{ old('jumlah_personel_tapor') }}">
                <label for="formasi_tapor" class="font-semibold">Jumlah Optimal TAPOR</label>
                <input type="number" name="formasi_tapor" id="formasi_tapor" placeholder="Jumlah Optimal ..."
                    class="resize-none w-full p-2 mt-1 border-2 border-slate-400 rounded-md"
                    value="{{ old('formasi_tapor') }}">
                <div class="mt-3 flex justify-end gap-4 w-full">
                    <button type="button"
                        class="bg-gray-300 hover:bg-gray-400 duration-200 text-gray-950 px-4 py-2 rounded-lg font-semibold"
                        onclick="changeSection(6)">
                        Kembali
                    </button>
                    <button type="button"
                        class="bg-[#7186F3] hover:bg-[#435EEF] duration-200 text-white px-4 py-2 rounded-lg font-semibold"
                        onclick="changeSection(8)">
                        Selanjutnya
                    </button>
                </div>
            </section>
            <section id="section-8" class="sections hidden flex-col gap-1 bg-slate-200 p-2 rounded-md">
                <label for="jumlah_personel_ats_system" class="font-semibold">Jumlah Eksisting ATS System</label>
                <input type="number" name="jumlah_personel_ats_system" id="jumlah_personel_ats_system"
                    placeholder="Jumlah Eksisting ..."
                    class="resize-none w-full p-2 mt-1 border-2 border-slate-400 rounded-md"
                    value="{{ old('jumlah_personel_ats_system') }}">
                <label for="formasi_ats_system" class="font-semibold">Jumlah Optimal ATS System</label>
                <input type="number" name="formasi_ats_system" id="formasi_ats_system"
                    placeholder="Jumlah Optimal ..."
                    class="resize-none w-full p-2 mt-1 border-2 border-slate-400 rounded-md"
                    value="{{ old('formasi_ats_system') }}">
                <div class="mt-3 flex justify-end gap-4 w-full">
                    <button type="button"
                        class="bg-gray-300 hover:bg-gray-400 duration-200 text-gray-950 px-4 py-2 rounded-lg font-semibold"
                        onclick="changeSection(7)">
                        Kembali
                    </button>
                    <button type="button"
                        class="bg-[#7186F3] hover:bg-[#435EEF] duration-200 text-white px-4 py-2 rounded-lg font-semibold"
                        onclick="changeSection(9)">
                        Selanjutnya
                    </button>
                </div>
            </section>
            <section id="section-9" class="sections hidden flex-col items-center gap-1 bg-slate-200 p-2 rounded-md">
                <label class="select-none">
                    <input type="checkbox" name="induk" id="induk" {{ old('induk') ? 'checked' : '' }}>
                    Cabang Induk ?
                </label>
                <div id="map" class="h-0 z-10 w-full">
                    <div class="w-full h-full flex items-center justify-center" id="loading">
                        <img src="/images/icons/ripples.svg" alt="loading"
                            class="w-20 h-20 z-40 p-2 bg-white rounded-full">
                    </div>
                </div>
                <div class="hidden w-full" id="latlng">
                    <label for="latitude" class="font-semibold">Coordinate</label>
                    <div class="flex gap-2">
                        <input type="text" name="latitude" id="latitude" value="{{ old('latitude') }}"
                            class="resize-none w-full p-2 mt-1 border-2 border-slate-400 rounded-md"
                            placeholder="Latitude" step=".00000001">
                        <input type="text" name="longitude" id="longitude"
                            value="{{ old('longitude') }}"class="resize-none w-full p-2 mt-1 border-2 border-slate-400 rounded-md"
                            placeholder="Longitude" step=".00000001">
                    </div>
                </div>
                <div class="mt-3 flex justify-end gap-4 w-full">
                    <button type="button"
                        class="bg-gray-300 hover:bg-gray-400 duration-200 text-gray-950 px-4 py-2 rounded-lg font-semibold"
                        onclick="changeSection(8)">
                        Kembali
                    </button>
                    <button type="submit"
                        class="bg-[#7186F3] hover:bg-[#435EEF] duration-200 text-white px-4 py-2 rounded-lg font-semibold">
                        Simpan
                    </button>
                </div>
            </section>
        </form>
    </main>
    @include('components.footer')
    <script src="/script/nav.js"></script>
    <script src="/script/map.js"></script>
    <script>
        function changeSection(section) {
            document.querySelectorAll('.sections').forEach(s => s.classList.add('hidden'));
            document.querySelector(`#section-${section}`).classList.remove('hidden');
            document.querySelector(`#section-${section}`).classList.add('flex');
        }
    </script>
    <script>
        // (re)bind delete button event for item by id
        function bindDeleteBtn(id) {
            document.querySelector(`#${id} > button`).addEventListener('click', function() {
                this.parentElement.remove();
            });
        }
    </script>
    <script>
        // counter for kompetensi id
        var kelasCount = 1;

        // bind delete button event for initial kompetensi item
        document.querySelectorAll(".kelas-item").forEach(kelas => {
            bindDeleteBtn(kelas.id);
        });

        // add kelas item
        document.querySelector("#kelas_tambah").addEventListener('click', function() {
            const kelasContainer = document.querySelector('#kelas');
            kelasContainer.insertAdjacentHTML("beforeend", `@include('rotasi.components.kelas-item', [
                'index' => '${kelasCount + 1}',
            ])`);
            document.querySelectorAll(".kelas-item").forEach(kelas => {
                bindDeleteBtn(kelas.id);
            });
            kelasCount++;
        });
    </script>
    <script>
        // set preview when thumbnail file value is changed
        document.getElementById("thumbnail").addEventListener("change", function() {
            var file = this.files[0];
            var reader = new FileReader();
            reader.onload = function(e) {
                document.querySelector("#thumbnail-preview").src = e.target.result;
                document.querySelector("#thumbnail-preview").classList.remove("hidden");
                document.querySelector("#thumbnail-popover").hidePopover();
                document.querySelector("#thumbnail_url").value = "";
            }
            reader.readAsDataURL(file);
        });
        // set preview when thumbnail url is set
        document.getElementById("thumbnail_url_set").addEventListener("click", function() {
            var url = document.getElementById("thumbnail_url").value;
            document.querySelector("#thumbnail-preview").src = url;
            document.querySelector("#thumbnail-preview").classList.remove("hidden");
            document.querySelector("#thumbnail-popover").hidePopover();
            document.querySelector("#thumbnail").value = "";
        });
    </script>
    <script>
        // marker / pointer container
        var marker;

        // set the map input if induk is checked
        const setInduk = () => {
            if (document.getElementById("induk").checked) {
                document.getElementById("map").classList.remove("h-0");
                document.getElementById("map").classList.add("h-[50vh]");
                document.getElementById("latlng").classList.remove("hidden");
                map = InitMap();

                // set marker on click
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

        // set marker from coordinate input value
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
