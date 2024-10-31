<header
    class="bg-white flex flex-col xl:text-sm xl:flex-row items-center justify-between px-8 py-4 gap-4 {{ !empty($static) && $static ? 'sticky' : 'fixed' }} top-0 left-0 z-50 w-full font-sans text-lg tracking-widest font-lg">
    <a href="/"><img class="xl:h-10" src="/images/logo.svg" alt="logo" /></a>
    <button class="xl:hidden">☰</button>
    <nav
        class="xl:min-w-1/4 hidden xl:flex flex-col sm:flex-row items-center justify-around gap-2 sm:gap-4 xl:gap-16 z-[60]">
        <div id="rotasi-nav">
            <button class="flex items-center gap-1">Rotasi <img src="/images/icons/moreArrow.svg"
                    class="duration-300"></button>
            <div
                class="max-h-0 duration-300 absolute flex flex-col gap-1 bg-white mt-4 text-gray-800 text-base font-light overflow-hidden">
                <div class="flex xl:text-sm flex-col gap-1 px-2 py-1 bg-slate-100">
                    <a href="/rotasi/cabang">Denah Rotasi</a>
                    <hr>
                    <a href="/rotasi/pengajuan">Input Personal (IP)</a>
                    @can('admin')
                        <hr>
                        <a href="/rotasi/selektif">Selektif Admin</a>
                    @endcan
                    @auth
                        <hr>
                        <a href="/rotasi/notification" class="flex">Notifikasi
                            @if (auth()->user()->profile->cabang && auth()->user()->profile->cabang->notreadnotifications->count() > 0)
                                <p class="bg-blue-500 w-2 h-2 rounded-full"></p>
                            @endif
                        </a>
                    @endauth
                </div>
            </div>
        </div>
        <a class="text-gray-500" href="#">Demosi</a>
        <a class="text-gray-500" href="#">Promosi</a>
    </nav>
    <div id="account" class="hidden xl:flex flex-col sm:flex-row gap-2">
        @auth
            <a href="/akun"
                class="text-center text-sm hover:bg-[#003285] hover:text-white duration-300 text-black border-2 border-[#003285] px-8 py-1 rounded-full">Akun</a>
            <a href="/logout"
                class="text-center text-sm hover:bg-white hover:text-black duration-300 bg-[#003285] text-white border-2 border-[#003285] px-8 py-1 rounded-full">Logout</a>
        @else
            <a href="/login"
                class="text-center text-sm hover:bg-[#003285] hover:text-white duration-300 text-black border-2 border-[#003285] px-8 py-1 rounded-full">Login</a>
        @endauth
    </div>
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
