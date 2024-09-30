<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('components/head')
    <title>Air Mutasi</title>
</head>

<body class="font-sans tracking-wider text-lg">
    @include('components/header', ['static' => true])
    <main class="flex flex-col gap-4 p-8">
        <section class="flex flex-col-reverse md:flex-row items-stretch gap-4">
            <aside class="md:w-3/5 flex flex-col justify-between">
                <p class="text-6xl 2xl:text-8xl font-black text-[#003285]">
                    Sistem Mutasi AirNav
                </p>
                <p class="font-medium text-lg mt-4 md:text-left text-justify">
                    Mutant adalah sebuah platform berbasis web yang dirancang untuk mengelola berbagai proses terkait
                    rotasi, demosi, dan promosi karyawan di lingkungan AirNav. Aplikasi ini dapat diakses melalui
                    browser, memudahkan pengelolaan dan pemantauan dari mana saja dan kapan saja.
                    Airmutasi membantu AirNav untuk mengelola sumber daya manusia secara lebih efektif, memastikan bahwa
                    setiap proses rotasi, demosi, dan promosi dilakukan dengan cara yang adil dan efisien.
                </p>
                <div class="grid md:grid-cols-2 gap-4 mt-4">
                    <div class="bg-[#003285] text-white p-4 rounded-md">
                        <p class="font-semibold text-2xl text-center">{{ $cabangs->count() }}+</p>
                        <p class="opacity-60 text-center">Branch Offices</p>
                    </div>
                    <div class="bg-[#003285] text-white p-4 rounded-md">
                        <p class="font-semibold text-2xl text-center">{{ $personel }}+</p>
                        <p class="opacity-60 text-center">Employees</p>
                    </div>
                </div>
            </aside>
            <aside class="md:w-2/5 aspect-video flex" id="carousel">
                @foreach ($cabangs as $cabang)
                    <img class="{{ $loop->index != 0 ? 'w-0' : '' }} object-cover rounded-md duration-300"
                        src="{{ $cabang->thumbnail_url }}" alt="thumbnail-{{ $loop->index }}">
                @endforeach
            </aside>
        </section>
        <div class="grid md:grid-cols-3 gap-4">
            <a href="/rotasi/cabang"
                class="bg-[#003285] text-white font-semibold text-lg 2xl:text-xl flex flex-col justify-center items-center gap-3 p-8 rounded-md 2xl:rounded-2xl"><img
                    src="/images/icons/rotasi.svg" alt="rotasi" />Rotasi</a>
            <a href="/"
                class="bg-[#003285] text-white font-semibold text-lg 2xl:text-xl flex flex-col justify-center items-center gap-3 p-8 rounded-md 2xl:rounded-2xl opacity-65">
                <img src="/images/icons/demosi.svg" alt="demosi" />Demosi</a>
            <a href="/"
                class="bg-[#003285] text-white font-semibold text-lg 2xl:text-xl flex flex-col justify-center items-center gap-3 p-8 rounded-md 2xl:rounded-2xl opacity-65">
                <img src="/images/icons/promosi.svg" alt="promosi" />Promosi</a>
        </div>
    </main>
    @include('components.footer')
    <script src="/script/nav.js"></script>
    <script>
        const carouselImgs = document.querySelectorAll("#carousel > img");
        var currCarouselIndex = 0;
        setInterval(() => {
            carouselImgs[currCarouselIndex].classList.add("w-0");
            carouselImgs[currCarouselIndex].classList.remove("w-full");
            currCarouselIndex = (currCarouselIndex + 1) % carouselImgs.length;
            carouselImgs[currCarouselIndex].classList.remove("w-0");
            carouselImgs[currCarouselIndex].classList.add("w-full");
        }, 2000);
    </script>
</body>

</html>
