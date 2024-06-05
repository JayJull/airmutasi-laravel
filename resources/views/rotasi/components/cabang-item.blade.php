<button value="{{ !$cabang ? '${cabang.id}' : $cabang['id'] }}"
    class="cabang-item w-full bg-white flex items-center justify-start gap-2 font-semibold p-2 rounded-lg">
    <img class="h-10" src="/images/icons/Place Marker.svg" alt="marker" />
    <span class="text-start">{{ !$cabang ? '${cabang.nama}' : $cabang['nama'] }}</span>
</button>
