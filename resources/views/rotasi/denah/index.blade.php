<!DOCTYPE html>
<html lang="en">

<head>
    @include('components/head')
    <title>Air Mutasi | Rotasi</title>
</head>

<body class="bg-[#CED0FF] font-poppins">
    @include('rotasi.components.header')
    @include('components.modal-component')
    <main>
        <section class="h-[50vh] md:h-screen w-full">
            <div id="map" class="w-full h-full z-40"></div>
        </section>
        <section class="p-4 flex flex-col items-center gap-2 bg-[#29367688]">
            <input id="search" class="w-full sm:w-5/6 md:w-2/3 border-[0.5rem] rounded-xl px-2 py-1 border-[#293676]"
                type="search" placeholder="Search ..." />
            <section class="w-full sm:w-5/6 md:w-2/3 flex flex-col-reverse sm:grid sm:grid-cols-2 gap-2">
                <aside id="anak-cabang"
                    class="bg-[#293676] col-span-2 sm:col-span-1 text-[#474747] p-2 rounded-xl flex flex-col gap-2 max-h-[70vh] overflow-y-auto">
                    @if (count($cabangs) === 0)
                        <p class="text-center text-white my-auto">Tidak ada data</p>
                    @endif
                    @foreach ($cabangs as $cabang)
                        @include('rotasi.components.cabang-item', ['cabang' => $cabang])
                    @endforeach
                </aside>
                <aside
                    class="bg-[#293676] col-span-2 sm:col-span-1 text-[#474747] p-2 rounded-xl flex flex-col gap-2 max-h-[70vh] overflow-y-auto">
                    <div class="flex items-center justify-center bg-white h-40 rounded-lg">
                        <img id="thumbnail-placeholder" src="/images/icons/Full Image.svg" alt="image" />
                        <img id="thumbnail" class="hidden w-full h-full object-cover" />
                    </div>
                    <h1 id="nama" class="text-white px-2 font-semibold text-lg hidden"></h1>
                    <p id="alamat" class="text-white p-2 text-center">
                        Pilih Cabang
                    </p>
                    <a id="detail" class="bg-white p-2 rounded-lg text-center font-semibold hidden">
                        Detail
                    </a>
                </aside>
            </section>
            @if (Auth::user()->role->name === 'admin')
                <a href="/rotasi/denah/input"
                    class="bg-[#293676] text-white w-full sm:w-5/6 md:w-2/3 text-center p-2 rounded-lg font-semibold">Tambah Cabang</a>
            @endif
        </section>
    </main>
    @include('components.footer')
    <script src="/script/nav.js"></script>
    <script src="/script/map.js"></script>
    <script src="/script/debounce.js"></script>
    <script>
        function setCabang(cabang) {
            document.getElementById('thumbnail').src = cabang.thumbnail_url || "/images/default_tower.jpg";
            document.getElementById('thumbnail-placeholder').classList.add('hidden');
            document.getElementById('thumbnail').classList.remove('hidden');
            document.getElementById('alamat').classList.remove('text-center');
            document.getElementById('alamat').innerText = cabang.alamat;
            document.getElementById('detail').classList.remove('hidden');
            document.getElementById('detail').href = `/rotasi/denah/${cabang.id}`;
            document.getElementById('nama').classList.remove('hidden');
            document.getElementById('nama').innerText = cabang.nama;
            if (cabang.longitude || cabang.latitude) {
                document.getElementById('anak-cabang').innerHTML = `@include('rotasi.components.cabang-item', ['cabang' => false])`;
                document.getElementById("search").value = cabang.nama;
            }
        }

        function bindCabangItemClick() {
            document.querySelectorAll('.cabang-item').forEach(cabangItem => {
                cabangItem.addEventListener('click', () => {
                    fetch(`/api/rotasi/cabang-summary/${cabangItem.value}`)
                        .then(response => response.json())
                        .then(data => {
                            setCabang(data);
                        });
                });
            })
        }
        bindCabangItemClick();

        document.getElementById('search').addEventListener('input', debounce(() => {
            const search = document.getElementById('search').value;
            fetch(`/api/rotasi/cabang-search?search=${search}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('anak-cabang').innerHTML = data.map(cabang =>
                        `@include('rotasi.components.cabang-item', ['cabang' => false])`).join('');
                    bindCabangItemClick();
                });
        }, 200));
        fetch('/api/rotasi/cabang-induk')
            .then(response => response.json())
            .then(data => {
                data.forEach(element => {
                    L.marker([element.latitude, element.longitude], {
                        icon: L.icon({
                            iconUrl: '/images/icons/marker.svg',
                            iconSize: [30, 30],
                            iconAnchor: [15, 30],
                            popupAnchor: [0, -30],
                        }),
                    }).addTo(map).on('click', () => {
                        setCabang(element);
                    });
                });
            });
    </script>
</body>

</html>
