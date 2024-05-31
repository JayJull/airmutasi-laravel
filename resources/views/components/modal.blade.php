<section id="popup-modal" class="z-50 fixed top-0 left-0 w-screen h-screen flex items-center justify-center">
    <button class="absolute top-0 left-0 w-full h-full" data-modal-hide="popup-modal"
        data-modal-target="popup-modal"></button>
    <div
        class="p-4 bg-white border-2 w-2/3 sm:w-1/2 md:w-1/3 min-h-[25vh] flex flex-col items-center justify-center gap-2 rounded-xl">
        <p class="text-center font-semibold text-xl">{{ $message }}</p>
        <button class="bg-red-600 text-white px-4 py-2 rounded-lg" data-modal-hide="popup-modal">Tutup</button>
    </div>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
