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
                    <h1 class="text-4xl md:text-6xl max-w-[50rem] font-bold mb-6 text-secondary md:text-start text-center">Temukan Jasa Profesional
                        yang Anda
                        Butuhkan</h1>
                    <p class=" text-lg md:text-xl md:w-[70%] mb-8 text-fontB md:text-start text-center">Platform terpercaya dan terbaik di
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




</body>

</html>
