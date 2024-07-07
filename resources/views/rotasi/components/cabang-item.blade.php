<button value="{{ !$cabang ? '${cabang.id}' : $cabang['id'] }}"
    class="cabang-item w-full bg-white flex items-center justify-start gap-2 font-medium p-2 rounded-lg border-2 border-[#656B8E]">
    <img class="h-10" src="/images/icons/Place Marker.svg" alt="marker" />
    <span class="text-start font-semibold">{{ !$cabang ? '${cabang.nama}' : $cabang['nama'] }}</span>
</button>
