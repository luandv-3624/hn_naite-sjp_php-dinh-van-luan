<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::select('id', 'name', 'email', 'premium_expired_at')
        ->with(['roles:id,name'])
        ->paginate(10);

        return view('admin.user-management.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load('roles');
        return view('admin.user-management.show', compact('user'));
    }

    public function edit(User $user)
    {
        $user->load('roles');
        return view('admin.user-management.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|string|in:admin,user,guest,premium_user',
            'premium_expired_at' => 'nullable|date'
        ]);

        // Cập nhật thông tin cơ bản
        $user->update([
            'name' => $validated['username'],
            'email' => $validated['email'],
            'premium_expired_at' => $request->input('role') === 'premium_user'
                ? ($request->has('premium_permanent') ? null : $validated['premium_expired_at'])
                : null
        ]);

        // Cập nhật role
        $user->roles()->sync(
            [$this->getRoleIdByName($validated['role'])]
        );

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    protected function getRoleIdByName(string $roleName): int
    {
        return Role::where('name', $roleName)->value('id');
    }

    public function destroy(User $user)
    {
        if ($user->hasRole('admin')) {
            return redirect()->route('users.index')
                ->with('error', 'You cannot delete an admin user.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }
}
