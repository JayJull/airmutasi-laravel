<div class="grid grid-cols-12 items-center gap-2 mt-1 kelas-item" id="kelas_{{ $index }}">
    <button type="button">❌️</button>
    <select class="col-span-11 text-center px-2 py-1 mt-1 bg-white border-2 border-slate-400 rounded-md" name="kelas[{{ $index }}]" id="kelas_{{ $index }}_select">
        <option value>--- Pilih kelas ---</option>
        @foreach ($kelases as $kelas)
            <option value="{{ $kelas->id }}" {{ isset($db_id) && $db_id == $kelas->id ? 'selected' : '' }}>
                {{ $kelas->nama_kelas }}
            </option>
        @endforeach
    </select>
</div>
