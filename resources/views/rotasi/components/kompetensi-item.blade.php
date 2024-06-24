<div class="grid grid-cols-12 items-center gap-2 mt-1 kompetensi-item" id="{{ $id }}">
    <button type="button">❌️</button>
    @if (isset($db_id))
        <input type="hidden" name="kompetensi[{{ $index }}][id]" value="{{ $db_id }}"
            id="{{ $id }}_id" />
    @endif
    @if (isset($file_url))
        <input type="hidden" name="kompetensi[{{ $index }}][file_url]" value="{{ $file_url }}"
            id="{{ $id }}_file_url" />
    @endif
    <input class="col-span-8 px-2 py-1 border-2 border-slate-400 rounded-md" type="text"
        name="kompetensi[{{ $index }}][nama]" id="{{ $id }}_nama" placeholder="Nama kompetensi ..."
        value="{{ isset($nama) ? $nama : '' }}">
    <button id="{{ $id }}_file_button"
        class="col-span-3 bg-blue-300 border-2 border-blue-300 px-2 py-1 rounded-md font-medium text-white" type="button"
        popovertarget="{{ $id }}_popover">{{ isset($file_url) ? 'Ubah' : 'Berkas' }}</button>
    @include('rotasi.components.file-popover', [
        'id' => $id,
        'url' => "kompetensi[{$index}][url]",
        'file' => "kompetensi[{$index}][file]",
        'file_url' => isset($file_url) ? $file_url : null,
    ])
</div>
