<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use App\Models\ControlledUser;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function create()
    {
        return view('superadmin.users.create');
    }
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = ControlledUser::select('*')->orderBy('created_at', 'desc');
            return Datatables::of($data)->addIndexColumn()
             ->addColumn('action', function($data){
                           return '
                        <a href="'.route('superadmin.users.edit', $data->id).'" class="btn-all mr-2">
                           <i class="fa-solid fa-pen-to-square" style="color: #c62a2a;"></i>
                              </a>
                           ';
                    })
                    ->addColumn('is_active', function($data) {
                        return $data->is_active == 1 ? 'Active User' : 'In Active User';
                    })
                    ->addColumn('is_login', function($data) {
                        return $data->is_login == 1 ? 'Login User' : 'Logout User';
                    })
                    ->rawColumns(['action','is_active','is_login'])->make(true);

        }
        return view('superadmin.users.index');

    }
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:controlled_users,email',
            'username' => 'required|unique:controlled_users,username',
            'password' => 'required',
            'role' => 'required',
            'phone_number'=> 'required'
        ]);
          $controlled_users   = new ControlledUser();
          $controlled_users->first_name = $request->first_name;
          $controlled_users->last_name = $request->last_name;
          $controlled_users->email = $request->email;
          $controlled_users->username = $request->username;
          $controlled_users->password = Hash::make($request->input('password'));
          $controlled_users->role = $request->role;
          $controlled_users->registration_date = now();
          $controlled_users->is_active = "1";
        if (!empty($request->phone_number)) {
            $controlled_users->phone_number = $request->phone_number;
        }
        if (!empty($request->sales_target)) {
            $controlled_users->sales_target = $request->sales_target;
        }
        $controlled_users->save();

       return redirect()->route('superadmin.index')->with('success','Successfully User Add !');
    }
    public function edit($id)
    {
        $user = ControlledUser::find($id);
        return view('superadmin.users.edit', compact('user'));
    }

    public function update(Request $request)
    {
        // dd($request->all());

        $controlled_users   = ControlledUser::find($request->id);
        $controlled_users->username = $request->username;
        if(!empty($request->password)){
            $controlled_users->password = Hash::make($request->input('password'));
        }
        $controlled_users->role = $request->role;
        $controlled_users->is_active = $request->is_active;
        $controlled_users->update();

       return redirect()->route('superadmin.index')->with('success','Successfully User Updated !');
    }
}
