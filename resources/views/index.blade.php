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
                            <a href="{{ url('/dashboard') }}"
                                class="bg-tertiary text-white px-4 py-2 rounded-md text-base font-medium hover:bg-tertiary/80 transition">Masuk</a>
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
                <a href="{{ url('/dashboard') }}"
                    class="bg-tertiary text-white px-4 py-2 rounded-md text-base font-medium hover:bg-tertiary/80 transition">Masuk</a>
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
                    <p class=" text-lg md:text-xl md:w-[70%] mb-8 text-fontB md:text-start text-justify">Platform
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
    <!-- Contact Section -->
    <section id="contact" class="py-16 bg-gray-50">
        <div class=" mx-auto px-4 sm:px-6 lg:px-36">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Hubungi Kami</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Ada pertanyaan atau butuh bantuan? Tim kami siap membantu
                    Anda 24/7.</p>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <div>
                    <h3 class="text-xl font-bold text-gray-800 mb-6">Lokasi Kami</h3>
                    <div class="location-map mb-6" id="companyMap">
                        <img src="{{ Storage::url('assets/kantor.jpeg') }}" alt="Lokasi Kantor"
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="bg-indigo-100 p-2 rounded-lg mr-4">
                                <i class="fas fa-map-marker-alt text-secondary"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold">Alamat</h4>
                                <p class="text-gray-600">Jl RS Fatmawati D-3/115, Dki Jakarta</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-indigo-100 p-2 rounded-lg mr-4">
                                <i class="fas fa-phone text-secondary"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold">Telepon</h4>
                                <p class="text-gray-600">+62 21 1234 5678</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-indigo-100 p-2 rounded-lg mr-4">
                                <i class="fas fa-envelope text-secondary"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold">Email</h4>
                                <p class="text-gray-600">info@jasaku.com</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-indigo-100 p-2 rounded-lg mr-4">
                                <i class="fas fa-clock text-secondary"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold">Jam Operasional</h4>
                                <p class="text-gray-600">Senin - Jumat: 08:00 - 17:00<br>Sabtu: 09:00 - 15:00</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800 mb-6">Kirim Pesan</h3>
                    <form id="contactForm" class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama
                                Lengkap</label>
                            <input type="text" id="name" name="name" required
                                class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-tertiary">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" id="email" name="email" required
                                class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-tertiary">
                        </div>
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subjek</label>
                            <input type="text" id="subject" name="subject" required
                                class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-tertiary">
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Pesan</label>
                            <textarea id="message" name="message" rows="5" required
                                class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-tertiary"></textarea>
                        </div>
                        <button type="submit"
                            class="w-full bg-tertiary text-white py-3 rounded-lg font-semibold hover:bg-tertiary/80 transition">
                            Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class=" mx-auto px-4 sm:px-6 lg:px-36">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">JasaKu</h3>
                    <p class="text-gray-300 mb-4">Platform marketplace jasa terkemuka di Indonesia, menghubungkan
                        penyedia jasa profesional dengan klien yang membutuhkan.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-300 hover:text-white transition"><i
                                class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-gray-300 hover:text-white transition"><i
                                class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-300 hover:text-white transition"><i
                                class="fab fa-instagram"></i></a>
                        <a href="#" class="text-gray-300 hover:text-white transition"><i
                                class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Layanan</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white transition">Desain & Kreatif</a>
                        </li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition">Teknologi</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition">Pemasaran Digital</a>
                        </li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition">Rumah Tangga</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition">Pendidikan</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Perusahaan</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white transition">Tentang Kami</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition">Karir</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition">Blog</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition">Pers</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition">Kontak</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Dukungan</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white transition">Pusat Bantuan</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition">Kebijakan Privasi</a>
                        </li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition">Syarat & Ketentuan</a>
                        </li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition">FAQ</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition">Laporan Masalah</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p class="text-gray-300">&copy; 2025 JasaKu. All rights reserved.</p>
            </div>
        </div>
    </footer>
    @auth
        <livewire:chat />
    @endauth
    <!-- Floating Chat Button -->
    <div class="fixed bottom-6 right-6 flex flex-row-reverse gap-3 items-center">
        <livewire:floating-chat-button />
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menu = document.querySelector('.mobile-menu');
            const toggleButton = document.getElementById('mobile-menu-toggle');

            if (toggleButton && menu) {
                toggleButton.addEventListener('click', function(e) {
                    e.stopPropagation();
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

        document.getElementById('serviceModal').addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });

        document.getElementById('chatModal').addEventListener('click', function(e) {
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
