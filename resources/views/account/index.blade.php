<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('components/head')
    <title>Air Mutasi | Profil</title>
</head>

<body class="bg-[#373737] font-sans tracking-wider text-lg">
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
                    @if ($akun->profile->cabang_id != null)
                        <p class="text-center">Cabang: {{ $akun->profile->cabang->nama }}</p>
                    @endif
                    <p class="text-center">NIK: {{ $akun->profile->nik }}</p>
                    <p class="text-center">Masa Kerja: {{ $akun->profile->masa_kerja }} Tahun</p>
                @endif
                <p class="text-center">Email: {{ $akun->email }}</p>
            </div>
            <a href="/akun/edit"
                class="bg-[#003285] hover:bg-[#003285] duration-200 text-gray-800 px-4 py-2 rounded-lg font-semibold text-center">Edit</a>
            @if ($akun->role->name == 'admin')
                <a href="/akun/add"
                    class="bg-[#7186F3] hover:bg-[#435EEF] duration-200 text-white px-4 py-2 rounded-lg font-semibold text-center">Buat
                    akun personel baru</a>
                <button popovertarget="cabang-assign" class="underline text-blue-500">Daftarkan cabang ke akun</button>
                <div id="cabang-assign" popover class="p-2 rounded-md w-1/2 border-2">
                    <form action="/akun/assign" method="POST" class="flex flex-col gap-2">
                        @csrf
                        <h1 class="text-center font-semibold text-xl">Daftarkan cabang ke akun</h1>
                        <select name="user_id" id="user_id"
                            class="w-full px-2 py-1 mt-1 bg-white border-2 border-slate-400 rounded-md text-center">
                            <option value disabled selected>--- Pilih Akun ---</option>
                            @foreach ($akuns as $currAkun)
                                <option value="{{ $currAkun->id }}">{{ $currAkun->user->name }}</option>
                            @endforeach
                        </select>
                        <select name="cabang_id" id="cabang_id"
                            class="w-full px-2 py-1 mt-1 bg-white border-2 border-slate-400 rounded-md text-center">
                            <option value disabled selected>--- Pilih Cabang ---</option>
                            @foreach ($cabangs as $currCabang)
                                <option value="{{ $currCabang->id }}">{{ $currCabang->nama }}</option>
                            @endforeach
                        </select>
                        <button
                            class="bg-[#7186F3] hover:bg-[#435EEF] duration-200 text-white px-4 py-2 rounded-lg font-semibold text-center">Daftarkan</button>
                    </form>
                </div>
            @endif
        </section>
    </main>
    @include('components.footer')
    <script src="/script/nav.js"></script>
</body>

</html>
