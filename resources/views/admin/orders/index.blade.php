<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-800 leading-tight">
            Управление заказами
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <style>
                    /* Полосатая разметка строк таблицы */
                    tbody tr:nth-child(odd) {
                        background-color: #f9f9f9;
                    }
                    tbody tr:nth-child(even) {
                        background-color: #ffffff;
                    }
                    tbody tr:hover {
                        background-color: #f1f1f1;
                    }

                    /* Стили кнопок */
                    button {
                        transition: background-color 0.3s ease;
                    }
                    button:hover {
                        background-color: #4a5568;
                    }

                    /* Стили для модального окна */
                    #orderDetailsModal {
                        transition: opacity 0.3s ease;
                    }
                    #orderDetailsModal.show {
                        opacity: 1;
                    }
                    #orderDetailsModal.hide {
                        opacity: 0;
                    }
                </style>

                <!-- Фильтр по статусу -->
                <div class="mb-4">
                    <form method="GET" action="{{ route('admin.orders.index') }}" class="flex gap-2 items-center">
                        <label for="status" class="mr-2 text-white">Статус:</label>
                        <select name="status" id="status" class="border rounded p-2">
                            <option value="">Все заказы</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>В ожидании</option>
                            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Обрабатывается</option>
                            <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Отправлен</option>
                            <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Доставлен</option>
                        </select>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                            Фильтр
                        </button>
                    </form>
                </div>

                <!-- Кнопка для выгрузки заказов в Excel -->
                <a href="{{ url('/export-orders') }}" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition">
                    Выгрузить заказы в Excel
                </a>

                <table class="w-full border-collapse border border-gray-200 text-sm">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                            <th class="p-4 border">ID</th>
                            <th class="p-4 border">Пользователь</th>
                            <th class="p-4 border">Сумма</th>
                            <th class="p-4 border">Статус</th>
                            <th class="p-4 border">Дата</th>
                            <th class="p-4 border">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="p-4 border">{{ $order->id }}</td>
                                <td class="p-4 border">{{ $order->user->name ?? 'Гость' }}</td>
                                <td class="p-4 border">{{ $order->total_price }} ₽</td>
                                <td class="p-4 border">
                                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" class="border rounded p-2" onchange="this.form.submit()">
                                            <option value="pending" class="text-yellow-500" {{ $order->status == 'pending' ? 'selected' : '' }}>🕒 В ожидании</option>
                                            <option value="processing" class="text-blue-500" {{ $order->status == 'processing' ? 'selected' : '' }}>🔄 Обрабатывается</option>
                                            <option value="shipped" class="text-purple-500" {{ $order->status == 'shipped' ? 'selected' : '' }}>📦 Отправлен</option>
                                            <option value="delivered" class="text-green-500" {{ $order->status == 'delivered' ? 'selected' : '' }}>✅ Доставлен</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="p-4 border">{{ $order->created_at->format('d.m.Y H:i') }}</td>
                                <td class="p-4 border flex gap-2">
                                    <!-- Кнопка просмотра деталей -->
                                    <button onclick="showOrderDetails({{ $order->id }})"
                                        class="bg-gray-500 text-white px-3 py-2 rounded-lg hover:bg-gray-600 transition">
                                        👁 Посмотреть
                                    </button>
                                    <!-- Удаление заказа -->
                                    <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST"
                                        onsubmit="return confirm('Удалить заказ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 transition">
                                            ❌ Удалить
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Модальное окно для деталей заказа -->
    <div id="orderDetailsModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg max-w-lg w-full">
            <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-200 mb-4 text-center">Детали заказа</h3>
            <div id="orderDetailsContent" class="text-gray-700 dark:text-gray-300"></div>
            <div class="text-center mt-4">
                <button onclick="closeOrderDetails()"
                    class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition">
                    Закрыть
                </button>
            </div>
        </div>
    </div>

    <script>
        function showOrderDetails(orderId) {
            fetch(`/admin/orders/${orderId}`)
                .then(response => {
                    if (!response.ok) throw new Error('Ошибка загрузки данных');
                    return response.json();
                })
                .then(order => {
                    document.getElementById('orderDetailsContent').innerHTML = `
                        <div class="space-y-4">
                            <p><strong>Телефон:</strong> ${order.phone || 'Не указан'}</p>
                            <p><strong>Адрес:</strong> ${order.address || 'Не указан'}</p>
                            <p><strong>Комментарий:</strong> ${order.comment || 'Нет комментария'}</p>
                            <p><strong>Способ оплаты:</strong> ${order.payment_method === 'card' ? 'Картой' : 'Наличными'}</p>
                            <p><strong>Статус:</strong> ${order.status || 'Не указан'}</p>
                            <p><strong>Дата заказа:</strong> ${new Date(order.created_at).toLocaleString()}</p>
                            <p><strong>Общая сумма:</strong> ${order.total_price} ₽</p>
                        </div>
                    `;
                    document.getElementById('orderDetailsModal').classList.remove('hidden');
                })
                .catch(error => {
                    alert('Ошибка загрузки заказа. Проверьте консоль.');
                    console.error(error);
                });
        }

        function closeOrderDetails() {
            document.getElementById('orderDetailsModal').classList.add('hidden');
        }
    </script>

</x-app-layout>