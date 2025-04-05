<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Company;
use App\Models\Package;
use Illuminate\Support\Facades\Hash;

class CompaniesController extends Controller
{
    public function create()
    {
        $packages = Package::all();
        return view('superadmin.compaines.create',compact('packages'));
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Company::orderBy('created_at', 'desc')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('package_name', function ($row) {
                    // Decode the JSON array from the `package_assigned` field
                    $packageIds = json_decode($row->package_assigned, true);

                    // Fetch package names using the IDs
                    $packages = Package::whereIn('id', $packageIds)->pluck('package_name')->toArray();

                    // Return the package names as a comma-separated string
                    return implode(', ', $packages);
                })
                ->addColumn('action', function ($data) {
                    return '
                        <a href="#" class="btn-all mr-2">
                            <i class="fa-solid fa-pen-to-square" style="color: #c62a2a;"></i>
                        </a>
                    ';
                })
                ->addColumn('created_at', function ($row) {
                    return \Carbon\Carbon::parse($row->created_at)->format('d-M-Y H:i:s');
                })
                ->rawColumns(['action', 'created_at','package_name'])
                ->make(true);
        }

        return view('superadmin.compaines.index');
    }



    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'contact_number' => 'required|string|max:15',
            'registration_number' => 'required|string|unique:companies,registration_number',
            'ntn' => 'required|string|unique:companies,ntn',
            'secp_registration' => 'nullable|string',
            'business_type' => 'required|string',
            'authorized_capital' => 'nullable|numeric',
            'registration_date' => 'required|date',
            'status' => 'required|string',
            'package_assigned' => 'required|array', // Validate as an array
            'package_assigned.*' => 'integer|exists:packages,id', // Each value must be a valid package ID
        ]);

        Company::create([
            'name' => $request->name,
            'address' => $request->address,
            'contact_number' => $request->contact_number,
            'registration_number' => $request->registration_number,
            'ntn' => $request->ntn,
            'secp_registration' => $request->secp_registration,
            'business_type' => $request->business_type,
            'authorized_capital' => $request->authorized_capital,
            'registration_date' => $request->registration_date,
            'is_active' => $request->status === 'active',
            'status' => $request->status,
            'package_assigned' => json_encode($request->package_assigned), // Store as JSON
        ]);

        return redirect()->route('superadmin.compaines.index')->with('success', 'Company created successfully.');
    }


}
