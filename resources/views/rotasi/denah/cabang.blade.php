<!DOCTYPE html>
<html lang="en">

<head>
    @include('components/head')
    <title>Air Mutasi | Rotasi</title>
</head>

<body class="font-geruduk tracking-wider text-lg">
    @include('components.header', ['static' => true])
    <main>
        <section class="bg-[#FFEFB2] p-8 flex flex-col md:grid md:grid-cols-3 gap-8">
            <aside class="col-span-3 md:col-span-1 sm:h-full flex flex-col">
                <div class="flex items-center justify-center h-64 rounded-lg">
                    <img src="{{ $cabang->thumbnail_url && $cabang->thumbnail_url != 'NULL' ? $cabang->thumbnail_url : '/images/default_tower.jpg' }}"
                        alt="foto cabang" class="w-full h-full object-cover rounded-lg">
                </div>
                <h1 id="nama" class="p-2 font-semibold text-lg">
                    {{ $cabang->nama }}
                </h1>
                <div class="px-2 flex gap-2">
                    @foreach ($cabang->kelases as $kelas)
                        <p class="text-xs bg-gray-300 px-2 py-1 rounded-md">{{ $kelas->kelas->nama_kelas }}</p>
                    @endforeach
                </div>
                <p class="p-2">
                    {{ $cabang->alamat }}
                </p>
                <a class="bg-[#7186F3] hover:bg-[#435EEF] duration-200 text-white w-full text-center p-2 rounded-lg font-semibold mb-2"
                    href="/personel/cabang/{{ $cabang->id }}">Personel</a>
                @can('admin')
                    <a href="/rotasi/denah/input/{{ $cabang->id }}"
                        class="bg-yellow-300 hover:bg-yellow-400 duration-200 text-gray-800 w-full text-center p-2 rounded-lg font-semibold mb-2">Update
                        Cabang</a>
                    <a href="/rotasi/denah/input/{{ $cabang->id }}/delete"
                        class="bg-red-500 hover:bg-red-700 duration-200 text-white w-full text-center p-2 rounded-lg font-semibold">Hapus
                        Cabang</a>
                @endcan
            </aside>
            <aside class="flex-grow col-span-3 md:col-span-2 grid md:grid-cols-2 md:grid-rows-1 gap-4">
                <div class="col-span-2 md:col-span-1 flex items-center justify-center bg-white rounded-lg p-4">
                    <div id="stats-bar" class="w-full h-full"></div>
                </div>
                <div class="col-span-2 md:col-span-1 flex items-center justify-center bg-white rounded-lg p-4">
                    <div id="stats-pie" class="w-full h-full"></div>
                </div>
                <div class="col-span-2 grid grid-cols-2 gap-2 bg-white rounded-lg p-4">
                    <div class="col-span-2 sm:col-span-1 border-4 rounded-lg flex flex-col justify-center p-2">
                        <h2 class="font-bold text-xl text-center">Jumlah Maksimal FRMS</h2>
                        <hr class="border-[1px] my-1">
                        <p class="font-medium ms-4">ATC {{ $cabang->formasi }} Orang</p>
                        <p class="font-medium ms-4">ACO {{ $cabang->formasi_aco }} Orang</p>
                        <p class="font-medium ms-4">AIS {{ $cabang->formasi_ais }} Orang</p>
                        <p class="font-medium ms-4">ATFM {{ $cabang->formasi_atfm }} Orang</p>
                        <p class="font-medium ms-4">TAPOR {{ $cabang->formasi_tapor }} Orang</p>
                        <p class="font-medium ms-4">ATS System {{ $cabang->formasi_ats_system }} Orang</p>
                    </div>
                    <div
                        class="col-span-2 sm:col-span-1 border-4 rounded-lg flex flex-col items-center justify-center p-2">
                        <h2 class="font-bold text-xl">Jumlah Minimal FRMS</h2>
                        <p class="font-medium">ATC {{ $cabang->frms }} Orang</p>
                    </div>
                    <div class="col-span-2 sm:col-span-1 border-4 rounded-lg flex flex-col justify-center p-2">
                        <h2 class="font-bold text-xl text-center">Jumlah Eksisting</h2>
                        <hr class="border-[1px] my-1">
                        <p class="font-medium ms-4">ATC {{ $cabang->jumlah_personel }} Orang</p>
                        <p class="font-medium ms-4">ACO {{ $cabang->jumlah_personel_aco }} Orang</p>
                        <p class="font-medium ms-4">AIS {{ $cabang->jumlah_personel_ais }} Orang</p>
                        <p class="font-medium ms-4">ATFM {{ $cabang->jumlah_personel_atfm }} Orang</p>
                        <p class="font-medium ms-4">TAPOR {{ $cabang->jumlah_personel_tapor }} Orang</p>
                        <p class="font-medium ms-4">ATS System {{ $cabang->jumlah_personel_ats_system }} Orang</p>
                    </div>
                    <div class="col-span-2 sm:col-span-1 border-4 rounded-lg flex flex-col justify-center p-2">
                        <h2 class="font-bold text-xl text-center">Prediksi Personel {{ date('Y') + 1 }}</h2>
                        <hr class="border-[1px] my-1">
                        <p class="font-medium ms-4">
                            ATC {{ $cabang->jumlah_personel + count($cabang->in) - count($cabang->out) }} Orang</p>
                        <p class="font-medium ms-4">
                            ACO {{ $cabang->jumlah_personel_aco + count($cabang->inACO) - count($cabang->outACO) }}
                            Orang</p>
                        <p class="font-medium ms-4">
                            AIS {{ $cabang->jumlah_personel_ais + count($cabang->inAIS) - count($cabang->outAIS) }}
                            Orang</p>
                        <p class="font-medium ms-4">
                            ATFM {{ $cabang->jumlah_personel_atfm + count($cabang->inATFM) - count($cabang->outATFM) }}
                            Orang</p>
                        <p class="font-medium ms-4">
                            TAPOR
                            {{ $cabang->jumlah_personel_tapor + count($cabang->inTAPOR) - count($cabang->outTAPOR) }}
                            Orang</p>
                        <p class="font-medium ms-4">
                            ATS System
                            {{ $cabang->jumlah_personel_ats_system + count($cabang->inATSSystem) - count($cabang->outATSSystem) }}
                            Orang</p>
                    </div>
                </div>
            </aside>
        </section>
        <section class="p-8">
            <div class="bg-white rounded-lg border-2 border-[#293676]">
                <div class="flex gap-4 p-4 border-b-2 border-[#293676] text-[#293676]">
                    <a class="{{ $tab != 'out' ? 'font-semibold' : '' }}"
                        href="/rotasi/denah/{{ $cabang->id }}?tab=in">PERSONEL IN</a>
                    <a class="{{ $tab == 'out' ? 'font-semibold' : '' }}"
                        href="/rotasi/denah/{{ $cabang->id }}?tab=out">PERSONEL OUT</a>
                </div>
                <div>
                    @if (($tab != 'out' && $cabang->inAll->isEmpty()) || ($tab == 'out' && $cabang->outAll->isEmpty()))
                        <p class="p-4 text-center">Tidak ada data</p>
                    @endif
                    @foreach ($tab == 'out' ? $cabang->outAll : $cabang->inAll as $pengajuan)
                        <div
                            class="font-medium px-4 py-2 {{ $loop->index % 2 === 0 ? 'bg-slate-200' : '' }} grid grid-cols-12 items-center gap-2">
                            <img class="h-14" src="/images/icons/User_fill.svg" alt="user" />
                            <h2 class="col-span-4">{{ $pengajuan->nama_lengkap }}</h2>
                            <p class="col-span-5">{{ $pengajuan->nik }}</p>
                            <p>{{ $pengajuan->posisi_tujuan }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </main>
    @include('components.footer')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="/script/nav.js"></script>
    <script src="/script/chart.js"></script>
    <script>
        // get statistics data
        const series = [{
            name: "ATC",
            data: [
                {{ $cabang->frms }},
                {{ $cabang->jumlah_personel }},
                {{ $cabang->formasi }}
            ],
        }, {
            name: "ACO",
            data: [
                0,
                {{ $cabang->jumlah_personel_aco }},
                {{ $cabang->formasi_aco }}
            ],
        }, {
            name: "AIS",
            data: [
                0,
                {{ $cabang->jumlah_personel_ais }},
                {{ $cabang->formasi_ais }}
            ],
        }, {
            name: "ATFM",
            data: [
                0,
                {{ $cabang->jumlah_personel_atfm }},
                {{ $cabang->formasi_atfm }}
            ],
        }, {
            name: "TAPOR",
            data: [
                0,
                {{ $cabang->jumlah_personel_tapor }},
                {{ $cabang->formasi_tapor }}
            ],
        }, {
            name: "ATS System",
            data: [
                0,
                {{ $cabang->jumlah_personel_ats_system }},
                {{ $cabang->formasi_ats_system }}
            ],
        }];
        const eksistingDistribution = [
            {{ $cabang->jumlah_personel }},
            {{ $cabang->jumlah_personel_aco }},
            {{ $cabang->jumlah_personel_ais }},
            {{ $cabang->jumlah_personel_atfm }},
            {{ $cabang->jumlah_personel_tapor }},
            {{ $cabang->jumlah_personel_ats_system }}
        ];

        // create bar chart
        var chartBar = new ApexCharts(
            document.querySelector("#stats-bar"),
            generateBarChart("Grafik Personel", series)
        );
        chartBar.render();

        // create pie chart
        var chartPie = new ApexCharts(
            document.querySelector("#stats-pie"),
            generatePieChart("Distribusi Personel Eksisting", eksistingDistribution, [
                "ATC",
                "ACO",
                "AIS",
                "ATFM",
                "TAPOR",
                "ATS System"
            ])
        );
        chartPie.render();
    </script>
</body>

</html>
