<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-800 leading-tight">
            {{ __('Главная') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Заказы -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-gray-200">Мои заказы</h3>

                        @if($orders->isEmpty())
                            <p class="text-gray-600 dark:text-gray-300 mt-4 text-lg">😔 У вас пока нет заказов.</p>
                        @else
                            <div class="space-y-6 mt-6">
                                @foreach($orders as $order)
                                    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl p-6 border border-gray-200 dark:border-gray-700">
                                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                            <div class="flex items-center gap-4">
                                                <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-200">
                                                    Заказ #{{ $order->id }}
                                                </h4>
                                                <span class="px-3 py-1 text-sm rounded-full font-semibold 
                                                    @if($order->status == 'pending') bg-yellow-100 text-yellow-700 
                                                    @elseif($order->status == 'processing') bg-blue-100 text-blue-700 
                                                    @elseif($order->status == 'shipped') bg-purple-100 text-purple-700 
                                                    @elseif($order->status == 'delivered') bg-green-100 text-green-700 
                                                    @endif">
                                                    @switch($order->status)
                                                        @case('pending')
                                                            Ожидается
                                                            @break
                                                        @case('processing')
                                                            В обработке
                                                            @break
                                                        @case('shipped')
                                                            Отправлен
                                                            @break
                                                        @case('delivered')
                                                            Доставлен
                                                            @break
                                                        @default
                                                            Неизвестный статус
                                                    @endswitch
                                                </span>
                                            </div>
                                            <div class="flex flex-col md:items-end gap-2">
                                                <p class="text-gray-600 dark:text-gray-400">
                                                    📅 <strong>{{ $order->created_at->format('d.m.Y') }}</strong>
                                                </p>
                                                <p class="text-gray-600 dark:text-gray-400">
                                                    📍 <strong>{{ $order->address }}</strong>
                                                </p>
                                            </div>
                                        </div>

                                        <div class="mt-6 border-t border-gray-300 dark:border-gray-600 pt-4">
                                            <h5 class="text-md font-semibold mb-4">🛍️ Товары:</h5>
                                            <div class="space-y-4">
                                                @foreach($order->items as $item)
                                                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                                        <img src="{{ $item->product->image_url }}"
                                                            class="w-20 h-20 rounded-lg object-cover shadow"
                                                            alt="{{ $item->product->name }}">
                                                        <div class="flex-1 min-w-0">
                                                            <p class="text-gray-900 dark:text-gray-200 font-semibold truncate">
                                                                {{ $item->product->name }}
                                                            </p>
                                                            <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-2">
                                                                {{ $item->product->description }}
                                                            </p>
                                                        </div>
                                                        <div class="flex flex-col items-end">
                                                            <p class="text-gray-900 dark:text-gray-200 font-semibold">
                                                                {{ $item->product->price * $item->quantity }} ₽
                                                            </p>
                                                            <p class="text-gray-600 dark:text-gray-400 text-sm">
                                                                Кол-во: {{ $item->quantity }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="mt-6 pt-4 border-t border-gray-300 dark:border-gray-600">
                                            @php
                                                $totalPrice = 0;
                                                foreach ($order->items as $item) {
                                                    $totalPrice += $item->product->price * $item->quantity;
                                                }
                                            @endphp
                                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-200">
                                                💰 Общая сумма: <span class="text-green-500">{{ $totalPrice }} ₽</span>
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Избранные товары -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-gray-200">Избранные товары</h3>

                        @if($favorites->isEmpty())
                            <p class="text-gray-600 dark:text-gray-300 mt-4 text-lg">😔 У вас нет избранных товаров.</p>
                        @else
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">
                                @foreach($favorites as $product)
                                    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl p-4 border border-gray-200 dark:border-gray-700">
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                            class="w-full h-48 object-cover rounded-lg mb-4">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-200">{{ $product->name }}</h4>
                                        <p class="text-gray-600 dark:text-gray-400 mt-2">{{ $product->price }} ₽</p>
                                        <a href="{{ route('product.show', $product->id) }}"
                                            class="mt-4 inline-block text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                            Посмотреть
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>