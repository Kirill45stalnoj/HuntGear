<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-900 dark:text-gray-900 leading-tight text-center">
            Управление товарами
        </h2>
    </x-slot>
    @if (session('error'))
        <div class="bg-red-500 text-white text-center p-3 rounded-lg mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="bg-green-500 text-white text-center p-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-6 flex justify-end">
                <a href="{{ route('admin.products.create') }}"
                    class="bg-green-600 text-white px-6 py-3 rounded-lg shadow-md hover:bg-green-700 transition flex items-center gap-2">
                    Добавить товар
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg p-6">

                <table class="min-w-full bg-white dark:bg-gray-800 border rounded-lg shadow-sm">
                    <thead>
                        <tr class="bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white text-left">
                            <th class="py-3 px-4 border">ID</th>
                            <th class="py-3 px-4 border">Название</th>
                            <th class="py-3 px-4 border">Описание</th>
                            <th class="py-3 px-4 border">Изображение</th>
                            <th class="py-3 px-4 border">Цена</th>
                            <th class="py-3 px-4 border text-center">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr class="border-b hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                <td class="py-3 px-4 border text-white">{{ $product->id }}</td>
                                <td class="py-3 px-4 border text-white">{{ $product->name }}</td>
                                <td class="py-3 px-4 border text-white">{{ Str::limit($product->description, 60) }}</td>
                                <td class="py-3 px-4 border text-white">
                                    <img src="{{ $product->image_url }}" alt="Фото товара"
                                        class="w-16 h-16 object-cover rounded-lg shadow-md">
                                </td>
                                <td class="py-3 px-4 border text-white">{{ $product->price }} ₽</td>
                                <td class="py-3 px-4 border text-center text-white">
                                    <button onclick="openEditModal({{ $product }})"
                                        class="text-blue-500 hover:text-blue-700 transition font-semibold mr-3">
                                        Редактировать
                                    </button>

                                    @if ($product->carts && $product->carts->isNotEmpty())
                                        <button disabled class="text-gray-400 cursor-not-allowed font-semibold">
                                            Удалить (в корзине)
                                        </button>
                                    @else
                                        <button onclick="openDeleteModal({{ $product->id }})"
                                            class="text-red-500 hover:text-red-700 transition font-semibold">
                                            Удалить
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Модальное окно редактирования -->
    <div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-1/3">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Редактировать товар</h3>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')

                <!-- Название -->
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Название</label>
                    <input type="text" id="editName" name="name" required
                        class="w-full border rounded-lg px-4 py-3 shadow-md focus:ring focus:ring-blue-300 transition">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Категория -->
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Категория</label>
                    <select id="editCategory" name="category_id" required
                        class="w-full border rounded-lg px-4 py-3 shadow-md focus:ring focus:ring-blue-300 transition">
                        <option value="">Выберите категорию</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Цена -->
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Цена</label>
                    <input type="number" id="editPrice" name="price" step="0.01" required min="0"
                        class="w-full border rounded-lg px-4 py-3 shadow-md focus:ring focus:ring-blue-300 transition">
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Описание -->
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Описание</label>
                    <textarea id="editDescription" name="description" rows="3"
                        class="w-full border rounded-lg px-4 py-3 shadow-md focus:ring focus:ring-blue-300 transition"></textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Текущее изображение -->
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Текущее изображение</label>
                    <img id="editImagePreview" src="" alt="Текущее изображение"
                        class="w-20 h-20 object-cover rounded-lg shadow-md mt-2">
                </div>

                <!-- URL изображения -->
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">URL изображения</label>
                    <input type="url" id="editImageUrl" name="image_url" required
                        class="w-full border rounded-lg px-4 py-3 shadow-md focus:ring focus:ring-blue-300 transition"
                        placeholder="Введите URL изображения">
                    @error('image_url')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Кнопки -->
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeEditModal()"
                        class="bg-gray-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-gray-600 transition">Отмена</button>
                    <button type="submit"
                        class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow-md hover:bg-blue-700 transition">Сохранить</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Модальное окно подтверждения удаления -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-1/3">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Удаление товара</h3>
            <p id="deleteMessage" class="text-gray-700 dark:text-gray-300 mb-4"></p>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeDeleteModal()"
                        class="bg-gray-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-gray-600 transition">Отмена</button>
                    <button type="submit" id="deleteButton"
                        class="bg-red-600 text-white px-6 py-3 rounded-lg shadow-md hover:bg-red-700 transition">Удалить</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(product) {
            document.getElementById('editName').value = product.name;
            document.getElementById('editPrice').value = product.price;
            document.getElementById('editDescription').value = product.description;
            document.getElementById('editImagePreview').src = product.image_url;
            document.getElementById('editImageUrl').value = product.image_url;
            document.getElementById('editCategory').value = product.category_id;
            document.getElementById('editForm').action = `/admin/products/${product.id}`;
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        function openDeleteModal(productId) {
            document.getElementById('deleteForm').action = `/admin/products/${productId}`;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
    </script>
</x-app-layout>