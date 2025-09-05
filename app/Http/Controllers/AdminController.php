<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['loginView', 'login']);
    }
    public function loginView()
    {
        return view('admin.login');
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user)
        {
            return back()->withErrors([
                'email' => 'No account found with this email.',
            ]);
        }

        $role = Role::find($user->role_id);
        if ($role && !$role->status)
        {
            return back()->withErrors([
                'status' => 'Your account has been deactivated.',
            ]);
        }

        if (Auth::attempt($credentials))
        {
            request()->session()->regenerate();

            if (strtolower($user->primary_role) === 'super_admin')
            {
                return redirect('/admin/dashboard');
            }

            return redirect('/products');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }

    public function dashboard()
    {
        $businessCount = Business::where('email', '<>', 'admin@mybusiness.com')->count();
        return view('admin.dashboard', compact('businessCount'));
    }
    public function business()
    {
        $user = auth()->user();

        $query = Business::query();

        if (strtolower($user->primary_role) !== "super_admin")
        {
            $query->where('id', $user->business_id);
        }

        $businesses = $query->where('email', '<>', 'admin@mybusiness.com')->paginate(10);

        return view('admin.business', compact('businesses'));
    }
    public function editBusiness(int $id)
    {
        $business = Business::findOrFail($id);

        return view('admin.editBusiness', compact('business'));
    }

    public function updateBusiness(Request $request, int $id)
    {
        $business = Business::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:businesses,email,' . $id,
            'logofile' => 'nullable|file|mimes:jpeg,png,jfif|max:2048',
            'domain' => 'required|string|max:255',
        ]);
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'domain' => $request->domain,
        ];

        if ($request->hasFile('logofile'))
        {
            $file = $request->file('logofile');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('logos', $file, $fileName);
            $data['logo'] = $fileName;
        }

        $business->update($data);

        return redirect()->route('admin.business')
            ->with('success', 'Business updated successfully!');
    }
    public function deleteBusiness(int $id)
    {
        $business = Business::findOrFail($id);

        if ($business->logo && Storage::disk('public')->exists('logos/' . $business->logo))
        {
            Storage::disk('public')->delete('logos/' . $business->logo);
        }

        $business->delete();

        return redirect()->route('admin.business')
            ->with('success', 'Business deleted successfully!');
    }
    public function newBusiness()
    {
        return view('admin.newBusiness');
    }
    public function AddBusiness(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:businesses,email',
            'logofile' => 'nullable|file|mimes:jpeg,png,jfif|max:2048',
            'domain' => 'required|string|max:255',
            'initials' => 'required|string|max:255'
        ]);
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'domain' => $request->domain,
            'initials' => $request->initials,
        ];

        if ($request->hasFile('logofile'))
        {
            $file = $request->file('logofile');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('logos', $file, $fileName);
            $data['logo'] = $fileName;
        }

        DB::transaction(function () use ($request, $data)
        {
            $newBusiness = Business::create($data);

            $roleData = [
                'business_id' => $newBusiness->id,
                'name' => 'Admin ' . $request->initials,
                'status' => true,
                'role_category' => 'staff'
            ];
            $newRole = Role::create($roleData);

            $userData = [
                'role_id' => $newRole->id,
                'email' => $request->email,
                'business_id' => $newBusiness->id,
                'name' => $request->initials . ' Admin',
                'primary_role' => 'Admin',
                'password' => bcrypt(Str::random(12)),
                'isBusinessAccount' => true
            ];

            User::create($userData);
        });


        return redirect()->route('admin.business')
            ->with('success', 'Business added successfully!');
    }
    public function startImpersonate(int $id)
    {
        $business = Business::findOrFail($id);

        $targetUser = User::where('email', $business->email)->firstOrFail();

        if (strtolower(Auth::user()->primary_role) !== "super_admin")
        {
            return redirect()->back()->withErrors(['error' => 'You are not authorised']);
        }

        session(['impersonator_id' => Auth::id()]);

        Auth::login($targetUser);

        return redirect('/home/dashboard')->with('status', 'Now impersonating ' . $targetUser->name);
    }

    public function stopImpersonate()
    {
        if (!session()->has('impersonator_id'))
        {
            return redirect()->back()->withErrors(['error' => 'You are not impersonating anyone']);
        }

        $originalId = session('impersonator_id');
        $originalUser = User::findOrFail($originalId);

        session()->forget('impersonator_id');

        Auth::login($originalUser);

        return redirect('/admin/dashboard')->with('success', 'Returned to your account');
    }
    public function passwordReset(int $id)
    {
        return view('admin.passwordReset', ['id' => $id]);
    }

    public function resetPassword(Request $request, int $id)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $business = Business::findOrFail($id);
        $user = User::where('email', $business->email)->firstOrFail();

        $user->password = bcrypt($request->password);
        $user->save();

        return redirect('/admin/business')->with('success', 'Password reset successfully');
    }
}
