<?php

namespace App\Http\Controllers\accounts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ControlledUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AccountAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('accounts.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        $accounts = ControlledUser::where('username', $request->username)->first();

        if ($accounts && $accounts->is_active == 0) {
            return redirect()->back()->withInput()->withErrors(['login' => 'Your account is disabled.']);
        }
        if ($accounts && $accounts->role == "accounts") {
            if ($accounts && $accounts->is_active == 1 && Auth::guard('accounts')->attempt($credentials)) {

                $id = $accounts->id;
                $accounts = Auth::guard('accounts')->user();

                $accountsupdate = ControlledUser::find($id);
                $accountsupdate->last_login_at = now();
                $accountsupdate->is_login = "1";
                $accountsupdate->update();

                session(['accounts' => $accounts]);

                if (auth()->guard('accounts')->check()) {
                    return redirect()->route('accounts.dashboards');
                }
            } else {
                return redirect()->back()->withInput()->withErrors(['login' => 'Invalid credentials, Kindly Check Your Username & Password, Password is Case Sensitive']);
            }
        } else {
            return redirect()->back()->withInput()->withErrors(['login' => 'Invalid credentials, Kindly Check Your Username & Password, Password is Case Sensitive']);
        }
    }

    public function showDashboard()
    {

        $accounts = session('accounts');

        if (!$accounts) {

            return redirect()->back()->withInput()->withErrors(['login' => 'Session Expired Kindly Re-login']);
        } else {



            return view('accounts.deshboard');
        }
    }
    public function logout(Request $request)
    {
        $accounts = Auth::guard('accounts')->user();
        // dd($request->all());
        Auth::guard('accounts')->logout();
        $accountsupdate = ControlledUser::where('username', $accounts->username)->first();
        $accountsupdate->is_login = "0";
        $accountsupdate->update();
        return redirect()->route('accounts.login');
    }
}
