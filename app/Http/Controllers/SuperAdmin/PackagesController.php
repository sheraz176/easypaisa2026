<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Package;
use Illuminate\Support\Facades\Hash;

class PackagesController extends Controller
{
    public function create()
    {
        return view('superadmin.packages.create');
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Package::select('*')->orderBy('created_at', 'desc');
            return Datatables::of($data)->addIndexColumn()
             ->addColumn('action', function($data){
                           return '
                        <a href="#" class="btn-all mr-2">
                           <i class="fa-solid fa-pen-to-square" style="color: #c62a2a;"></i>
                              </a>
                           ';
                    })

                    ->rawColumns(['action'])->make(true);

        }
        return view('superadmin.packages.index');

    }
    public function store(Request $request)
    {
        $request->validate([
            'package_name' => 'required|string|max:255',
            'type' => 'required|in:conventional,islamic',
            'min_duration_days' => 'required|integer|min:1',
            'max_duration_days' => 'required|integer|gte:min_duration_days',
            'duration_breakage_days' => 'nullable|integer',
            'processing_fee' => 'required|numeric|min:0',
        ]);

        Package::create([
            'package_name' => $request->package_name,
            'type' => $request->type,
            'min_duration_days' => $request->min_duration_days,
            'max_duration_days' => $request->max_duration_days,
            'duration_breakage_days' => $request->duration_breakage_days,
            'processing_fee' => $request->processing_fee,
        ]);

        return redirect()->route('superadmin.Packages.index')->with('success', 'Package created successfully.');
    }

}
