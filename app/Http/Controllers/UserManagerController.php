<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $currentUser = auth()->user();
        $users = User::with('role')->where('business_id', $currentUser->business_id)
            ->where('email', '<>', 'admin@mybusiness.com');
        $roles = Role::with('users')->where('business_id', $currentUser->business_id);
        $busAdmin = User::where('isBusinessAccount', true)
            ->where('business_id', $currentUser->business_id)
            ->first();
        if (!session('impersonator_id'))
        {
            $users =  $users->where('isBusinessAccount', false);
            if ($busAdmin)
            {
                $roles = $roles->where('id', '<>', $busAdmin->role_id);
            }
        }
        $users = $users->paginate(10);
        $roles = $roles->paginate(10);
        return view('users.index', compact('users', 'roles'));
    }
    public function addUser()
    {
        $businessId = Auth()->user()->business_id;
        return view('users.addUser', ['id' => $businessId]);
    }
    public function storeUser(Request $request, $id)
    {
        $request->validate([
            'role_id' => 'required|integer|exists:roles,id',
            'email' => 'required|string|email|unique:users,email',
            'name' => 'required|string|max:255',
            'password' => 'required|string|confirmed'
        ]);
        $role = Role::findorFail($request->role_id);
        $primary_role = strtolower(auth()->user()->primary_role);
        $role_cat = $primary_role === 'super_admin' ? 'super_admin' : $role->role_category;

        User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'business_id' => $id,
            'name' => $request->name,
            'role_id' => $request->role_id,
            'primary_role' => $role_cat
        ]);
        return redirect()->route('users.index')->with('status', 'User created successfully');
    }
    public function addRole()
    {
        return view('Users.addRole');
    }
    public function storeRole(Request $request)
    {
        $currentUser = Auth()->user();
        $request->validate([
            'name' => 'required|string|max:255',
            'role_category' => 'required|in:customer,staff'
        ]);
        $exists = Role::where('business_id', $currentUser->business_id)
            ->where('name', $request->name)->first();
        if ($exists)
            return back()->withErrors('A role by the same name exists');
        Role::create([
            'business_id' => $currentUser->business_id,
            'name' => $request->name,
            'status' => ($request->status ?? false),
            'role_category' => $request->role_category
        ]);
        return redirect()->route('users.index')->with('status', 'Role created successfully');
    }
    public function editUser($id)
    {
        $user = User::findorFail($id);
        return view('users.editUser', compact('user'));
    }
    public function editRole($id)
    {
        $role = Role::findorFail($id);
        return view('users.editRole', compact('role'));
    }
    public function updateUser(Request $request, int $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($id),
            ],
            'role_id' => 'required|exists:roles,id',
            'password' => 'nullable|string|min:8|confirmed'
        ]);
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id
        ];
        $role = Role::findOrFail($request->role_id);
        $userData['primary_role'] = $role->name;
        if ($request->filled('password'))
            $userData['password'] = bcrypt($request->password);
        $user->update($userData);
        return redirect()->route('users.index')->with('status', 'User updated successfully');
    }
    public function updateRole(Request $request, int $id)
    {
        $role = Role::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255'
        ]);
        $role->name = $request->name;
        $role->status = $request->status;
        $role->save();
        return redirect()->route('users.index')->with('status', 'Role updated successfully');
    }
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('status', 'User deleted successfully');
    }
    public function deleteRole($id)
    {
        $role = Role::with('users')->firstOrFail();
        if ($role->users())
            return back()->withErrors('This role has been assigned to users.');
        $role->delete();
        return redirect()->route('users.index')->with('status', 'User deleted successfully');
    }
}
