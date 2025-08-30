<div>
    @if ($showModal && $service)
        <div class="fixed inset-0 bg-black/80 flex items-center justify-center z-50 p-4" x-data
            x-on:keydown.escape.window="$wire.closeModal()">

            <div class="bg-white rounded-lg max-w-6xl w-full max-h-screen overflow-y-auto"
                @click.outside="$wire.closeModal()">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <h2 class="text-2xl font-bold text-gray-800">{{ $service->name }}</h2>
                        <button wire:click="closeModal"
                            class="text-gray-500 hover:text-gray-700 text-2xl cursor-pointer">&times;</button>
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div>
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                @foreach ($service->images as $image)
                                    <img src="{{ Storage::url($image->path) }}" alt="{{ $service->name }}"
                                        class="w-full h-80 object-cover rounded-lg mb-4">
                                @endforeach
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h3 class="font-bold text-lg mb-2">Deskripsi Layanan</h3>
                                <p class="text-gray-700 mb-4">{!! str($service->description)->sanitizeHtml() !!}</p>
                            </div>
                        </div>
                        <div>
                            <div class="bg-white border border-gray-200 p-6 rounded-lg mb-6">
                                <h3 class="font-bold text-lg mb-4">Informasi Penjual</h3>
                                <div class="flex items-center mb-4">
                                    <img src="{{ $service->user->avatar ? Storage::url($service->user->avatar) : 'https://i.pinimg.com/736x/ae/b6/77/aeb6771c02eb6e5398cac13395dd1894.jpg' }}"
                                        alt="Avatar Penjual" class="w-12 h-12 object-cover object-center rounded-full mr-4">
                                    <div>
                                        <h4 class="font-semibold" id="modalSellerName">{{ $service->user->name }}</h4>
                                        <p class="text-sm text-gray-600">{{ $service->user->about }}</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div class="text-center p-3 bg-gray-50 rounded">
                                        <div class="text-2xl font-bold text-secondary" id="modalSellerOrders">154</div>
                                        <div class="text-xs text-gray-600">Pesanan Selesai</div>
                                    </div>
                                    <div class="text-center p-3 bg-gray-50 rounded">
                                        <div class="text-2xl font-bold text-secondary">98%</div>
                                        <div class="text-xs text-gray-600">Tingkat Respons</div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <h4 class="font-semibold mb-2">Lokasi Penjual</h4>
                                    <div class="location-map mb-2 rounded-lg overflow-hidden border">
                                        @if (isset($service->user->location['lat']) && isset($service->user->location['lng']))
                                            @php
                                                $lat = $service->user->location['lat'];
                                                $lng = $service->user->location['lng'];
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
                                    <p class="text-sm text-gray-600">{{ $service->user->address }}</p>

                                    @if (isset($service->user->location['lat']) && isset($service->user->location['lng']))
                                        <a href="https://www.openstreetmap.org/?mlat={{ $service->user->location['lat'] }}&mlon={{ $service->user->location['lng'] }}#map=16/{{ $service->user->location['lat'] }}/{{ $service->user->location['lng'] }}"
                                            target="_blank" rel="noopener noreferrer"
                                            class="text-sm text-blue-600 hover:underline mt-1 inline-block">
                                            Buka di tab baru →
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <div class="bg-white border border-gray-200 p-6 rounded-lg mb-6">
                                <h3 class="font-bold text-lg mb-4">Ulasan Pelanggan</h3>
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
                                        <p class="text-gray-700 text-sm">Desainnya sangat keren dan sesuai dengan yang
                                            saya inginkan. Prosesnya cepat dan komunikasi sangat baik.</p>
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
                                        <p class="text-gray-700 text-sm">Hasilnya bagus, tapi ada sedikit revisi yang
                                            dibutuhkan. Overall puas dengan hasil akhirnya.</p>
                                        <div class="flex items-center mt-2">
                                            <img src="https://placehold.co/30x30/764ba2/ffffff?text=U" alt="User"
                                                class="w-6 h-6 rounded-full mr-2">
                                            <span class="text-xs text-gray-600">Siti Rahayu</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-indigo-50 p-6 rounded-lg">
                                <div class="flex justify-between items-center mb-4">
                                    <span
                                        class="text-3xl font-bold text-secondary">{{ number_format($service->price, 0, ',', '.') }}</span>
                                    <span
                                        class="bg-green-100 text-green-800 text-sm font-semibold px-3 py-1 rounded-full">{{ $service->status }}</span>
                                </div>
                                <div class="mb-4">
                                    <h3 class="font-bold mb-2">Peringkat & Ulasan</h3>
                                    <div class="flex items-center mb-2">
                                        <span class="text-yellow-500 mr-2">
                                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="fas fa-star-half-alt"></i>
                                        </span>
                                        <span class="text-gray-700">4.5 (24 ulasan)</span>
                                    </div>
                                </div>
                                {{-- <button wire:click="closeModal"
                                    onclick="Livewire.dispatch('start-chat', { userId: {{ $service->user_id }} })"
                                    class="w-full bg-tertiary text-white py-3 rounded-lg font-semibold hover:bg-tertiary/80 transition mb-4">
                                    <i class="fas fa-comment"></i> Chat dengan Penjual
                                </button> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
