<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-900 dark:text-gray-800 leading-tight text-center">
            Корзина
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-8">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if(count($cart) > 0)
                    <table class="w-full border-collapse border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                <th class="p-4 border text-white">Изображение</th>
                                <th class="p-4 border text-white">Название</th>
                                <th class="p-4 border text-white">Цена за шт.</th>
                                <th class="p-4 border text-white">Количество</th>
                                <th class="p-4 border text-white">Размер</th>
                                <th class="p-4 border text-white">Общая стоимость</th>
                                <th class="p-4 border text-white">Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $totalPrice = 0; @endphp
                            @foreach($cart as $key => $item)
                                @php $totalPrice += $item['price'] * $item['quantity']; @endphp
                                <tr>
                                    <td class="p-4 border text-center">
                                        <img src="{{ $item['image'] }}" class="w-20 h-20 rounded-lg">
                                    </td>
                                    <td class="p-4 border text-white">{{ $item['name'] }}</td>
                                    <td class="p-4 border text-white">{{ $item['price'] }} ₽</td>
                                    <td class="p-4 border text-center">
                                        <form action="{{ route('cart.update', $key) }}" method="POST"
                                            class="flex justify-center items-center">
                                            @csrf
                                            <button type="submit" name="action" value="decrease"
                                                class="bg-gray-300 text-gray-700 px-2 rounded-md">−</button>
                                            <span class="mx-3">{{ $item['quantity'] }}</span>
                                            <button type="submit" name="action" value="increase"
                                                class="bg-gray-300 text-gray-700 px-2 rounded-md">+</button>
                                        </form>
                                    </td>
                                    <td class="p-4 border text-white">{{ $item['size'] }}</td>
                                    <td class="p-4 border text-white">{{ $item['price'] * $item['quantity'] }} ₽</td>
                                    <td class="p-4 border text-center">
                                        <form action="{{ route('cart.remove', $key) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit"
                                                class="bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 transition">Удалить</button>
                                        </form>
                                        <!-- Кнопка для открытия модального окна -->
                                        <button
                                            onclick="openEditModal('{{ $key }}', '{{ $item['category_id'] ?? '' }}', '{{ $item['size_id'] ?? '' }}')"
                                            class="bg-blue-500 text-white px-3 py-2 rounded-lg hover:bg-blue-600 transition">
                                            Редактировать
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div id="editCartModal"
                        class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center hidden">
                        <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg max-w-lg w-full relative">
                            <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-200 mb-4 text-center">
                                Редактирование заказа</h3>

                            <form action="{{ route('cart.updateItem') }}" method="POST">
                                @csrf
                                <input type="hidden" name="cart_id" id="cart_id">

                                <!-- Выбор категории -->
                                <div class="mb-4">
                                    <label for="edit_category"
                                        class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Категория</label>
                                    <select name="category" id="edit_category"
                                        class="w-full border rounded-lg px-4 py-2 shadow-sm focus:ring focus:ring-blue-300"
                                        onchange="updateSizes()">
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Выбор размера -->
                                <div class="mb-4">
                                    <label for="edit_size"
                                        class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Выберите
                                        размер</label>
                                    <select name="size" id="edit_size"
                                        class="w-full border rounded-lg px-4 py-2 shadow-sm focus:ring focus:ring-blue-300">
                                        <option value="">Выберите размер</option>
                                    </select>
                                </div>

                                <!-- ФИО пользователя -->
                                <div class="mb-4">
                                    <label for="edit_name"
                                        class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Ваше имя</label>
                                    <input type="text" name="name" id="edit_name"
                                        class="w-full border rounded-lg px-4 py-2 shadow-sm focus:ring focus:ring-blue-300"
                                        required>
                                </div>

                                <!-- Телефон -->
                                <div class="mb-4">
                                    <label for="edit_phone"
                                        class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Телефон</label>
                                    <input type="text" name="phone" id="edit_phone"
                                        class="w-full border rounded-lg px-4 py-2 shadow-sm focus:ring focus:ring-blue-300"
                                        required>
                                </div>

                                <!-- Кнопки -->
                                <div class="flex justify-between">
                                    <button type="button" onclick="closeEditModal()"
                                        class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition">
                                        Отмена
                                    </button>
                                    <button type="submit"
                                        class="bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 transition">
                                        Сохранить
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-between items-center">
                        <p class="text-2xl font-bold text-white">Итого: {{ $totalPrice }} ₽</p>
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition">
                                Очистить корзину
                            </button>
                        </form>
                        <button id="openModalButton"
                            class="bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 transition">
                            Оформить заказ
                        </button>
                    </div>
                @else
                    <p class="text-center text-lg text-gray-700 dark:text-gray-300">Корзина пуста.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Модальное окно -->
    <div id="orderModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg max-w-lg w-full relative">
            <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-200 mb-4 text-center">Оформление заказа</h3>

            <form action="{{ route('order.store') }}" method="POST">
                @csrf

                <!-- Ввод адреса с маской -->
                <div class="mb-4">
                    <label for="address" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Адрес
                        доставки</label>
                    <input type="text" name="address" id="address"
                        class="w-full border rounded-lg px-4 py-2 shadow-sm focus:ring focus:ring-blue-300"
                        placeholder="г. Москва, ул. Ленина, д. 5, кв. 10" required>
                </div>

                <!-- Способ доставки -->
                <div class="mb-4">
                    <label for="delivery_type" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Способ
                        доставки</label>
                    <select name="delivery_type" id="delivery_type"
                        class="w-full border rounded-lg px-4 py-2 shadow-sm focus:ring focus:ring-blue-300" required>
                        <option value="courier">Курьер</option>
                        <option value="pickup">Самовывоз</option>
                    </select>
                </div>

                <!-- Способ оплаты -->
                <div class="mb-4">
                    <label for="payment_method" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Способ
                        оплаты</label>
                    <select name="payment_method" id="payment_method"
                        class="w-full border rounded-lg px-4 py-2 shadow-sm focus:ring focus:ring-blue-300" required>
                        <option value="card">Карта</option>
                        <option value="cash">Наличные</option>
                    </select>
                </div>

                <!-- ФИО пользователя -->
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Ваше имя</label>
                    <input type="text" name="name" id="name"
                        class="w-full border rounded-lg px-4 py-2 shadow-sm focus:ring focus:ring-blue-300"
                        placeholder="Введите ваше имя" required>
                </div>

                <!-- Телефон -->
                <div class="mb-4">
                    <label for="phone" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Телефон</label>
                    <input type="text" name="phone" id="phone"
                        class="w-full border rounded-lg px-4 py-2 shadow-sm focus:ring focus:ring-blue-300"
                        placeholder="Введите ваш телефон" required>
                </div>

                <!-- Комментарий к заказу -->
                <div class="mb-4">
                    <label for="comment"
                        class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Комментарий</label>
                    <textarea name="comment" id="comment" rows="3"
                        class="w-full border rounded-lg px-4 py-2 shadow-sm focus:ring focus:ring-blue-300"
                        placeholder="Например, пожелания к доставке..."></textarea>
                </div>

                <!-- Кнопки -->
                <div class="flex justify-between">
                    <button type="button" id="closeModalButton"
                        class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition">
                        Отмена
                    </button>
                    <button type="submit"
                        class="bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 transition">
                        Оформить заказ
                    </button>
                </div>
            </form>

        </div>
    </div>

    <script>
        const openModalButton = document.getElementById('openModalButton');
        const closeModalButton = document.getElementById('closeModalButton');
        const orderModal = document.getElementById('orderModal');

        openModalButton.addEventListener('click', () => {
            orderModal.classList.remove('hidden');
        });

        closeModalButton.addEventListener('click', () => {
            orderModal.classList.add('hidden');
        });

        function openEditModal(cartId, categoryId, sizeId) {
            document.getElementById('cart_id').value = cartId;
            
            // Устанавливаем выбранную категорию
            const categorySelect = document.getElementById('edit_category');
            categorySelect.value = categoryId;
            
            // Загружаем размеры для выбранной категории
            updateSizes().then(() => {
                // После загрузки размеров устанавливаем выбранный размер
                const sizeSelect = document.getElementById('edit_size');
                sizeSelect.value = sizeId;
                
                // Показываем модальное окно только после установки всех значений
                document.getElementById('editCartModal').classList.remove('hidden');
            });
        }

        function updateSizes() {
            const categoryId = document.getElementById('edit_category').value;
            const sizeSelect = document.getElementById('edit_size');
            
            return new Promise((resolve) => {
                if (categoryId) {
                    fetch(`/sizes/${categoryId}`)
                        .then(response => response.json())
                        .then(sizes => {
                            sizeSelect.innerHTML = '<option value="">Выберите размер</option>';
                            sizes.forEach(size => {
                                const option = document.createElement('option');
                                option.value = size.id;
                                option.textContent = size.size;
                                sizeSelect.appendChild(option);
                            });
                            resolve();
                        })
                        .catch(error => {
                            console.error('Error fetching sizes:', error);
                            sizeSelect.innerHTML = '<option value="">Ошибка загрузки размеров</option>';
                            resolve();
                        });
                } else {
                    sizeSelect.innerHTML = '<option value="">Выберите категорию для отображения размеров</option>';
                    resolve();
                }
            });
        }

        function closeEditModal() {
            document.getElementById('editCartModal').classList.add('hidden');
        }
    </script>
</x-app-layout>