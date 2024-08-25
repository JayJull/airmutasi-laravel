<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('components/head')
    <title>Air Mutasi | Profil</title>
</head>

<body class="bg-[#373737] font-sans tracking-wider text-lg">
    @include('components/header', ['static' => true])
    @include('components.modal-component')
    <main class="min-h-screen">
        <form action="/akun/edit" method="post" class="rounded-lg flex flex-col gap-1 bg-white mx-8 my-2 p-4">
            @csrf
            <label for="name" class="font-semibold">Nama <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name"
                class="w-full p-2 mt-1 border-2 border-slate-400 rounded-md mb-2" placeholder="Nama"
                value="{{ old('name') === null ? $akun->name : old('name') }}">
            <label for="email" class="font-semibold">Email <span class="text-red-500">*</span></label>
            <input type="email" name="email" id="email"
                class="w-full p-2 mt-1 border-2 border-slate-400 rounded-md mb-2" placeholder="Email"
                value="{{ old('email') === null ? $akun->email : old('email') }}">
            <label for="password" class="font-semibold">Password</label>
            <input type="password" name="password" id="password"
                class="w-full p-2 mt-1 border-2 border-slate-400 rounded-md mb-2"
                placeholder="Isi ulang untuk mengganti, Minimal 8 karakter">

            <label for="nik" class="font-semibold">NIK <span class="text-red-500">*</span></label>
            <input type="text" name="nik" id="nik"
                class="w-full p-2 mt-1 border-2 border-slate-400 rounded-md mb-2" placeholder="NIK"
                value="{{ old('nik') === null ? ($akun->profile === null ? '' : $akun->profile->nik) : old('nik') }}">
            <label for="masa_kerja" class="font-semibold">Masa Kerja <span class="text-red-500">*</span></label>
            <input type="number" name="masa_kerja" id="masa_kerja"
                class="w-full p-2 mt-1 border-2 border-slate-400 rounded-md mb-2" placeholder="Masa Kerja"
                value="{{ old('masa_kerja') === null ? ($akun->profile === null ? '' : $akun->profile->masa_kerja) : old('masa_kerja') }}">
            <label for="jabatan" class="font-semibold">Jabatan <span class="text-red-500">*</span></label>
            <input type="jabatan" name="jabatan" id="jabatan"
                class="w-full p-2 mt-1 border-2 border-slate-400 rounded-md mb-2" placeholder="Jabatan"
                value="{{ old('jabatan') === null ? ($akun->profile === null ? '' : $akun->profile->jabatan) : old('jabatan') }}">

            <button type="submit" class="bg-[#383A83] text-white py-2 rounded-lg font-semibold">Simpan</button>
        </form>
    </main>
    @include('components.footer')
    <script src="/script/nav.js"></script>
</body>

</html>
