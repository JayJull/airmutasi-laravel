<header
    class="bg-[#293676] text-[#D2D2D2] font-bold flex flex-col md:flex-row items-center justify-between px-8 py-4 gap-4 {{ !empty($static) && $static ? 'static' : 'fixed' }} top-0 left-0 z-50 w-full">
    <a href="/"><img src="/images/logo.svg" alt="logo" /></a>
    <button class="md:hidden">☰</button>
    <nav class="hidden md:flex flex-col sm:flex-row flex-grow items-center justify-around gap-2">
        <a class="text-center" href="/rotasi">Home</a>
        <a class="text-center" href="/rotasi/denah">Denah Rotasi</a>
        <a class="text-center" href="/rotasi/personal">Input Personal (IP)</a>
        @auth
            @if (Auth::user()->role->name == 'admin')
                <a class="text-center" href="/rotasi/selektif">Selektif Admin</a>
            @endif
        @endauth
        <a class="text-center" href="/akun">Akun</a>
        <a class="text-center" href="/logout">Logout</a>
    </nav>
</header>
