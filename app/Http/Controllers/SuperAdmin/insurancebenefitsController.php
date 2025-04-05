<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\InsuranceBenefits;
use Illuminate\Support\Facades\Hash;
use App\Models\Package;

class insurancebenefitsController extends Controller
{
    public function create()
    {
        $packages = Package::all(); // Fetch all packages
        return view('superadmin.insurance_benefits.create', compact('packages'));
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = InsuranceBenefits::with('package')->orderBy('created_at', 'desc')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('package_name', function ($row) {
                    return $row->package->package_name ?? 'N/A'; // Assuming the `Package` model has a `name` column
                })
                ->addColumn('action', function ($row) {
                    return '
                        <a href="#" class="btn-all mr-2">
                            <i class="fa-solid fa-pen-to-square" style="color: #c62a2a;"></i>
                        </a>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('superadmin.insurance_benefits.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'benefit_type' => 'required|in:health,life,accidental,other',
            'benefit_name' => 'required|string|max:255',
            'benefit_description' => 'required|string',
            'amount' => 'required|numeric|min:0',
        ]);

        InsuranceBenefits::create($request->all());

        return redirect()->route('superadmin.insurancebenefits.index')->with('success', 'Insurance benefit added successfully!');
    }
}
