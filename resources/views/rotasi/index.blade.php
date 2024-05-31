<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('components/head')
    <title>Air Mutasi | Rotasi</title>
</head>

<body class="bg-[#373737] font-poppins">
    <header
        class="bg-[#293676] text-[#D2D2D2] font-bold flex flex-col md:flex-row items-center justify-between px-8 py-4 gap-4 fixed top-0 left-0 z-50 w-full">
        <a href="/"><img src="/images/logo.svg" alt="logo" /></a>
        <button class="md:hidden">☰</button>
        <nav class="hidden md:flex flex-col sm:flex-row flex-grow items-center justify-around gap-2">
            <a class="text-center" href="/rotasi">Home</a>
            <a class="text-center" href="/rotasi/denah">Denah Rotasi</a>
            <a class="text-center" href="#">Sistem Pengajuan Mutasi (SPM)</a>
            <a class="text-center" href="#">Sistem Antrian Mutasi (SAM)</a>
            <a class="text-center" href="#">Sistem Administrasi (SA)</a>
            <a class="text-center" href="#">Sistem Pelaporan dan Analisis (SPA)</a>
            <a class="text-center" href="#">Akun</a>
        </nav>
    </header>
    <main class="h-[70vh] sm:h-screen">
        <section class="h-full w-full p-4">
            <div id="map" class="w-full h-full z-40"></div>
        </section>
    </main>
    @include('components.footer')
    <script src="/script/nav.js"></script>
    <script src="/script/map.js"></script>
</body>

</html>
