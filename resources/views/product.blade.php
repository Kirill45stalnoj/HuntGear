<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-4xl text-gray-900 dark:text-gray-700 leading-tight text-center">
            {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Карточка товара -->
            <div
                class="product-card bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-2xl p-8 flex flex-col md:flex-row items-center transition-all duration-300 hover:shadow-2xl">
                <!-- Изображение товара -->
                <div
                    class="w-full md:w-1/2 flex justify-center transform transition-transform duration-300 hover:scale-105">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                        class="w-full max-w-md h-auto rounded-lg shadow-lg">
                </div>

                <!-- Описание товара -->
                <div class="w-full md:w-1/2 mt-8 md:mt-0 md:ml-8">
                    <h3 class="product-name text-3xl font-bold mb-4">{{ $product->name }}</h3>
                    <p class="text-lg text-gray-600 dark:text-gray-300 mb-6">{{ $product->description }}</p>
                    <span class="product-price block text-4xl font-bold mb-6">{{ $product->price }} ₽</span>
                    <div class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-4">
                        <!-- Форма добавления в корзину -->
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="w-full md:w-auto">
                            @csrf
                            <div class="mb-6">
                                <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Размер</label>
                                <select name="size_id"
                                    class="w-full border rounded-lg px-4 py-2 shadow-sm focus:ring-2 focus:ring-green-500"
                                    required>
                                    @foreach($product->sizes as $size)
                                        <option value="{{ $size->id }}">{{ $size->size }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit"
                                class="add-to-cart-button px-8 py-3 rounded-lg shadow-md transition-transform transform hover:scale-105">
                                В корзину
                            </button>
                        </form>

                        <!-- Форма добавления/удаления из избранного -->
                        <form action="{{ route('favorites.toggle', $product->id) }}" method="POST" class="mt-4 md:mt-0">
                            @csrf
                            <button type="submit"
                                class="favorite-button px-8 py-3 rounded-lg shadow-md transition-transform transform hover:scale-105">
                                {{ Auth::user() && Auth::user()->favorites()->where('product_id', $product->id)->exists() ? 'Убрать из избранного' : 'Добавить в избранное' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Отзывы -->
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mt-12">
            <h3 class="text-3xl font-bold text-green-900 dark:text-gray mb-6">Отзывы</h3>

            @auth
                @php
                    $hasDeliveredOrder = auth()->user()->orders()
                        ->whereHas('items', function ($query) use ($product) {
                            $query->where('product_id', $product->id);
                        })
                        ->where('status', 'delivered')
                        ->exists();
                    
                    $hasReview = $product->reviews()->where('user_id', auth()->id())->exists();
                @endphp

                @if($hasDeliveredOrder && !$hasReview)
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold mb-4">Оставить отзыв</h3>
                        <form action="{{ route('reviews.store', ['product' => $product->id]) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label for="rating" class="block text-sm font-medium text-gray-700">Оценка</label>
                                <select name="rating" id="rating" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#8B4513] focus:ring-[#8B4513]">
                                    <option value="">Выберите оценку</option>
                                    <option value="1">1 - Плохо</option>
                                    <option value="2">2 - Неудовлетворительно</option>
                                    <option value="3">3 - Удовлетворительно</option>
                                    <option value="4">4 - Хорошо</option>
                                    <option value="5">5 - Отлично</option>
                                </select>
                            </div>
                            <div>
                                <label for="review" class="block text-sm font-medium text-gray-700">Отзыв</label>
                                <textarea name="review" id="review" rows="4" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#8B4513] focus:ring-[#8B4513]"
                                    placeholder="Напишите ваш отзыв о товаре..."></textarea>
                            </div>
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#8B4513] hover:bg-[#724011] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#8B4513]">
                                Отправить отзыв
                            </button>
                        </form>
                    </div>
                @elseif($hasReview)
                    <div class="mt-4 p-4 bg-green-50 rounded-md">
                        <p class="text-green-700">Вы уже оставили отзыв на этот товар.</p>
                    </div>
                @else
                    <div class="mt-4 p-4 bg-yellow-50 rounded-md">
                        <p class="text-yellow-700">Вы можете оставить отзыв только после получения товара.</p>
                    </div>
                @endif
            @endauth
            <div class="space-y-6 mt-8">
                @forelse($product->reviews as $review)
                    <div
                        class="review-card bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">
                        <div class="flex items-center justify-between">
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $review->user->name }}</span>
                            <span class="text-yellow-500 text-lg">{{ str_repeat('★', $review->rating) }}</span>
                        </div>
                        <p class="mt-4 text-gray-600 dark:text-gray-300">{{ $review->review }}</p>

                        @if(Auth::check() && (Auth::user()->is_admin || Auth::id() === $review->user_id))
                            <div class="mt-4 flex space-x-4">
                                <button
                                    onclick="openEditModal({{ $review->id }}, '{{ $review->review }}', {{ $review->rating }})"
                                    class="text-blue-600 hover:text-blue-700">Редактировать</button>

                                <form action="{{ route('review.destroy', $review->id) }}" method="POST"
                                    onsubmit="return confirm('Вы уверены, что хотите удалить этот отзыв?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700">Удалить</button>
                                </form>
                            </div>
                        @endif
                    </div>
                @empty
                    <p class="text-gray-600 dark:text-gray-400">Отзывов пока нет.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Модальное окно для редактирования отзыва -->
    <div id="editReviewModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex items-center justify-center">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-lg">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Редактировать отзыв</h2>

            <form id="editReviewForm" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" id="reviewId" name="review_id">

                <!-- Оценка -->
                <div class="mb-4">
                    <label for="editRating" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Оценка</label>
                    <select id="editRating" name="rating"
                        class="w-full border rounded-lg px-4 py-2 shadow-sm focus:ring-2 focus:ring-green-500">
                        <option value="1">1 - Очень плохо</option>
                        <option value="2">2 - Плохо</option>
                        <option value="3">3 - Нормально</option>
                        <option value="4">4 - Хорошо</option>
                        <option value="5">5 - Отлично</option>
                    </select>
                </div>

                <!-- Текст отзыва -->
                <div class="mb-4">
                    <label for="editReviewText"
                        class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Отзыв</label>
                    <textarea id="editReviewText" name="review" rows="4"
                        class="w-full border rounded-lg px-4 py-2 shadow-sm focus:ring-2 focus:ring-green-500"></textarea>
                </div>

                <!-- Кнопки -->
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeEditModal()"
                        class="bg-gray-500 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-600">Отмена</button>
                    <button type="submit"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg shadow hover:bg-green-700">Сохранить</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            if (categorySelect && sizeSelect) {
                categorySelect.addEventListener('change', function () {
                    const categoryId = this.value;
                    fetch(`/sizes/${categoryId}`)
                        .then(response => response.json())
                        .then(sizes => {
                            sizeSelect.innerHTML = '<option value="">Выберите размер</option>';
                            sizes.forEach(size => {
                                sizeSelect.innerHTML += `<option value="${size.id}">${size.size}</option>`;
                            });
                        });
                });
            } else {
                console.error('Элементы с id "category-select" и/или "size-select" не найдены.');
            }
        });

        function openEditModal(reviewId, reviewText, rating) {
            document.getElementById('editReviewModal').classList.remove('hidden');
            document.getElementById('reviewId').value = reviewId;
            document.getElementById('editReviewText').value = reviewText;
            document.getElementById('editRating').value = rating;

            // Устанавливаем URL формы
            document.getElementById('editReviewForm').action = `/reviews/${reviewId}`;
        }

        function closeEditModal() {
            document.getElementById('editReviewModal').classList.add('hidden');
        }
    </script>

    <style>
        /* Улучшенные стили карточки товара */
        .product-card {
            transition: transform 0.4s ease, box-shadow 0.4s ease;
            background-color: #ffffff;
            border: 1px solid #d1d1d1;
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.1);
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 30px rgba(0, 0, 0, 0.2);
        }

        /* Улучшенные стили для названия товара */
        .product-name {
            color: #808080;
            /* Серый цвет */
        }

        /* Улучшенные стили для цены товара */
        .product-price {
            color: #008000;
            /* Зеленый цвет */
        }

        /* Улучшенные стили кнопок с градиентом */
        .add-to-cart-button {
            background: linear-gradient(135deg, #32CD32, #228B22);
            color: #fff;
            transition: background 0.4s ease, transform 0.4s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .add-to-cart-button:hover {
            background: linear-gradient(135deg, #228B22, #006400);
            transform: scale(1.08);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }

        .favorite-button {
            background: linear-gradient(135deg, #FF69B4, #FF1493);
            color: #fff;
            transition: background 0.4s ease, transform 0.4s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .favorite-button:hover {
            background: linear-gradient(135deg, #FF1493, #C71585);
            transform: scale(1.08);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }

        /* Улучшенные стили для отзывов */
        .review-card {
            transition: box-shadow 0.4s ease;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .review-card:hover {
            box-shadow: 0 12px 18px rgba(0, 0, 0, 0.2);
        }
    </style>
</x-app-layout>