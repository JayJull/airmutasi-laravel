<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('components/head')
    <title>Air Mutasi | Personel</title>
</head>

<body class="bg-[#373737] font-sans tracking-wider text-lg">
    @include('components/header', ['static' => true])
    @include('components.modal-component')
    <main class="min-h-screen">
        {{-- <div id="export-personel-popover" popover class="bg-white p-2 rounded-md border-2">
            <form action="/personel/export?posisi={{ $tab }}&cabang_id={{ $cabang->id }}" method="POST"
                class="flex flex-col gap-2" enctype="multipart/form-data">
                @csrf
                <input type="file" name="sheet" id="sheet" accept=".csv">
                <button type="submit"
                    class="text-center bg-[#7186F3] hover:bg-[#435EEF] duration-200 text-white px-4 py-2 rounded-lg font-semibold flex-grow">Export</button>
            </form>
        </div> --}}
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
                    <aside class="flex gap-4 col-span-12 overflow-x-auto">
                        <a class="flex-grow {{ $tab == 'ATC' ? 'font-semibold underline' : '' }}"
                            href="/personel/cabang/{{ $cabang->id }}?tab=ATC">Personel ATC</a>
                        <a class="flex-grow {{ $tab == 'ACO' ? 'font-semibold underline' : '' }}"
                            href="/personel/cabang/{{ $cabang->id }}?tab=ACO">Personel ACO</a>
                        <a class="flex-grow {{ $tab == 'AIS' ? 'font-semibold underline' : '' }}"
                            href="/personel/cabang/{{ $cabang->id }}?tab=AIS">Personel AIS</a>
                        <a class="flex-grow {{ $tab == 'ATFM' ? 'font-semibold underline' : '' }}"
                            href="/personel/cabang/{{ $cabang->id }}?tab=ATFM">Personel ATFM</a>
                        <a class="flex-grow {{ $tab == 'TAPOR' ? 'font-semibold underline' : '' }}"
                            href="/personel/cabang/{{ $cabang->id }}?tab=TAPOR">Personel TAPOR</a>
                        <a class="flex-grow {{ $tab == 'ATSSystem' ? 'font-semibold underline' : '' }}"
                            href="/personel/cabang/{{ $cabang->id }}?tab=ATSSystem">Personel ATS System</a>
                        <a class="flex-grow {{ $tab == 'lainnya' ? 'font-semibold underline' : '' }}"
                            href="/personel/cabang/{{ $cabang->id }}?tab=lainnya">Lainnya</a>
                    </aside>
                    {{-- @can('admin')
                        <div class="flex col-span-6 md:col-span-3 gap-2">
                            <a href="/personel/add"
                                class="text-center bg-[#7186F3] hover:bg-[#435EEF] duration-200 text-white px-4 py-2 rounded-lg font-semibold flex-grow">Tambah
                                +</a>
                            <button popovertarget="export-personel-popover"
                                class="text-center bg-[#7186F3] hover:bg-[#435EEF] duration-200 text-white px-4 py-2 rounded-lg font-semibold flex-grow">
                                Export
                            </button>
                        </div>
                    @endcan --}}
                </div>
                <div class="relative overflow-x-auto max-h-[70vh] overflow-y-auto block">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead
                            class="sticky top-0 text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    No.
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Aksi
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    NIK-AirNav
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    E-NIK
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    NIK-AP1
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Nama
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Gelar
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Kelamin
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Tempat, Tanggal Lahir
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Usia
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Status Karyawan
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    TMT Kerja Airnav
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    TMT Kerja Golongan
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    TMT Pensiun
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Lokasi
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Lokasi Induk
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Lokasi Kedudukan
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Unit
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Jabatan
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    TMT Jabatan
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Masa Kerja Jabatan
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Nama Level Jabatan (Level)
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    TMT Level Jabatan
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Masa Kerja Level Jabatan
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Skala Jabatan
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Fungsi
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Job Text
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cabang->personels as $personel)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $loop->iteration }}
                                    </th>
                                    <td class="px-6 py-4">
                                        <a href="/personel/pensiun/{{ $personel->id }}">
                                            {{ $personel->pensiun ? 'Batalkan pensiun' : 'Pensiun' }}
                                        </a>
                                        <a href="/personel/delete/{{ $personel->id }}" class="text-red-500">Hapus</a>
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $personel->nik }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $personel->e_nik }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $personel->nik_ap1 }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $personel->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $personel->gelar }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $personel->kelamin }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $personel->tempat_lahir }}, {{ $personel->tgl_lahir }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $personel->usia_th }} Tahun, {{ $personel->usia_bl }} Bulan
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $personel->sts_karyawan }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $personel->tmt_kerja_airnav }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $personel->tmt_kerja_golongan }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $personel->tmt_pensiun }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $personel->cabang->nama }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $personel->lokasi ? $personel->lokasiCabang->nama : '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $personel->lokasi_induk ? $personel->lokasiInduk->nama : '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $personel->unit }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $personel->posisi }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $personel->tmt_jabatan }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $personel->masa_kerja }} Tahun,
                                        {{ $personel->masa_kerja_jabatan_bl }} Bulan
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $personel->nama_level_jabatan }} ({{ $personel->level }})
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $personel->tmt_level_jabatan }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $personel->masa_kerja_level_jabatan_th }} Tahun,
                                        {{ $personel->masa_kerja_level_jabatan_bl }} Bulan
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $personel->skala_jabatan }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $personel->fungsi }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $personel->job_text }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-between px-4 py-2">
                    <a @if ($page > 0) href="?page={{ $page - 1 }}" @endif>Back</a>
                    <a href="?page={{ $page + 1 }}">Next</a>
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
    <script src="/script/chatbot.js"></script>
</body>

</html>
