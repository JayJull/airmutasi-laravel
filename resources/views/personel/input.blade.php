<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('components/head')
    <title>Air Mutasi | Personel</title>
</head>

<body class="bg-[#CED0FF] font-sans tracking-wider text-lg relative">
    @include('components.header', ['static' => true])
    @include('components.modal-component')
    <main>
        <section class="flex flex-col items-center my-4 px-2">
            <form method="POST" action="/personel/add" class="w-full md:w-2/3 p-8 flex flex-col gap-4">
                <h1 class="font-semibold text-xl">Tambah Data Personel</h1>
                @csrf
                <div class="w-full">
                    <label class="font-semibold" for="cabang_id">Cabang</label><br />
                    <select class="text-center w-full px-2 py-1 mt-1 bg-white border-2 border-slate-400 rounded-md"
                        name="cabang_id" id="cabang">
                        <option value disabled>--- Pilih Cabang ---</option>
                        @foreach ($cabangs as $cabang)
                            <option id="cabang-{{ $cabang->id }}" value="{{ $cabang->id }}"
                                {{ old('cabang_id') == $cabang->id || (!old('cabang_id') && $loop->index === 0) ? 'selected' : '' }}>
                                {{ $cabang->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="grid md:grid-cols-2 gap-4">
                    <aside class="w-full">
                        <label class="font-semibold" for="name">Nama Lengkap</label><br />
                        <input type="text" name="name" id="name"
                            class="w-full px-2 py-1 mt-1 border-2 border-slate-400 rounded-md"
                            placeholder="Ketik Disini ..." value="{{ old('name') }}" />
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
                <div class="grid md:grid-cols-2 gap-4">
                    <aside>
                        <label class="font-semibold" for="posisi">Posisi</label><br />
                        <select name="posisi" id="posisi"
                            class="text-center w-full px-2 py-1 mt-1 bg-white border-2 border-slate-400 rounded-md">
                            <option value disabled {{ !old('posisi') ? 'selected' : '' }}>--- Pilih
                                Posisi ---
                            </option>
                            <option value="ATC (TWR)" {{ old('posisi') == 'ATC (TWR)' ? 'selected' : '' }}>
                                ATC
                                (TWR)</option>
                            <option value="ATC (APS)" {{ old('posisi') == 'ATC (APS)' ? 'selected' : '' }}>
                                ATC
                                (APS)</option>
                            <option value="ATC (ACS)" {{ old('posisi') == 'ATC (ACS)' ? 'selected' : '' }}>
                                ATC
                                (ACS)</option>
                            <option value="ACO" {{ old('posisi') == 'ACO' ? 'selected' : '' }}>ACO
                            </option>
                            <option value="AIS" {{ old('posisi') == 'AIS' ? 'selected' : '' }}>AIS
                            </option>
                            <option value="ATFM" {{ old('posisi') == 'ATFM' ? 'selected' : '' }}>
                                ATFM
                            </option>
                            <option value="TAPOR" {{ old('posisi') == 'TAPOR' ? 'selected' : '' }}>
                                TAPOR
                            </option>
                            <option value="ATSSystem" {{ old('posisi') == 'ATSSystem' ? 'selected' : '' }}>ATS
                                System
                            </option>
                            <option value="STAFF" {{ old('posisi') == 'STAFF' ? 'selected' : '' }}>
                                STAFF
                            </option>
                        </select>
                    </aside>
                    <aside>
                        <label class="font-semibold" for="level_jabatan">Level Jabatan</label><br />
                        <input type="text" name="level_jabatan" id="level_jabatan"
                            class="w-full px-2 py-1 mt-1 border-2 border-slate-400 rounded-md"
                            placeholder="Ketik Disini ..." value="{{ old('level_jabatan') }}" />
                    </aside>
                </div>
                <div class="w-full">
                    <label class="font-semibold" for="kontak">Kontak</label><br />
                    <input type="text" name="kontak" id="kontak"
                        class="w-full px-2 py-1 mt-1 border-2 border-slate-400 rounded-md"
                        placeholder="Ketik Disini ..." value="{{ old('kontak') }}" />
                </div>
                <label class="font-semibold self-end" for="pensiun"><input type="checkbox" name="pensiun" id="pensiun">
                    Persiapan pensiun?</label>
                <div class="w-full">
                    <label class="font-semibold" for="kompetensi">Kompetensi</label><br />
                    <div id="kompetensi">
                        @if (old('kompetensi'))
                            @foreach (old('kompetensi') as $index => $kompetensi)
                                @include('components.kompetensi-item', [
                                    'index' => $index,
                                    'db_id' => $kompetensi,
                                ])
                            @endforeach
                        @else
                            @include('components.kompetensi-item', ['index' => 1])
                        @endif
                    </div>
                    <button
                        class="bg-[#7186F3] hover:bg-[#435EEF] duration-200 text-white py-2 rounded-lg font-semibold w-full mt-1"
                        type="button" id="kompetensi_tambah">Tambah +</button>
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
        // counter for kompetensi id
        var kompetensiCount = 1;

        // bind delete button event for initial kompetensi item
        document.querySelectorAll(".kompetensi-item").forEach(kompetensi => {
            kompetensiBindDeleteBtn(kompetensi.id);
        });

        // add kompetensi item
        document.querySelector("#kompetensi_tambah").addEventListener('click', function() {
            const kompetensiContainer = document.querySelector('#kompetensi');
            kompetensiContainer.insertAdjacentHTML("beforeend", `@include('components.kompetensi-item', [
                'index' => '${kompetensiCount + 1}',
            ])`);
            document.querySelectorAll(".kompetensi-item").forEach(kompetensi => {
                kompetensiBindDeleteBtn(kompetensi.id);
            });
            kompetensiCount++;
        });
    </script>
    <script src="/script/chatbot.js"></script>
</body>

</html>
