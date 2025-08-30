<div wire:click="$dispatch('showServiceDetail', { serviceId: {{ $service->id }} })"
    class="bg-white rounded-lg shadow-md overflow-hidden service-card">
    <img src="{{ Storage::url($service->cover) }}" alt="{{ $service->name }}"
        class="w-full l h-72  aspect-square object-center object-cover">
    <div class="p-6">
        <div class="flex flex-wrap justify-between items-center mb-2">
            <span
                class="bg-indigo-100 text-indigo-800 text-xs font-semibold px-3 py-1 rounded-full">{{ $service->service_category->name }}</span>
            <span class="text-yellow-500"><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                    class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i></span>
        </div>
        <div class="flex flex-wrap justify-between items-center">
            <h3 class="text-xl font-bold mb-2 min-w-0 truncate">{{ $service->name }}</h3>
            <span class="text-2xl font-bold text-[#0059FF] whitespace-nowrap">{{ number_format($service->price, 0, ',', '.') }}</span>
        </div>
        <p class="text-gray-600">{!! Str::limit($service->description, 150) !!}</p>
    </div>
</div>
