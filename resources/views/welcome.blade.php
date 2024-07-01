<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('components/head')
    <title>Air Mutasi</title>
</head>

<body class="bg-[#373737] font-poppins">
    @include('components/header')
    <main class="min-h-screen">
        <section class="h-screen w-full flex items-center justify-center bg-[#262626]">
            <img src="/images/backgrounds/background1.png" alt="background landing"
                class="blur-sm absolute z-0 opacity-50" />
            <div class="z-10 flex flex-col items-center gap-2 text-[#EDEDED]">
                <h1 class="text-6xl 2xl:text-8xl font-bold my-2">Air Mutasi</h1>
                <p class="text-2xl 2xl:text-4xl font-medium my-1">
                    Aplikasi operasi AirNav Indonesia
                </p>
            </div>
        </section>
        <section class="text-white flex flex-col gap-5 p-8">
            <div class="flex flex-col gap-2">
                <h2 class="font-bold text-base">Tentang AirMutasi</h2>
                <p class="font-medium text-sm">
                    Airmutasi adalah sebuah platform berbasis web yang dirancang untuk mengelola berbagai proses terkait
                    rotasi, demosi, dan promosi karyawan di lingkungan AirNav. Aplikasi ini dapat diakses melalui
                    browser, memudahkan pengelolaan dan pemantauan dari mana saja dan kapan saja.
                    Airmutasi membantu AirNav untuk mengelola sumber daya manusia secara lebih efektif, memastikan bahwa
                    setiap proses rotasi, demosi, dan promosi dilakukan dengan cara yang adil dan efisien.
                </p>
            </div>
            <div class="grid md:grid-cols-3 gap-4">
                <a href="/rotasi/denah"
                    class="bg-[#293676] font-semibold text-lg 2xl:text-xl flex justify-center items-center gap-3 p-4 rounded-xl 2xl:rounded-2xl">Rotasi
                    <img src="/images/icons/rotasi.svg" alt="rotasi" /></a>
                <a href="/"
                    class="bg-[#293676] font-semibold text-lg 2xl:text-xl flex justify-center items-center gap-3 p-4 rounded-xl 2xl:rounded-2xl opacity-65">Demosi
                    <img src="/images/icons/demosi.svg" alt="demosi" /></a>
                <a href="/"
                    class="bg-[#293676] font-semibold text-lg 2xl:text-xl flex justify-center items-center gap-3 p-4 rounded-xl 2xl:rounded-2xl opacity-65">Promosi
                    <img src="/images/icons/promosi.svg" alt="promosi" /></a>
            </div>
        </section>
    </main>
    @include('components.footer')
    <script src="/script/nav.js"></script>
</body>

</html>
