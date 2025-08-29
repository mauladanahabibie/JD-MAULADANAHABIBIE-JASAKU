<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JasaKu - Marketplace Jasa</title>
    @vite('resources/css/app.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .service-card:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease;
        }

        .chat-bubble:hover {
            transform: scale(1.05);
            transition: all 0.2s ease;
        }

        .location-map {
            height: 300px;
            width: 100%;
        }

        .map-container {
            position: relative;
            height: 400px;
            width: 100%;
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .map-placeholder {
            background: linear-gradient(45deg, #f0f1f6 25%, transparent 25%, transparent 50%, #f0f1f6 50%, #f0f1f6 75%, transparent 75%, transparent);
            background-size: 50px 50px;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #4a5568;
            font-weight: 500;
        }
    </style>
</head>

<body class="font-sans text-gray-800">
    <!-- Navigation -->
    <header class="fixed w-full top-0 z-50">
        <nav class="bg-white shadow-lg">
            <div class=" mx-auto px-4 sm:px-6 lg:px-36">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center">
                        <span class="text-3xl font-bold font-dancing">JasaKu</span>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-center space-x-4">
                            <a href="#home"
                                class="text-gray-800 hover:text-tertiary px-3 py-2 rounded-md text-base font-medium transition">Beranda</a>
                            <a href="#services"
                                class="text-gray-800 hover:text-tertiary px-3 py-2 rounded-md text-base font-medium transition">Layanan</a>
                            <a href="#about"
                                class="text-gray-800 hover:text-tertiary px-3 py-2 rounded-md text-base font-medium transition">Tentang</a>
                            <a href="#contact"
                                class="text-gray-800 hover:text-tertiary px-3 py-2 rounded-md text-base font-medium transition">Kontak</a>
                            <button
                                class="bg-tertiary text-white px-4 py-2 rounded-md text-base font-medium hover:bg-tertiary/80 transition">Masuk</button>
                        </div>
                    </div>
                    <div class="md:hidden">
                        <button class="text-gray-800 hover:text-tertiary focus:outline-none" id="mobile-menu-toggle">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                    </div>
                </div>
            </div>
        </nav>
        <div class="mobile-menu hidden">
            <div class="bg-white w-full p-4">
                <a href="#home"
                    class="block text-gray-800 hover:text-tertiary py-2 rounded-md text-base font-medium transition">Beranda</a>
                <a href="#services"
                    class="block text-gray-800 hover:text-tertiary py-2 rounded-md text-base font-medium transition">Layanan</a>
                <a href="#about"
                    class="block text-gray-800 hover:text-tertiary py-2 rounded-md text-base font-medium transition">Tentang</a>
                <a href="#contact"
                    class="block text-gray-800 hover:text-tertiary py-2 rounded-md text-base font-medium transition">Kontak</a>
                <button
                    class="bg-tertiary text-white px-4 py-2 rounded-md text-base font-medium hover:bg-tertiary/80 transition">Masuk</button>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="home" class="md:pt-56 pt-28  bg-primary text-white">
        <div class=" mx-auto px-4 sm:px-6 lg:px-36 relative">
            <img class="absolute bottom-0 left-0 w-full -mb-[1px] max-h-[700px]"
                src="{{ Storage::url('assets/wave2.png') }}" alt="">
            <div class="flex flex-col justify-between md:flex-row">
                <div class="md:w-1/2 my-auto md:pb-56 relative md:z-10">
                    <h1
                        class="text-4xl md:text-6xl max-w-[50rem] font-bold mb-6 text-secondary md:text-start text-center">
                        Temukan Jasa Profesional
                        yang Anda
                        Butuhkan</h1>
                    <p class=" text-lg md:text-xl md:w-[70%] mb-8 text-fontB md:text-start text-center">Platform
                        terpercaya dan terbaik di
                        Indonesia Dari desain
                        grafis, pembuatan website, pemasaran digital, hingga jasa rumah tangga semua tersedia di satu
                        tempat. Percayakan kebutuhan Anda pada ahli terbaik, hanya di Jasaku!</p>
                    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 z-10">
                        <button
                            class="bg-tertiary text-fontW px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-tertiary transition transform hover:scale-105">
                            Jelajahi Layanan
                        </button>
                        <button
                            class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-tertiary transition transform hover:scale-105">
                            Jadi Penyedia Jasa
                        </button>
                    </div>
                </div>
                <div class="relative md:absolute bottom-0 md:right-1/10">
                    <img src="{{ Storage::url('assets/header.png') }}" alt="Jasa Profesional"
                        class="w-full object-cover max-h-[700px]">
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-16 bg-gray-50">
        <div class=" mx-auto px-4 sm:px-6 lg:px-36">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Layanan Populer</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Temukan berbagai layanan profesional yang siap membantu
                    menyelesaikan kebutuhan Anda dengan kualitas terbaik.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @for ($i = 1; $i <= 2; $i++)
                    <!-- Service Card 1 -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden service-card">
                        <img src="https://i.pinimg.com/736x/4a/02/87/4a02873503c2d0cc956c05a653424b92.jpg"
                            alt="Desain Grafis" class="w-full h-72 object-cover">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-2">
                                <span
                                    class="bg-indigo-100 text-indigo-800 text-xs font-semibold px-3 py-1 rounded-full">Desain
                                    & Kreatif</span>
                                <span class="text-yellow-500"><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                        class="fas fa-star"></i><i class="fas fa-star"></i><i
                                        class="fas fa-star-half-alt"></i></span>
                            </div>
                            <h3 class="text-xl font-bold mb-2">Desain Logo Profesional</h3>
                            <p class="text-gray-600 mb-4">Buat identitas merek Anda dengan desain logo yang unik dan
                                profesional.</p>
                            <div class="flex justify-between items-center">
                                <span class="text-2xl font-bold text-secondary">Rp 500.000</span>
                                <button
                                    class="bg-tertiary text-white px-4 py-2 rounded-lg hover:bg-tertiary/80 transition chat-button"
                                    data-service="Desain Logo Profesional">
                                    <i class="fas fa-comment"></i> Chat Penjual
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Service Card 2 -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden service-card">
                        <img src="https://i.pinimg.com/736x/b8/1b/6e/b81b6e7851887353d67658fa2b05b5b8.jpg"
                            alt="Web Development" class="w-full h-72 object-cover">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-2">
                                <span
                                    class="bg-purple-100 text-purple-800 text-xs font-semibold px-3 py-1 rounded-full">Teknologi</span>
                                <span class="text-yellow-500"><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                        class="fas fa-star"></i><i class="fas fa-star"></i><i
                                        class="far fa-star"></i></span>
                            </div>
                            <h3 class="text-xl font-bold mb-2">Pembuatan Website</h3>
                            <p class="text-gray-600 mb-4">Website responsif dan modern untuk bisnis atau portofolio
                                Anda.</p>
                            <div class="flex justify-between items-center">
                                <span class="text-2xl font-bold text-secondary">Rp 1.500.000</span>
                                <button
                                    class="bg-tertiary text-white px-4 py-2 rounded-lg hover:bg-tertiary/80 transition chat-button"
                                    data-service="Pembuatan Website">
                                    <i class="fas fa-comment"></i> Chat Penjual
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Service Card 3 -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden service-card">
                        <img src="https://i.pinimg.com/736x/9a/c6/44/9ac644ce47dcf0b7fab2d196567c74ef.jpg"
                            alt="Photography" class="w-full h-72 object-cover">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-2">
                                <span
                                    class="bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full">Fotografi</span>
                                <span class="text-yellow-500"><i class="fas fa-star"></i><i
                                        class="fas fa-star"></i><i class="fas fa-star"></i><i
                                        class="fas fa-star"></i><i class="fas fa-star"></i></span>
                            </div>
                            <h3 class="text-xl font-bold mb-2">Foto Prewedding</h3>
                            <p class="text-gray-600 mb-4">Dokumentasi momen spesial Anda dengan hasil foto yang
                                artistik.</p>
                            <div class="flex justify-between items-center">
                                <span class="text-2xl font-bold text-secondary">Rp 2.000.000</span>
                                <button
                                    class="bg-tertiary text-white px-4 py-2 rounded-lg hover:bg-tertiary/80 transition chat-button"
                                    data-service="Foto Prewedding">
                                    <i class="fas fa-comment"></i> Chat Penjual
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md overflow-hidden service-card">
                        <img src="https://i.pinimg.com/736x/6d/d4/fb/6dd4fb1449cdfa2d98601890c6daa046.jpg"
                            alt="Kuli Bangunan" class="w-full h-72 object-cover">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-2">
                                <span
                                    class="bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full">Fotografi</span>
                                <span class="text-yellow-500"><i class="fas fa-star"></i><i
                                        class="fas fa-star"></i><i class="fas fa-star"></i><i
                                        class="fas fa-star"></i><i class="fas fa-star"></i></span>
                            </div>
                            <h3 class="text-xl font-bold mb-2">Kuli Borongan</h3>
                            <p class="text-gray-600 mb-4">Dokumentasi momen spesial Anda dengan hasil foto yang
                                artistik.</p>
                            <div class="flex justify-between items-center">
                                <span class="text-2xl font-bold text-secondary">Rp 2.000.000</span>
                                <button
                                    class="bg-tertiary text-white px-4 py-2 rounded-lg hover:bg-tertiary/80 transition chat-button"
                                    data-service="Foto Prewedding">
                                    <i class="fas fa-comment"></i> Chat Penjual
                                </button>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </section>
    <!-- Service Detail Modal -->
    <div id="serviceModal" class="fixed inset-0 bg-black/80 hidden flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg max-w-6xl w-full max-h-screen overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-2xl font-bold text-gray-800" id="modalServiceTitle">Detail Layanan</h2>
                    <button id="closeModal"
                        class="text-gray-500 hover:text-gray-700 text-2xl cursor-pointer">&times;</button>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <img src="https://i.pinimg.com/736x/0c/f8/e1/0cf8e1934c6125a1588ea4e4c15fdbdf.jpg"
                            alt="Detail Layanan" class="w-full rounded-lg mb-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-bold text-lg mb-2">Deskripsi Layanan</h3>
                            <p class="text-gray-700 mb-4" id="modalServiceDescription">
                                Kami menyediakan layanan desain logo profesional yang akan membantu membangun identitas
                                merek Anda. Setiap desain dibuat dari awal sesuai dengan kebutuhan dan visi bisnis Anda.
                            </p>
                            <h3 class="font-bold text-lg mb-2">Fitur Layanan</h3>
                            <ul class="list-disc list-inside text-gray-700 space-y-1 mb-4">
                                <li>3 Konsep desain awal</li>
                                <li>Revisi tanpa batas</li>
                                <li>File dalam format PNG, JPG, dan SVG</li>
                                <li>Dokumen panduan penggunaan logo</li>
                                <li>Support 7x24 jam</li>
                            </ul>
                        </div>
                    </div>
                    <div>
                        <div class="bg-indigo-50 p-6 rounded-lg mb-6">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-3xl font-bold text-secondary" id="modalServicePrice">Rp
                                    500.000</span>
                                <span
                                    class="bg-green-100 text-green-800 text-sm font-semibold px-3 py-1 rounded-full">Tersedia</span>
                            </div>
                            <div class="mb-4">
                                <h3 class="font-bold mb-2">Peringkat & Ulasan</h3>
                                <div class="flex items-center mb-2">
                                    <span class="text-yellow-500 mr-2">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </span>
                                    <span class="text-gray-700">4.5 (24 ulasan)</span>
                                </div>
                            </div>
                            <button
                                class="w-full bg-tertiary text-white py-3 rounded-lg font-semibold hover:bg-tertiary/80 transition chat-button-modal mb-4"
                                id="chatSellerBtn">
                                <i class="fas fa-comment"></i> Chat dengan Penjual
                            </button>
                        </div>

                        <!-- Seller Information -->
                        <div class="bg-white border border-gray-200 p-6 rounded-lg mb-6">
                            <h3 class="font-bold text-lg mb-4">Informasi Penjual</h3>
                            <div class="flex items-center mb-4">
                                <img src="https://placehold.co/60x60/667eea/ffffff?text=SP" alt="Penjual"
                                    class="w-12 h-12 rounded-full mr-4">
                                <div>
                                    <h4 class="font-semibold" id="modalSellerName">Budi Santoso</h4>
                                    <p class="text-sm text-gray-600">Desainer Grafis Profesional</p>
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
                                <div class="location-map mb-2" id="sellerMap">
                                    <img src="https://placehold.co/500x300/e2e8f0/4a5568?text=Map+Lokasi+Penjual"
                                        alt="Lokasi Penjual" class="w-full h-full object-cover rounded">
                                </div>
                                <p class="text-sm text-gray-600" id="modalSellerLocation">Jakarta Selatan, DKI Jakarta
                                </p>
                            </div>
                        </div>
                        <!-- Reviews -->
                        <div class="bg-white border border-gray-200 p-6 rounded-lg">
                            <h3 class="font-bold text-lg mb-4">Ulasan Pelanggan</h3>
                            <div class="space-y-4">
                                <div class="border-b border-gray-200 pb-4">
                                    <div class="flex items-center mb-2">
                                        <span class="text-yellow-500 mr-2">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </span>
                                        <span class="text-sm text-gray-600">5 hari yang lalu</span>
                                    </div>
                                    <p class="text-gray-700 text-sm">Desainnya sangat keren dan sesuai dengan yang saya
                                        inginkan. Prosesnya cepat dan komunikasi sangat baik.</p>
                                    <div class="flex items-center mt-2">
                                        <img src="https://placehold.co/30x30/667eea/ffffff?text=U" alt="User"
                                            class="w-6 h-6 rounded-full mr-2">
                                        <span class="text-xs text-gray-600">Andi Pratama</span>
                                    </div>
                                </div>
                                <div class="border-b border-gray-200 pb-4">
                                    <div class="flex items-center mb-2">
                                        <span class="text-yellow-500 mr-2">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Order Confirmation Modal -->
    <div id="orderModal" class="fixed inset-0 bg-black/80 hidden flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg max-w-2xl w-full">
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-2xl font-bold text-gray-800">Konfirmasi Pesanan</h2>
                    <button id="closeOrderModal" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
                </div>
                <div class="mb-6">
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                        <div class="flex items-start">
                            <div class="text-yellow-600 mr-3 mt-1">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-yellow-800 mb-1">Konfirmasi Pesanan</h4>
                                <p class="text-yellow-700 text-sm">Silakan konfirmasi pesanan Anda. Setelah
                                    dikonfirmasi, Anda dapat membagikan lokasi Anda dengan penjual untuk memudahkan
                                    pertemuan.</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <h3 class="font-bold mb-2" id="orderServiceTitle">Desain Logo Profesional</h3>
                        <div class="flex justify-between text-lg font-bold text-indigo-600 mb-2">
                            <span>Harga:</span>
                            <span id="orderServicePrice">Rp 500.000</span>
                        </div>
                        <div class="text-sm text-gray-600">
                            <p>Penjual: <span id="orderSellerName">Budi Santoso</span></p>
                            <p>Lokasi Penjual: <span id="orderSellerLocation">Jakarta Selatan, DKI Jakarta</span></p>
                        </div>
                    </div>
                </div>

                <div class="flex space-x-4">
                    <button id="confirmOrderBtn"
                        class="flex-1 bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-tertiary/80 transition">
                        <i class="fas fa-check mr-2"></i> Konfirmasi Pesanan
                    </button>
                    <button id="cancelOrderBtn"
                        class="flex-1 bg-gray-600 text-white py-3 rounded-lg font-semibold hover:bg-gray-700 transition">
                        <i class="fas fa-times mr-2"></i> Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- About Section -->
    <section id="about" class="py-16 bg-white">
        <div class=" mx-auto px-4 sm:px-6 lg:px-36">
            <div class="flex flex-col lg:flex-row items-center">
                <div class="lg:w-1/2 mb-10 lg:mb-0">
                    <img src="{{ Storage::url('assets/thinking.png') }}" alt="Tentang Kami"
                        class="rounded-lg w-[45rem] ">
                </div>
                <div class="lg:w-1/2 lg:pl-12">
                    <h2 class="text-3xl font-bold text-gray-800 mb-6">Tentang JasaKu</h2>
                    <p class="text-gray-600 mb-6">JasaKu adalah platform marketplace jasa terkemuka di Indonesia yang
                        menghubungkan penyedia jasa profesional dengan klien yang membutuhkan. Kami percaya bahwa setiap
                        orang memiliki keahlian yang berharga dan layak untuk dibagikan.</p>
                    <p class="text-gray-600 mb-6">Dengan ribuan penyedia jasa terverifikasi di berbagai kategori, kami
                        memastikan Anda menemukan yang terbaik untuk kebutuhan Anda. Dari desain kreatif hingga layanan
                        teknis, dari pendidikan hingga perawatan rumah, semua ada di JasaKu.</p>
                    <div class="grid grid-cols-2 gap-6 mt-8">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-secondary mb-2">5000+</div>
                            <div class="text-gray-600">Penyedia Jasa</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-secondary mb-2">100K+</div>
                            <div class="text-gray-600">Pelanggan Puas</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-secondary mb-2">20+</div>
                            <div class="text-gray-600">Kategori Jasa</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-secondary mb-2">98%</div>
                            <div class="text-gray-600">Tingkat Kepuasan</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get elements
            const menu = document.querySelector('.mobile-menu');
            const toggleButton = document.getElementById('mobile-menu-toggle');

            if (toggleButton && menu) {
                toggleButton.addEventListener('click', function(e) {
                    e.stopPropagation(); // Prevent this click from triggering the document click handler
                    menu.classList.toggle('hidden');
                });

                // Close menu when clicking outside
                document.addEventListener('click', function(e) {
                    if (!menu.contains(e.target) && e.target !== toggleButton) {
                        menu.classList.add('hidden');
                    }
                });

                // Prevent clicks inside menu from closing it
                menu.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            } else {
                console.error('Menu elements not found!');
            }
        });
        // Service data
        const services = {
            'Desain Logo Profesional': {
                title: 'Desain Logo Profesional',
                price: 'Rp 500.000',
                description: 'Kami menyediakan layanan desain logo profesional yang akan membantu membangun identitas merek Anda. Setiap desain dibuat dari awal sesuai dengan kebutuhan dan visi bisnis Anda.',
                seller: 'Budi Santoso',
                location: 'Jakarta Selatan, DKI Jakarta',
                orders: '154'
            },
            'Pembuatan Website': {
                title: 'Pembuatan Website',
                price: 'Rp 1.500.000',
                description: 'Layanan pembuatan website responsif dan modern untuk bisnis atau portofolio Anda. Kami menggunakan teknologi terkini untuk memastikan website Anda cepat, aman, dan SEO friendly.',
                seller: 'Ani Susanti',
                location: 'Bandung, Jawa Barat',
                orders: '89'
            },
            'Foto Prewedding': {
                title: 'Foto Prewedding',
                price: 'Rp 2.000.000',
                description: 'Dokumentasi momen spesial Anda dengan hasil foto yang artistik dan natural. Kami menyediakan paket lengkap termasuk makeup, kostum, dan lokasi shooting.',
                seller: 'Agus Wijaya',
                location: 'Yogyakarta, DIY',
                orders: '67'
            }
        };

        // Open service modal
        document.querySelectorAll('.chat-button, .chat-button-modal').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const serviceKey = this.getAttribute('data-service') || document.getElementById(
                    'modalServiceTitle').textContent;
                const service = services[serviceKey];

                if (service) {
                    document.getElementById('modalServiceTitle').textContent = service.title;
                    document.getElementById('modalServicePrice').textContent = service.price;
                    document.getElementById('modalServiceDescription').textContent = service.description;
                    document.getElementById('modalSellerName').textContent = service.seller;
                    document.getElementById('modalSellerLocation').textContent = service.location;
                    document.getElementById('modalSellerOrders').textContent = service.orders;

                    // Set the service for order
                    document.getElementById('orderServiceTitle').textContent = service.title;
                    document.getElementById('orderServicePrice').textContent = service.price;
                    document.getElementById('orderSellerName').textContent = service.seller;
                    document.getElementById('orderSellerLocation').textContent = service.location;
                }

                document.getElementById('chatModal').classList.remove('hidden');
                document.getElementById('serviceModal').classList.add('hidden');
            });
        });

        // Open service detail modal
        document.querySelectorAll('.service-card').forEach(card => {
            card.addEventListener('click', function(e) {
                if (!e.target.closest('.chat-button')) {
                    const serviceTitle = this.querySelector('h3').textContent;
                    const service = services[serviceTitle];

                    if (service) {
                        document.getElementById('modalServiceTitle').textContent = service.title;
                        document.getElementById('modalServicePrice').textContent = service.price;
                        document.getElementById('modalServiceDescription').textContent = service
                            .description;
                        document.getElementById('modalSellerName').textContent = service.seller;
                        document.getElementById('modalSellerOrders').textContent = service.orders;

                        // Update order modal
                        document.getElementById('orderServiceTitle').textContent = service.title;
                        document.getElementById('orderServicePrice').textContent = service.price;
                        document.getElementById('orderSellerName').textContent = service.seller;
                    }

                    document.getElementById('serviceModal').classList.remove('hidden');
                }
            });
        });

        // Close modals
        document.getElementById('closeModal').addEventListener('click', function() {
            document.getElementById('serviceModal').classList.add('hidden');
        });

        document.getElementById('closeOrderModal').addEventListener('click', function() {
            document.getElementById('orderModal').classList.add('hidden');
        });

        // Confirm order
        document.getElementById('confirmOrderBtn').addEventListener('click', function() {
            document.getElementById('orderModal').classList.add('hidden');
            document.getElementById('locationModal').classList.remove('hidden');
        });

        document.getElementById('cancelOrderBtn').addEventListener('click', function() {
            document.getElementById('orderModal').classList.add('hidden');
        });


        // Handle contact form
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Terima kasih atas pesan Anda. Tim kami akan segera menghubungi Anda.');
            this.reset();
        });

        // Smooth scrolling for navigation
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    window.scrollTo({
                        top: target.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Close modals when clicking outside
        document.getElementById('serviceModal').addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });


        document.getElementById('orderModal').addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });
    </script>
</body>

</html>
