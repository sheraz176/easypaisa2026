<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Slab;
use Illuminate\Support\Facades\Hash;
use App\Models\Package;

class SlabsController extends Controller
{
    public function create()
    {
        $packages = Package::all();
        return view('superadmin.Slabs.create', compact('packages'));
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Slab::with('package')->orderBy('created_at', 'desc')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('package_name', function ($data) {
                    return $data->package->package_name ?? 'N/A';
                })
                ->addColumn('action', function ($data) {
                    return '
                    <a href="#" class="btn-all mr-2">
                        <i class="fa-solid fa-pen-to-square" style="color: #c62a2a;"></i>
                    </a>
                ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('superadmin.Slabs.index');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'slab_name' => 'required|string|max:255',
            'initial_deposit' => 'required|numeric',
            'maximum_deposit' => 'required|numeric',
            'daily_return_rate' => 'required|numeric',
        ]);

        Slab::create($request->all());

        return redirect()->route('superadmin.Slabs.index')->with('success', 'Slab created successfully.');
    }

  public function SlabsApi(Request $request)
{
    try {
        $data = Slab::with('package')->orderBy('created_at', 'asc')->get(); // Oldest first

        // Format data to include package_name and add comma separators
        $formattedData = $data->map(function ($slab) {
            return [
                'id' => $slab->id,
                'slab_name' => $slab->slab_name,
                'initial_deposit' => number_format($slab->initial_deposit), // Add commas
                'maximum_deposit' => number_format($slab->maximum_deposit),
                'daily_return_rate' => rtrim(rtrim($slab->daily_return_rate, '0'), '.'), // Remove .00 if exists
                'created_at' => $slab->created_at,
                'package_name' => $slab->package ? $slab->package->package_name : 'N/A',
            ];
        });

        return response()->json([
            'status' => true,
            'data' => $formattedData
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Something went wrong!',
            'error' => $e->getMessage()
        ], 500);
    }
}




}
