<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\KiborRate;
use Illuminate\Support\Facades\Hash;

class KiborRatesController extends Controller
{
    public function create()
    {
        return view('superadmin.KiborRates.create');
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = KiborRate::select('*')->orderBy('created_at', 'desc');
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
        return view('superadmin.KiborRates.index');

    }
    public function store(Request $request)
    {
        $request->validate([
            'effective_date' => 'required|date',
            'kibor_rate' => 'required|numeric',
            'status' => 'required|string|in:Active,Inactive',
        ]);

        KiborRate::create($request->all());

        return redirect()->route('superadmin.KiborRates.index')->with('success', 'KIBOR rate added successfully.');
    }

}
