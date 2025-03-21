<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Models\Role;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:users.view', only: ['index']),
            new Middleware('permission:users.delete', only: ['destroy']),
            new Middleware('permission:users.update-role', only: ['makeAdmin']),

        ];
    }

    public function index()
    {
        $users = User::with('roles')->paginate(15);
        return view('users.index', compact('users'));
    }


    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'You cannot delete yourself.');
        }

        $user->delete();
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }

    public function makeAdmin(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'You cannot modify your own role.');
        }

        $adminRole = Role::findByName('admin');

        if ($user->hasRole('admin')) {
            $user->removeRole($adminRole);
            $message = 'Admin rights revoked';
        } else {
            $user->assignRole($adminRole);
            $message = 'Admin rights granted';
        }

        return redirect()->route('users.index')
            ->with('success', $message);
    }
}
