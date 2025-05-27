<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-white">
        <div class="w-full max-w-2xl bg-white p-8">
            <!-- Логотип -->
            <div class="text-center mb-8">
                <div class="flex justify-center mb-4">
                    <div class="bg-[#8B4513] rounded p-2">
                        <svg class="w-8 h-8 text-white" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M19 3H5C3.89 3 3 3.89 3 5V19C3 20.11 3.89 21 5 21H19C20.11 21 21 20.11 21 19V5C21 3.89 20.11 3 19 3M16.5 13H15V15.5C15 16.33 14.33 17 13.5 17S12 16.33 12 15.5V13H10.5C9.67 13 9 12.33 9 11.5S9.67 10 10.5 10H12V8.5C12 7.67 12.67 7 13.5 7S15 7.67 15 8.5V10H16.5C17.33 10 18 10.67 18 11.5S17.33 13 16.5 13Z" />
                        </svg>
                    </div>
                </div>
                <a href="/"
                    class="absolute top-8 left-8 flex items-center text-gray-600 hover:text-[#8B4513] transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    На главную
                </a>
                <h2 class="text-2xl font-bold text-gray-900">Добро пожаловать в ОхотСнаб</h2>
                <p class="mt-2 text-gray-600">Создайте свой аккаунт</p>
            </div>

            <!-- Форма регистрации -->
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <!-- Имя -->
                <div class="max-w-lg mx-auto">
                    <label for="name" class="block text-sm font-medium text-gray-700">Имя</label>
                    <div class="mt-1">
                        <input type="text" name="name" id="name" required
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-[#8B4513] focus:border-[#8B4513]"
                            placeholder="Иван Иванов">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                </div>

                <!-- Email -->
                <div class="max-w-lg mx-auto">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <div class="mt-1">
                        <input type="email" name="email" id="email" required
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-[#8B4513] focus:border-[#8B4513]"
                            placeholder="ivanov@gmail.com">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                </div>

                <!-- Пароль -->
                <div class="max-w-lg mx-auto">
                    <label for="password" class="block text-sm font-medium text-gray-700">Пароль</label>
                    <div class="mt-1 relative">
                        <input type="password" name="password" id="password" required
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-[#8B4513] focus:border-[#8B4513]"
                            placeholder="••••••••">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                </div>

                <!-- Подтверждение пароля -->
                <div class="max-w-lg mx-auto">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Подтвердите
                        пароль</label>
                    <div class="mt-1 relative">
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-[#8B4513] focus:border-[#8B4513]"
                            placeholder="••••••••">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                </div>

                <!-- Кнопка регистрации -->
                <div class="max-w-lg mx-auto">
                    <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#8B4513] hover:bg-[#724011] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#8B4513]">
                        Зарегистрироваться
                    </button>
                </div>
            </form>

            <!-- Ссылка на вход -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Уже есть аккаунт?
                    <a href="{{ route('login') }}" class="font-medium text-[#8B4513] hover:text-[#724011]">
                        Войти
                    </a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>