@extends('accounts.layouts.app')

@section('title')
    <title>Search Customer || Index</title>
@endsection
@push('styles')
    <!-- Datatable -->
@endpush
@section('content')
    <div class="main-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card stretch stretch-full">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>Search Customer</h4>
                        <div class="dataTables_filter d-flex gap-3 align-items-center">
                            <!-- Larger MSISDN input field -->
                            <input id="msisdn" class="form-control form-control-lg" placeholder="Search by MSISDN"
                                style="width: 250px;">

                            <!-- Red Search Button -->
                            <button type="button" id="searchBtn" class="btn btn-danger btn-lg">Search</button>

                            <!-- Clear Button -->
                            <button type="button" id="clearBtn" class="btn btn-secondary btn-lg">Clear</button>
                        </div>
                    </div>
                    <div class="card-header d-flex justify-content-between align-items-center">

                        <div class="card-body p-0">
                            <div class="table-responsive">

                                <form id="customer-form">
                                    <!-- Customer Details -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="first_name">First Name</label>
                                            <input type="text" id="first_name" class="form-control" disabled>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="last_name">Last Name</label>
                                            <input type="text" id="last_name" class="form-control" disabled>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="user_msisdn">Customer MSISDN</label>
                                            <input type="text" id="user_msisdn" class="form-control" disabled>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="date_of_birth">Date of Birth</label>
                                            <input type="text" id="date_of_birth" class="form-control" disabled>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="gender">Gender</label>
                                            <input type="text" id="gender" class="form-control" disabled>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="cnic">CNIC</label>
                                            <input type="text" id="cnic" class="form-control" disabled>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="mother_name">Mother Name</label>
                                            <input type="text" id="mother_name" class="form-control" disabled>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="father_name">Father Name</label>
                                            <input type="text" id="father_name" class="form-control" disabled>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="email_address">Email Address</label>
                                            <input type="text" id="email_address" class="form-control" disabled>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="address">Address</label>
                                            <input type="text" id="address" class="form-control" disabled>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="province">Province</label>
                                            <input type="text" id="province" class="form-control" disabled>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="city">City</label>
                                            <input type="text" id="city" class="form-control" disabled>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="occupation">Occupation</label>
                                            <input type="text" id="occupation" class="form-control" disabled>
                                        </div>
                                    </div>



                                    <!-- Investment Ledger Saving Data -->
                                    <div id="investment-ledger-data" class="mt-3"></div>

                                    <!-- Insurance Data -->
                                    <div id="insurance-data" class="mt-3"></div>

                                    <!-- Customer Savings Master Data -->
                                    <div id="savings-data" class="mt-3"></div>
                                    <div id="savings-data-two" class="mt-3"></div>

                                    <!-- Beneficiary Data -->
                                    <div id="beneficiary-data" class="mt-3"></div>
                                    <div id="beneficiary-data-two" class="mt-3"></div>

                                    <!-- Daily Return Data -->
                                    <div id="daily-return-data" class="mt-3"></div>

                                    <div id="daily-return-data-two" class="mt-3"></div>



                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <!-- Page Specific Scripts Finish -->
    <script>
        $(document).ready(function() {
            // Search functionality when the MSISDN input field changes
            $('#msisdn').on('input', function() {
                var msisdn = $(this).val();

                if (msisdn.length >= 11) {
                    // Perform the AJAX request to fetch data from the backend
                    $.ajax({
                        url: '{{ route('account.searchCustomer') }}', // Your route to fetch customer data
                        method: 'GET',
                        data: {
                            msisdn: msisdn
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                $('#first_name').val(response.data.first_name);
$('#last_name').val(response.data.last_name);
$('#user_msisdn').val(response.data.user_msisdn);
$('#date_of_birth').val(response.data.date_of_birth);
$('#gender').val(response.data.gender);
$('#cnic').val(response.data.cnic);
$('#mother_name').val(response.data.mother_name);
$('#father_name').val(response.data.father_name);
$('#email_address').val(response.data.email_address);
$('#address').val(response.data.address);
$('#province').val(response.data.province);
$('#city').val(response.data.city);
$('#occupation').val(response.data.occupation);


                                // Investment Ledger Saving Data Table
                                var investmentHtml = `
                                    <h4>Investment Ledger Saving</h4>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Transaction ID</th>
                                                <th>Investment Amount</th>
                                                <th>Transaction Type</th>
                                                <th>Net Amount</th>
                                                <th>Gross Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>`;

                                response.data.investment_ledger_data.forEach(function(record) {
                                    investmentHtml += `
                                        <tr>
                                            <td><input type="text" class="form-control" value="${record.transaction_id}" disabled></td>
                                            <td><input type="text" class="form-control" value="${record.amount}" disabled></td>
                                            <td><input type="text" class="form-control" value="${record.transaction_type}" disabled></td>
                                            <td><input type="text" class="form-control" value="${record.net_amount}" disabled></td>
                                            <td><input type="text" class="form-control" value="${record.gross_amount}" disabled></td>
                                        </tr>
                                    `;
                                });

                                investmentHtml += `</tbody></table>`;
                                $('#investment-ledger-data').html(investmentHtml);

                                // Insurance Data Table
                                var insuranceHtml = `
    <h4>Insurance Data</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Policy Start Date</th>
                <th>Policy End Date</th>
                <th>EFU Life Policy #</th>
                <th>EFU Status</th>
                <th>EFU Data 1</th>
                <th>Active EFU Policy #</th>
            </tr>
        </thead>
        <tbody>`;

response.data.insurance_data.forEach(function(record) {
    // Format dates using JS (assuming backend is sending valid ISO date format)
    var startDate = new Date(record.policy_start_date).toLocaleDateString('en-CA'); // yyyy-mm-dd
    var endDate = new Date(record.policy_end_date).toLocaleDateString('en-CA');

    insuranceHtml += `
        <tr>
            <td><input type="text" class="form-control" value="${startDate}" disabled></td>
            <td><input type="text" class="form-control" value="${endDate}" disabled></td>
            <td><input type="text" class="form-control" value="${record.eful_policy_number}" disabled></td>
            <td><input type="text" class="form-control" value="${record.eful_status}" disabled></td>
            <td><input type="text" class="form-control" value="${record.eful_data1}" disabled></td>
            <td><input type="text" class="form-control" value="${record.active_eful_policy_number}" disabled></td>
        </tr>
    `;
});

insuranceHtml += `</tbody></table>`;
$('#insurance-data').html(insuranceHtml);


                              // Customer Savings Master Data Table
var savingsHtml = `
    <h4>Customer Savings Data</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Initial Deposit</th>
                <th>Plan</th>
                <th>Activated Slab</th>
                <th>Fund Growth Amount</th>
                <th>Saving Status</th>

            </tr>
        </thead>
        <tbody>`;

response.data.savings_data.forEach(function(record) {
    var savingStartDate = new Date(record.saving_start_date).toLocaleDateString('en-CA'); // YYYY-MM-DD
    var savingEndDate = new Date(record.saving_end_date).toLocaleDateString('en-CA');
    var lastProfitDate = new Date(record.last_profit_calculated_at).toLocaleDateString('en-CA');

    savingsHtml += `
        <tr>
            <td><input type="text" class="form-control" value="${record.initial_deposit}" disabled></td>
            <td><input type="text" class="form-control" value="${record.plan}" disabled></td>
            <td><input type="text" class="form-control" value="${record.activated_slab}" disabled></td>
            <td><input type="text" class="form-control" value="${record.fund_growth_amount}" disabled></td>
            <td><input type="text" class="form-control" value="${record.saving_status}" disabled></td>

        </tr>
    `;
});

savingsHtml += `</tbody></table>`;
$('#savings-data').html(savingsHtml);


var savingsHtml = `

    <table class="table table-bordered">
        <thead>
            <tr>

                <th>Saving Start Date</th>
                <th>Saving End Date</th>
                <th>Tenure Days</th>
                <th>Active Days</th>
                <th>Maturity Status</th>
                <th>Last Profit Calculated At</th>
            </tr>
        </thead>
        <tbody>`;

response.data.savings_data.forEach(function(record) {
    var savingStartDate = new Date(record.saving_start_date).toLocaleDateString('en-CA'); // YYYY-MM-DD
    var savingEndDate = new Date(record.saving_end_date).toLocaleDateString('en-CA');
    var lastProfitDate = new Date(record.last_profit_calculated_at).toLocaleDateString('en-CA');

    savingsHtml += `
        <tr>

            <td><input type="text" class="form-control" value="${savingStartDate}" disabled></td>
            <td><input type="text" class="form-control" value="${savingEndDate}" disabled></td>
            <td><input type="text" class="form-control" value="${record.tenure_days}" disabled></td>
            <td><input type="text" class="form-control" value="${record.active_days}" disabled></td>
            <td><input type="text" class="form-control" value="${record.maturity_status}" disabled></td>
            <td><input type="text" class="form-control" value="${lastProfitDate}" disabled></td>
        </tr>
    `;
});

savingsHtml += `</tbody></table>`;
$('#savings-data-two').html(savingsHtml);

                    // Beneficiary Data Table
var beneficiaryHtml = `
    <h4>Beneficiary Data</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nominee Name</th>
                <th>Gender</th>
                <th>Relationship</th>
                <th>Type</th>
                <th>Nationality</th>
                <th>Address</th>
                <th>Date of Birth</th>
                <th>Beneficiary %</th>

            </tr>
        </thead>
        <tbody>`;

response.data.beneficiary_data.forEach(function(record) {
    let dob = record.date_of_birth ? new Date(record.date_of_birth).toLocaleDateString('en-CA') : '';
    let cnicExpiry = record.cnic_expiry_date ? new Date(record.cnic_expiry_date).toLocaleDateString('en-CA') : '';

    beneficiaryHtml += `
        <tr>
            <td><input type="text" class="form-control" value="${record.nominee_name}" disabled></td>
            <td><input type="text" class="form-control" value="${record.gender}" disabled></td>
            <td><input type="text" class="form-control" value="${record.nominee_relationship}" disabled></td>
            <td><input type="text" class="form-control" value="${record.beneficiary_type}" disabled></td>
            <td><input type="text" class="form-control" value="${record.nationality}" disabled></td>
            <td><input type="text" class="form-control" value="${record.address}" disabled></td>
            <td><input type="text" class="form-control" value="${dob}" disabled></td>
            <td><input type="text" class="form-control" value="${record.beneficiary_percentage}" disabled></td>

        </tr>
    `;
});

beneficiaryHtml += `</tbody></table>`;
$('#beneficiary-data').html(beneficiaryHtml);



var beneficiaryHtml = `

    <table class="table table-bordered">
        <thead>
            <tr>

                <th>Contact Number</th>
                <th>CNIC</th>
                <th>CNIC Expiry</th>
                <th>Policy Number</th>
                <th>Bank Name</th>
                <th>Title of Account</th>
                <th>Account Number</th>
                <th>IBAN</th>
                <th>Insurance ID</th>
            </tr>
        </thead>
        <tbody>`;

response.data.beneficiary_data.forEach(function(record) {
    let dob = record.date_of_birth ? new Date(record.date_of_birth).toLocaleDateString('en-CA') : '';
    let cnicExpiry = record.cnic_expiry_date ? new Date(record.cnic_expiry_date).toLocaleDateString('en-CA') : '';

    beneficiaryHtml += `
        <tr>

            <td><input type="text" class="form-control" value="${record.contact_number}" disabled></td>
            <td><input type="text" class="form-control" value="${record.cnic}" disabled></td>
            <td><input type="text" class="form-control" value="${cnicExpiry}" disabled></td>
            <td><input type="text" class="form-control" value="${record.policy_number}" disabled></td>
            <td><input type="text" class="form-control" value="${record.bank_name}" disabled></td>
            <td><input type="text" class="form-control" value="${record.title_of_account}" disabled></td>
            <td><input type="text" class="form-control" value="${record.account_number}" disabled></td>
            <td><input type="text" class="form-control" value="${record.iban}" disabled></td>
            <td><input type="text" class="form-control" value="${record.insurance_id}" disabled></td>
        </tr>
    `;
});

beneficiaryHtml += `</tbody></table>`;
$('#beneficiary-data-two').html(beneficiaryHtml);


                              // Daily Return Data Table
var dailyReturnHtml = `
    <h4>Daily Return Data</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Investment Ledger Saving ID</th>
                <th>Amount Earned</th>
                <th>Commulative Amount</th>
                <th>Fund Growth Amount</th>
                <th>EFU Share</th>
                <th>Easypaisa Share</th>
                <th>Customer Share</th>
                <th>Sum Assured</th>

            </tr>
        </thead>
        <tbody>`;

response.data.daily_return_data.forEach(function(record) {
    dailyReturnHtml += `
        <tr>
            <td><input type="text" class="form-control" value="${record.investment_ledger_saving_id}" disabled></td>
            <td><input type="text" class="form-control" value="${record.amount_earned}" disabled></td>
            <td><input type="text" class="form-control" value="${record.commulative_amount}" disabled></td>
            <td><input type="text" class="form-control" value="${record.fund_growth_amount}" disabled></td>
            <td><input type="text" class="form-control" value="${record.efu_share}" disabled></td>
            <td><input type="text" class="form-control" value="${record.easypaisa_share}" disabled></td>
            <td><input type="text" class="form-control" value="${record.customer_share}" disabled></td>
            <td><input type="text" class="form-control" value="${record.sum_assured}" disabled></td>

        </tr>
    `;
});

dailyReturnHtml += `</tbody></table>`;
$('#daily-return-data').html(dailyReturnHtml);


var dailyReturnHtml = `

    <table class="table table-bordered">
        <thead>
            <tr>

                <th>Sum at Risk</th>
                <th>Mortality Charges</th>
                <th>PTF Share</th>
                <th>OSF Share</th>
                <th>Type</th>
                <th>Today's Interest Rate</th>
                <th>Easypaisa Share %</th>
                <th>EFU Share %</th>
                <th>Customer Share %</th>
            </tr>
        </thead>
        <tbody>`;

response.data.daily_return_data.forEach(function(record) {
    dailyReturnHtml += `
        <tr>

            <td><input type="text" class="form-control" value="${record.sum_at_risk}" disabled></td>
            <td><input type="text" class="form-control" value="${record.mortality_charges}" disabled></td>
            <td><input type="text" class="form-control" value="${record.ptf_share}" disabled></td>
            <td><input type="text" class="form-control" value="${record.osf_share}" disabled></td>
            <td><input type="text" class="form-control" value="${record.type}" disabled></td>
            <td><input type="text" class="form-control" value="${record.todays_interest_rate}" disabled></td>
            <td><input type="text" class="form-control" value="${record.easypaisa_share_percentage}" disabled></td>
            <td><input type="text" class="form-control" value="${record.efu_share_percentage}" disabled></td>
            <td><input type="text" class="form-control" value="${record.customer_share_percentage}" disabled></td>
        </tr>
    `;
});

dailyReturnHtml += `</tbody></table>`;
$('#daily-return-data-two').html(dailyReturnHtml);




                            } else {
                                alert('Customer not found!');
                            }
                        },
                        error: function(error) {
                            console.error('Error fetching customer data:', error);
                        }
                    });
                }
            });
        });
    </script>


    <!-- Global Required Scripts Start -->
    <script src="{{ asset('admin/assets/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery-ui.min.js') }}"></script>

    <script src="{{ asset('admin/assets/js/framework.js') }}"></script>
    <!-- Settings -->
    <script src="{{ asset('admin/assets/js/settings.js') }}"></script>
@endpush
