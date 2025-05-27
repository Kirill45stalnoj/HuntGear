<x-app-layout>
    <h1 class="text-2xl font-bold mb-4">Добавить категорию</h1>

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <label class="block">
            <span>Название</span>
            <input type="text" name="name" class="w-full p-2 border rounded-lg">
        </label>
        <button type="submit" class="mt-3 bg-green-500 text-white px-4 py-2 rounded-lg">Добавить</button>
    </form>
</x-app-layout>

