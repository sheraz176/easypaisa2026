<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use App\Models\Super\SuperAdmin;
use Illuminate\Support\Facades\Hash;

class ManageSuperAdminController extends Controller
{
    public function create()
    {
        return view('superadmin.admincreate.create');
    }
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = SuperAdmin::select('*')->orderBy('created_at', 'desc');
            return Datatables::of($data)->addIndexColumn()
             ->addColumn('action', function($data){
                           return '
                               <a href="#" class="btn-all mr-2">
                           <i class="fa-solid fa-pen-to-square" style="color: #c62a2a;"></i>
                             </a>
                           ';
                    })->rawColumns(['action'])->make(true);
        }
        return view('superadmin.admincreate.index');

    }
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:controlled_users,email',
            'username' => 'required|unique:controlled_users,username',
            'password' => 'required',
        ]);
          $super_admin_users   = new SuperAdmin();
          $super_admin_users->firstname = $request->firstname;
          $super_admin_users->lastname = $request->lastname;
          $super_admin_users->email = $request->email;
          $super_admin_users->username = $request->username;
          $super_admin_users->status = "active";
          $super_admin_users->password = Hash::make($request->input('password'));
          $super_admin_users->save();

       return redirect()->route('superadmin.admincreate.index')->with('success','Successfully Super Admin Add !');
    }
}
