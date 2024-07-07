<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('components/head')
    <title>Air Mutasi</title>
</head>

<body class="bg-[#373737] font-poppins">
    @include('components/header', ['static' => true])
    @include('components.modal-component')
    <main class="min-h-screen">
        <section class="p-8">
            <div class="bg-white rounded-lg border-2 border-[#293676]">
                <div class="grid grid-cols-12 gap-4 items-center p-4 border-b-2 border-[#293676] text-[#293676]">
                    <aside class="flex gap-4 col-span-8 md:col-span-10 overflow-x-auto">
                        <a class="{{ $tab == 'ATC' ? 'font-semibold' : '' }}"
                            href="/personel/cabang/{{ $cabang->id }}?tab=ATC">Personel ATC</a>
                        <a class="{{ $tab == 'ACO' ? 'font-semibold' : '' }}"
                            href="/personel/cabang/{{ $cabang->id }}?tab=ACO">Personel ACO</a>
                        <a class="{{ $tab == 'AIS' ? 'font-semibold' : '' }}"
                            href="/personel/cabang/{{ $cabang->id }}?tab=AIS">Personel AIS</a>
                        <a class="{{ $tab == 'ATFM' ? 'font-semibold' : '' }}"
                            href="/personel/cabang/{{ $cabang->id }}?tab=ATFM">Personel ATFM</a>
                        <a class="{{ $tab == 'TAPOR' ? 'font-semibold' : '' }}"
                            href="/personel/cabang/{{ $cabang->id }}?tab=TAPOR">Personel TAPOR</a>
                        <a class="{{ $tab == 'ATSSystem' ? 'font-semibold' : '' }}"
                            href="/personel/cabang/{{ $cabang->id }}?tab=ATSSystem">Personel ATS System</a>
                    </aside>
                    @can('admin')
                        <a href="/personel/add"
                            class="col-span-4 md:col-span-2 text-center bg-[#7186F3] hover:bg-[#435EEF] duration-200 text-white px-4 py-2 rounded-lg font-semibold">Tambah
                            +</a>
                    @endcan
                </div>
                <div>
                    @if ($cabang->personels->isEmpty())
                        <p class="p-4 text-center">Tidak ada data</p>
                    @endif
                    @foreach ($cabang->personels as $personel)
                        <div
                            class="font-medium px-4 py-2 {{ $loop->index % 2 === 0 ? 'bg-slate-200' : '' }} grid grid-cols-4 md:grid-cols-12 items-center gap-2">
                            <img class="h-14 md:block hidden" src="/images/icons/User_fill.svg" alt="user" />
                            <p class="col-span-4 md:col-span-1 text-wrap break-all">{{ $personel->nik }}</p>
                            <p class="col-span-2 break-all">{{ $personel->name }}</p>
                            <p class="col-span-2 md:col-span-1 break-all">{{ $personel->jabatan }}</p>
                            <p class="col-span-2 md:col-span-1 break-all">{{ $personel->masa_kerja }} Tahun</p>
                            <p class="col-span-2 md:col-span-1 text-wrap break-all">{{ $personel->level_jabatan }}</p>
                            <p class="col-span-2">{{ $personel->kontak }}</p>
                            <div class="flex flex-wrap gap-1 justify-center col-span-4 md:col-span-2">
                                @foreach ($personel->kompetensis as $kompetensi)
                                    <p class="text-xs bg-gray-300 px-2 py-1 rounded-md">{{ $kompetensi->kompetensi }}
                                    </p>
                                @endforeach
                            </div>
                            @if ($personel->pensiun)
                                <p class="bg-yellow-500 text-gray-800 text-center rounded-md p-2 text-xs">Persiapan pensiun</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </main>
    @include('components.footer')
    <script src="/script/nav.js"></script>
</body>

</html>
