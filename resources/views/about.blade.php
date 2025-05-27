<x-app-layout>
    <div class="bg-white">
        <div class="relative h-[500px] overflow-hidden">
            <div class="absolute w-full h-full bg-cover bg-center bg-fixed" 
                 style="background-image: url('/images/hunting-landscape.jpg');">
            </div>
            <div class="absolute inset-0 bg-black bg-opacity-50"></div>
            <div class="relative h-full flex items-center justify-center text-center">
                <div class="max-w-4xl px-6">
                    <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">О компании HuntGear</h1>
                    <p class="text-xl text-gray-200">Ваш надежный партнер в мире охоты с 2010 года</p>
                </div>
            </div>
        </div>
        <div class="py-16 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                    <div class="space-y-6" data-aos="fade-right">
                        <h2 class="text-3xl font-bold text-gray-900">Наша История</h2>
                        <p class="text-lg text-gray-600">Компания HuntGear начала свой путь как небольшой магазин охотничьего снаряжения. За годы работы мы выросли в крупную сеть магазинов, обслуживающую охотников по всей России.</p>
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center">
                                <span class="text-3xl font-bold text-[#8B4513]">13</span>
                                <span class="ml-2 text-gray-600">лет опыта</span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-3xl font-bold text-[#8B4513]">50+</span>
                                <span class="ml-2 text-gray-600">магазинов</span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-3xl font-bold text-[#8B4513]">100k+</span>
                                <span class="ml-2 text-gray-600">клиентов</span>
                            </div>
                        </div>
                    </div>
                    <div class="relative" data-aos="fade-left">
                        <img src="/images/store-front.jpeg" alt="Магазин HuntGear" class="rounded-lg shadow-xl">
                        <div class="absolute -bottom-6 -right-6 bg-[#8B4513] rounded-lg p-4 text-white">
                            <p class="font-semibold">Первый магазин</p>
                            <p class="text-sm">Открыт в 2010 году</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 py-16 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Наши преимущества</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1">
                        <div class="text-[#8B4513] mb-4">
                            <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Качество продукции</h3>
                        <p class="text-gray-600">Мы работаем только с проверенными производителями и гарантируем качество каждого товара.</p>
                    </div>
                    <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1">
                        <div class="text-[#8B4513] mb-4">
                            <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Лучшие цены</h3>
                        <p class="text-gray-600">Прямые поставки от производителей позволяют нам держать конкурентные цены.</p>
                    </div>
                    <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1">
                        <div class="text-[#8B4513] mb-4">
                            <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-2 0c0 .993-.241 1.929-.668 2.754l-1.524-1.525a3.997 3.997 0 00.078-2.183l1.562-1.562C15.802 8.249 16 9.1 16 10zm-5.165 3.913l1.58 1.58A5.98 5.98 0 0110 16a5.976 5.976 0 01-2.516-.552l1.562-1.562a4.006 4.006 0 001.789.027zm-4.677-2.796a4.002 4.002 0 01-.041-2.08l-.08.08-1.53-1.533A5.98 5.98 0 004 10c0 .954.223 1.856.619 2.657l1.54-1.54zm1.088-6.45A5.974 5.974 0 0110 4c.954 0 1.856.223 2.657.619l-1.54 1.54a4.002 4.002 0 00-2.346.033L7.246 4.668zM12 10a2 2 0 11-4 0 2 2 0 014 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Экспертная поддержка</h3>
                        <p class="text-gray-600">Наши консультанты - опытные охотники, готовые поделиться своими знаниями.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true,
        });
    </script>
    @endpush

    <!-- Стили -->
    @push('styles')
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    @endpush
</x-app-layout>