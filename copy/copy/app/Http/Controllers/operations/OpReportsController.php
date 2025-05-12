<?php

namespace App\Http\Controllers\operations;

use App\Http\Controllers\Controller;
use App\Models\Refund;
use App\Models\PdfReport;
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
            $query->whereBetween('created_at', [
                $request->from_date . ' 00:00:00',
                $request->to_date . ' 23:59:59'
            ]);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('user_msisdn', fn($row) => $row->customer->user_msisdn ?? '-')
            ->addColumn('first_name', fn($row) => $row->customer->first_name ?? '-')
            ->addColumn('last_name', fn($row) => $row->customer->last_name ?? '-')
            ->addColumn('email_address', fn($row) => $row->customer->email_address ?? '-')
            ->addColumn('refund_amount', fn($row) => $row->refund_amount)
           ->addColumn('status', function ($row) {
    $badge = match($row->status) {
        'Accepted' => 'bg-success',
        'Rejected' => 'bg-danger',
        default => 'bg-warning'
    };

    // Show time only for Accepted or Rejected
    $time = in_array($row->status, ['Accepted', 'Rejected']) && $row->status_updated_at
        ? '<br><small>' . \Carbon\Carbon::parse($row->status_updated_at)->format('Y-m-d h:i A') . '</small>'
        : '';

    return '<span class="badge ' . $badge . '">' . $row->status . '</span>' . $time;
})
            ->addColumn('created_at', fn($row) => \Carbon\Carbon::parse($row->created_at)->format('Y-m-d H:i:s'))
            ->addColumn('action', function ($row) {
                if ($row->status === 'Under-Process') {
                    return '
                        <div class="d-flex gap-1">
                            <button class="btn btn-sm btn-success accept-btn" data-id="' . $row->id . '">
                                <i class="fas fa-check"></i> Accept
                            </button>
                            <button class="btn btn-sm btn-danger reject-btn" data-id="' . $row->id . '">
                                <i class="fas fa-times"></i> Reject
                            </button>
                            <a href="/easypaisa/public/storage/' . $row->file . '" target="_blank" class="btn btn-sm btn-info">
                                <i class="fas fa-file-pdf"></i> View PDF
                            </a>
                        </div>';
                } else {
                    return '
                        <a href="/easypaisa/public/storage/' . $row->file . '" target="_blank" class="btn btn-sm btn-info">
                            <i class="fas fa-file-pdf"></i> View PDF
                        </a>';
                }
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    return view('operations.RefundCustomer.index');
}


    public function updateRefundStatus(Request $request)
{
    $refund = Refund::findOrFail($request->refund_id);
    $refund->status = $request->status;
     $refund->status_updated_at = now();
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


    public function illustrationReport(Request $request)
    {

        if ($request->ajax()) {
            $query = PdfReport::orderBy('created_at', 'desc');

            if ($request->from_date && $request->to_date) {
                $query->whereBetween('created_at', [$request->from_date . ' 00:00:00', $request->to_date . ' 23:59:59']);
            }



            return Datatables::of($query)
                ->addIndexColumn()

                ->addColumn('name', function ($row) {
                    return $row->name;
                })
                ->addColumn('msisdn', function ($row) {
                    return $row->msisdn;
                })
                ->addColumn('amount', function ($row) {
                    return $row->amount;
                })
                ->addColumn('contribution_term', function ($row) {
                    return $row->contribution_term;
                })
                ->addColumn('sum_covered', function ($row) {
                    return $row->sum_covered;
                })
                ->addColumn('profit_at_9', function ($row) {
                    return $row->profit_at_9;
                })
                ->addColumn('profit_at_13', function ($row) {
                    return $row->profit_at_13;
                })

                ->addColumn('created_at', function ($row) {
                    return \Carbon\Carbon::parse($row->created_at)->format('Y-m-d H:i:s');
                })


                ->rawColumns(['action'])
                ->make(true);
        }


        return view('operations.illustration.index');
    }

    public function exportillustrationReport(Request $request)
    {
        $query = PdfReport::orderBy('created_at', 'desc');

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

        $filename = 'illustrationReport_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        ];

        $callback = function () use ($records) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Name',
                'MSISDN',
                'Amount',
                'Contribution Term',
                'Sum Covered',
                'Profit at 9%',
                'Profit at 13%',
                'Created At',
            ]);

            // CSV rows
            foreach ($records as $row) {
                fputcsv($file, [
                    $row->name ?? '',
                    $row->msisdn ?? '',
                    $row->amount ?? '',
                    $row->contribution_term ?? '',
                    $row->sum_covered ?? '',
                    $row->profit_at_9 ?? '',
                    $row->profit_at_13 ?? '',
                    \Carbon\Carbon::parse($row->created_at)->format('Y-m-d H:i:s'),
                ]);
            }


            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }




}
