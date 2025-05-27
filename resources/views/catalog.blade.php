<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-900 dark:text-gray-800 leading-tight text-center">
            {{ __('Каталог товаров') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl p-8">
                <!-- Поисковая строка и фильтры -->
                <div class="search-filter-container mb-8">
                    <!-- Форма поиска -->
                    <div class="max-w-6xl mx-auto mt-10 px-4 sm:px-6 lg:px-8">
                        <form method="GET" action="{{ route('products.search') }}" class="flex items-center space-x-4">
                            <input type="text" name="query" placeholder="Введите название товара..."
                                class="w-full border rounded-lg px-4 py-3 shadow-md focus:ring focus:ring-blue-300 transition"
                                value="{{ request('query') }}">
                            <button type="submit"
                                class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow-md hover:bg-blue-700 transition">Поиск</button>
                        </form>
                    </div>
                    <!-- Форма фильтрации -->
                    <form method="GET" action="{{ route('catalog') }}" class="flex gap-4 items-center">
                        <label for="category" class="mr-2 text-white">Категория:</label>
                        <select name="category" id="category" class="border rounded-lg px-4 py-3 shadow-md focus:ring focus:ring-blue-300 transition">
                            <option value="all">Все категории</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>

                        <label for="price" class="mr-2 text-white">Цена:</label>
                        <select name="price" id="price" class="border rounded-lg px-4 py-3 shadow-md focus:ring focus:ring-blue-300 transition">
                            <option value="">Сортировка по цене</option>
                            <option value="asc" {{ request('price') == 'asc' ? 'selected' : '' }}>Цена: по возрастанию</option>
                            <option value="desc" {{ request('price') == 'desc' ? 'selected' : '' }}>Цена: по убыванию</option>
                        </select>

                        <button type="submit" class="bg-blue-500 text-white px-4 py-3 rounded-lg shadow-md hover:bg-blue-600 transition">
                            Применить
                        </button>
                    </form>
                </div>

                <!-- Сетка товаров -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($products as $product)
                        <div class="product-card bg-white dark:bg-gray-700 border rounded-xl shadow-lg p-6 hover:shadow-2xl transition relative">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-56 object-cover rounded-lg mb-4">
                            <h3 class="text-xl font-semibold text-black dark:text-white truncate">{{ $product->name }}</h3>
                            <p class="text-md text-gray-800 dark:text-gray-300 mt-2 break-words">{{ $product->description }}</p>

                            <div class="flex justify-between items-center mt-5">
                                <span class="text-xl font-bold text-green-600">{{ $product->price }} ₽</span>
                                <a href="{{ route('product.show', $product->id) }}" class="bg-green-500 text-white px-5 py-2.5 rounded-lg hover:bg-green-600 transition inline-block text-center">
                                    Просмотр
                                </a>
                            </div>
                            <form action="{{ route('favorites.toggle', $product->id) }}" method="POST" class="inline">
                                @csrf
                                <a href="#" onclick="this.closest('form').submit(); return false;" class="text-pink-500 hover:text-red-600 transition">
                                    {{ Auth::user() && Auth::user()->favorites()->where('product_id', $product->id)->exists() ? 'Убрать из избранного' : 'Добавить в избранное' }}
                                </a>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <script>
        document.querySelectorAll('.favorite-button').forEach(button => {
            button.addEventListener('click', function () {
                const productId = this.dataset.productId;
                fetch('/favorites', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ product_id: productId })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'added') {
                            this.classList.add('text-red-500');
                        } else {
                            this.classList.remove('text-red-500');
                        }
                    })
                    .catch(error => console.error('Ошибка:', error));
            });
        });
    </script>
    <style>
        /* Стили карточек товаров с охотничьей тематикой */
        .product-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background-color: #f5f5f5;
            border: 1px solid #d1d1d1;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2);
        }

        /* Стили кнопок с охотничьей тематикой */
        button {
            transition: background-color 0.3s ease;
            background-color: #6b8e23;
            color: #fff;
        }
        button:hover {
            background-color: #556b2f;
        }

        /* Фон и текстуры */
        body {
            background-image: url('/images/forest-texture.jpg');
            background-size: cover;
            background-attachment: fixed;
        }

        /* Заголовки и текст */
        h2, h3 {
            color: #2e8b57;
        }
        p {
            color: #4b5320;
        }

        /* Обновленные цвета текста для заголовков и описаний товаров */
        .product-card h3 {
            color: #2e2e2e; /* Темный цвет для светлой темы */
        }
        .product-card p {
            color: #3e3e3e; /* Темный цвет для светлой темы */
        }
        .dark .product-card h3, .dark .product-card p {
            color: #e0e0e0; /* Светлый цвет для темной темы */
        }

        /* Обновленные стили для выравнивания поисковой строки и фильтров */
        .search-filter-container {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
            justify-items: center;
        }
        @media (min-width: 640px) {
            .search-filter-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        .search-filter-container form {
            display: flex;
            align-items: center;
            gap: 8px;
        }
    </style>
</x-app-layout>