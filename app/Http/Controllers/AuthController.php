<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login()
    {
        if(Auth::check()){
            return redirect(route('home'));


        }
        return view('login');
    }

    public function registration()
    {
        return view('registration');
    }

    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended(route('home'))->with('success', "Login details are valid");
        }

        return redirect(route('login'))->with('error', "Login details are not valid");
    }

    public function registrationPost(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed', // Ensure password confirmation
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ];

        $user = User::create($data);

        // Debugging - Check if user is created

        // Registration success redirect
        return redirect(route('login'))->with('success', "Registration successful, please log in");
    }

    public function logout()
    {
        Auth::logout();
        return redirect(route('login'))->with('success', "Logged out successfully");
    }
    
}
