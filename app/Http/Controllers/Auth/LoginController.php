<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Default redirect path after login.
     *
     * @var string
     */
    protected $redirectTo = '/home/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Handle user logout and redirect.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Override authenticated method to control login redirect.
     */
    protected function authenticated(Request $request, $user)
    {
        return redirect('/products');
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user)
        {
            return back()->withErrors([
                'email' => 'No account found with this email.',
            ]);
        }

        if (strtolower($user->primary_role) === "super_admin")
        {
            return back()->withErrors([
                'error' => 'You are not allowed to log in.',
            ]);
        }

        $role = Role::find($user->role_id);

        if (!$role || !$role->status)
        {
            return back()->withErrors([
                'error' => 'Your account is inactive.',
            ]);
        }

        if (Auth::attempt($credentials, $request->filled('remember')))
        {
            $request->session()->regenerate();

            return redirect()->intended('/home/dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials provided.',
        ])->withInput($request->only('email'));
    }
}
