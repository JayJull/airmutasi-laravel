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
                class="w-full md:w-2/3 bg-[#ECECEC] px-8 py-4 rounded-xl border-2 border-slate-400 flex flex-col gap-2"
                enctype="multipart/form-data">
                @csrf
                <div id="lokasi-awal" class="p-4 border-2 rounded-lg" popover>
                    <div class="flex flex-col gap-2">
                        <h2 class="font-bold text-xl">Lokasi awal</h2>
                        <input type="search" id="search-lokasi-awal" class="px-2 py-1 border-2 rounded-md"
                            placeholder="Search ...">
                        <div class="flex flex-col gap-1 max-h-[70vh] overflow-y-auto">
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
                        <div class="flex flex-col gap-1 max-h-[70vh] overflow-y-auto">
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
                        <div class="grid grid-cols-4 mt-1 gap-2 items-center">
                            <input type="number" name="masa_kerja" id="masa_kerja"
                                class="col-span-3 px-2 py-1 border-2 border-slate-400 rounded-md"
                                placeholder="Ketik Disini ..." value="{{ old('masa_kerja') }}" />
                            <button type="button" id="sk_mutasi_file_button"
                                class="col-span-1 bg-blue-300 border-2 border-blue-300 px-2 py-1 rounded-md font-medium text-white"
                                popovertarget="sk_mutasi_popover">{{ old('sk_mutasi_url') ? '✅️ Ubah' : 'Berkas' }}</button>
                            @include('rotasi.components.file-popover', [
                                'id' => 'sk_mutasi',
                                'url' => 'sk_mutasi_url',
                                'file' => 'sk_mutasi_file',
                                'file_url' => old('sk_mutasi_url'),
                            ])
                        </div>
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
                            <option value="ATC (TWR)" {{ old('posisi_sekarang') == 'ATC (TWR)' ? 'selected' : '' }}>
                                ATC
                                (TWR)</option>
                            <option value="ATC (APS)" {{ old('posisi_sekarang') == 'ATC (APS)' ? 'selected' : '' }}>
                                ATC
                                (APS)</option>
                            <option value="ATC (ACS)" {{ old('posisi_sekarang') == 'ATC (ACS)' ? 'selected' : '' }}>
                                ATC
                                (ACS)</option>
                            <option value="ACO" {{ old('posisi_sekarang') == 'ACO' ? 'selected' : '' }}>ACO
                            </option>
                            <option value="STAFF" {{ old('posisi_sekarang') == 'STAFF' ? 'selected' : '' }}>STAFF
                            </option>
                        </select>
                    </aside>
                    <aside>
                        <label class="font-semibold" for="posisi_tujuan">Posisi Kerja Tujuan</label><br />
                        <select name="posisi_tujuan" id="posisi_tujuan"
                            class="w-full px-2 py-1 mt-1 bg-white border-2 border-slate-400 rounded-md">
                            <option value disabled {{ !old('posisi_tujuan') ? 'selected' : '' }}>--- Pilih Posisi ---
                            </option>
                            <option value="ATC (TWR)" {{ old('posisi_tujuan') == 'ATC (TWR)' ? 'selected' : '' }}>ATC
                                (TWR)</option>
                            <option value="ATC (APS)" {{ old('posisi_tujuan') == 'ATC (APS)' ? 'selected' : '' }}>ATC
                                (APS)</option>
                            <option value="ATC (ACS)" {{ old('posisi_tujuan') == 'ATC (ACS)' ? 'selected' : '' }}>ATC
                                (ACS)</option>
                            <option value="ACO" {{ old('posisi_tujuan') == 'ACO' ? 'selected' : '' }}>ACO</option>
                            <option value="STAFF" {{ old('posisi_tujuan') == 'STAFF' ? 'selected' : '' }}>STAFF
                            </option>
                        </select>
                    </aside>
                </div>
                <hr class="border-1 border-slate-400 w-full my-4" />
                <div class="grid md:grid-cols-2 auto-rows-auto gap-2">
                    <aside class="w-full">
                        <label class="font-semibold" for="kompetensi">Kompetensi</label><br />
                        <div id="kompetensi" class="w-full">
                            @if (old('kompetensi'))
                                @foreach (old('kompetensi') as $index => $kompetensi)
                                    @include('rotasi.components.kompetensi-item', [
                                        'index' => $index,
                                        'id' => 'kompetensi_' . $index,
                                        'nama' => $kompetensi['nama'],
                                        'file_url' => $kompetensi['url'],
                                    ])
                                @endforeach
                            @else
                                @include('rotasi.components.kompetensi-item', [
                                    'index' => 1,
                                    'id' => 'kompetensi_1',
                                ])
                            @endif
                        </div>
                        <button class="bg-[#383A83] text-white py-2 rounded-lg font-semibold w-full mt-1"
                            type="button" id="kompetensi_tambah">Tambah +</button>
                    </aside>
                    <aside class="flex flex-col justify-center gap-0">
                        <label class="font-semibold" for="tujuan_rotasi">Tujuan Rotasi</label>
                        <textarea name="tujuan_rotasi" id="tujuan_rotasi"
                            class="resize-none flex-grow w-full px-2 py-1 mt-1 border-2 border-slate-400 rounded-md" rows="4"
                            placeholder="Ketik Disini ...">{{ old('tujuan_rotasi') }}</textarea>
                    </aside>
                </div>
                <div>
                    <label class="font-semibold">Surat Persetujuan Pejabat Setempat</label>
                    <br>
                    <button type="button" id="surat_persetujuan_file_button"
                        class="w-full bg-blue-300 border-2 border-blue-300 px-2 py-1 mt-1 rounded-md font-medium text-white"
                        popovertarget="surat_persetujuan_popover">{{ old('surat_persetujuan_url') ? '✅️ Ubah' : 'Berkas' }}</button>
                    @include('rotasi.components.file-popover', [
                        'id' => 'surat_persetujuan',
                        'url' => 'surat_persetujuan_url',
                        'file' => 'surat_persetujuan_file',
                        'file_url' => old('surat_persetujuan_url'),
                    ])
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
    <script src="/script/filePopover.js"></script>
    <script>
        function kompetensiBindDeleteBtn(id) {
            document.querySelector(`#${id} > button`).addEventListener('click', function() {
                this.parentElement.remove();
            });
        }
    </script>
    <script>
        var kompetensiCount = 1;
        initFilePopover('sk_mutasi');
        initFilePopover('surat_persetujuan');
        document.querySelectorAll(".kompetensi-item").forEach(kompetensi => {
            kompetensiBindDeleteBtn(kompetensi.id);
            initFilePopover(kompetensi.id);
        });
        document.querySelector("#kompetensi_tambah").addEventListener('click', function() {
            const kompetensiContainer = document.getElementById('kompetensi');
            kompetensiContainer.innerHTML += `@include('rotasi.components.kompetensi-item', [
                'index' => '${kompetensiCount + 1}',
                'id' => 'kompetensi_${kompetensiCount + 1}',
            ])`;
            document.querySelectorAll(".kompetensi-item").forEach(kompetensi => {
                kompetensiBindDeleteBtn(kompetensi.id);
                initFilePopover(kompetensi.id);
            });
            kompetensiCount++;
        });
    </script>
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
