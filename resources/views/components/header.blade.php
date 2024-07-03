<header
    class="bg-[#293676] text-[#D2D2D2] font-bold flex flex-col md:flex-row items-center justify-between px-8 py-4 gap-4 {{ !empty($static) && $static ? 'sticky' : 'fixed' }} top-0 left-0 z-50 w-full shadow-black drop-shadow-lg">
    <a href="/"><img src="/images/logo.svg" alt="logo" /></a>
    <button class="md:hidden">☰</button>
    <nav class="md:min-w-1/4 hidden md:flex flex-col sm:flex-row items-center justify-around gap-2 sm:gap-4">
        <div id="rotasi-nav">
            <button class="flex items-center gap-1">Rotasi <img src="/images/icons/moreArrow.svg"
                    class="duration-300"></button>
            <div
                class="max-h-0 duration-300 absolute flex flex-col gap-1 bg-white mt-4 text-gray-800 text-base font-light overflow-hidden">
                <div class="border-2 flex flex-col gap-1 px-2 py-1">
                    <a href="/rotasi/denah">Denah Rotasi</a>
                    <hr>
                    <a href="/rotasi/personal">Input Personal (IP)</a>
                    @can('admin')
                        <hr>
                        <a href="/rotasi/selektif">Selektif Admin</a>
                    @endcan
                </div>
            </div>
        </div>
        <a class="text-gray-400" href="#">Demosi</a>
        <a class="text-gray-400" href="#">Promosi</a>
        @auth
            <div id="akun-nav">
                <button class="flex items-center gap-1">Akun <img src="/images/icons/moreArrow.svg"
                        class="duration-300"></button>
                <div
                    class="max-h-0 duration-300 absolute flex flex-col gap-1 bg-white mt-4 text-gray-800 text-base font-light overflow-hidden">
                    <div class="border-2 flex flex-col gap-1 px-2 py-1">
                        <a href="/akun">Profile</a>
                        <hr>
                        <a class="text-red-500" href="/logout">Logout</a>
                    </div>
                </div>
            </div>
        @else
            <a class="bg-[#7186F3] hover:bg-[#435EEF] duration-200 text-white px-4 py-1" href="/login">Login</a>
        @endauth
    </nav>
</header>

<script>
    const rotasiNav = document.getElementById('rotasi-nav');
    rotasiNav.addEventListener('click', () => {
        const dropdown = rotasiNav.querySelector('div');
        dropdown.classList.toggle('max-h-0');
        dropdown.classList.toggle('max-h-[170%]');
        rotasiNav.querySelector('button > img').classList.toggle('rotate-90');
    });
    const akunNav = document.getElementById('akun-nav');
    akunNav.addEventListener('click', () => {
        const dropdown = akunNav.querySelector('div');
        dropdown.classList.toggle('max-h-0');
        dropdown.classList.toggle('max-h-[170%]');
        akunNav.querySelector('button > img').classList.toggle('rotate-90');
    });
</script>
