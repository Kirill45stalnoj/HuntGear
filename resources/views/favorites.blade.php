<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-900 dark:text-gray-200 leading-tight text-center">
            Избранные товары
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

                @if($favorites->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($favorites as $favorite)
                            <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4 shadow-md">
                                <img src="{{ $favorite->product->image_url }}" class="w-full h-48 object-cover rounded-lg">
                                <h3 class="mt-4 text-lg font-bold">{{ $favorite->product->name }}</h3>
                                <p class="text-green-600 font-bold">{{ $favorite->product->price }} ₽</p>

                                <form action="{{ route('favorites.toggle', $favorite->product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="mt-3 bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
                                        Удалить из избранного
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-lg text-gray-700 dark:text-gray-300">У вас нет избранных товаров.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
