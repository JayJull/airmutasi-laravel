<!DOCTYPE html>
<html lang="en">

<head>
    @include('components/head')
    <title>Air Mutasi | Rotasi</title>
</head>

<body class="bg-[#CED0FF] font-poppins">
    @include('rotasi.components.header', ['static' => true])
    <main>
        <section
            class="bg-[#29367688] text-[#474747] p-8 flex flex-col md:grid md:grid-cols-3 gap-8 md:min-h-screen">
            <aside class="col-span-3 md:col-span-1 md:h-full flex flex-col">
                <div class="flex items-center justify-center bg-white flex-grow max-h-[30%] md:max-h-[50%] rounded-lg">
                    {{-- <img src="/images/icons/Full Image.svg" alt="image" /> --}}
                    <img src="/storage/{{ $cabang->thumbnail }}" alt="foto cabang" class="w-full h-full object-cover rounded-lg">
                </div>
                <h1 id="nama" class="text-white p-2 font-semibold text-lg">
                    {{ $cabang->nama }}
                </h1>
                <p class="text-white p-2">
                    {{ $cabang->alamat }}
                </p>
            </aside>
            <aside class="flex-grow col-span-3 md:col-span-2 md:h-screen grid md:grid-cols-2 md:grid-rows-2 gap-4">
                <div class="flex items-center justify-center bg-white rounded-lg p-4">
                    <div id="stats" class="w-full h-full"></div>
                </div>
                <div class="flex items-center justify-center bg-white rounded-lg p-4">
                    <img src="/images/icons/Bell Curve.svg" alt="image" />
                </div>
                <div class="col-span-2 grid grid-cols-2 gap-2 bg-white rounded-lg p-4">
                    <div>
                        <h2>Jumlah Personel</h2>
                        <p>{{ $cabang->jumlah_personel }} Orang</p>
                    </div>
                    <div>
                        <h2>Formasi</h2>
                        <p>{{ $cabang->formasi }} Orang</p>
                    </div>
                    <div>
                        <h2>Prediksi personel</h2>
                        <p>{{ $cabang->jumlah_personel + count($cabang->in) - count($cabang->out) }}</p>
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
                name: "In",
                data: [10, 41, 35, 51, 49, 62, 69, 91, 148],
            },
            {
                name: "Out",
                data: [148, 91, 69, 62, 49, 51, 35, 41, 10],
            },
        ];
        const title = "Statistik In & Out";

        var chart = new ApexCharts(
            document.querySelector("#stats"),
            generateChart(title, series)
        );
        chart.render();
    </script>
</body>

</html>
