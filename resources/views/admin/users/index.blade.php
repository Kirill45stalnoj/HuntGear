<x-app-layout>
    <div class="min-h-screen bg-gray-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Управление пользователями</h1>

    @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
            {{ session('success') }}
        </div>
    @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Имя</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Роль</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Статус</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Действия</th>
            </tr>
        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($users as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-black">{{ $user->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-black">{{ $user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-black">{{ $user->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-black">{{ ucfirst($user->role) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @if ($user->is_banned)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Заблокирован
                                            </span>
                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Активен
                                            </span>
                        @endif
                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-black">
                                        <div class="flex space-x-2">
                                            <form action="{{ route('users.changeRole', $user) }}" method="POST" class="flex items-center">
                            @csrf
                                                <select name="role" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Пользователь</option>
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Админ</option>
                            </select>
                                                <button type="submit" class="ml-2 inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    Изменить
                                                </button>
                        </form>

                        <form action="{{ route('users.toggleBan', $user) }}" method="POST">
                            @csrf
                                                <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white {{ $user->is_banned ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700' }} focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                {{ $user->is_banned ? 'Разблокировать' : 'Заблокировать' }}
                            </button>
                        </form>
                                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
                </div>
            </div>
        </div>
</div>
</x-app-layout>
