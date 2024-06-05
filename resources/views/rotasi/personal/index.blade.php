<!DOCTYPE html>
<html lang="en">

<head>
    @include('components/head')
    <title>Air Mutasi | Rotasi</title>
</head>

<body class="bg-[#CED0FF] font-poppins relative">
    @include('rotasi.components.header', ['static' => true])
    @include('components.modal-component')
    <main>
        <section class="flex flex-col items-center my-4 px-2">
            <div class="w-full md:w-2/3 flex gap-1 flex-col md:flex-row my-2">
                <button popovertarget="lokasi-awal"
                    class="md:max-w-[50%] flex-grow p-4 bg-[#383A83] text-white border-2 border-slate-400 rounded-xl md:rounded-none md:rounded-s-xl">
                    <h2 class="font-medium">Bandara Lokasi Awal</h2>
                    <h3 class="font-bold text-3xl underline" id="cabang-awal">{{ $cabangs[0]->nama }}</h3>
                </button>
                <button popovertarget="lokasi-tujuan"
                    class="md:max-w-[50%] flex-grow p-4 bg-[#383A83] text-white border-2 border-slate-400 rounded-xl md:rounded-none md:rounded-e-xl">
                    <h2 class="font-medium">Bandara Lokasi Tujuan</h2>
                    <h3 class="font-bold text-3xl underline" id="cabang-tujuan">Pilih</h3>
                </button>
            </div>
            <form method="POST" action="/rotasi/personal"
                class="w-full md:w-2/3 bg-[#ECECEC] px-8 py-4 rounded-xl border-2 border-slate-400 flex flex-col gap-2">
                @csrf
                <div id="lokasi-awal" class="p-4 border-2 rounded-lg" popover>
                    <div class="flex flex-col gap-2">
                        <h2 class="font-bold text-xl">Lokasi awal</h2>
                        <input type="search" id="search-lokasi-awal" class="px-2 py-1 border-2 rounded-md"
                            placeholder="Search ...">
                        <div class="flex flex-col gap-1">
                            @foreach ($cabangs as $cabang)
                                <label>
                                    <input type="radio" name="lokasi_awal_id" id="lokasi-awal-{{ $cabang->id }}"
                                        value="{{ $cabang->id }}"
                                        {{ old('lokasi_awal_id') == $cabang->id || (!old('lokasi_awal_id') && $loop->index === 0) ? 'checked' : '' }}>
                                    {{ $cabang->nama }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div id="lokasi-tujuan" class="p-4 border-2 rounded-lg" popover>
                    <div class="flex flex-col gap-2">
                        <h2 class="font-bold text-xl">Lokasi tujuan</h2>
                        <input type="search" id="search-lokasi-tujuan" class="px-2 py-1 border-2 rounded-md"
                            placeholder="Search ...">
                        <div class="flex flex-col gap-1">
                            @foreach ($cabangs as $cabang)
                                <label>
                                    <input type="radio" name="lokasi_tujuan_id" id="lokasi-tujuan-{{ $cabang->id }}"
                                        value="{{ $cabang->id }}"
                                        {{ old('lokasi_tujuan_id') == $cabang->id ? 'checked' : '' }}>
                                    {{ $cabang->nama }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="grid md:grid-cols-2 gap-2">
                    <aside class="w-full">
                        <label class="font-semibold" for="nama_lengkap">Nama Lengkap</label><br />
                        <input type="text" name="nama_lengkap" id="nama_lengkap"
                            class="w-full px-2 py-1 mt-1 border-2 border-slate-400 rounded-md"
                            placeholder="Ketik Disini ..." value="{{ old('nama_lengkap') }}" />
                    </aside>
                    <aside class="w-full">
                        <label class="font-semibold" for="nik">NIK</label><br />
                        <input type="text" name="nik" id="nik"
                            class="w-full px-2 py-1 mt-1 border-2 border-slate-400 rounded-md"
                            placeholder="Ketik Disini ..." value="{{ old('nik') }}" />
                    </aside>
                </div>
                <div class="grid md:grid-cols-2 gap-2">
                    <aside class="w-full">
                        <label class="font-semibold" for="masa_kerja">Masa Kerja</label><br />
                        <input type="number" name="masa_kerja" id="masa_kerja"
                            class="w-full px-2 py-1 mt-1 border-2 border-slate-400 rounded-md"
                            placeholder="Ketik Disini ..." value="{{ old('masa_kerja') }}" />
                    </aside>
                    <aside class="w-full">
                        <label class="font-semibold" for="jabatan">Jabatan</label><br />
                        <input type="text" name="jabatan" id="jabatan"
                            class="w-full px-2 py-1 mt-1 border-2 border-slate-400 rounded-md"
                            placeholder="Ketik Disini ..." value="{{ old('jabatan') }}" />
                    </aside>
                </div>
                <div class="grid md:grid-cols-2 gap-2">
                    <aside>
                        <label class="font-semibold" for="posisi_sekarang">Posisi Kerja Sekarang</label><br />
                        <select name="posisi_sekarang" id="posisi_sekarang"
                            class="w-full px-2 py-1 mt-1 bg-white border-2 border-slate-400 rounded-md">
                            <option value disabled {{ !old('posisi_sekarang') ? 'selected' : '' }}>--- Pilih Posisi ---
                            </option>
                            <option value="posisi1" {{ old('posisi_sekarang') == 'posisi1' ? 'selected' : '' }}>Posisi
                                1</option>
                            <option value="posisi2" {{ old('posisi_sekarang') == 'posisi2' ? 'selected' : '' }}>Posisi
                                2</option>
                        </select>
                    </aside>
                    <aside>
                        <label class="font-semibold" for="posisi_tujuan">Posisi Kerja Tujuan</label><br />
                        <select name="posisi_tujuan" id="posisi_tujuan"
                            class="w-full px-2 py-1 mt-1 bg-white border-2 border-slate-400 rounded-md">
                            <option value disabled {{ !old('posisi_tujuan') ? 'selected' : '' }}>--- Pilih Posisi ---
                            </option>
                            <option value="posisi1" {{ old('posisi_tujuan') == 'posisi1' ? 'selected' : '' }}>Posisi
                                1</option>
                            <option value="posisi2" {{ old('posisi_tujuan') == 'posisi2' ? 'selected' : '' }}>Posisi
                                2</option>
                        </select>
                    </aside>
                </div>
                <hr class="border-1 border-slate-400 w-full my-4" />
                <div class="grid md:grid-cols-2 gap-2">
                    <aside>
                        <label class="font-semibold" for="kompetensi">Kompetensi</label><br />
                        <textarea name="kompetensi" id="kompetensi" class="resize-none w-full p-2 mt-1 border-2 border-slate-400 rounded-md"
                            rows="4" placeholder="Ketik Disini ...">{{ old('kompetensi') }}</textarea>
                    </aside>
                    <aside>
                        <label class="font-semibold" for="tujuan_rotasi">Tujuan Rotasi</label><br />
                        <textarea name="tujuan_rotasi" id="tujuan_rotasi"
                            class="resize-none w-full p-2 mt-1 border-2 border-slate-400 rounded-md" rows="4"
                            placeholder="Ketik Disini ...">{{ old('tujuan_rotasi') }}</textarea>
                    </aside>
                </div>
                <div>
                    <label class="font-semibold" for="keterangan">Keterangan Tambahan</label><br />
                    <textarea name="keterangan" id="keterangan" class="resize-none w-full p-2 mt-1 border-2 border-slate-400 rounded-md"
                        rows="3" placeholder="Ketik Disini ...">{{ old('keterangan') }}</textarea>
                </div>
                <button type="submit" class="bg-[#383A83] text-white py-2 rounded-lg font-semibold">
                    Kirim
                </button>
            </form>
        </section>
    </main>
    @include('components.footer')
    <script src="/script/nav.js"></script>
    <script>
        document
            .querySelectorAll('[name=lokasi_awal_id]')
            .forEach(
                radio => radio.addEventListener('change', function(e) {
                    document.querySelector('#cabang-awal').textContent =
                        `${e.target.parentElement.textContent.trim()}`;
                    document.getElementById('lokasi-awal').hidePopover();
                })
            );
        document
            .querySelectorAll('[name=lokasi_tujuan_id]')
            .forEach(
                radio => radio.addEventListener('change', function(e) {
                    document.querySelector('#cabang-tujuan').textContent =
                        `${e.target.parentElement.textContent.trim()}`;
                    document.getElementById('lokasi-tujuan').hidePopover();
                })
            );
        const lokasiAwalChecked = document.querySelector('[name=lokasi_awal_id]:checked');
        document.querySelector('#cabang-awal').textContent = lokasiAwalChecked ?
            `${lokasiAwalChecked.parentElement.textContent.trim()}` : "Pilih";
        const lokasiTujuanChecked = document.querySelector('[name=lokasi_tujuan_id]:checked');
        document.querySelector('#cabang-tujuan').textContent = lokasiTujuanChecked ?
            `${lokasiTujuanChecked.parentElement.textContent.trim()}` : "Pilih";
    </script>
</body>

</html>
