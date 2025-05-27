<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-4xl text-gray-900 dark:text-gray-700 leading-tight text-center">
            Редактирование отзыва
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-2xl p-8">
                <form action="{{ route('review.update', $review->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-6">
                        <label for="rating" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Оценка</label>
                        <select name="rating" id="rating"
                            class="w-full border rounded-lg px-4 py-2 shadow-sm focus:ring-2 focus:ring-blue-500">
                            <option value="1" {{ $review->rating == 1 ? 'selected' : '' }}>1 - Очень плохо</option>
                            <option value="2" {{ $review->rating == 2 ? 'selected' : '' }}>2 - Плохо</option>
                            <option value="3" {{ $review->rating == 3 ? 'selected' : '' }}>3 - Нормально</option>
                            <option value="4" {{ $review->rating == 4 ? 'selected' : '' }}>4 - Хорошо</option>
                            <option value="5" {{ $review->rating == 5 ? 'selected' : '' }}>5 - Отлично</option>
                        </select>
                    </div>

                    <div class="mb-6">
                        <label for="review" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Текст отзыва</label>
                        <textarea name="review" id="review" rows="4"
                            class="w-full border rounded-lg px-4 py-2 shadow-sm focus:ring-2 focus:ring-blue-500">{{ $review->review }}</textarea>
                    </div>

                    <button type="submit"
                        class="bg-blue-600 text-white px-8 py-3 rounded-lg shadow-md hover:bg-blue-700 transition-transform transform hover:scale-105">
                        Обновить отзыв
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
