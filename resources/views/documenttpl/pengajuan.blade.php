<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <section id="page1" style="height: 1000px">
        <table>
            <tr>
                <td style="width: 525px">
                    {{-- <img src="{{ asset('/images/documents/airnav.png') }}" alt="logo" width="100"> --}}
                    AirNav Indonesia
                </td>
                <td style="font-size: 0.7rem">
                    {{ $pengajuan->lokasiAwal->nama }} <br>
                    {{ $pengajuan->lokasiAwal->alamat }}
                    {{-- CABANG SORONG <br>
                    Gedung Air Traffic Service Bandar Udara <br>
                    Domine Eduarsd Osok Sorong <br>
                    Jl. Basuki Rahmat Km. 8 --}}
                </td>
            </tr>
        </table>
        <p>
            Sorong, 26 April 2021
        </p>
        <table>
            <tr>
                <td style="width: 200px">Nomor</td>
                <td>:</td>
                <td style="padding: 0 10px">112/G/32/PER.08/IV/2021</td>
            </tr>
            <tr>
                <td>Sifat</td>
                <td>:</td>
                <td style="padding: 0 10px">Biasa/ Terbuka</td>
            </tr>
            <tr>
                <td>Lampiran</td>
                <td>:</td>
                <td style="padding: 0 10px">1 (satu) Berkas</td>
            </tr>
            <tr style="vertical-align: top">
                <td>Perihal</td>
                <td>:</td>
                <td style="padding: 0 10px">Persetujuan Permohonan Mutasi Jabatan Personel {{ $pengajuan->jabatan }} di
                    {{ $pengajuan->lokasiAwal->nama }} a.n. {{ $pengajuan->nama_lengkap }} ke
                    {{ $pengajuan->lokasiTujuan->nama }}</td>
            </tr>
        </table>

        <p>
            Kepada Yth. <br>
            Direktur SDM dan Umum <br>
            Di Tempat
        </p>
        <p>Dengan hormat,</p>

        <ol>
            <li>
                Berdasarkan :
                <ol type="a">
                    <li>
                        Surat Direktur Personalia dan Umum Nomor : 03.05/00/LPPNPI/II/2017/086 tanggal 03 November
                        2017 perihal Mutasi Atas Permintaan Sendiri;
                    </li>
                    <li>
                        Aplikasi E-Chain (Competitivenes Human Resources of Airnav Indonesia) perihal Perhitungan
                        Formasi Kebutuhan Personel {{ $pengajuan->posisi_tujuan }} pada Cabang.
                    </li>
                </ol>
            </li>
            <li>Terkait butir 1 (satu) diatas, disampaikan persetujuan permohonan mutasi jabatan Personel
                {{ $pengajuan->posisi_tujuan }}
                di {{ $pengajuan->lokasiAwal->nama }} a.n. {{ $pengajuan->nama_lengkap }} ke
                {{ $pengajuan->lokasiTujuan->nama }}.
            </li>
            <li>
                Demikian disampaikan, atas perhatiannya diucapkan terimakasih.
            </li>

        </ol>

        <div>
            <p>General Manager Cabang Sorong</p>
            <div style="height: 50px"></div>
            <p>Ef Oktavian</p>
        </div>
    </section>
    <table style="color: #00f; font-size: 0.5rem;">
        <tr>
            <td style="width: 650px">ARSIPku</td>
            <td>© 2021</td>
        </tr>
    </table>

    <section id="page2" style="padding: 20px 40px">
        <p>
            Sorong, 26 April 2021
        </p>

        <table>
            <tr style="vertical-align: top">
                <td style="width: 200px">Perihal</td>
                <td>:</td>
                <td style="padding: 0 10px">
                    Permohonan Pindah Tugas Sdr. {{ $pengajuan->nama_lengkap }} ke
                    {{ $pengajuan->lokasiTujuan->nama }}
                </td>
            </tr>
            <tr>
                <td style="width: 200px">Lampiran</td>
                <td>:</td>
                <td style="padding: 0 10px">
                    1 ( Satu )
                </td>
            </tr>
        </table>

        <p>
            Kepada Yth. <br>
            <span style="font-weight: 700">
                General Manager <br>
                {{ $pengajuan->lokasiTujuan->nama }} <br>
            </span>
            di - <br>
            Sorong
        </p>

        <ol>
            <li>
                <p>Dengan hormat, saya yang bertanda tangan dibawah ini :</p>
                <table>
                    <tr>
                        <td style="width: 175px">Nama</td>
                        <td>:</td>
                        <td>{{ $pengajuan->nama_lengkap }}</td>
                    </tr>
                    <tr>
                        <td>NIK</td>
                        <td>:</td>
                        <td>{{ $pengajuan->nik }}</td>
                    </tr>
                    <tr>
                        <td>Tempat Tanggal Lahir</td>
                        <td>:</td>
                        <td>Muara Bungo, 06 Juli 1991</td>
                    </tr>
                    <tr>
                        <td>Jabatan/Level Jabatan</td>
                        <td>:</td>
                        <td>{{ $pengajuan->jabatan }} / 9 ( Sembilan )</td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>:</td>
                        <td>Karyawan</td>
                    </tr>
                    <tr>
                        <td>Unit Kerja</td>
                        <td>:</td>
                        <td>{{ $pengajuan->posisi_sekarang }}</td>
                    </tr>
                    <tr>
                        <td>TMT Pemagangan</td>
                        <td>:</td>
                        <td>12 Juni 2017 s.d 22 Desember 2017</td>
                    </tr>
                    <tr>
                        <td>TMT Masa Kerja</td>
                        <td>:</td>
                        <td>22 Desember 2017 s.d Sekarang</td>
                    </tr>
                </table>
            </li>
            <li>
                Bersama ini mengajukan permohonan pindah tugas dengan keterangan dan bahan
                pertimbangan sebagai berikut :
                <table>
                    <tr>
                        <td style="width: 175px">Lokasi kerja Eksisting</td>
                        <td>:</td>
                        <td>{{ $pengajuan->lokasiAwal->nama }}</td>
                    </tr>
                    <tr>
                        <td>Lokasi Kerja Tujuan</td>
                        <td>:</td>
                        <td>{{ $pengajuan->lokasiTujuan->nama }}</td>
                    </tr>
                    <tr>
                        <td>Unit Kerja</td>
                        <td>:</td>
                        <td>{{ $pengajuan->posisi_tujuan }}</td>
                    </tr>
                    <tr style="vertical-align: top">
                        <td>Alasan / Justifikasi</td>
                        <td>:</td>
                        <td style="width: 400px">
                            {{ $pengajuan->keterangan }}
                        </td>
                    </tr>
                </table>
            </li>
            <li>
                <p>
                    Terkait dengan hal tersebut diatas, bersama ini dilampirkan berkas-berkas atas permohonan ialah
                    sebagai berikut :
                </p>
                <ol type="a">
                    <li>Daftar Riwayat Hidup</li>
                    <li>Personal Training Record</li>
                    <li>Fotocopy SK Pengangkatan Karyawan</li>
                    <li>Fotocopy SK Pengukuhan Dalam Jabatan</li>
                    <li>Fotocopy Ijazah Terakhir</li>
                    <li>Fotocopy Sertifikat-Sertifikat Pelatihan</li>
                </ol>
            </li>
            <li>
                Demikian disampaikan, besar harapan saya akan adanya persetujuan atas permohonan ini dan atas perhatian
                beserta perkenaannya diucapkan terima kasih.
            </li>
        </ol>

        <table>
            <tr style="text-align: center">
                <td style="width: 280px">
                    Pemohon <br>
                </td>
                <td style="width: 320px">
                    Mengetahui <br>
                    PH. Manager Adm & Keuangan <br>
                </td>
            </tr>
            <tr>
                <td style="height: 100px"></td>
                <td></td>
            </tr>
            <tr style="text-align: center">
                <td>
                    {{ $pengajuan->nama_lengkap }} <br>
                    NIK. {{ $pengajuan->nik }}
                </td>
                <td>
                    FIKY MASRUL KHUZAENI <br>
                    NIK. ASN83875
                </td>
            </tr>
        </table>
    </section>
</body>

</html>
