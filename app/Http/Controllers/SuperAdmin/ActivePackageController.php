<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Slab;
use App\Models\InsuranceBenefits;
use App\Models\Company;
use App\Models\KiborRate;


class ActivePackageController extends Controller
{
    public function index()
    {
        $packages = Package::get();
        return view('superadmin.activepackages.index',compact('packages'));
    }

    public function show($id)
    {
        // Fetch the package by id
        $package = Package::findOrFail($id);
        $Slabs = Slab::where('package_id',$package->id)->get();
        $InsuranceBenefit = InsuranceBenefits::where('package_id',$package->id)->get();
        $companies = Company::whereJsonContains('package_assigned', (string) $package->id)->get();

        $KiborRate = KiborRate::latest()->first();


        // dd($companies);
        // Return the package

        return view('superadmin.activepackages.show', compact('package','Slabs','InsuranceBenefit','companies','KiborRate'));
    }

}
