<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InsuranceData;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;


class InsuranceDataController extends Controller
{
     
    public function updateActivePolicy(Request $request)
    {
       // return true;
       $validator = Validator::make($request->all(), [
        'reference_id' => 'required|string|exists:insurance_data,eful_policy_number',
        'active_eful_policy_number' => 'required',
    ]);
    
    if ($validator->fails()) {
        return response()->json([
            'status' => 404,
            'message' => $validator->errors()->first() // Get the first validation error
        ], 404);
    }

        // Find the insurance data by eful_policy_number
        $insuranceData = InsuranceData::where('eful_policy_number', $request->reference_id)->first();

        if (!$insuranceData) {
            return response()->json([
                'status' => 404,
                'message' => 'Policy not found'
            ], 404);
        }

        // Update active_eful_policy_number
        $insuranceData->active_eful_policy_number = $request->active_eful_policy_number;
        $insuranceData->save();

        return response()->json([
            'status' => 200,
            'message' => 'Active policy number updated successfully',
            'data' => $insuranceData
        ], 200);
    }
}
