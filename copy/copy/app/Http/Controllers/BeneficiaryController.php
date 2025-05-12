<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EasypaisaUser;
use App\Models\Beneficiary;
use App\Models\InsuranceData;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Http; // Import HTTP Client

class BeneficiaryController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        try {
            // Validate input
            $request->validate([
                'open_id' => 'required|string|exists:easypaisa_users,open_id',
                'beneficiary_name' => 'required|string',
                'relationship' => 'required|string',
            ]);

            // Find the Easypaisa user by open_id
            $easypaisaUser = EasypaisaUser::where('open_id', $request->open_id)->first();

            if (!$easypaisaUser) {
                return response()->json(['error' => 'User not found'], 404);
            }

            // Find insurance data
            $insurance = InsuranceData::where('customer_id', $easypaisaUser->id)->first();

            if (!$insurance) {
                return response()->json([
                    'error' => 'No insurance policy found for the user'
                ], 404);
            }

            // Create beneficiary
            $beneficiary = Beneficiary::create([
                'easypaisa_customer_id' => $easypaisaUser->id,
                'nominee_name' => $request->beneficiary_name,
                'nominee_relationship' => $request->relationship,
                'cnic' => $request->cnic ?? null, // Optional CNIC
                'beneficiary_type' => 'Primary',
                'beneficiary_percentage' => 100,
                'policy_number' => $insurance->eful_policy_number,
                'insurance_id' => $insurance->id,
            ]);

            $easypaisaUser->beneficiary = true;
            $easypaisaUser->save(); // Save the update

            // Call EFU Life API
            $efuResponse = Http::withHeaders([
                'Authorization' => 'Bearer XXXXAAA123EPDIGITAKAFUL',
                'channelcode'   => 'EPDIGITAKAFUL',
                'Content-Type' => 'application/json',
            ])->post('https://api.efulife.com/epay/digi/tkf/update/policy/details', [
                'referance_no' => $insurance->eful_policy_number,
                'customer_cnic_issue_date' => now()->format('Y-m-d'), // Dummy issue date
                'beneficiary_name' => $request->beneficiary_name,
                'beneficiary_relation' => 'Q17', // Assuming it is in the correct format
            ]);

            // Check EFU response
            if ($efuResponse->successful()) {
                return response()->json([
                    'message' => 'Beneficiary added successfully and EFU Life API updated',
                    'data' => $beneficiary,
                    'efu_response' => $efuResponse->json()
                ], 201);
            } else {
                return response()->json([
                    'message' => 'Beneficiary added but failed to update EFU Life API',
                    'error' => $efuResponse->body()
                ], 500);
            }

        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation error',
                'details' => $e->errors()
            ], 422);
        } catch (QueryException $e) {
            return response()->json([
                'error' => 'Database error',
                'details' => $e->getMessage()
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Something went wrong',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}
