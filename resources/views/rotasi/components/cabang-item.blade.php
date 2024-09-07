<button value="{{ !$cabang ? '${cabang.id}' : $cabang['id'] }}"
    class="cabang-item w-full 
    {{ (int) $index % 2 == 0 ? 'bg-slate-300' : 'bg-white' }} 
     flex items-center justify-start gap-2 font-medium p-2 border-b-2">
    <img class="h-10" src="/images/icons/Place Marker.svg" alt="marker" />
    <span class="text-start font-semibold">{{ !$cabang ? '${cabang.nama}' : $cabang['nama'] }}</span>
</button>
