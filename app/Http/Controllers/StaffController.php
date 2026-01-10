<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class StaffController extends Controller
{
    public function index()
    {
        $staff = User::where('restaurant_id', Auth::user()->restaurant_id)
            ->where('role', 'staff')
            ->get();
        return view('admin.staff.index', compact('staff'));
    }

    public function create()
    {
        return view('admin.staff.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'restaurant_id' => Auth::user()->restaurant_id,
            'role' => 'staff',
        ]);

        return redirect()->route('staff.index')->with('success', 'Staff account created successfully.');
    }

    public function edit(User $staff)
    {
        $this->authorizeOwner($staff);
        return view('admin.staff.edit', compact('staff'));
    }

    public function update(Request $request, User $staff)
    {
        $this->authorizeOwner($staff);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $staff->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $staff->update($data);

        return redirect()->route('staff.index')->with('success', 'Staff account updated successfully.');
    }

    public function destroy(User $staff)
    {
        $this->authorizeOwner($staff);
        
        if ($staff->id === Auth::id()) {
            return back()->withErrors(['staff' => 'You cannot delete your own account.']);
        }

        $staff->delete();

        return redirect()->route('staff.index')->with('success', 'Staff account deleted successfully.');
    }

    private function authorizeOwner(User $staff)
    {
        if ($staff->restaurant_id !== Auth::user()->restaurant_id || $staff->role !== 'staff') {
            abort(403);
        }
    }
}
