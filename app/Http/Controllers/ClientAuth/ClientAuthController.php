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
        $credentials = $request->only('email');
        dd(Auth::guard('client')->check(), Auth::check());
    //    dd(   Auth::guard('client')->check());
        if (Auth::guard('client')->attempt(['email' => $request->email])) {
             dd($request->all());
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/');
    }
}
