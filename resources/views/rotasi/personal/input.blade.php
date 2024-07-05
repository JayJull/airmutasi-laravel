<!DOCTYPE html>
<html lang="en">

<head>
    @include('components/head')
    <title>Air Mutasi | Rotasi</title>
</head>

<body class="bg-[#CED0FF] font-poppins relative">
    @include('components.header', ['static' => true])
    @include('components.modal-component')
    <main>
        <section class="flex flex-col items-center my-4 px-2">
            <form method="POST" action="/rotasi/personal" class="w-full md:w-2/3 p-8 flex flex-col gap-4"
                enctype="multipart/form-data">
                <h1 class="font-semibold text-xl">Tambah Data Personel</h1>
                @csrf
                <div class="grid md:grid-cols-9 gap-4">
                    <aside class="w-full md:col-span-4">
                        <label class="font-semibold" for="lokasi_awal_id">Lokasi Awal</label><br />
                        <select class="w-full px-2 py-1 mt-1 bg-white border-2 border-slate-400 rounded-md"
                            name="lokasi_awal_id" id="lokasi_awal">
                            <option value disabled>--- Pilih Lokasi Awal ---</option>
                            @foreach ($cabangs as $cabang)
                                <option id="lokasi-awal-{{ $cabang->id }}" value="{{ $cabang->id }}"
                                    {{ old('lokasi_awal_id') == $cabang->id || (!old('lokasi_awal_id') && $loop->index === 0) ? 'selected' : '' }}>
                                    {{ $cabang->nama }}
                                </option>
                            @endforeach
                        </select>
                    </aside>
                    <div class="flex justify-center items-end">
                        <img src="/images/icons/switch_blue.svg" alt="switch">
                    </div>
                    <aside class="w-full md:col-span-4">
                        <label class="font-semibold" for="lokasi_tujuan_id">Lokasi Tujuan</label><br />
                        <select class="w-full px-2 py-1 mt-1 bg-white border-2 border-slate-400 rounded-md"
                            name="lokasi_tujuan_id" id="lokasi_tujuan">
                            <option value>--- Pilih Lokasi Tujuan ---</option>
                            @foreach ($cabangs as $cabang)
                                <option id="lokasi-tujuan-{{ $cabang->id }}" value="{{ $cabang->id }}"
                                    {{ old('lokasi_tujuan_id') == $cabang->id ? 'selected' : '' }}>
                                    {{ $cabang->nama }}
                                </option>
                            @endforeach
                        </select>
                    </aside>
                </div>
                <label class="self-end">
                    <input type="checkbox" name="abnormal" id="abnormal"
                        {{ old('abnormal') || !old() ? 'checked' : '' }}>
                    Mutasi abnormal?
                </label>
                <hr class="border-1 border-slate-400 w-full my-4" />
                <div class="grid md:grid-cols-2 gap-4">
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
                <div class="grid md:grid-cols-2 gap-4">
                    <aside class="w-full">
                        <label class="font-semibold" for="masa_kerja">Masa Kerja</label><br />
                        <div class="grid grid-cols-4 mt-1 gap-2 items-center">
                            <input type="number" name="masa_kerja" id="masa_kerja"
                                class="col-span-3 px-2 py-1 border-2 border-slate-400 rounded-md"
                                placeholder="Ketik Disini ..." value="{{ old('masa_kerja') }}" />
                            <button type="button" id="sk_mutasi_file_button"
                                class="col-span-1 bg-[#7186F3] hover:bg-[#435EEF] duration-200 text-white px-2 py-1 rounded-md font-medium"
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
                <div class="grid md:grid-cols-2 gap-4">
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
                            <option value="AIS" {{ old('posisi_sekarang') == 'AIS' ? 'selected' : '' }}>AIS
                            </option>
                            <option value="ATFM" {{ old('posisi_sekarang') == 'ATFM' ? 'selected' : '' }}>ATFM
                            </option>
                            <option value="TAPOR" {{ old('posisi_sekarang') == 'TAPOR' ? 'selected' : '' }}>TAPOR
                            </option>
                            <option value="ATSSystem" {{ old('posisi_sekarang') == 'ATSSystem' ? 'selected' : '' }}>ATS
                                System
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
                            <option value="AIS" {{ old('posisi_tujuan') == 'AIS' ? 'selected' : '' }}>AIS
                            </option>
                            <option value="ATFM" {{ old('posisi_tujuan') == 'ATFM' ? 'selected' : '' }}>ATFM
                            </option>
                            <option value="TAPOR" {{ old('posisi_tujuan') == 'TAPOR' ? 'selected' : '' }}>TAPOR
                            </option>
                            <option value="ATSSystem" {{ old('posisi_tujuan') == 'ATSSystem' ? 'selected' : '' }}>ATS
                                System
                            </option>
                            <option value="STAFF" {{ old('posisi_tujuan') == 'STAFF' ? 'selected' : '' }}>STAFF
                            </option>
                        </select>
                    </aside>
                </div>
                <hr class="border-1 border-slate-400 w-full my-4" />
                <div class="grid md:grid-cols-2 auto-rows-auto gap-4">
                    <aside class="w-full">
                        <label class="font-semibold" for="kompetensi">Kompetensi</label><br />
                        <div id="kompetensi" class="w-full my-2">
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
                        <button
                            class="bg-[#7186F3] hover:bg-[#435EEF] duration-200 text-white py-2 rounded-lg font-semibold w-full mt-1"
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
                        class="w-full bg-[#7186F3] hover:bg-[#435EEF] duration-200 text-white px-2 py-1 mt-1 rounded-md font-medium"
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
                <button type="submit"
                    class="bg-[#7186F3] hover:bg-[#435EEF] duration-200 text-white py-2 rounded-lg font-semibold">
                    Kirim
                </button>
            </form>
        </section>
    </main>
    @include('components.footer')
    <script src="/script/nav.js"></script>
    <script src="/script/filePopover.js"></script>
    <script>
        // (re)bind delete button event for kompetensi item by id
        function kompetensiBindDeleteBtn(id) {
            document.querySelector(`#${id} > button`).addEventListener('click', function() {
                this.parentElement.remove();
            });
        }
    </script>
    <script>
        const abnormalCheckbox = document.getElementById('abnormal');
        const lokasiAwal = document.getElementById('lokasi_awal')

        lokasiAwal.addEventListener('change', function() {
            const lokasiAwalID = this.value;
            if (!abnormalCheckbox.checked) {
                const cabangTujuan = fetch('/api/rotasi/cabang-same-kelas/' + lokasiAwalID)
                    .then(response => response.json())
                    .then(data => {
                        const lokasiTujuan = document.getElementById('lokasi_tujuan');
                        lokasiTujuan.innerHTML = '<option value>--- Pilih Lokasi Tujuan ---</option>';
                        data.forEach(cabang => {
                            const option = document.createElement('option');
                            option.id = 'lokasi-tujuan-' + cabang.id;
                            option.value = cabang.id;
                            option.innerText = cabang.nama;
                            lokasiTujuan.appendChild(option);
                        });
                    });
            }
        });
        abnormalCheckbox.addEventListener('change', function() {
            const lokasiAwalID = lokasiAwal.value;
            if (!this.checked) {
                const cabangTujuan = fetch('/api/rotasi/cabang-same-kelas/' + lokasiAwalID)
                    .then(response => response.json())
                    .then(data => {
                        const lokasiTujuan = document.getElementById('lokasi_tujuan');
                        lokasiTujuan.innerHTML = '<option value>--- Pilih Lokasi Tujuan ---</option>';
                        data.forEach(cabang => {
                            const option = document.createElement('option');
                            option.id = 'lokasi-tujuan-' + cabang.id;
                            option.value = cabang.id;
                            option.innerText = cabang.nama;
                            lokasiTujuan.appendChild(option);
                        });
                    });
            } else {
                const cabangTujuan = fetch('/api/rotasi/cabang')
                    .then(response => response.json())
                    .then(data => {
                        const lokasiTujuan = document.getElementById('lokasi_tujuan');
                        lokasiTujuan.innerHTML = '<option value>--- Pilih Lokasi Tujuan ---</option>';
                        data.forEach(cabang => {
                            const option = document.createElement('option');
                            option.id = 'lokasi-tujuan-' + cabang.id;
                            option.value = cabang.id;
                            option.innerText = cabang.nama;
                            lokasiTujuan.appendChild(option);
                        });
                    });
            }
        });
    </script>
    <script>
        // counter for kompetensi id
        var kompetensiCount = 1;

        // set file popover behaviour
        initFilePopover('sk_mutasi');
        initFilePopover('surat_persetujuan');
        // bind delete button event for initial kompetensi item
        document.querySelectorAll(".kompetensi-item").forEach(kompetensi => {
            kompetensiBindDeleteBtn(kompetensi.id);
            initFilePopover(kompetensi.id);
        });

        // add kompetensi item
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
</body>

</html>
