<?php

namespace App\Http\Controllers\investment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ControlledUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class investmentAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('investment.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        $investment = ControlledUser::where('username', $request->username)->first();

        if ($investment && $investment->is_active == 0) {
            return redirect()->back()->withInput()->withErrors(['login' => 'Your account is disabled.']);
        }
        if ($investment && $investment->role == "investment") {
            if ($investment && $investment->is_active == 1 && Auth::guard('investment')->attempt($credentials)) {

                $id = $investment->id;
                $investment = Auth::guard('investment')->user();

                $investmentupdate = ControlledUser::find($id);
                $investmentupdate->last_login_at = now();
                $investmentupdate->is_login = "1";
                $investmentupdate->update();

                session(['investment' => $investment]);

                if (auth()->guard('investment')->check()) {
                    return redirect()->route('investment.dashboards');
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

        $investment = session('investment');

        if (!$investment) {

            return redirect()->back()->withInput()->withErrors(['login' => 'Session Expired Kindly Re-login']);
        } else {



            return view('investment.deshboard');
        }
    }
    public function logout(Request $request)
    {
        // dd($request->all());
        $investment = Auth::guard('investment')->user();
        Auth::guard('investment')->logout();
        $investmentupdate = ControlledUser::where('username', $investment->username)->first();
        $investmentupdate->is_login = "0";
        $investmentupdate->update();
        return redirect()->route('investment.login');
    }
}
