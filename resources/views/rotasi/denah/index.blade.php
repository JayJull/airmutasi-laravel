<!DOCTYPE html>
<html lang="en">

<head>
    @include('components/head')
    <title>Air Mutasi | Rotasi</title>
</head>

<body class="bg-[#CED0FF] font-poppins">
    @include('rotasi.components.header')
    @if (session('success'))
        @include('components.modal', ['message' => session('success')])
    @endif
    <main>
        <section class="h-[50vh] md:h-screen w-full">
            <div id="map" class="w-full h-full z-40"></div>
        </section>
        <section class="p-4 flex flex-col items-center gap-2 bg-[#29367688]">
            <input id="search" class="w-full sm:w-3/4 md:w-2/3 border-[6px] rounded-xl px-2 py-1 border-[#293676]" type="search"
                placeholder="Search ..." />
            <section class="w-full sm:w-3/4 md:w-2/3 flex flex-col-reverse sm:flex-row gap-2 sm:max-h-[50vh]">
                <aside id="anak-cabang"
                    class="bg-[#293676] sm:max-w-[50%] h-[50vh] sm:h-auto flex-grow text-[#474747] p-2 rounded-xl flex flex-col gap-2 overflow-y-auto">
                    @foreach ($cabangs as $cabang)
                        @include('rotasi.components.cabang-item', ['cabang' => $cabang])
                    @endforeach
                </aside>
                <aside
                    class="bg-[#293676] sm:max-w-[50%] flex-grow text-[#474747] p-2 rounded-xl flex flex-col gap-2 overflow-y-auto">
                    <div class="flex items-center justify-center bg-white h-40 rounded-lg">
                        <img id="thumbnail-placeholder" src="/images/icons/Full Image.svg" alt="image" />
                        <img id="thumbnail" class="hidden w-full h-full object-cover" />
                    </div>
                    <p id="alamat" class="text-white p-2">
                        Pilih Cabang
                    </p>
                    <a id="detail" class="bg-white p-2 rounded-lg text-center font-semibold hidden">
                        Detail
                    </a>
                </aside>
            </section>
        </section>
    </main>
    @include('components.footer')
    <script src="/script/nav.js"></script>
    <script src="/script/map.js"></script>
    <script src="/script/debounce.js"></script>
    <script>
        function setCabang(cabang) {
            document.getElementById('thumbnail').src = `/storage${cabang.thumbnail}`;
            document.getElementById('thumbnail-placeholder').classList.add('hidden');
            document.getElementById('thumbnail').classList.remove('hidden');
            document.getElementById('alamat').innerText = cabang.alamat;
            document.getElementById('detail').classList.remove('hidden');
            document.getElementById('detail').href = `/rotasi/denah/${cabang.id}`;
            if (cabang.anak_cabang) {
                document.getElementById('anak-cabang').innerHTML = [cabang, ...cabang.anak_cabang].map(cabang =>
                    `@include('rotasi.components.cabang-item', ['cabang' => false])`).join('');
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
