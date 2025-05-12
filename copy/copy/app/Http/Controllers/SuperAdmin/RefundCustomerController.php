<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\RefundCases;
use App\Models\investmentmaster;
use Illuminate\Support\Facades\Hash;

class RefundCustomerController extends Controller
{
    public function create()
    {
        return view('superadmin.RefundCustomer.create');
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = RefundCases::// Load the related customer via investmentMaster
                orderBy('created_at', 'desc');

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('customer_name', function ($data) {
                    // Access the related customer name via investmentMaster.customer
                    return 'N/A'; // Display 'N/A' if customer is not found
                })
                ->addColumn('action', function ($data) {
                    return '
                        <a href="#" class="btn-all mr-2">
                            <i class="fa-solid fa-pen-to-square" style="color: #c62a2a;"></i>
                        </a>
                    ';
                })
                ->rawColumns(['action','customer_name'])
                ->make(true);
        }

        return view('superadmin.RefundCustomer.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'investment_master_id' => 'required', // Validate if the ID exists in the investment_masters table
            'refund_amount' => 'required|numeric|min:0',
            'refund_request_date' => 'required|date',
            'processing_fee_deducted' => 'required|numeric|min:0',
            'status' => 'required|string|in:pending,processed',
            'type' => 'required|string|in:partial,full',
        ]);

        RefundCases::create($request->all());

        return redirect()->route('superadmin.RefundCustomer.index')->with('success', 'Refund case created successfully.');
    }

}
