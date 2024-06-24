<div class="flex items-center gap-2 mt-1 kompetensi-item" id="{{ $id }}">
    <button type="button" class="flex items-center">❌️</button>
    <input class="flex-grow px-2 py-1 border-2 border-slate-400 rounded-md" type="text"
        name="kompetensi[{{ $index }}][nama]" id="{{ $id }}_nama" placeholder="Nama kompetensi ..."
        value="{{ isset($nama) ? $nama : '' }}">
    <button id="{{ $id }}_file_button"
        class="bg-blue-300 border-2 border-blue-300 px-2 py-1 rounded-md font-medium text-white" type="button"
        popovertarget="{{ $id }}_popover">Berkas</button>
    @include('rotasi.components.file-popover', [
        'id' => $id,
        'url' => "kompetensi[{$index}][url]",
        'file' => "kompetensi[{$index}][file]",
    ])
</div>
