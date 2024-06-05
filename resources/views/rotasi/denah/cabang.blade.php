<!DOCTYPE html>
<html lang="en">

<head>
    @include('components/head')
    <title>Air Mutasi | Rotasi</title>
</head>

<body class="bg-[#CED0FF] font-poppins">
    @include('rotasi.components.header', ['static' => true])
    <main>
        <section class="bg-[#29367688] text-[#474747] p-8 flex flex-col md:grid md:grid-cols-3 gap-8">
            <aside class="col-span-3 md:col-span-1 sm:h-full flex flex-col">
                <div class="flex items-center justify-center bg-white flex-grow h-[50vh] md:max-h-[50%] rounded-lg">
                    {{-- <img src="/images/icons/Full Image.svg" alt="image" /> --}}
                    <img src="{{ $cabang->thumbnail_url ? $cabang->thumbnail_url : '/images/default_tower.jpg' }}"
                        alt="foto cabang" class="w-full h-full object-cover rounded-lg">
                </div>
                <h1 id="nama" class="text-white p-2 font-semibold text-lg">
                    {{ $cabang->nama }}
                </h1>
                <p class="text-white p-2">
                    {{ $cabang->alamat }}
                </p>
                @if (Auth::user()->role->name === 'admin')
                    <a href="/rotasi/denah/input/{{ $cabang->id }}"
                        class="bg-[#293676] text-white w-full text-center p-2 rounded-lg font-semibold mb-2">Update
                        Cabang</a>
                    <a href="/rotasi/denah/input/{{ $cabang->id }}/delete"
                        class="bg-red-500 text-white w-full text-center p-2 rounded-lg font-semibold">Hapus
                        Cabang</a>
                @endif
            </aside>
            <aside class="flex-grow col-span-3 md:col-span-2 md:h-screen grid md:grid-cols-2 md:grid-rows-2 gap-4">
                <div class="col-span-2 md:col-span-1 flex items-center justify-center bg-white rounded-lg p-4">
                    <div id="stats-bar" class="w-full h-full"></div>
                </div>
                <div class="col-span-2 md:col-span-1 flex items-center justify-center bg-white rounded-lg p-4">
                    <div id="stats-pie" class="w-full h-full"></div>
                </div>
                <div class="col-span-2 grid grid-cols-2 gap-2 bg-white rounded-lg p-4">
                    <div
                        class="col-span-2 sm:col-span-1 border-4 rounded-lg flex flex-col items-center justify-center p-2">
                        <h2 class="font-medium">Jumlah Personel</h2>
                        <p class="font-bold text-2xl">{{ $cabang->jumlah_personel }} Orang</p>
                    </div>
                    <div
                        class="col-span-2 sm:col-span-1 border-4 rounded-lg flex flex-col items-center justify-center p-2">
                        <h2 class="font-medium">Formasi</h2>
                        <p class="font-bold text-2xl">{{ $cabang->formasi }} Orang</p>
                    </div>
                    <div class="border-4 rounded-lg col-span-2 flex flex-col items-center justify-center p-2">
                        <h2 class="font-medium">Prediksi personel</h2>
                        <p class="font-bold text-2xl">
                            {{ $cabang->jumlah_personel + count($cabang->in) - count($cabang->out) }} Orang</p>
                    </div>
                </div>
            </aside>
        </section>
        <section class="flex flex-col sm:flex-row gap-4 p-8">
            <aside class="sm:max-w-[50%] flex-grow bg-white rounded-xl rounded-t-2xl">
                <h1 class="bg-[#383A83] text-white text-center font-bold text-2xl p-4 rounded-t-xl">
                    Personel IN
                </h1>
                <div class="flex flex-col gap-2 p-4">
                    @if ($cabang->in->isEmpty())
                        <p class="text-center">Tidak ada data</p>
                    @endif
                    @foreach ($cabang->in as $pengajuan)
                        <div
                            class="px-4 py-2 border-2 border-slate-400 bg-slate-200 rounded-lg flex items-center gap-2">
                            <img class="h-14" src="/images/icons/Businessman.svg" alt="business" />
                            <aside>
                                <h2 class="font-bold">{{ $pengajuan->nama_lengkap }}</h2>
                                <p>{{ $pengajuan->nik }}</p>
                            </aside>
                        </div>
                    @endforeach
                </div>
            </aside>
            <aside class="sm:max-w-[50%] flex-grow bg-white rounded-xl rounded-t-2xl">
                <h1 class="bg-[#383A83] text-white text-center font-bold text-2xl p-4 rounded-t-xl">
                    Personel OUT
                </h1>
                <div class="flex flex-col gap-2 p-4">
                    @if ($cabang->out->isEmpty())
                        <p class="text-center">Tidak ada data</p>
                    @endif
                    @foreach ($cabang->out as $pengajuan)
                        <div
                            class="px-4 py-2 border-2 border-slate-400 bg-slate-200 rounded-lg flex items-center gap-2">
                            <img class="h-14" src="/images/icons/Businessman.svg" alt="business" />
                            <aside>
                                <h2 class="font-bold">{{ $pengajuan->nama_lengkap }}</h2>
                                <p>{{ $pengajuan->nik }}</p>
                            </aside>
                        </div>
                    @endforeach
                </div>
            </aside>
        </section>
    </main>
    @include('components.footer')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="/script/nav.js"></script>
    <script src="/script/chart.js"></script>
    <script>
        const series = [{
            name: "Jumlah Personel",
            data: [
                {{ $cabang->frms }},
                {{ $cabang->jumlah_personel }},
                {{ $cabang->formasi }}
            ],
        }, ];

        var chartBar = new ApexCharts(
            document.querySelector("#stats-bar"),
            generateBarChart("Grafik Personel", series)
        );
        chartBar.render();

        var chartPie = new ApexCharts(
            document.querySelector("#stats-pie"),
            generatePieChart("Distribusi Personel", series[0].data)
        );
        chartPie.render();
    </script>
</body>

</html>
