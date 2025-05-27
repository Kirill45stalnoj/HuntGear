<x-app-layout>
    <h1 class="text-2xl font-bold mb-4">Редактировать категорию</h1>

    <form action="{{ route('categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')
        <label class="block">
            <span>Название</span>
            <input type="text" name="name" value="{{ $category->name }}" class="w-full p-2 border rounded-lg">
        </label>
        <button type="submit" class="mt-3 bg-blue-500 text-white px-4 py-2 rounded-lg">Сохранить</button>
    </form>
</x-app-layout>