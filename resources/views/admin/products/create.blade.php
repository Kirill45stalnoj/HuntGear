<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 dark:text-gray-200 leading-tight">
            Добавление товара
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.products.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Название товара</label>
                        <input type="text" name="name" required class="w-full border rounded-lg px-4 py-2 shadow-sm focus:ring focus:ring-blue-300">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Описание</label>
                        <textarea name="description" class="w-full border rounded-lg px-4 py-2 shadow-sm focus:ring focus:ring-blue-300"></textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Цена (₽)</label>
                        <input type="number" name="price" step="0.01" required min="0" class="w-full border rounded-lg px-4 py-2 shadow-sm focus:ring focus:ring-blue-300">
                        @error('price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Категория</label>
                        <select name="category_id" id="category_id" required class="w-full border rounded-lg px-4 py-2 shadow-sm focus:ring focus:ring-blue-300">
                            <option value="">Выберите категорию</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Размеры</label>
                        <div class="relative">
                            <select name="sizes[]" id="sizes" multiple required 
                                class="w-full border rounded-lg px-4 py-2 shadow-sm focus:ring focus:ring-blue-300 h-32"
                                data-placeholder="Выберите категорию для отображения размеров">
                                <option value="">Выберите категорию для отображения размеров</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">Выберите один или несколько размеров:</p>
                            <ul class="text-sm text-gray-500 list-disc list-inside">
                                <li>Для выбора одного размера - просто кликните по нему</li>
                                <li>Для выбора нескольких размеров подряд - кликните по первому, затем, удерживая Shift, кликните по последнему</li>
                                <li>Для выбора нескольких размеров вразброс - удерживайте Ctrl (или Command на Mac) и кликайте по нужным размерам</li>
                            </ul>
                        </div>
                        @error('sizes')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Изображение (URL)</label>
                        <input type="text" name="image_url" required class="w-full border rounded-lg px-4 py-2 shadow-sm focus:ring focus:ring-blue-300">
                        @error('image_url')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-md hover:bg-green-600 transition">
                        Добавить товар
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categorySelect = document.getElementById('category_id');
            const sizesSelect = document.getElementById('sizes');

            categorySelect.addEventListener('change', function() {
                const categoryId = this.value;
                sizesSelect.innerHTML = '<option value="">Загрузка размеров...</option>';

                if (categoryId) {
                    fetch(`/sizes/${categoryId}`)
                        .then(response => response.json())
                        .then(sizes => {
                            sizesSelect.innerHTML = '';
                            sizes.forEach(size => {
                                const option = document.createElement('option');
                                option.value = size.id;
                                option.textContent = size.size;
                                sizesSelect.appendChild(option);
                            });
                        })
                        .catch(error => {
                            console.error('Error fetching sizes:', error);
                            sizesSelect.innerHTML = '<option value="">Ошибка загрузки размеров</option>';
                        });
                } else {
                    sizesSelect.innerHTML = '<option value="">Выберите категорию для отображения размеров</option>';
                }
            });
        });
    </script>
</x-app-layout>
