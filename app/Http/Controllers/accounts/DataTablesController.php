<?php

namespace App\Http\Controllers\accounts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Beneficiary;
use App\Models\InsuranceData;
use App\Models\InvestmentLedgerSaving;
use App\Models\DailyReturn;
use App\Models\CustomerSavingsMaster;
use App\Models\EasypaisaUser;
use Carbon\Carbon;



class DataTablesController extends Controller
{
    public function InvestmentLedger(Request $request)
    {
        if ($request->ajax()) {
            $query = InvestmentLedgerSaving::with(['customer', 'savings'])->orderBy('created_at', 'desc');

            if ($request->from_date && $request->to_date) {
                $query->whereBetween('created_at', [$request->from_date . ' 00:00:00', $request->to_date . ' 23:59:59']);
            }

            if ($request->search_name) {
                $query->whereHas('customer', function ($q) use ($request) {
                    $q->where('first_name', 'like', '%' . $request->search_name . '%')
                        ->orWhere('last_name', 'like', '%' . $request->search_name . '%');
                });
            }

            return Datatables::of($query)
                ->addIndexColumn()
                ->addColumn('user_msisdn', fn($row) => $row->customer->user_msisdn ?? '-')
                ->addColumn('first_name', fn($row) => $row->customer->first_name ?? '-')
                ->addColumn('last_name', fn($row) => $row->customer->last_name ?? '-')
                ->addColumn('email_address', fn($row) => $row->customer->email_address ?? '-')
                ->addColumn('plan', fn($row) => $row->savings->plan ?? '-')
                ->addColumn('initial_deposit', fn($row) => $row->savings->initial_deposit ?? '-')
                ->addColumn('action', function ($data) {
                    return '<a href="#" class="btn-all mr-2"><i class="fa-solid fa-pen-to-square" style="color: #c62a2a;"></i></a>';
                })
                ->addColumn('date_time', function ($row) {
                    return \Carbon\Carbon::parse($row->date_time)->format('Y-m-d H:i:s');
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('accounts.investmentledger.index');
    }

    public function exportInvestmentLedger(Request $request)
    {
        $query = InvestmentLedgerSaving::with(['customer', 'savings'])->orderBy('created_at', 'desc');

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

        $filename = 'investment_ledger_' . now()->format('Y_m_d_H_i_s') . '.csv';

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
                'Transaction ID',
                'Amount',
                'Type',
                'Net Amount',
                'Gross Amount',
                'Date',
                'Plan',
                'Initial Deposit'
            ]);

            foreach ($records as $row) {
                fputcsv($file, [
                    $row->customer->user_msisdn ?? '',
                    $row->customer->first_name ?? '',
                    $row->customer->last_name ?? '',
                    $row->customer->email_address ?? '',
                    $row->transaction_id,
                    $row->amount,
                    $row->transaction_type,
                    $row->net_amount,
                    $row->gross_amount,
                    $row->date_time,
                    $row->savings->plan ?? '',
                    $row->savings->initial_deposit ?? '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }



    public function InsuranceData(Request $request)
    {
        if ($request->ajax()) {
            $query = InsuranceData::with(['customer', 'savings'])->orderBy('created_at', 'desc');

            if ($request->from_date && $request->to_date) {
                $query->whereBetween('created_at', [$request->from_date . ' 00:00:00', $request->to_date . ' 23:59:59']);
            }

            if ($request->search_name) {
                $query->whereHas('customer', function ($q) use ($request) {
                    $q->where('first_name', 'like', '%' . $request->search_name . '%')
                        ->orWhere('last_name', 'like', '%' . $request->search_name . '%');
                });
            }

            return Datatables::of($query)
                ->addIndexColumn()
                ->addColumn('user_msisdn', fn($row) => $row->customer->user_msisdn ?? '-')
                ->addColumn('first_name', fn($row) => $row->customer->first_name ?? '-')
                ->addColumn('last_name', fn($row) => $row->customer->last_name ?? '-')
                ->addColumn('email_address', fn($row) => $row->customer->email_address ?? '-')
                ->addColumn('plan', fn($row) => $row->savings->plan ?? '-')
                ->addColumn('initial_deposit', fn($row) => $row->savings->initial_deposit ?? '-')
                ->addColumn('action', function ($data) {
                    return '<a href="#" class="btn-all mr-2"><i class="fa-solid fa-pen-to-square" style="color: #c62a2a;"></i></a>';
                })
                ->addColumn('policy_start_date', function ($row) {
                    return \Carbon\Carbon::parse($row->policy_start_date)->format('Y-m-d H:i:s');
                })
                ->addColumn('policy_end_date', function ($row) {
                    return \Carbon\Carbon::parse($row->policy_end_date)->format('Y-m-d H:i:s');
                })
                ->addColumn('created_at', function ($row) {
                    return \Carbon\Carbon::parse($row->created_at)->format('Y-m-d H:i:s');
                })

                ->rawColumns(['action'])
                ->make(true);
        }

        return view('accounts.InsuranceData.index');
    }

    // Controller
    public function exportInsuranceData(Request $request)
    {

        $query = InsuranceData::with(['customer', 'savings'])->orderBy('created_at', 'desc');

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

        $filename = 'insuranceData_' . now()->format('Y_m_d_H_i_s') . '.csv';

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
                'policy start date',
                'policy end date',
                'eful policy number',
                'eful status',
                'eful data1',
                'active eful policy number',
                'Plan',
                'Initial Deposit',
                'date',
            ]);

            foreach ($records as $row) {
                fputcsv($file, [
                    $row->customer->user_msisdn ?? '',
                    $row->customer->first_name ?? '',
                    $row->customer->last_name ?? '',
                    $row->customer->email_address ?? '',
                    $row->policy_start_date,
                    $row->policy_end_date,
                    $row->eful_policy_number,
                    $row->eful_status,
                    $row->eful_data1,
                    $row->active_eful_policy_number,
                    $row->savings->plan ?? '',
                    $row->savings->initial_deposit ?? '',
                    $row->created_at ?? '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function CustomerSavingsMaster(Request $request)
    {

        if ($request->ajax()) {
            $query = CustomerSavingsMaster::with(['customer'])->orderBy('created_at', 'desc');

            if ($request->from_date && $request->to_date) {
                $query->whereBetween('created_at', [$request->from_date . ' 00:00:00', $request->to_date . ' 23:59:59']);
            }

            if ($request->search_name) {
                $query->whereHas('customer', function ($q) use ($request) {
                    $q->where('first_name', 'like', '%' . $request->search_name . '%')
                        ->orWhere('last_name', 'like', '%' . $request->search_name . '%');
                });
            }

            return Datatables::of($query)
                ->addIndexColumn()
                ->addColumn('user_msisdn', fn($row) => $row->customer->user_msisdn ?? '-')
                ->addColumn('first_name', fn($row) => $row->customer->first_name ?? '-')
                ->addColumn('last_name', fn($row) => $row->customer->last_name ?? '-')
                ->addColumn('email_address', fn($row) => $row->customer->email_address ?? '-')
                ->addColumn('plan', fn($row) => $row->plan ?? '-')
                ->addColumn('initial_deposit', fn($row) => $row->initial_deposit ?? '-')
                ->addColumn('action', function ($data) {
                    return '<a href="#" class="btn-all mr-2"><i class="fa-solid fa-pen-to-square" style="color: #c62a2a;"></i></a>';
                })
                ->addColumn('created_at', function ($row) {
                    return \Carbon\Carbon::parse($row->created_at)->format('Y-m-d H:i:s');
                })
                ->addColumn('saving_start_date', function ($row) {
                    return \Carbon\Carbon::parse($row->saving_start_date)->format('Y-m-d H:i:s');
                })
                ->addColumn('saving_end_date', function ($row) {
                    return \Carbon\Carbon::parse($row->saving_end_date)->format('Y-m-d H:i:s');
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('accounts.CustomerSaving.index');
    }

    public function exportCustomerSavingsMaster(Request $request)
    {
        $query = CustomerSavingsMaster::with(['customer'])->orderBy('created_at', 'desc');

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

        $filename = 'CustomerSaving_' . now()->format('Y_m_d_H_i_s') . '.csv';

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
                'customer_msisdn',
                'initial_deposit',
                'plan',
                'activated_slab',
                'fund_growth_amount',
                'saving_status',
                'saving_start_date',
                'saving_end_date',
                'tenure_days',
                'active_days',
                'maturity_status',
                'last_profit_calculated_at',
                'Date'
            ]);

            foreach ($records as $row) {
                fputcsv($file, [
                    $row->customer->user_msisdn ?? '',
                    $row->customer->first_name ?? '',
                    $row->customer->last_name ?? '',
                    $row->customer->email_address ?? '',
                    $row->customer_msisdn,
                    $row->initial_deposit,
                    $row->plan,
                    $row->activated_slab,
                    $row->fund_growth_amount,
                    $row->saving_status,
                    $row->saving_start_date,
                    $row->saving_end_date,
                    $row->tenure_days,
                    $row->active_days,
                    $row->maturity_status,
                    $row->last_profit_calculated_at,

                    $row->created_at,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }


    public function Beneficiary(Request $request)
    {

        if ($request->ajax()) {
            $query = Beneficiary::with(['easypaisaCustomer', 'insurance'])->orderBy('created_at', 'desc');

            if ($request->from_date && $request->to_date) {
                $query->whereBetween('created_at', [$request->from_date . ' 00:00:00', $request->to_date . ' 23:59:59']);
            }

            if ($request->search_name) {
                $query->whereHas('easypaisaCustomer', function ($q) use ($request) {
                    $q->where('first_name', 'like', '%' . $request->search_name . '%')
                        ->orWhere('last_name', 'like', '%' . $request->search_name . '%');
                });
            }

            return Datatables::of($query)
                ->addIndexColumn()
                ->addColumn('user_msisdn', fn($row) => $row->easypaisaCustomer->user_msisdn ?? '-')
                ->addColumn('first_name', fn($row) => $row->easypaisaCustomer->first_name ?? '-')
                ->addColumn('last_name', fn($row) => $row->easypaisaCustomer->last_name ?? '-')
                ->addColumn('email_address', fn($row) => $row->easypaisaCustomer->email_address ?? '-')
                ->addColumn('plan', fn($row) => $row->insurance->savings->plan ?? '-')
                ->addColumn('initial_deposit', fn($row) => $row->insurance->savings->initial_deposit ?? '-')
                ->addColumn('action', function ($data) {
                    return '<a href="#" class="btn-all mr-2"><i class="fa-solid fa-pen-to-square" style="color: #c62a2a;"></i></a>';
                })

                ->addColumn('created_at', function ($row) {
                    return \Carbon\Carbon::parse($row->created_at)->format('Y-m-d H:i:s');
                })

                ->rawColumns(['action'])
                ->make(true);
        }
        return view('accounts.Beneificatial.index');
    }

    public function exportBeneficiaryData(Request $request)
    {

        $query = Beneficiary::with(['easypaisaCustomer', 'insurance'])->orderBy('created_at', 'desc');

        if ($request->from_date && $request->to_date) {
            $query->whereBetween('created_at', [$request->from_date . ' 00:00:00', $request->to_date . ' 23:59:59']);
        }

        if ($request->search_name) {
            $query->whereHas('easypaisaCustomer', function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->search_name . '%')
                    ->orWhere('last_name', 'like', '%' . $request->search_name . '%');
            });
        }

        $records = $query->get();

        $filename = 'beneficiary_' . now()->format('Y_m_d_H_i_s') . '.csv';

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
                'Nominee Name',
                'gender',
                'nominee relationship',
                'beneficiary type',
                'nationality',
                'address',
                'date_of_birth',
                'beneficiary_percentage',
                'contact_number',
                'cnic',
                'cnic_expiry_date',
                'policy_number',
                'bank_name',
                'title_of_account',
                'account_number',
                'iban',
                'Plan',
                'Initial Deposit',
                'date',
            ]);

            foreach ($records as $row) {
                fputcsv($file, [
                    $row->easypaisaCustomer->user_msisdn ?? '',
                    $row->easypaisaCustomer->first_name ?? '',
                    $row->easypaisaCustomer->last_name ?? '',
                    $row->custeasypaisaCustomermer->email_address ?? '',
                    $row->nominee_name,
                    $row->gender,
                    $row->nominee_relationship,
                    $row->beneficiary_type,
                    $row->nationality,
                    $row->address,
                    $row->date_of_birth,
                    $row->beneficiary_percentage,
                    $row->contact_number,
                    $row->cnic,
                    $row->cnic_expiry_date,
                    $row->policy_number,
                    $row->bank_name,
                    $row->title_of_account,
                    $row->account_number,
                    $row->iban,
                    $row->insurance->savings->plan ?? '',
                    $row->insurance->savings->initial_deposit ?? '',
                    $row->created_at ?? '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }




    public function DailyReturn(Request $request)
    {

        if ($request->ajax()) {
            $query = DailyReturn::with(['customer', 'savings','investmentLedgerSaving'])->orderBy('created_at', 'desc');

            if ($request->from_date && $request->to_date) {
                $query->whereBetween('created_at', [$request->from_date . ' 00:00:00', $request->to_date . ' 23:59:59']);
            }

            if ($request->search_name) {
                $query->whereHas('customer', function ($q) use ($request) {
                    $q->where('first_name', 'like', '%' . $request->search_name . '%')
                        ->orWhere('last_name', 'like', '%' . $request->search_name . '%');
                });
            }

            return Datatables::of($query)
                ->addIndexColumn()
                ->addColumn('user_msisdn', fn($row) => $row->customer->user_msisdn ?? '-')
                ->addColumn('first_name', fn($row) => $row->customer->first_name ?? '-')
                ->addColumn('last_name', fn($row) => $row->customer->last_name ?? '-')
                ->addColumn('email_address', fn($row) => $row->customer->email_address ?? '-')
                ->addColumn('plan', fn($row) => $row->savings->plan ?? '-')
                ->addColumn('initial_deposit', fn($row) => $row->savings->initial_deposit ?? '-')

                ->addColumn('transaction_id', fn($row) => $row->investmentLedgerSaving->transaction_id ?? '-')
                ->addColumn('amount', fn($row) => $row->investmentLedgerSaving->amount ?? '-')
                ->addColumn('transaction_type', fn($row) => $row->investmentLedgerSaving->transaction_type ?? '-')
                ->addColumn('date_time', fn($row) => optional($row->investmentLedgerSaving->date_time)->format('Y-m-d H:i:s') ?? '-')
                ->addColumn('net_amount', fn($row) => $row->investmentLedgerSaving->net_amount ?? '-')
                ->addColumn('gross_amount', fn($row) => $row->investmentLedgerSaving->gross_amount ?? '-')




                ->addColumn('action', function ($data) {
                    return '<a href="#" class="btn-all mr-2"><i class="fa-solid fa-pen-to-square" style="color: #c62a2a;"></i></a>';
                })
                ->addColumn('created_at', function ($row) {
                    return \Carbon\Carbon::parse($row->date_time)->format('Y-m-d H:i:s');
                })
                ->rawColumns(['action'])
                ->make(true);
        }


        return view('accounts.DailyReturn.index');
    }

    public function exportDailyReturn(Request $request)
    {
        $query = DailyReturn::with(['customer', 'savings','investmentLedgerSaving'])->orderBy('created_at', 'desc');

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

        $filename = 'DailyReturn_' . now()->format('Y_m_d_H_i_s') . '.csv';

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
                'Plan',
                'Initial Deposit',
                'Transaction ID',
                'Amount',
                'Transaction Type',
                'Date Time',
                'Net Amount',
                'Gross Amount',
                'Amount Earned',
                'Commulative Amount',
                'Fund Growth Amount',
                'EFU Share',
                'Easypaisa Share',
                'Customer Share',
                'Sum Assured',
                'Sum At Risk',
                'Mortality Charges',
                'PTF Share',
                'OSF Share',
                'Type',
                'Today\'s Interest Rate',
                'Easypaisa Share %',
                'EFU Share %',
                'Customer Share %',
                'Created At',
                'Action'
            ]);

            foreach ($records as $row) {
                fputcsv($file, [
                    $row->customer->user_msisdn ?? '',
                    $row->customer->first_name ?? '',
                    $row->customer->last_name ?? '',
                    $row->customer->email_address ?? '',
                    $row->savings->plan ?? '',
                    $row->savings->initial_deposit ?? '',
                    $row->investmentLedgerSaving->transaction_id ?? '',
                    $row->investmentLedgerSaving->amount ?? '',
                    $row->investmentLedgerSaving->transaction_type ?? '',
                    optional($row->investmentLedgerSaving->date_time)->format('Y-m-d H:i:s') ?? '',
                    $row->investmentLedgerSaving->net_amount ?? '',
                    $row->investmentLedgerSaving->gross_amount ?? '',
                    $row->amount_earned ?? '',
                    $row->commulative_amount ?? '',
                    $row->fund_growth_amount ?? '',
                    $row->efu_share ?? '',
                    $row->easypaisa_share ?? '',
                    $row->customer_share ?? '',
                    $row->sum_assured ?? '',
                    $row->sum_at_risk ?? '',
                    $row->mortality_charges ?? '',
                    $row->ptf_share ?? '',
                    $row->osf_share ?? '',
                    $row->type ?? '',
                    $row->todays_interest_rate ?? '',
                    $row->easypaisa_share_percentage ?? '',
                    $row->efu_share_percentage ?? '',
                    $row->customer_share_percentage ?? '',
                    optional($row->created_at)->format('Y-m-d H:i:s') ?? '',
                    $row->action ?? ''
                ]);
            }


            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }


    public function SearchForm(Request $request)
    {

        return view('accounts.Serach.index');


    }

    public function searchCustomer(Request $request)
    {
        $msisdn = $request->input('msisdn');

        // Fetch the customer data by MSISDN
        $customer = EasypaisaUser::where('user_msisdn', $msisdn)->first();

        if ($customer) {
            // Fetch data from related tables (with appropriate relationships)
            $investmentLedgerSavings = InvestmentLedgerSaving::where('customer_id', $customer->id)->get();
            $insuranceData = InsuranceData::where('customer_id', $customer->id)->get();
            $customerSavingsMaster = CustomerSavingsMaster::where('customer_id', $customer->id)->get();
            $beneficiaries = Beneficiary::where('easypaisa_customer_id', $customer->id)->get();
            $dailyReturns = DailyReturn::where('customer_id', $customer->id)->get();

            // Return the data to the frontend
            return response()->json([
                'status' => 'success',
                'data' => [
                    'first_name'        => $customer->first_name,
'last_name'         => $customer->last_name,
'user_msisdn'       => $customer->user_msisdn,
'date_of_birth'  => Carbon::parse($customer->date_of_birth)->format('d-m-Y'),
'gender'            => $customer->gender,
'cnic'              => $customer->cnic,
'mother_name'       => $customer->mother_name,
'father_name'       => $customer->father_name,
'email_address'     => $customer->email_address,
'address'           => $customer->address,
'province'          => $customer->province,
'city'              => $customer->city,
'occupation'        => $customer->occupation,



                    // Investment Ledger Savings
                    'investment_ledger_data' => $investmentLedgerSavings,

                    // Insurance Data
                    'insurance_data' => $insuranceData,

                    // Customer Savings Master Data
                    'savings_data' => $customerSavingsMaster,

                    // Beneficiary Data
                    'beneficiary_data' => $beneficiaries,

                    // Daily Return Data
                    'daily_return_data' => $dailyReturns,
                ]
            ]);
        }

        // If no customer is found
        return response()->json(['status' => 'error', 'message' => 'Customer not found']);
    }




}
