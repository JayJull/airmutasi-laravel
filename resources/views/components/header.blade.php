<header
    class="bg-white font-bold flex flex-col md:flex-row items-center justify-between px-8 py-4 gap-4 {{ !empty($static) && $static ? 'sticky' : 'fixed' }} top-0 left-0 z-50 w-full shadow-black drop-shadow-lg font-sans text-lg tracking-widest font-lg">
    <a href="/"><img src="/images/logo.svg" alt="logo" /></a>
    <button class="md:hidden">☰</button>
    <nav
        class="md:min-w-1/4 hidden md:flex flex-col sm:flex-row items-center justify-around gap-2 sm:gap-4 md:gap-16 z-[60]">
        <div id="rotasi-nav">
            <button class="flex items-center gap-1">Rotasi <img src="/images/icons/moreArrow.svg"
                    class="duration-300"></button>
            <div
                class="max-h-0 duration-300 absolute flex flex-col gap-1 bg-white mt-4 text-gray-800 text-base font-light overflow-hidden">
                <div class="flex flex-col gap-1 px-2 py-1 bg-[#FFB72D]">
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
        <a class="text-gray-500" href="#">Demosi</a>
        <a class="text-gray-500" href="#">Promosi</a>
        @auth
            <a href="/akun">Akun</a>
            <a href="/logout">Logout</a>
        @else
            <a href="/login">Login</a>
        @endauth
    </nav>
    <div class="hidden md:block absolute h-full right-0 z-40 w-40">
        <img src="/images/backgrounds/headerAccent.svg" alt="header accent" class="h-full object-cover object-left">
    </div>
</header>
{{-- 
<div popover id="login-popover" class="w-1/3 bg-white p-4 rounded-lg border">
    <form action="/login" method="post" class="flex flex-col gap-2">
        @csrf
        <h1 class="font-bold text-xl text-center">Masuk</h1>
        <hr>
        <input type="email" name="email" placeholder="Email" class="px-4 py-2 border rounded-md">
        <input type="password" name="password" placeholder="Password" class="px-4 py-2 border rounded-md">
        <button type="submit"
            class="font-semibold bg-[#FFB72D] hover:opacity-100 opacity-80 duration-200 px-4 py-2 rounded-md">Login</button>
        <a href="/forget-password" class="text-blue-500 underline text-sm">Lupa password?</a>
    </form>
</div> --}}

<script>
    const rotasiNav = document.getElementById('rotasi-nav');
    rotasiNav.addEventListener('click', () => {
        const dropdown = rotasiNav.querySelector('div');
        dropdown.classList.toggle('max-h-0');
        dropdown.classList.toggle('max-h-[170%]');
        rotasiNav.querySelector('button > img').classList.toggle('rotate-90');
    });
</script>
