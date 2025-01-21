<?php
namespace App\Http\Controllers\ClientAuth;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;


class ClientAuthController extends Controller
{
    public function showLoginForm()
    {
       dd('zzzzzzzz');
        return view('ClientDashboard.login');
    }

    public function login(Request $request)
    {
        // $client  = Client::where('email', $request->email)->first(); 
        // if ($client) {
        //     Auth::guard('client')->login($client);
        // } else {
        //     // Handle invalid login attempt
        //     return redirect()->back()->withErrors(['email' => 'User not found.']);
        // }  
        $credentials = $request->only('email', 'password');
        // dd(Auth::guard('client')->check(), Auth::check());
       dd(   Auth::guard('client')->check());
        if (Auth::guard('client')->attempt(['email' => $request->email, 'password' => $request->password])) {
             dd($request->all());
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function logout()
    {
        Auth::guard('client')->logout();
        return redirect('/');
    }
}
