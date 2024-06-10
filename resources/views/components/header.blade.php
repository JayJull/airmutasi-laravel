<header
    class="bg-[#293676] text-[#D2D2D2] font-bold flex flex-col md:flex-row items-center justify-between px-8 py-4 gap-4 {{ !empty($static) && $static ? 'static' : 'fixed' }} top-0 left-0 z-50 w-full">
    <a href="/"><img src="/images/logo.svg" alt="logo" /></a>
    <button class="md:hidden">☰</button>
    <nav class="md:w-1/4 hidden md:flex flex-col sm:flex-row items-center justify-around gap-2">
        <a href="/rotasi">Rotasi</a>
        <a href="#">Demosi</a>
        <a href="#">Promosi</a>
        @auth
            <a href="/akun">Akun</a>
            <a href="/logout">Logout</a>
        @else
            <a href="/login">Login</a>
        @endauth
    </nav>
</header>
