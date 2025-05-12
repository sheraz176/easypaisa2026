<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
    use App\Models\CustomerSavingMaster;
    use App\Models\KiborRate;
    use App\Models\Slab;
    use App\Models\DailyReturn;
    use Carbon\Carbon;
    use Illuminate\Support\Facades\DB;

class CalculateDailyProfit implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $customerSavings = CustomerSavingMaster::where('saving_status', 'on-going')
            ->where('maturity_status', 'in-progress')
            ->get();

        // Loop through each customer saving record
        foreach ($customerSavings as $saving) {

            // Get policy rate (from KiborRate table)
            $policyRate = KiborRate::where('effective_date', '<=', Carbon::today())
                ->orderBy('effective_date', 'desc')
                ->first()->kibor_rate;

            // Get slab based on the initial deposit
            $slab = Slab::where('initial_deposit', '<=', $saving->initial_deposit)
                ->where('maximum_deposit', '>=', $saving->initial_deposit)
                ->first();

            if ($slab) {
                // Daily Return Rate based on slab
                $slabRate = $slab->daily_return_rate;
            } else {
                // If no slab found, default return rate can be applied
                $slabRate = 0;
            }

            // Calculate daily profit
            $fundGrowthRate = pow(1 + ($policyRate / 100), 1 / 365) - 1;
            $customerReturnRate = pow(1 + ($slabRate / 100), 1 / 365) - 1; // Assuming slabRate is for customer return
            $efuLifeRate = pow(1 + (1 / 100), 1 / 365) - 1; // Placeholder rate for EFU life rate
            $easypaisaRate = $fundGrowthRate - $customerReturnRate - $efuLifeRate;

            
            $fundGrowthRate = pow(1 + ($policyRate / 100), 1 / 365) - 1;
            $customerReturnRate = pow(1 + ($slabRate / 100), 1 / 365) - 1; // Assuming slabRate is for customer return
            $efuLifeRate = pow(1 + (1 / 100), 1 / 365) - 1; // Placeholder rate for EFU life rate
            $easypaisaRate = $fundGrowthRate - $customerReturnRate - $efuLifeRate;

            // Now calculate % contribution of each in fundGrowthRate
            $totalComponents = $customerReturnRate + $efuLifeRate + $easypaisaRate;

            // Avoid division by zero
            if ($totalComponents != 0) {
                $customerReturnPercent = ($customerReturnRate / $totalComponents) * 100;
                $efuLifePercent = ($efuLifeRate / $totalComponents) * 100;
                $easypaisaPercent = ($easypaisaRate / $totalComponents) * 100;
            } else {
                $customerReturnPercent = $efuLifePercent = $easypaisaPercent = 0;
            }


            // Initialize values
            $cumulativeAmount = $saving->initial_deposit;
            $sumAssured = $cumulativeAmount * 1.25;

            // Initialize result variables
            $results = [];
            $dailyProfit = 0;
            
                $fundGrowthAmount = $cumulativeAmount * $fundGrowthRate;
                $efuLifeReturn = $cumulativeAmount * $efuLifeRate;
                $easypaisaReturn = $cumulativeAmount * $easypaisaRate;
                $customerReturnAmount = $cumulativeAmount * $customerReturnRate;

                // Sum at risk and mortality charge calculations
                $sumAtRisk = max(0, $sumAssured - $cumulativeAmount);
                $mortalityCharge = ($sumAtRisk * 0.8 / 1000) / 365;
                $ptfShare = $mortalityCharge;
                $osfShare = $efuLifeReturn - $mortalityCharge;

                // Calculate the daily profit for the customer
                $dailyProfit = $customerReturnAmount;


            // Prepare data to insert into daily_return table
            $dailyReturnData = [
                'customer_id' => $saving->customer_id,
                'customer_msisdn' => $saving->customer_msisdn,
                'customer_union_id' => $saving->customer_union_id,
                'initial_deposit' => $saving->initial_deposit,
                'fund_growth_amount' => $dailyProfit,  // Assuming no extra fund growth calculation for now
                'saving_status' => 'on-going',
                'saving_start_date' => $saving->saving_start_date,
                'saving_end_date' => $saving->saving_end_date,
                'amount_earned' => $dailyProfit,
                'commulative_amount' => $saving->initial_deposit + $dailyProfit,
                'fund_growth_amount' => $dailyProfit,
                'efu_share' => $dailyProfit * 0.25,  // Placeholder percentage for EFU share
                'easypaisa_share' => $dailyProfit * 0.25, // Placeholder percentage for Easypaisa share
                'customer_share' => $dailyProfit * 0.50,  // Placeholder percentage for customer share
                'sum_assured' => $saving->initial_deposit * 1.25, // Assuming 25% as sum assured
                'sum_at_risk' => max(0, ($saving->initial_deposit * 1.25) - $saving->initial_deposit),
                'mortality_charges' => $dailyProfit * 0.01, // Placeholder mortality charges calculation
                'ptf_share' => $dailyProfit * 0.1, // Placeholder percentage for PTF share
                'osf_share' => $dailyProfit * 0.1, // Placeholder percentage for OSF share
                'type' => 'profit', // For profit type
                'todays_interest_rate' => $slabRate,
                'easypaisa_share_percentage' => $customerReturnPercent, // Placeholder percentage for Easypaisa share
                'efu_share_percentage' => $efuLifePercent, // Placeholder percentage for EFU share
                'customer_share_percentage' => $customerReturnPercent, // Placeholder percentage for customer share
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            // Insert daily return data into the daily_return table
            DailyReturn::create($dailyReturnData);
        }
    }
    
}
