<header
    class="bg-[#293676] text-[#D2D2D2] font-bold flex flex-col md:flex-row items-center justify-between px-8 py-4 gap-4 {{ !empty($static) && $static ? 'sticky' : 'fixed' }} top-0 left-0 z-50 w-full">
    <a href="/"><img src="/images/logo.svg" alt="logo" /></a>
    <button class="md:hidden">☰</button>
    <nav class="md:min-w-1/4 hidden md:flex flex-col sm:flex-row items-center justify-around gap-2 sm:gap-4">
        <div id="rotasi-nav">
            <button class="flex items-center gap-1">Rotasi <img src="/images/icons/moreArrow.svg" class="duration-300"></button>
            <div class="max-h-0 duration-300 absolute flex flex-col gap-1 bg-white mt-4 text-gray-800 text-base font-light overflow-hidden [&_a]:py-1 [&_a]:px-2">
                <a href="/rotasi/denah">Denah Rotasi</a>
                <hr>
                <a href="/rotasi/personal">Input Personal (IP)</a>
                <hr>
                <a href="/rotasi/selektif">Selektif Admin</a>
            </div>
        </div>
        <a class="text-gray-400" href="#">Demosi</a>
        <a class="text-gray-400" href="#">Promosi</a>
        @auth
            <a href="/akun">Akun</a>
            <a href="/logout">Logout</a>
        @else
            <a href="/login">Login</a>
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
</script>
