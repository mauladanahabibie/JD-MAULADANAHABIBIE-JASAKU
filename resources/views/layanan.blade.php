<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JasaKu - Semua Layanan</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('assets/logo.png') }}" type="image/x-icon">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body class="font-poppins text-gray-800 bg-gray-50 min-h-screen">
    <livewire:navbar />
    <section class="pt-32 bg-gradient-to-br from-indigo-50 to-white">
        <div class="mx-auto px-4 sm:px-6 lg:px-36">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">Temukan Jasa yang Anda Butuhkan</h1>
                <p class="text-xl text-gray-600">Ribu layanan profesional siap membantu Anda, dari desain kreatif
                    hingga layanan rumah tangga</p>
            </div>
        </div>
    </section>

    <section class="py-12">
        <div class="mx-auto px-4 sm:px-6 lg:px-36">
            <livewire:layanan-card />
        </div>
    </section>
    @auth
        <livewire:chat />
    @endauth
    <livewire:footer />
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

    <!-- Floating Chat Button -->
    <div class="fixed bottom-6 right-6 flex flex-row-reverse gap-3 items-center">
        <button id="floatingChatBtn"
            class=" bg-tertiary text-white p-4 rounded-full shadow-lg hover:bg-tertiary/80 transition z-40 cursor-pointer">
            <i class="fas fa-robot text-xl"></i>
        </button>
        <livewire:floating-chat-button />
    </div>
</body>

</html>
