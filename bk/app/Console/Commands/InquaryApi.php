<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use App\Models\Plans;
use App\Models\Products;
use App\Models\Categories;
use App\Models\Subscription;
use App\Models\Inquary;
use App\Models\FailedSubscriptions;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;



class InquaryApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inquary:api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inquary Api Check Inquary Status';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {


        $Inquaries = Inquary::where('status', '0')->get();

         foreach($Inquaries as $Inquary){
            //    dd($inquary->transaction_reference_id);
             $ref_id = $Inquary->transaction_reference_id;

            //  dd($ref_id);
              $response = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->post('https://sandbox.jazzcash.com.pk/ApplicationAPI/API/PaymentInquiry/Inquire', [
                'pp_TxnRefNo' => "63057131424597041",
                'pp_MerchantID' => 'Merc0003',
                'pp_Password' => '0123456789',
                'pp_SecureHash' => 'A72955CD9D7D687CFF4B43BE8EE37E4E88168B388AD0CA30D436798F1BAD44DD'
            ]);

            $res = $response->body();
            dd($res);
          }


        return 0;
    }
}
