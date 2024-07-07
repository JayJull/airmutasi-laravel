<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('components/head')
    <title>Air Mutasi</title>
</head>

<body class="bg-[#373737] font-geruduk tracking-wider text-lg">
    @include('components/header', ['static' => true])
    @include('components.modal-component')
    <main class="min-h-screen">
        <div id="export-personel-popover" popover class="bg-white p-2 rounded-md border-2">
            <form action="/personel/export?posisi={{ $tab }}&cabang_id={{ $cabang->id }}" method="POST"
                class="flex flex-col gap-2" enctype="multipart/form-data">
                @csrf
                <input type="file" name="sheet" id="sheet" accept=".csv">
                <button type="submit"
                    class="text-center bg-[#7186F3] hover:bg-[#435EEF] duration-200 text-white px-4 py-2 rounded-lg font-semibold flex-grow">Export</button>
            </form>
        </div>
        <section>
            <div class="bg-[#FFB72D] p-8">
                <h1 class="text-center font-bold text-xl">DATA PERSONIL OPERASI <br>
                    AIRNAV INDONESIA</h1>
                <h2 class="font-semibold text-lg mt-8">{{ $cabang->nama }}</h2>
            </div>
        </section>
        <section class="p-8">
            <div class="bg-white rounded-lg border-2 border-[#293676]">
                <div class="grid grid-cols-12 gap-4 items-center p-4 border-b-2 border-[#293676] text-[#293676]">
                    <aside class="flex gap-4 col-span-6 md:col-span-9 overflow-x-auto">
                        <a class="flex-grow {{ $tab == 'ATC' ? 'font-semibold' : '' }}"
                            href="/personel/cabang/{{ $cabang->id }}?tab=ATC">Personel ATC</a>
                        <a class="flex-grow {{ $tab == 'ACO' ? 'font-semibold' : '' }}"
                            href="/personel/cabang/{{ $cabang->id }}?tab=ACO">Personel ACO</a>
                        <a class="flex-grow {{ $tab == 'AIS' ? 'font-semibold' : '' }}"
                            href="/personel/cabang/{{ $cabang->id }}?tab=AIS">Personel AIS</a>
                        <a class="flex-grow {{ $tab == 'ATFM' ? 'font-semibold' : '' }}"
                            href="/personel/cabang/{{ $cabang->id }}?tab=ATFM">Personel ATFM</a>
                        <a class="flex-grow {{ $tab == 'TAPOR' ? 'font-semibold' : '' }}"
                            href="/personel/cabang/{{ $cabang->id }}?tab=TAPOR">Personel TAPOR</a>
                        <a class="flex-grow {{ $tab == 'ATSSystem' ? 'font-semibold' : '' }}"
                            href="/personel/cabang/{{ $cabang->id }}?tab=ATSSystem">Personel ATS System</a>
                    </aside>
                    @can('admin')
                        <div class="flex col-span-6 md:col-span-3 gap-2">
                            <a href="/personel/add"
                                class="text-center bg-[#7186F3] hover:bg-[#435EEF] duration-200 text-white px-4 py-2 rounded-lg font-semibold flex-grow">Tambah
                                +</a>
                            <button popovertarget="export-personel-popover"
                                class="text-center bg-[#7186F3] hover:bg-[#435EEF] duration-200 text-white px-4 py-2 rounded-lg font-semibold flex-grow">
                                Export
                            </button>
                        </div>
                    @endcan
                </div>
                <div>
                    @if ($cabang->personels->isEmpty())
                        <p class="p-4 text-center">Tidak ada data</p>
                    @else
                        <div
                            class="px-4 py-2 bg-slate-200 hidden md:grid grid-cols-4 md:grid-cols-12 items-center gap-2 font-semibold">
                            <h1>Aksi</h1>
                            <h1 class="col-span-4 md:col-span-1">NIK</h1>
                            <h1 class="col-span-2">Nama</h1>
                            <h1 class="col-span-2 md:col-span-1">Jabatan</h1>
                            <h1 class="col-span-2 md:col-span-1">Level</h1>
                            <h1 class="col-span-2 md:col-span-1">Masa Kerja</h1>
                            <h1 class="col-span-2">Kontak</h1>
                            <h1 class="col-span-4 md:col-span-2">Kompetensi</h1>
                            <h1>Pensiun</h1>
                        </div>
                        <hr class="border-[1px] border-black w-full">
                    @endif
                    @foreach ($cabang->personels as $personel)
                        <div
                            class="font-medium px-4 py-2 {{ $loop->index % 2 === 0 ? 'bg-slate-200' : '' }} grid grid-cols-4 md:grid-cols-12 items-center gap-2">
                            <div class="personels-action">
                                <button
                                    class="flex items-center gap-1 bg-[#FFB72D] hover:opacity-100 opacity-80 duration-200 px-2 py-1 rounded-md">Aksi<img
                                        src="/images/icons/moreArrow.svg" class="duration-300"></button>
                                <div
                                    class="max-h-0 duration-300 absolute flex flex-col gap-1 bg-white mt-4 text-gray-800 text-base font-light overflow-hidden z-50">
                                    <div class="border-2 flex flex-col gap-1 px-2 py-1">
                                        <a href="/personel/pensiun/{{ $personel->id }}">
                                            {{ $personel->pensiun ? 'Batalkan pensiun' : 'Pensiun' }}
                                        </a>
                                        <hr>
                                        <a href="/personel/delete/{{ $personel->id }}" class="text-red-500">Hapus</a>
                                    </div>
                                </div>
                            </div>
                            <p class="col-span-4 md:col-span-1 text-wrap break-all">
                                <span class="block md:hidden">NIK: </span>
                                {{ $personel->nik }}
                            </p>
                            <p class="col-span-2 break-all">
                                <span class="block md:hidden">Nama: </span>
                                {{ $personel->name }}
                            </p>
                            <p class="col-span-2 md:col-span-1 break-all">
                                <span class="block md:hidden">Jabatan: </span>{{ $personel->jabatan }}
                            </p>
                            <p class="col-span-2 md:col-span-1 text-wrap break-all">
                                <span class="block md:hidden">Level Jabatan: </span>{{ $personel->level_jabatan }}
                            </p>
                            <p class="col-span-2 md:col-span-1 break-all"><span class="block md:hidden">Masa Kerja:
                                </span>{{ $personel->masa_kerja }} Tahun</p>
                            <p class="col-span-2"><span class="block md:hidden">Kontak: </span>{{ $personel->kontak }}
                            </p>
                            <div class="flex flex-wrap gap-1 md:justify-center col-span-4 md:col-span-2">
                                <span class="block md:hidden">Kompetensi: </span>
                                @foreach ($personel->kompetensis as $kompetensi)
                                    <p class="text-xs bg-gray-300 px-2 py-1 rounded-md">{{ $kompetensi->kompetensi }}
                                    </p>
                                @endforeach
                            </div>
                            @if ($personel->pensiun)
                                <div>
                                    <span class="block md:hidden">Pensiun: </span>
                                    <p class="bg-yellow-500 text-gray-800 text-center rounded-md p-2 text-xs">Persiapan
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </main>
    @include('components.footer')
    <script src="/script/nav.js"></script>
    <script>
        var activepopup = null;
        const aksiPopup = document.querySelectorAll('.personels-action');
        aksiPopup.forEach((element) => {
            element.addEventListener('click', () => {
                if (activepopup) {
                    activepopup.querySelector('div').classList.toggle('max-h-0');
                    activepopup.querySelector('div').classList.toggle('max-h-[15%]');
                    activepopup.querySelector('button > img').classList.toggle('rotate-90');
                }
                if (activepopup === element) {
                    activepopup = null;
                    return;
                }
                const dropdown = element.querySelector('div');
                dropdown.classList.toggle('max-h-0');
                dropdown.classList.toggle('max-h-[15%]');
                element.querySelector('button > img').classList.toggle('rotate-90');
                activepopup = element;
            });
        });
    </script>
</body>

</html>
