<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EasypaisaUser;
use App\Models\PdfReport;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Refund;
use App\Models\Customer;
use PDF;
use Smalot\PdfParser\Parser;
use PhpOffice\PhpSpreadsheet\IOFactory;



class PDFController extends Controller
{
     public function generate(Request $request)
     {
        // Step 1: Validate the request
        $validated = $request->validate([
             'msisdn' => 'required|string',
             'amount' => 'required|numeric',
             'contribution_term' => 'required|numeric',
         ]);

         // Step 2: Fetch user from EasypaisaUser model
         $user = EasypaisaUser::where('user_msisdn', $validated['msisdn'])->first();

         if (!$user) {
             return response()->json([
                 'status' => false,
                 'message' => 'User not found for the given MSISDN.'
            ], 404);
        }

        // Step 3: Prepare data for PDF
        $data = [
            'name' => $user->first_name . ' ' . $user->last_name,
             'msisdn' => $validated['msisdn'],
          'amount' => $validated['amount'],
            'contribution_term' => $validated['contribution_term'],
            'sum_covered' => $validated['amount'] * 1.25,
             'profit_at_9' => $validated['amount'] * 5,
         'profit_at_13' => $validated['amount'] * 7,
             'dob' => $user->dob ?? 'N/A', // Optional DOB if exists
         ];

         // Step 4: Generate the PDF
         $pdf = PDF::loadView('pdfs.benefit', $data)
             ->setPaper('A4', 'landscape')
             ->setOption('isRemoteEnabled', true)
             ->setOption('isHtml5ParserEnabled', true)
            ->setOption('defaultFont', 'Jameel Noori Nastaleeq');

        // Step 5: Save the PDF to storage
        $filename = 'benefit_' . Str::random(10) . '.pdf';
        $filePath = "public/pdfs/{$filename}";
        Storage::put($filePath, $pdf->output());

        // Step 6: Save record in database
         PdfReport::create([
             'name' => $data['name'],
             'msisdn' => $data['msisdn'],
             'amount' => $data['amount'],
             'contribution_term' => $data['contribution_term'],
             'sum_covered' => $data['sum_covered'],
             'profit_at_9' => $data['profit_at_9'],
             'profit_at_13' => $data['profit_at_13'],
             'pdf_path' => "storage/pdfs/{$filename}",
         ]);

         // Step 7: Return download URL in response
         return response()->json([
            'status' => 'success',
            'download_url' => asset("storage/app/public/pdfs/{$filename}")
         ]);
    }
    
    
     
public function uploadRefundFile(Request $request)
{
    try {
        // Validate the incoming request
        $request->validate([
            'file' => 'required|mimes:pdf|max:10240', // Limit size to 10MB
            'msisdn' => 'required|numeric',
            'refund_amount' => 'required|numeric',
        ]);

        // Check if MSISDN exists in EasypaisaUser
        $user = EasypaisaUser::where('user_msisdn', $request->msisdn)->first();

        if (!$user) {
            return response()->json([
                'message' => 'Easypaisa User not found.',
            ], 404); // 404 Not Found
        }

        // Create a new Refund instance and assign data
        $refund = new Refund();
        $refund->msisdn = $request->msisdn;
        $refund->refund_amount = $request->refund_amount;
         $refund->customer_id = $user->id;

        // Upload the file to the 'public' disk and get its path
        $filePath = $request->file('file')->store('refunds', 'public');

        // Save the file path in the database
        $refund->file = $filePath;
        $refund->save();

        return response()->json([
            'message' => 'File uploaded successfully.',
            'file_path' => Storage::url($refund->file),
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'An error occurred while uploading the file.',
            'error' => $e->getMessage(),
        ], 500);
    }
}

     
    
    
    
}
