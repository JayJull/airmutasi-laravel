<div id="{{ $id }}_popover" class="border-2 rounded-lg p-4 w-5/6 ms:w-2/3 md:w-1/2 max-h-[90vh]" popover>
    <div class="flex flex-col gap-2">
        @if (isset($file_url))
            <a href="{{ $file_url }}" target="_blank"
                class="bg-[#383A83] text-center text-white p-2 rounded-lg font-semibold">Lihat Berkas</a>
        @endif
        <div class="flex w-full">
            <input type="text" name="{{ $url }}" id="{{ $id }}_url"
                class="resize-none flex-grow p-2 border-2 border-slate-400 rounded-s-md" placeholder="URL Berkas">
            <button id="{{ $id }}_url_set" type="button"
                class="bg-[#383A83] text-white p-2 rounded-e-lg font-semibold">Set</button>
        </div>
        <p class="text-center">atau</p>
        <label class="bg-blue-300 px-2 py-1 rounded-md font-medium text-white hover:cursor-pointer text-center">
            <span class="text-center">Upload Berkas (max 2MB)</span>
            <input type="file" name="{{ $file }}" id="{{ $id }}_file" class="h-0 w-0"
                accept=".pdf,.doc,.docx">
        </label>
    </div>
</div>
