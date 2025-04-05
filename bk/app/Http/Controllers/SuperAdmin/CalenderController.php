<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\CalenderManagement;
use Illuminate\Support\Facades\Hash;

class CalenderController extends Controller
{
    public function create()
    {
        return view('superadmin.Calender.create');
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = CalenderManagement::select('*')->orderBy('created_at', 'desc');
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
        return view('superadmin.Calender.index');

    }
    public function store(Request $request)
    {
        $request->validate([
            'holiday_date' => 'required|date',
            'description' => 'required|string|max:255',
        ]);

        CalenderManagement::create($request->all());

        return redirect()->route('superadmin.Calender.index')->with('success', 'Holiday added successfully!');
    }

}
