<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\SuperAdmin;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Package;
use App\Models\Slab;
use App\Models\KiborRate;
use App\Models\RefundCases;
use App\Models\CalenderManagement;
use App\Models\InsuranceBenefits;
use App\Models\ControlledUser;


class SuperAdminAuthController extends Controller
{
    protected $redirectTo = '/superadmin/dashboard';

    public function showLoginForm()
    {
        return view('superadmin.login');
    }

    public function login(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::guard('super_admin')->attempt($request->only('username', 'password'))) {

            Log::channel('super_admin_log')->info('Super Admin logged in.', ['username' => $request->username]);

            $Superadmin = Auth::guard('super_admin')->user();

            session(['Superadmin' => $Superadmin]);
            return redirect()->route('superadmin.dashboard');

        }

        return redirect()->back()->withInput()->withErrors(['login' => 'Invalid credentials, Kindly Check Your Username & Password, Password is Case Sensitive']);


    }

    public function showDashboard()
    {


        return view('superadmin.deshboard');
    }
    public function logout()
    {
        Auth::guard('super_admin')->logout();
        Log::channel('super_admin_log')->info('Super Admin log out.');

        return redirect()->route('superadmin.login');
    }

    public function getCounts()
    {
        $data = [
            'packages_count' => Package::count(),
            'slabs_count' => Slab::count(),
            'kibor_rates_count' => KiborRate::count(),
            'refund_cases_count' => RefundCases::count(),
            'holidays_count' => CalenderManagement::count(),
            'insurance_benefits_count' => InsuranceBenefits::count(),
            'accountsUsersCount' => ControlledUser::where('role','accounts')->count(),
            'investmentUsersCount' => ControlledUser::where('role','investment')->count(),
            'operationsUsersCount' => ControlledUser::where('role','operations')->count(),
            'total_users' => ControlledUser::count(),
        ];

        return response()->json($data);
    }


}
