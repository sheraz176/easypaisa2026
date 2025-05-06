<?php

namespace App\Http\Controllers\operations;

use App\Http\Controllers\Controller;
use App\Models\Refund;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OpReportsController extends Controller
{


    public function RefundReport(Request $request)
    {

        if ($request->ajax()) {
            $query = Refund::with(['customer', 'savings'])->orderBy('created_at', 'desc');

            if ($request->from_date && $request->to_date) {
                $query->whereBetween('created_at', [$request->from_date . ' 00:00:00', $request->to_date . ' 23:59:59']);
            }



            return Datatables::of($query)
                ->addIndexColumn()
                ->addColumn('user_msisdn', fn($row) => $row->customer->user_msisdn ?? '-')
                ->addColumn('first_name', fn($row) => $row->customer->first_name ?? '-')
                ->addColumn('last_name', fn($row) => $row->customer->last_name ?? '-')
                ->addColumn('email_address', fn($row) => $row->customer->email_address ?? '-')


                ->addColumn('action', function ($data) {
                    return '<a href="#" class="btn-all mr-2"><i class="fa-solid fa-pen-to-square" style="color: #c62a2a;"></i></a>';
                })

                ->addColumn('refund_amount', function ($row) {
                    return $row->refund_amount;
                })

                ->addColumn('status', function ($row) {
                    return $row->status;
                })

                ->addColumn('created_at', function ($row) {
                    return \Carbon\Carbon::parse($row->created_at)->format('Y-m-d H:i:s');
                })


                ->rawColumns(['action'])
                ->make(true);
        }


        return view('operations.RefundCustomer.index');
    }


    public function updateRefundStatus(Request $request)
{
    $refund = Refund::findOrFail($request->refund_id);
    $refund->status = $request->status;
    $refund->save();

    return response()->json(['message' => 'Status updated']);
}

public function viewRefundPdf ($id)
{
    $refund = Refund::findOrFail($id);

    if (!$refund->file || !Storage::disk('public')->exists($refund->file)) {
        abort(404, 'File not found.');
    }

    $filePath = storage_path('app/public/' . $refund->file);
    return response()->file($filePath);
}

    public function exportRefundReport(Request $request)
    {
        $query = Refund::with(['customer'])->orderBy('created_at', 'desc');

        if ($request->from_date && $request->to_date) {
            $query->whereBetween('created_at', [$request->from_date . ' 00:00:00', $request->to_date . ' 23:59:59']);
        }

        if ($request->search_name) {
            $query->whereHas('customer', function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->search_name . '%')
                    ->orWhere('last_name', 'like', '%' . $request->search_name . '%');
            });
        }

        $records = $query->get();

        $filename = 'RefundCustomers_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        ];

        $callback = function () use ($records) {
            $file = fopen('php://output', 'w');

            // CSV header
            fputcsv($file, [
                'MSISDN',
                'First Name',
                'Last Name',
                'Email',

                'Refund Amount',
                'Status',

                'Date Time',

            ]);

            foreach ($records as $row) {
                fputcsv($file, [
                    $row->customer->user_msisdn ?? '',
                    $row->customer->first_name ?? '',
                    $row->customer->last_name ?? '',
                    $row->customer->email_address ?? '',

                    $row->refund_amount ?? '',
                    $row->status ?? '',

                    optional($row->created_at)->format('Y-m-d H:i:s') ?? '',

                ]);
            }


            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
