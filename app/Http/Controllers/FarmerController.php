<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class FarmerController extends Controller
{
    public function index()
    {
        return User::where('role', 'farmer')->latest()->paginate(20);
    }
    public function store(Request $r)
    {
        $data = $r->validate([
            'name'     => 'required', 'email'       => 'required|email|unique:users',
            'password' => 'nullable|min:6', 'phone' => 'nullable',
        ]);
        $data['password'] = Hash::make($data['password'] ?? 'Farmer#123');
        $data['role']     = 'farmer';
        return User::create($data);
    }
    public function show(User $user)
    {abort_unless($user->role === 'farmer', 404);return $user;}
    public function update(Request $r, User $user)
    {
        abort_unless($user->role === 'farmer', 404);
        $data = $r->validate([
            'name'     => 'sometimes', 'email'      => ['sometimes', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|min:6', 'phone' => 'nullable',
        ]);
        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);
        return $user;
    }
    public function destroy(User $user)
    {
        abort_unless($user->role === 'farmer', 404);
        $user->delete();
        return response()->noContent();
    }
}
