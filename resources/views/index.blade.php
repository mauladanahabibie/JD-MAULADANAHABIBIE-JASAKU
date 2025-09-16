<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JasaKu - Marketplace Jasa</title>
    @vite('resources/css/app.css')
    <link rel="shortcut icon" href="{{ asset('assets/logo.png') }}" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>

<body class="font-poppins text-gray-800">
    <!-- Navigation -->
    <livewire:navbar />

<!-- Hero Section -->
<section id="home" class="md:pt-40 md:pb-32 pt-28 text-black">
    <div class="mx-auto px-4 sm:px-6 lg:px-36 relative">
        <div class="flex flex-col-reverse md:flex-row items-center justify-between gap-10">
            
            <!-- Left Content -->
            <div class="md:w-1/2 text-center md:text-left">
                <h1
                    class="text-4xl md:text-6xl font-bold font-space mb-6 text-fontB leading-tight">
                    Temukan Jasa <br class="hidden md:block">Profesional
                    yang <br class="hidden md:block"> Anda Butuhkan
                </h1>
                <p class="text-lg md:text-xl text-[#919191] mb-8 md:w-4/5 mx-auto md:mx-0 text-justify md:text-left">
                    Platform terpercaya dan terbaik di Indonesia. Dari desain grafis, pembuatan website, pemasaran digital, hingga jasa rumah tangga semua tersedia di satu tempat. Percayakan kebutuhan Anda pada ahli terbaik, hanya di Jasaku!
                </p>
                <div class="flex flex-col sm:flex-row items-center sm:justify-start justify-center gap-4 font-poppins">
                    <a href="#services"
                        class="bg-tertiary text-fontW px-8 py-3 rounded-lg font-semibold hover:bg-tertiary/80 transition duration-300">
                        Jelajahi Layanan
                    </a>
                    <a href="{{ url('/mitra') }}"
                        class="border-2 border-tertiary text-fontB px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
                        Jadi Penyedia Jasa
                    </a>
                </div>
            </div>

            <!-- Right Image -->
            <div class="md:w-1/2 flex justify-center">
                <img src="{{ asset('assets/orang3.svg') }}" alt="Jasa Profesional"
                    class="w-full max-w-lg object-contain">
            </div>
        </div>
    </div>
</section>


    <!-- Services Section -->
    <section id="services" class="py-16 bg-gray-50" style="background-image: ">
        <div class=" mx-auto px-4 sm:px-6 lg:px-36">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Layanan Populer</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Temukan berbagai layanan profesional yang siap membantu
                    menyelesaikan kebutuhan Anda dengan kualitas terbaik.</p>
            </div>
            <livewire:service-list />
        </div>
    </section>
    <livewire:service-detail-modal />

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
                    <img src="{{ asset('assets/about.png') }}" alt="Tentang Kami" class="rounded-lg w-[45rem] ">
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
                            <div class="text-3xl font-bold text-[#0059FF] mb-2">5000+</div>
                            <div class="text-gray-600">Penyedia Jasa</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-[#0059FF] mb-2">100K+</div>
                            <div class="text-gray-600">Pelanggan Puas</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-[#0059FF] mb-2">20+</div>
                            <div class="text-gray-600">Kategori Jasa</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-[#0059FF] mb-2">98%</div>
                            <div class="text-gray-600">Tingkat Kepuasan</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Section -->
    <section id="contact" class="py-16 bg-gray-50">
        <div class=" mx-auto px-4 sm:px-6 lg:px-36">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Hubungi Kami</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Ada pertanyaan atau butuh bantuan? Tim kami siap
                    membantu
                    Anda 24/7.</p>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <div>
                    <h3 class="text-xl font-bold text-gray-800 mb-6">Lokasi Kami</h3>
                    <div class="location-map mb-6" id="companyMap">
                       <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1974.4148271581603!2d114.36866252945251!3d-8.21987982839678!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd145b383ae9f8d%3A0xfe27ef9d34b7bf07!2sRicheese%20Factory%20Banyuwangi!5e0!3m2!1sid!2sid!4v1756535625095!5m2!1sid!2sid" width="100%" height="100%" style="border:0; border-radius: 15px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="bg-[#0059FF] p-2 rounded-lg mr-4">
                                <i class="fas fa-map-marker-alt text-fontW"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold">Alamat</h4>
                                <p class="text-gray-600">Jl. Sukowangi No. 123, Banyuwangi</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-[#0059FF] p-2 rounded-lg mr-4">
                                <i class="fas fa-phone text-fontW"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold">Telepon</h4>
                                <p class="text-gray-600">+62 21 1234 5678</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-[#0059FF] p-2 rounded-lg mr-4">
                                <i class="fas fa-envelope text-fontW"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold">Email</h4>
                                <p class="text-gray-600">info@jasaku.com</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-[#0059FF] p-2 rounded-lg mr-4">
                                <i class="fas fa-clock text-fontW"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold">Jam Operasional</h4>
                                <p class="text-gray-600">Senin - Jumat: 08:00 - 17:00<br>Sabtu: 09:00 - 15:00</p>
                            </div>
                        </div>
                    </div>
                </div>
                <livewire:contact-form />
            </div>
        </div>
    </section>
    <!-- AI Chatbot Modal -->
    <div id="aiChatbotModal"
        class="fixed bottom-0 md:right-1 shadow-lg hidden flex rounded-lg items-center justify-end z-50 md:shadow-2xl">
        <div class="bg-white rounded-lg max-w-4xl w-full max-h-screen overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-2xl font-bold text-gray-800">AI Assistant JasaKu</h2>
                    <button id="closeAiChatbotModal"
                        class="text-gray-500 hover:text-gray-700 text-2xl cursor-pointer">&times;</button>
                </div>
                <div class="chat-container bg-gray-100 rounded-lg p-4 mb-4 h-60 overflow-y-auto" id="aiChatMessages">
                    <div class="mb-4">
                        <div class="bg-tertiary text-white rounded-lg p-3 max-w-xs">
                            <p class="text-sm">Halo! Saya adalah asisten AI JasaKu. Bagaimana saya bisa membantu
                                Anda
                                hari ini?</p>
                            <span class="text-xs opacity-80 mt-1 block text-right">
                                <script>
                                    document.write(new Date().toLocaleTimeString('id-ID', {
                                        hour: '2-digit',
                                        minute: '2-digit'
                                    }));
                                </script>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="typing-indicator mb-2" id="aiTyping" style="display: none;">AI sedang mengetik...
                </div>
                <div class="flex">
                    <input type="text" id="aiChatInput" placeholder="Ketik pertanyaan Anda..."
                        class="flex-1 border border-gray-300 rounded-l-lg p-3 focus:outline-none focus:ring-2 focus:ring-tertiary">
                    <button id="helpAiChat"
                        class="bg-tertiary text-white px-4 py-3 border-r-2 hover:bg-tertiary/80 transition cursor-pointer"
                        title="Tampilkan bantuan cepat">
                        ℹ️
                    </button>
                    <button id="sendAiChat"
                        class="bg-tertiary text-white px-6 py-3 rounded-r-lg hover:bg-tertiary/80 transition cursor-pointer">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
                <div class="mt-4 text-xs text-gray-500">
                    <p><i class="fas fa-info-circle mr-1"></i> AI Assistant ini memberikan informasi yang akurat
                        dan
                        membantu Anda menemukan penyedia jasa yang tepat.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <livewire:footer />
    @auth
        <livewire:chat />
    @endauth
    <!-- Floating Chat Button -->
    <div class="fixed bottom-6 right-6 flex flex-row-reverse gap-3 items-center">
        <button id="floatingChatBtn"
            class=" bg-tertiary text-white p-4 rounded-full shadow-lg hover:bg-tertiary/80 transition z-40 cursor-pointer">
            <i class="fas fa-robot text-xl"></i>
        </button>
        <livewire:floating-chat-button />
    </div>
    @vite('resources/js/app.js')
    @livewireScripts
</body>

</html>
