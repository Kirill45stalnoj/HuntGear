<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Отображение списка пользователей
    public function index()
    {
        $users = User::all(); // Получаем всех пользователей
        return view('admin.users.index', compact('users')); // Передаем в представление
    }

    // Блокировка/разблокировка пользователя
    public function toggleBan(User $user)
    {
        $user->is_banned = !$user->is_banned;
        $user->save();

        // Если пользователь был заблокирован, разлогиниваем его
        if ($user->is_banned) {
            // Проверяем, является ли заблокированный пользователь текущим
            if (auth()->id() === $user->id) {
                auth()->logout();
                return redirect()->route('login')
                    ->with('error', 'Ваш аккаунт был заблокирован администратором.');
            }
        }

        return redirect()->route('users.index')
            ->with('success', 'Статус пользователя успешно обновлен.');
    }

    // Изменение роли пользователя
    public function changeRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|string|in:user,admin,moderator', // Ограничение ролей
        ]);

        $user->role = $request->role;
        $user->save();

        return redirect()->route('users.index')->with('success', 'Роль пользователя обновлена.');
    }
}
