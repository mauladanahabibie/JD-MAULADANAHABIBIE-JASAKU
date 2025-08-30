<div>
    <div class="flex flex-col sm:flex-row justify-center items-center space-y-4 sm:space-y-0 sm:space-x-4 mb-12">
        <div class="relative w-full sm:w-64">
            <input type="text" placeholder="Cari layanan..."
                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-tertiary focus:border-transparent"
                wire:model.live.debounce.300ms="search">
            <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                <i class="fas fa-search"></i>
            </span>
        </div>
        <select
            class="w-full sm:w-48 px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-tertiary focus:border-transparent"
            wire:model.live="category">
            <option value="">Semua Kategori</option>
            @foreach ($categories as $category)
                <option value="{{ $category->name }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-2xl font-bold text-gray-800">Semua Layanan</h2>
        <div class="text-sm text-gray-500">
            <span>{{ $services->count() }}</span> layanan ditemukan
        </div>
    </div>

    <div wire:loading class="loading">
        <div class="loading-spinner"></div>
        <p>Memuat layanan...</p>
    </div>

    <div wire:loading.remove class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach ($services as $service)
            <div class="service-card">
                <div class="service-image cursor-pointer" wire:click="openModal({{ $service->id }})">
                    <img src="{{ Storage::url($service->cover) }}" alt="{{ $service->name }}"
                        class="w-full h-48 object-cover rounded-t-lg">
                </div>
                <div class="service-content">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="font-bold text-lg text-gray-800">{{ $service->name }}</h3>
                        <span
                            class="bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded-full">{{ $service->service_category->name }}</span>
                    </div>
                    <div class="flex items-center mb-2">
                        <div class="flex text-yellow-400 mr-1">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <span class="text-sm text-gray-600">(80)</span>
                    </div>
                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">{!! Str::of($service->description)->sanitizeHtml() !!}</p>
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-[#0059FF] text-xl font-bold">Rp
                            {{ number_format($service->price, 0, ',', '.') }}</span>
                        <span class="text-sm text-gray-500">{{ $service->created_at->diffForHumans() }}</span>
                    </div>

                </div>
            </div>
        @endforeach
    </div>

    <div class="text-center mt-8">
        <button wire:click="loadMore"
            class="bg-tertiary text-white px-8 py-3 rounded-lg font-semibold hover:bg-tertiary/60 transition transform hover:scale-105">
            Muat Lebih Banyak
        </button>
    </div>

    @if ($showModal && $selectedService)
        <div class="modal" style="display: block;">
            <div class="modal-content">
                <span class="close-modal" wire:click="closeModal">&times;</span>
                <div class="modal-body">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="overflow-y-auto" style="max-height: 70vh;">
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                @foreach ($selectedService->images as $image)
                                    <img src="{{ Storage::url($image->path) }}" alt="{{ $selectedService->name }}"
                                        class="w-full h-80 object-fill rounded-lg mb-4">
                                @endforeach
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg border-0">
                                <div class="flex justify-between items-center mb-4">
                                    <h2 class="font-bold text-xl">{{ $selectedService->name }}</h2>
                                    <span class="text-xl font-bold text-[#0059FF]">Rp.
                                        {{ number_format($selectedService->price, 0, ',', '.') }}</span>
                                </div>
                                <h3 class="font-bold text-lg mb-2">Deskripsi Layanan</h3>
                                <p class="text-gray-700 mb-4">{!! str($selectedService->description)->sanitizeHtml() !!}</p>
                            </div>
                        </div>
                        <div>
                            <div class="bg-white border border-gray-200 p-6 rounded-lg mb-6">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="font-bold text-lg">Informasi Penjual</h3>
                                    <span
                                        class="bg-green-100 text-green-800 text-sm font-semibold px-3 py-1 rounded-full">{{ $selectedService->status }}</span>
                                </div>
                                <div class="flex items-center mb-4">
                                    <img src="{{ $selectedService->user->avatar ? Storage::url($selectedService->user->avatar) : 'https://i.pinimg.com/736x/ae/b6/77/aeb6771c02eb6e5398cac13395dd1894.jpg' }}"
                                        alt="Avatar Penjual"
                                        class="w-12 h-12 object-cover object-center rounded-full mr-4">
                                    <div>
                                        <h4 class="font-semibold" id="modalSellerName">
                                            {{ $selectedService->user->name }}</h4>
                                        <p class="text-sm text-gray-600">{{ $selectedService->user->about }}</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div class="text-center p-3 bg-gray-50 rounded">
                                        <div class="text-2xl font-bold text-[#0059FF]" id="modalSellerOrders">154</div>
                                        <div class="text-xs text-gray-600">Pesanan Selesai</div>
                                    </div>
                                    <div class="text-center p-3 bg-gray-50 rounded">
                                        <div class="text-2xl font-bold text-[#0059FF]">98%</div>
                                        <div class="text-xs text-gray-600">Tingkat Respons</div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <h4 class="font-semibold mb-2">Lokasi Penjual</h4>
                                    <div class="location-map mb-2 rounded-lg overflow-hidden border">
                                        @if (isset($selectedService->user->location['lat']) && isset($selectedService->user->location['lng']))
                                            @php
                                                $lat = $selectedService->user->location['lat'];
                                                $lng = $selectedService->user->location['lng'];
                                                $bbox_delta = 0.01;
                                                $bbox =
                                                    $lng -
                                                    $bbox_delta .
                                                    ',' .
                                                    ($lat - $bbox_delta) .
                                                    ',' .
                                                    ($lng + $bbox_delta) .
                                                    ',' .
                                                    ($lat + $bbox_delta);
                                            @endphp

                                            <iframe width="100%" height="100%" frameborder="0" scrolling="no"
                                                marginheight="0" marginwidth="0"
                                                src="https://www.openstreetmap.org/export/embed.html?bbox={{ $bbox }}&layer=mapnik&marker={{ $lat }},{{ $lng }}">
                                            </iframe>
                                        @else
                                            <div
                                                class="flex items-center justify-center w-full h-full bg-gray-200 text-gray-500">
                                                Lokasi tidak tersedia
                                            </div>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-600">{{ $selectedService->user->address }}</p>

                                    @if (isset($selectedService->user->location['lat']) && isset($selectedService->user->location['lng']))
                                        <a href="https://www.openstreetmap.org/?mlat={{ $selectedService->user->location['lat'] }}&mlon={{ $selectedService->user->location['lng'] }}#map=16/{{ $selectedService->user->location['lat'] }}/{{ $selectedService->user->location['lng'] }}"
                                            target="_blank" rel="noopener noreferrer"
                                            class="text-sm text-blue-600 hover:underline mt-1 inline-block">
                                            Buka di tab baru →
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-200 p-6 rounded-lg mb-6 lg:col-span-2">
                        <div class="mb-4 flex gap-5 items-center">
                            <h3 class="font-bold text-lg">Ulasan Pelanggan</h3>
                            <div class="flex items-center ">
                                <span class="text-yellow-500 mr-2">
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                        class="fas fa-star"></i><i class="fas fa-star"></i><i
                                        class="fas fa-star-half-alt"></i>
                                </span>
                                <span class="text-gray-700">4.5 (24 ulasan)</span>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="border-b border-gray-200 pb-4">
                                <div class="flex items-center mb-2">
                                    <span class="text-yellow-500 mr-2">
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i>
                                    </span>
                                    <span class="text-sm text-gray-600">5 hari yang lalu</span>
                                </div>
                                <p class="text-gray-700 text-sm">Desainnya sangat keren dan sesuai dengan
                                    yang saya inginkan. Prosesnya cepat dan komunikasi sangat baik.</p>
                                <div class="flex items-center mt-2">
                                    <img src="https://placehold.co/30x30/667eea/ffffff?text=U" alt="User"
                                        class="w-6 h-6 rounded-full mr-2">
                                    <span class="text-xs text-gray-600">Andi Pratama</span>
                                </div>
                            </div>
                            <div class="border-b border-gray-200 pb-4">
                                <div class="flex items-center mb-2">
                                    <span class="text-yellow-500 mr-2">
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star"></i><i class="fas fa-star"></i><i
                                            class="fas fa-star-half-alt"></i>
                                    </span>
                                    <span class="text-sm text-gray-600">2 minggu yang lalu</span>
                                </div>
                                <p class="text-gray-700 text-sm">Hasilnya bagus, tapi ada sedikit revisi
                                    yang dibutuhkan. Overall puas dengan hasil akhirnya.</p>
                                <div class="flex items-center mt-2">
                                    <img src="https://placehold.co/30x30/764ba2/ffffff?text=U" alt="User"
                                        class="w-6 h-6 rounded-full mr-2">
                                    <span class="text-xs text-gray-600">Siti Rahayu</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 my-6">
                        <div class="flex items-start">
                            <i class="fas fa-lightbulb text-[#0059FF] mr-3 mt-1"></i>
                            <div>
                                <h4 class="font-semibold mb-1">Tips Memilih Penyedia Jasa</h4>
                                <p class="text-sm">Periksa ulasan, portofolio, dan komunikasi dengan penyedia
                                    jasa sebelum memesan untuk memastikan kecocokan dengan kebutuhan Anda.</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                        @if (auth()->check() && auth()->id() !== $selectedService->mitra_id)
                            <button
                                wire:click="$dispatch('start-chat', { userId: {{ $selectedService->mitra_id }}, serviceId: {{ $selectedService->id }} }); @this.closeModal()"
                                class="flex-1 flex items-center justify-center bg-tertiary text-white px-4 py-2 rounded-lg font-semibold shadow hover:bg-tertiary/90 transition duration-150">
                                <i class="fas fa-comments mr-2"></i> Chat Penjual
                            </button>
                        @endif
                        <button
                            class="flex-1 flex items-center justify-center border-2 border-tertiary text-tertiary px-4 py-2 rounded-lg font-semibold shadow hover:bg-tertiary hover:text-white transition duration-150">
                            <i class="fas fa-heart mr-2"></i> Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
