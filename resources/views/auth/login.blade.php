<!DOCTYPE html>
<html lang="en">

<head>
    @include('components/head')
    <title>Air Mutasi | Login</title>
</head>

<body class="font-sans tracking-wider text-lg">
    @include('components.modal-component')
    <main class="h-screen flex justify-between">
        <img src="/images/backgrounds/LOGIN.png" alt="bg" class="-z-10 absolute w-screen h-screen object-cover">
        <form action="/login" method="post"
            class="h-full bg-opacity-70 backdrop-blur-lg w-full sm:w-1/2 flex flex-col justify-center gap-4 bg-white px-8 py-16 shadow-black shadow-md">
            <a href="/" class="flex justify-center"><img src="/images/logo.svg" alt="logo" class="max-h-12"></a>
            @csrf
            <div
                class="flex-grow flex flex-col justify-center items-center bg-[#2B2B2B] bg-opacity-10 shadow-md px-4 sm:px-6 md:px-8 lg:px-16 py-4 rounded-md">
                <h1 class="font-bold text-2xl text-center">Log in</h1>
                <p class="text-center">Enter your account details below.</p>
                <hr class="my-2">
                <label for="email" class="self-start mt-2 mb-1">Email</label>
                <input type="email" name="email" placeholder="Email"
                    class="px-4 py-2 border-2 border-gray-700 rounded-md w-full">
                <label for="password" class="self-start mt-2 mb-1">Password</label>
                <input type="password" name="password" placeholder="Password"
                    class="px-4 py-2 border-2 border-gray-700 rounded-md w-full">
                <button type="submit"
                    class="w-full font-semibold bg-[#003285] text-white hover:opacity-100 opacity-80 duration-200 px-4 py-2 rounded-full mt-10">Log
                    in</button>
                <a href="/forget-password" class="text-blue-500 underline text-sm mt-2">Forgot your password?</a>
            </div>
        </form>
        <div class="px-4 py-2 hidden sm:block">
            <a href="/login"
                class="text-sm hover:bg-white hover:text-black duration-300 text-white border-2 px-8 py-1 rounded-full">Login</a>
        </div>
    </main>
</body>

</html>
