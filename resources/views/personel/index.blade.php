<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('components/head')
    <title>Air Mutasi | Personel</title>
</head>

<body class="font-sans tracking-wider text-lg">
    @include('components/header', ['static' => true])
    @include('components.modal-component')

    <div id="import-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <form method="POST" action="/personel/import" enctype="multipart/form-data"
                class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                @csrf
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Import Data Personel
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="import-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">
                    <input type="file" name="sheet" id="sheet" required>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button data-modal-hide="import-modal" type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Kirim</button>
                    <button data-modal-hide="import-modal" type="button"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Batal</button>
                </div>
            </form>
        </div>
    </div>
    <main class="min-h-screen">
        <div class="flex justify-between items-center px-4 py-2 bg-gray-100 dark:bg-gray-800">
            <h1 class="text-xl font-semibold text-gray-800 dark:text-white">Personel</h1>
            <div class="flex items center gap-2">
                <button
                    class="flex items-center justify-center px-4 py-2 text-white text-sm bg-blue-500 rounded-md hover:bg-blue-600"
                    onclick="window.location.href='/personel/create'">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah
                </button>
                <button
                    class="flex items-center justify-center px-4 py-2 text-white text-sm bg-blue-500 rounded-md hover:bg-blue-600"
                    data-modal-target="import-modal" data-modal-toggle="import-modal">
                    <svg class="w-6 h-6 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2m-8 1V4m0 12-4-4m4 4 4-4" />
                    </svg>
                    Import
                </button>
            </div>
        </div>
        <div class="relative overflow-x-auto max-h-[70vh] overflow-y-auto block">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="sticky top-0 text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
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
                    @foreach ($personels as $personel)
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
    </main>
    @include('components.footer')
    <script src="/script/nav.js"></script>
    <script src="/script/chatbot.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</body>

</html>
