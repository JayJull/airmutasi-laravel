<!DOCTYPE html>
<html lang="en">

<head>
    @include('components/head')
    <title>Air Mutasi | Login</title>
</head>

<body class="font-sans tracking-wider text-lg">
    @include('components.header', ['static' => true])
    @include('components.modal-component')
    <main class="h-screen flex justify-end">
        <img src="/images/backgrounds/background2.png" alt="bg" class="w-full object-cover">
        <form action="/login" method="post" class="absolute h-full bg-opacity-30 backdrop-blur-lg border-2 w-full sm:w-1/2 md:w-1/3 flex flex-col justify-center gap-4 bg-white p-4 z-10">
            @csrf
            <h1 class="font-bold text-xl text-center">Masuk</h1>
            <hr>
            <input type="email" name="email" placeholder="Email" class="px-4 py-2 border rounded-md">
            <input type="password" name="password" placeholder="Password" class="px-4 py-2 border rounded-md">
            <button type="submit"
                class="font-semibold bg-[#003285] hover:opacity-100 opacity-80 duration-200 px-4 py-2 rounded-md">Login</button>
            <a href="/forget-password" class="text-blue-500 underline text-sm">Lupa password?</a>
        </form>
    </main>
    <script src="/script/nav.js"></script>
</body>

</html>
