<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-900 dark:text-gray-800 leading-tight text-center">
            Панель администратора
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg p-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Добро пожаловать, Администратор!</h3>
                <p class="text-gray-600 dark:text-gray-300 mt-2">Здесь вы можете управлять пользователями, товарами и
                    заказами.</p>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mt-6">
                    <a href="{{ route('admin.products') }}"
                        class="bg-green-500 text-white p-4 rounded-lg shadow-md hover:bg-green-600 transition text-center">
                        Управление товарами
                    </a>
                    <a href="{{ route('users.index') }}"
                        class="bg-green-500 text-white p-4 rounded-lg shadow-md hover:bg-green-600 transition text-center">
                        Управление пользователями
                    </a>
                    <a href="{{ route('categories.index') }}"
                        class="bg-green-500 text-white p-4 rounded-lg shadow-md hover:bg-green-600 transition text-center">
                        Управление категориями
                    </a>
                    <a href="{{ route('admin.orders.index') }}"
                        class="bg-green-500 text-white p-4 rounded-lg shadow-md hover:bg-green-600 transition text-center">
                        Управление заказами
                    </a>
                    <a href="{{ route('admin.reviews.index') }}"
                        class="bg-green-500 text-white p-4 rounded-lg shadow-md hover:bg-green-600 transition text-center">
                        Управление отзывами
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>