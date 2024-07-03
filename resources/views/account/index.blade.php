<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('components/head')
    <title>Air Mutasi</title>
</head>

<body class="bg-[#373737] font-poppins">
    @include('components/header', ['static' => true])
    @include('components.modal-component')
    <main class="min-h-screen flex justify-center items-center">
        <section class="rounded-lg flex flex-col gap-1 bg-white mx-8 my-2 p-4 sm:w-2/3">
            <h1 class="font-semibold text-xl text-center">{{ $akun->name }}</h1>
            @if ($akun->profile != null)
                <p class="text-center">{{ $akun->profile->jabatan }}</p>
            @endif
            <div class="bg-blue-100 p-2 rounded-md flex flex-col items-center gap-2">
                @if ($akun->profile != null)
                    <p class="text-center">NIK: {{ $akun->profile->nik }}</p>
                    <p class="text-center">Masa Kerja: {{ $akun->profile->masa_kerja }} Tahun</p>
                @endif
                <p class="text-center">Email: {{ $akun->email }}</p>
            </div>
            <a href="/akun/edit" class="bg-yellow-300 hover:bg-yellow-400 duration-200 text-gray-800 px-4 py-2 rounded-lg font-semibold text-center">Edit</a>
            @if ($akun->role->name == 'admin')
                <a href="/akun/add" class="bg-[#7186F3] hover:bg-[#435EEF] duration-200 text-white px-4 py-2 rounded-lg font-semibold text-center">Buat
                    akun personel baru</a>
            @endif
        </section>
    </main>
    @include('components.footer')
    <script src="/script/nav.js"></script>
</body>

</html>
