<?php
namespace App\Http\Controllers\ClientAuth;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;


class ClientAuthController extends Controller
{
    public function showLoginForm()
    {
       
        return view('ClientDashboard.login');
    }

    public function login(Request $request)
    {  
        $credentials = $request->only('email','password');
      
        if (Auth::guard('client')->attempt($credentials)) {
            //  dd($request->all());
            return redirect()->route('client.index');
        }
        // dd($credentials);
        return redirect()->route('client.login')->withErrors(['error' => 'Invalid credentials']);
    }

    public function logout()
    {
        Auth::guard('client')->logout();
        return redirect()->route('client.login');
    }
}
