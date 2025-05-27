<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Детали заказа #{{ $order->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-8">
                <h3 class="text-xl font-bold mb-4">Информация о заказе</h3>

                <!-- Основная информация о заказе -->
                <div class="space-y-2">
                    <p><strong>Пользователь:</strong> {{ $order->user->fullname }}</p>
                    <p><strong>Дата заказа:</strong> {{ $order->created_at->format('d.m.Y H:i') }}</p>
                    <p><strong>Статус:</strong> {{ ucfirst($order->status) }}</p>
                    <p><strong>Адрес доставки:</strong> {{ $order->address }}</p>
                    @if($order->comment)
                        <p><strong>Комментарий к заказу:</strong> {{ $order->comment }}</p>
                    @endif
                </div>

                <!-- Товары в заказе -->
                <h3 class="text-xl font-bold mt-6 mb-4">Товары</h3>
                <table class="min-w-full bg-white dark:bg-gray-700 rounded-lg overflow-hidden">
                    <thead class="bg-gray-50 dark:bg-gray-600">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-200">Товар
                            </th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-200">
                                Количество</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-200">Цена за
                                шт.</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-200">Размер
                            </th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-200">Общая
                                сумма</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                        @foreach($order->items as $item)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">{{ $item->product->name }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">{{ $item->quantity }} шт.
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">{{ $item->price }} ₽</td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">
                                    @if($item->size)
                                        {{ $item->size }}
                                    @else
                                        Не указан
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">
                                    {{ $item->quantity * $item->price }} ₽</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Общая сумма заказа -->
                <div class="mt-4">
                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-200">
                        <strong>Общая сумма заказа:</strong> {{ $order->total_price }} ₽
                    </p>
                </div>

                <!-- Кнопки управления -->
                <div class="mt-6 flex justify-between">
                    <a href="{{ route('admin.orders.index') }}"
                        class="inline-block bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition">
                        Назад к заказам
                    </a>

                    <!-- Форма для изменения статуса заказа -->
                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="inline-block">
                        @csrf
                        @method('PUT')
                        <select name="status"
                            class="px-4 py-2 border rounded-lg bg-white dark:bg-gray-700 dark:text-gray-200">
                            <option value="обработка" {{ $order->status == 'обработка' ? 'selected' : '' }}>Обработка
                            </option>
                            <option value="отправлен" {{ $order->status == 'отправлен' ? 'selected' : '' }}>Отправлен
                            </option>
                            <option value="доставлен" {{ $order->status == 'доставлен' ? 'selected' : '' }}>Доставлен
                            </option>
                            <option value="отменен" {{ $order->status == 'отменен' ? 'selected' : '' }}>Отменен</option>
                        </select>
                        <button type="submit"
                            class="ml-4 bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition">
                            Обновить статус
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>