<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('components/head')
    <title>Air Mutasi | Profil</title>
</head>

<body class="font-sans tracking-wider">
    @include('components/header', ['static' => true])
    @include('components.modal-component')
    <main class="px-8 py-16">
        <section class="flex justify-center gap-16">
            <aside class="w-2/5">
                <img class="h-full object-cover rounded-md" src="/images/thumbnail2.jpeg" alt="illustration">
            </aside>
            <aside class="w-3/5 flex flex-col gap-4">
                <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-2">
                    <aside>
                        <h1 class="font-semibold text-2xl">{{ $akun->name }}</h1>
                        @if ($akun->profile != null)
                            <p class="text-xl">{{ $akun->profile->jabatan }}</p>
                        @endif
                    </aside>
                    <aside class="flex items-center gap-4">
                        <a href="/akun/edit"
                            class="px-4 py-2 bg-[#003285] text-white opacity-80 hover:opacity-100 duration-300 rounded-md">Edit</a>
                        @can('admin')
                            <button
                                class="px-4 py-2 bg-[#003285] text-white opacity-80 hover:opacity-100 duration-300 rounded-md"
                                popovertarget="admin-action">☰</button>
                        @endcan
                    </aside>
                </div>
                <hr>
                <div class="flex flex-col gap-2">
                    @if ($akun->profile != null)
                        @if ($akun->profile->cabang_id != null)
                            <p>Cabang:</p>
                            <p class="w-full border-2 border-[#0005] rounded-md px-2 py-1">
                                {{ $akun->profile->cabang->nama }}</p>
                        @endif
                        <p>NIK:</p>
                        <p class="w-full border-2 border-[#0005] rounded-md px-2 py-1">{{ $akun->profile->nik }}</p>
                        <p>Masa Kerja:</p>
                        <p class="w-full border-2 border-[#0005] rounded-md px-2 py-1">{{ $akun->profile->masa_kerja }}
                            Tahun</p>
                    @endif
                    <p>Email:</p>
                    <p class="w-full border-2 border-[#0005] rounded-md px-2 py-1">{{ $akun->email }}</p>
                </div>
            </aside>
        </section>
        @can('admin')
            <section popover="auto" id="admin-action" class="rounded-md p-4 shadow-lg">
                <div class="flex flex-col gap-2">
                    <a href="/akun/add"
                        class="px-4 py-2 bg-[#003285] text-white opacity-80 hover:opacity-100 rounded-md duration-300">Buat
                        akun personel baru</a>
                    <button popovertarget="cabang-assign"
                        class="px-4 py-2 bg-[#003285] text-white opacity-80 hover:opacity-100 rounded-md duration-300">Daftarkan
                        cabang ke
                        akun</button>
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
                </div>
            </section>
        @endcan
    </main>
    @include('components.footer')
    <script src="/script/nav.js"></script>
    <script src="/script/chatbot.js"></script>
</body>

</html>
