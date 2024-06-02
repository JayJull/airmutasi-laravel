<!DOCTYPE html>
<html lang="en">

<head>
    @include('components/head')
    <title>Air Mutasi | Rotasi</title>
</head>

<body class="bg-[#CED0FF] font-poppins">
    @include('rotasi.components.header', ['static' => true])
    @if (session('success'))
        @include('components.modal', ['message' => session('success')])
    @endif
    @if ($errors->any())
        @include('components.modal', [
            'message' => str_contains($errors->first(), 'required')
                ? 'Mohon isi semua kolom'
                : (str_contains($errors->first(), 'must be a number')
                    ? 'Terdapat format data yang salah'
                    : $errors->first()),
        ])
    @endif
    @if (count($pengajuans) > 0)
        <div id="detail-pengajuan" class="border-2 rounded-lg p-4 w-1/2 max-h-[90vh]" popover>
            <h1 class="font-bold text-xl">Detail</h1>
            <p class="my-1">
                <span>{{ $pengajuan->lokasiAwal->nama }}</span>
                ->
                <span>{{ $pengajuan->lokasiTujuan->nama }}</span>
            </p>
            <div class="flex">
                <aside class="flex-grow">
                    <p class="font-semibold mt-2">Nama</p>
                    <p>{{ $pengajuan->nama_lengkap }}</p>
                    <p class="font-semibold mt-2">NIK</p>
                    <p>{{ $pengajuan->nik }}</p>
                </aside>
                <aside>
                    <p class="font-semibold mt-2">Masa Kerja</p>
                    <p>{{ $pengajuan->masa_kerja }} Tahun</p>
                    <p class="font-semibold mt-2">Jabatan</p>
                    <p>{{ $pengajuan->jabatan }}</p>
                </aside>
            </div>
            <p class="font-semibold mt-2">Rotasi</p>
            <p>
                <span>{{ $pengajuan->posisi_sekarang }}</span>
                ->
                <span>{{ $pengajuan->posisi_tujuan }}</span>
            </p>
            <p class="font-semibold mt-2">Kompetensi</p>
            <p>{{ $pengajuan->kompetensi }}</p>
            <p class="font-semibold mt-2">Tujuan</p>
            <p>{{ $pengajuan->tujuan_rotasi }}</p>
            <p class="font-semibold mt-2">Keterangan</p>
            <p>{{ $pengajuan->keterangan }}</p>
        </div>
    @endif
    <main>
        <section class="flex flex-col-reverse md:grid md:grid-cols-2 m-4 gap-4 md:h-screen">
            <aside
                class="flex flex-col {{ count($pengajuans) === 0 ? 'justify-center col-span-2' : '' }} gap-2 bg-white text-[#474747] border-2 border-[#DEDEDE] rounded-xl p-2 h-[50vh] md:h-full overflow-y-auto">
                <div class="py-2 w-full flex gap-2 {{ count($pengajuans) === 0 ? 'justify-center' : ''}}">
                    <a class="text-blue-500 {{ !$tab || $tab === 'diajukan' ? 'underline' : '' }}" href="/rotasi/selektif">Diajukan</a>
                    <a class="text-blue-500 {{ $tab === 'dapat' ? 'underline' : '' }}" href="/rotasi/selektif?tab=dapat">Dapat</a>
                    <a class="text-blue-500 {{ $tab === 'tidak_dapat' ? 'underline' : '' }}" href="/rotasi/selektif?tab=tidak_dapat">Tidak Dapat</a>
                </div>
                @if (count($pengajuans) === 0)
                    <h1 class="font-bold text-2xl text-center">Tidak Ada Pengajuan</h1>
                @endif
                @foreach ($pengajuans as $currPengajuan)
                    <a href="/rotasi/selektif?id={{ $currPengajuan->id }}{{ $tab ? '&tab=' . ($tab === 'dapat' ? 'dapat' : ($tab === 'tidak_dapat' ? 'tidak_dapat' : '')) : '' }}"
                        class="pengajuan-item border-2 {{ $currPengajuan->id === $pengajuan->id ? 'pengajuan-active border-slate-700' : '' }} bg-[#D6D6D6] px-8 py-3 rounded-lg flex flex-col sm:flex-row items-center justify-between gap-2">
                        <aside class="flex flex-col items-center sm:items-start">
                            <h3 class="font-semibold text-lg">{{ $currPengajuan->nama_lengkap }}</h3>
                            <p>{{ $currPengajuan->nik }}</p>
                        </aside>
                        <aside class="flex items-center gap-4">
                            <h4 class="font-semibold">{{ $currPengajuan->lokasiAwal->nama }}</h4>
                            <img src="/images/icons/Arrow.svg" alt="arrow" />
                            <h4 class="font-semibold">{{ $currPengajuan->lokasiTujuan->nama }}</h4>
                        </aside>
                    </a>
                @endforeach
            </aside>
            @if (count($pengajuans) > 0)
                <form method="POST" action="/rotasi/selektif/{{ $pengajuan->id }}"
                    class="flex flex-col gap-4 bg-white text-[#474747] border-2 border-[#DEDEDE] rounded-xl px-8 py-4 md:h-full overflow-y-auto">
                    @csrf
                    <div class="flex flex-col gap-2 sm:flex-row items-center justify-between">
                        <button class="bg-[#293676] text-white px-6 py-2 font-semibold rounded-lg" type="submit">
                            Submit
                        </button>
                        <h1 class="font-bold text-2xl">Deskripsi</h1>
                        <aside class="flex flex-col items-center sm:items-end font-semibold">
                            <p>Tanggal Pengajuan</p>
                            <p id="tanggal-pengajuan">{{ $pengajuan->tanggal_pengajuan }}</p>
                        </aside>
                    </div>
                    <hr class="w-full border-2 border-[#B6B6B6]" />
                    <div>
                        <label class="font-semibold" for="nama">Nama</label>
                        <input class="w-full border-2 border-[#B6B6B6] px-2 py-1 mt-1 bg-[#C6C6C6]" type="text"
                            id="nama" name="nama" value="{{ $pengajuan->nama_lengkap }}" disabled />
                    </div>
                    <div>
                        <label class="font-semibold" for="nik">NIK</label>
                        <input class="w-full border-2 border-[#B6B6B6] px-2 py-1 mt-1 bg-[#C6C6C6]" type="text"
                            id="nik" name="nik" value="{{ $pengajuan->nik }}" disabled />
                    </div>
                    <button type="button" class="bg-[#293676] text-white px-6 py-2 font-semibold rounded-lg"
                        popovertarget="detail-pengajuan">Detail</button>
                    <div>
                        @if ($tab === 'dapat')
                            <h2 class="font-semibold">Status Pemindahan</h2>
                            <input type="checkbox" name="status" id="diterima" value="diterima">
                            <label for="diterima">Diterima</label><br />
                        @else
                            <h2 class="font-semibold">Status Pemindahan</h2>
                            <input type="radio" name="status" id="dapat" value="dapat"
                                {{ old('status') == 'dapat' ? 'checked' : '' }} />
                            <label for="dapat">Dapat Pemindahan</label><br />
                            <input type="radio" name="status" id="tidak_dapat" value="tidak"
                                {{ old('status') == 'tidak' ? 'checked' : '' }} />
                            <label for="tidak_dapat">Tidak Dapat Pemindahan</label>
                        @endif
                    </div>
                    <div id="keterangan-field" class="hidden">
                        <label class="font-semibold" for="keterangan">Keterangan Penolakan</label>
                        <textarea name="keterangan" id="keterangan" placeholder="Ketik Disini ..."
                            class="w-full border-2 border-[#B6B6B6] px-2 py-1 mt-1 resize-none" rows="5"></textarea>
                    </div>
                    <div id="rekomendasi-field" class="hidden">
                        <label class="font-semibold" for="rekomendasi">Rekomendasi</label>
                        <textarea name="rekomendasi" id="rekomendasi" placeholder="Ketik Disini ..."
                            class="w-full border-2 border-[#B6B6B6] px-2 py-1 mt-1 resize-none" rows="5"></textarea>
                    </div>
                </form>
            @endif
        </section>
    </main>
    @include('components.footer')
    <script src="/script/nav.js"></script>
    <script>
        document.querySelectorAll('input[name="status"]').forEach((radio) => {
            radio.addEventListener("change", () => {
                if (radio.value === "dapat") {
                    document.getElementById("keterangan-field").classList.add("hidden");
                    document.getElementById("rekomendasi-field").classList.add("hidden");
                } else if (radio.value === "tidak") {
                    document.getElementById("keterangan-field").classList.remove("hidden");
                    document.getElementById("rekomendasi-field").classList.remove("hidden");
                }
            });
        });
        if (document.querySelector('input[name="status"]:checked') && document.querySelector('input[name="status"]:checked')
            .value === "tidak") {
            document.getElementById("keterangan-field").classList.remove("hidden");
            document.getElementById("rekomendasi-field").classList.remove("hidden");
        }
    </script>
</body>

</html>
