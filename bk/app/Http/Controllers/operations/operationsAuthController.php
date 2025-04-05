<?php

namespace App\Http\Controllers\operations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ControlledUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class operationsAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('operations.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        $operations = ControlledUser::where('username', $request->username)->first();

        if ($operations && $operations->is_active == 0) {
            return redirect()->back()->withInput()->withErrors(['login' => 'Your account is disabled.']);
        }
        if ($operations && $operations->role == "operations") {
            if ($operations && $operations->is_active == 1 && Auth::guard('operations')->attempt($credentials)) {

                $id = $operations->id;
                $operations = Auth::guard('operations')->user();

                $operationsupdate = ControlledUser::find($id);
                $operationsupdate->last_login_at = now();
                $operationsupdate->is_login = "1";
                $operationsupdate->update();

                session(['operations' => $operations]);

                if (auth()->guard('operations')->check()) {
                    return redirect()->route('operations.dashboards');
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

        $operations = session('operations');

        if (!$operations) {

            return redirect()->back()->withInput()->withErrors(['login' => 'Session Expired Kindly Re-login']);
        } else {



            return view('operations.deshboard');
        }
    }
    public function logout(Request $request)
    {
        // dd($request->all());
        $operations = Auth::guard('operations')->user();
        Auth::guard('operations')->logout();
        $operationsupdate = ControlledUser::where('username', $operations->username)->first();
        $operationsupdate->is_login = "0";
        $operationsupdate->update();
        return redirect()->route('operations.login');
    }
}
