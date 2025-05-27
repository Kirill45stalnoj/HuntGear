<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-white">
        <div class="w-full max-w-2xl bg-white p-8"> <!-- Увеличил max-w-md до max-w-2xl -->
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
                <p class="mt-2 text-gray-600">Войдите в свой аккаунт</p>
            </div>

            <!-- Форма входа -->
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Сообщения об ошибках -->
                @if ($errors->any())
                    <div class="max-w-lg mx-auto">
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Ошибка!</strong>
                            <span class="block sm:inline">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}
                                @endforeach
                            </span>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="max-w-lg mx-auto">
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Ошибка!</strong>
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                <!-- Email -->
                <div class="max-w-lg mx-auto"> <!-- Добавил контейнер с максимальной шириной для полей -->
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <div class="mt-1">
                        <input type="email" name="email" id="email" required
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-[#8B4513] focus:border-[#8B4513]"
                            placeholder="ivanov@gmail.com">
                    </div>
                </div>

                <!-- Пароль -->
                <div class="max-w-lg mx-auto">
                    <label for="password" class="block text-sm font-medium text-gray-700">Пароль</label>
                    <div class="mt-1 relative">
                        <input type="password" name="password" id="password" required
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-[#8B4513] focus:border-[#8B4513]"
                            placeholder="••••••••">
                    </div>
                </div>

                <!-- Запомнить меня -->
                <div class="max-w-lg mx-auto flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember"
                            class="h-4 w-4 text-[#8B4513] focus:ring-[#8B4513] border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">
                            Запомнить меня
                        </label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-[#8B4513] hover:text-[#724011]">
                            Забыли пароль?
                        </a>
                    @endif
                </div>

                <!-- Кнопка входа -->
                <div class="max-w-lg mx-auto">
                    <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#8B4513] hover:bg-[#724011] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#8B4513]">
                        Войти
                    </button>
                </div>
            </form>

            <!-- Ссылка на регистрацию -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Нет аккаунта?
                    <a href="{{ route('register') }}" class="font-medium text-[#8B4513] hover:text-[#724011]">
                        Зарегистрироваться
                    </a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>