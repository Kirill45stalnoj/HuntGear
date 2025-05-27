<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-4xl text-gray-900 dark:text-gray-700 leading-tight text-center">
            Управление отзывами
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-2xl p-8">
                <a href="{{ route('reviews.export') }}"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    📥 Скачать Excel
                </a>
                <table class="min-w-full mt-5 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left">Продукт</th>
                            <th class="px-6 py-3 text-left">Описание продукта</th>
                            <th class="px-6 py-3 text-left">Пользователь</th>
                            <th class="px-6 py-3 text-left">Оценка</th>
                            <th class="px-6 py-3 text-left">Комментарий</th>
                            <th class="px-6 py-3 text-left">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reviews as $review)
                            <tr>
                                <td class="px-6 py-4">{{ $review->product->name }}</td>
                                <td class="px-6 py-4">{{ $review->product->description }}</td>
                                <td class="px-6 py-4">{{ $review->user->name }}</td>
                                <td class="px-6 py-4">
                                    <span class="text-yellow-500">
                                        @for($i = 0; $i < $review->rating; $i++)
                                            ★
                                        @endfor
                                    </span>
                                </td>
                                <td class="px-6 py-4">{{ $review->review }}</td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.reviews.edit', $review->id) }}"
                                        class="text-blue-600 hover:text-blue-700">Редактировать</a>
                                    |
                                    <form action="{{ route('review.destroy', $review->id) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Вы уверены, что хотите удалить этот отзыв?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-700">Удалить</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>