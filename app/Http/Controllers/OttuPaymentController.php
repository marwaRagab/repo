<?php

namespace App\Http\Controllers;

ini_set('memory_limit', '600M');

use App\Http\Controllers\Controller;
use App\Models\Installment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class OttuPaymentController extends Controller
{
    public function process($id)
    {
        // Fetch client data from the database
        $clientData = DB::table('installment_clients')->find($id);

        print_r($clientData);exit;

        if (!$clientData) {
            return redirect()->back()->with('error', 'Client not found');
        }

        $customerPhone = $clientData->phone;
        $customerEmail = $clientData->email;
        $amount = $clientData->first_amount;
        $civilId = $clientData->civil_id;
        $orderNum = "#electron" . rand(1, 100000);

        $payload = [
            "amount" => "1",
            "pg_codes" => ["live-pg"],
            "type" => "e_commerce",
            "currency_code" => "KWD",
            "order_no" => $orderNum,
            "customer_email" => $customerEmail,
            "customer_phone" => $customerPhone,
            "customer_id" => $civilId,
            "redirect_url" => "https://electronkw.com/installment/admin",
            "webhook_url" => "https://electronkw.com/payment/webhook",
            "payment_type" => "auto_debit",
            "agreement" => [
                "id" => $civilId,
                "type" => "recurring",
                "amount_variability" => "fixed",
                "start_date" => "2024-07-24",
                "expiry_date" => "2024-07-25",
                "max_amount_per_cycle" => "15",
                "frequency" => "monthly",
                "cycle_interval_days" => "30",
                "total_cycles" => "12",
            ],
        ];

        $response = Http::withHeaders([
            "Content-Type" => "application/json",
            "Authorization" => "Api-Key H7o77wEV.dkZTq2TBPWSgepDIuAD6KNgALqSIFVYY",
        ])->post('https://pay.electronkw.com/b/checkout/v1/pymt-txn/', $payload);

        if ($response->failed()) {
            return redirect()->back()->with('error', 'Payment failed.');
        }

        $data = $response->json();

        if (isset($data['agreement'])) {
            $agreement = $data['agreement'];

            // Insert agreement into 'agreements' table
            $agreementData = [
                'agreement_code' => $agreement['id'],
                'amount_variability' => $agreement['amount_variability'],
                'start_date' => $agreement['start_date'],
                'expiry_date' => $agreement['expiry_date'],
                'max_amount_per_cycle' => $agreement['max_amount_per_cycle'],
                'cycle_interval_days' => $agreement['cycle_interval_days'],
                'total_cycles' => $agreement['total_cycles'],
                'frequency' => $agreement['frequency'],
                'type' => $agreement['type'],
            ];

            $agreementId = DB::table('agreements')->insertGetId($agreementData);

            // Update 'installment_clients' table
            DB::table('installment_clients')->where('id', $id)->update([
                'session_id' => $data['session_id'],
                'agreement_id' => $agreementId,
            ]);

            return redirect()->to($data['checkout_url']);
        }

        if (isset($data['error']) && !empty($data['error'])) {
            return redirect()->back()->with('error', $data['error']);
        }

        return redirect()->to($data['checkout_url']);
    }

    // Webhook method
    public function webhook(Request $request)
    {
        return response('yes', 200);
    }

    // Cron job method
    public function cornJob()
    {
        return response('yes', 200);
    }

    // Success method
    public function success()
    {
        return view('ottu.payment_status');
    }

    public function processInitiating($id)
    {
        // Fetch client data and installment details
        $clientData = DB::table('installment_clients')->find($id);
        $installmentData = DB::table('installment')->where('installment_clients', $id)->first();

        if (!$clientData || !$installmentData) {
            return response()->json(['error' => 'Client or installment data not found'], 404);
        }

        $name = $clientData->name;
        $customerPhone = $clientData->phone;
        $customerEmail = $clientData->email;
        $amount = $installmentData->installment;
        $civilId = $clientData->civil_id;
        $orderNum = "#electron" . rand(1, 100000);

        // Payload for the API request
        $payload = [
            "amount" => "1",
            "pg_codes" => ["live-pg"],
            "type" => "e_commerce",
            "currency_code" => "KWD",
            "order_no" => $orderNum,
            "customer_email" => $customerEmail,
            "customer_phone" => $customerPhone,
            "customer_id" => $civilId,
            "payment_type" => "auto_debit",
            "agreement" => [
                "id" => $civilId,
                "type" => "recurring",
                "amount_variability" => "fixed",
                "start_date" => "2024-07-24",
                "expiry_date" => "2024-07-25",
                "max_amount_per_cycle" => "15",
                "frequency" => "monthly",
                "cycle_interval_days" => "30",
                "total_cycles" => "12",
            ],
        ];

        // Make the API request using Laravel's HTTP client
        $response = Http::withHeaders([
            "Content-Type" => "application/json",
            "Authorization" => "Api-Key H7o77wEV.dkZTq2TBPWSgepDIuAD6KNgALqSIFVYY",
        ])->post('https://pay.electronkw.com/b/checkout/v1/pymt-txn/', $payload);

        // Handle response
        if ($response->failed()) {
            return response()->json(['error' => 'API request failed'], $response->status());
        }

        $data = $response->json();

        if ($response->status() !== 200) {
            // Update session_id in the installment_clients table
            DB::table('installment_clients')->where('id', $id)->update([
                'session_id' => $data['session_id'] ?? null,
            ]);
        }

        return response()->json($data);
    }

    public function getCardDetails($instClientId)
    {
        // Retrieve client data
        $clientData = DB::table('installment_clients')->where('id', $instClientId)->first();

        if (!$clientData) {
            return response()->json(['error' => 'Client not found'], 404);
        }

        $returnSession = $this->processInitiating($instClientId); // Assuming processInitiating is in the same controller
        $civilId = $clientData->civil_id;

        // Prepare API payload
        $payload = [
            "type" => "sandbox",
            "customer_id" => $civilId,
            "pg_codes" => ["live-pg"],
            "agreement_id" => $civilId,
        ];

        // Make the API request using Laravel HTTP client
        $response = Http::withHeaders([
            "Content-Type" => "application/json",
            "Authorization" => "Api-Key H7o77wEV.dkZTq2TBPWSgepDIuAD6KNgALqSIFVYY",
        ])->post('https://pay.electronkw.com/b/checkout/v1/pymt-txn/', $payload);

        if ($response->failed()) {
            return $this->autoDebit($response->json()[0]['token'], $returnSession['session_id']);
        }

        $data = $response->json();
        $httpCode = $response->status();

        if ($httpCode !== 200) {
            return $this->autoDebit($data[0]['token'], $returnSession['session_id']);
        } else {
            if (!is_array($data) || !isset($data[0]['token'])) {
                return redirect()->back()->with('error', 'There was an issue decoding the response.');
            } elseif (isset($data['error']) && !empty($data['error'])) {
                return redirect()->back()->with('error', $data['error']);
            } else {
                return $this->autoDebit($data[0]['token'], $returnSession['session_id']);
            }
        }
    }

    public function autoDebit($token, $session)
    {
        // API request payload
        $payload = [
            "session_id" => $session,
            "token" => $token,
        ];

        // Make the API request using Laravel HTTP client
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Api-Key H7o77wEV.dkZTq2TBPWSgepDIuAD6KNgALqSIFVYY',
        ])->post('https://pay.electronkw.com/b/checkout/v1/pymt-txn/', $payload);

        // Decode the response
        $data['response_1'] = $response->json();

        // Prepare data for the database
        $addData = [
            'amount_details' => $data['response_1']['amount_details'] ?? null,
            'card_acceptance_criteria' => $data['response_1']['card_acceptance_criteria'] ?? null,
            'fee' => $data['response_1']['fee'] ?? null,
            'gateway_account' => $data['response_1']['gateway_account'] ?? null,
            'gateway_name' => $data['response_1']['gateway_name'] ?? null,
            'order_' => $data['response_1']['gateway_response']['order'] ?? null,
            'result' => $data['response_1']['gateway_response']['result'] ?? null,
            'version' => $data['response_1']['gateway_response']['version'] ?? null,
            'merchant' => $data['response_1']['gateway_response']['merchant'] ?? null,
            'response' => $data['response_1']['gateway_response']['response'] ?? null,
            'transaction' => $data['response_1']['gateway_response']['transaction'] ?? null,
            'timeOfRecord' => $data['response_1']['gateway_response']['timeOfRecord'] ?? null,
            'sourceOfFunds' => $data['response_1']['gateway_response']['sourceOfFunds'] ?? null,
            'timeOfLastUpdate' => $data['response_1']['gateway_response']['timeOfLastUpdate'] ?? null,
            'gatewayEntryPoint' => $data['response_1']['gateway_response']['gatewayEntryPoint'] ?? null,
            'authorizationResponse' => $data['response_1']['gateway_response']['authorizationResponse'] ?? null,
            'initiator' => $data['response_1']['initiator'] ?? null,
            'is_sandbox' => $data['response_1']['is_sandbox'] ?? null,
            'order_no' => $data['response_1']['order_no'] ?? null,
            'payment_type' => $data['response_1']['payment_type'] ?? null,
            'pg_params' => $data['response_1']['pg_params'] ?? null,
            'reference_number' => $data['response_1']['reference_number'] ?? null,
            'session_id' => $data['response_1']['session_id'] ?? null,
            'signature' => $data['response_1']['signature'] ?? null,
            'state' => $data['response_1']['state'] ?? null,
            'token' => $data['response_1']['token'] ?? null,
            'all_response' => $data['response_1'] ?? null,
        ];

        // Insert data into the database
        DB::table('ottu_payment')->insert($addData);

        // Check payment result
        if (($data['response_1']['result'] ?? '') === 'success' && ($data['response_1']['state'] ?? '') === 'paid') {
            // Retrieve client and installment data
            $clientData = DB::table('installment_clients')->where('session_id', $session)->first();

            if ($clientData) {
                $installData = DB::table('installment')->where('installment_clients', $clientData->id)->first();

                if ($installData) {
                    // Call a method to process the payment
                    $res = $this->payFromOttu($installData->id);

                    if ($res === 'done') {
                        return view('ottu.payment_status', $data);
                    } else {
                        return response('not paid', 200);
                    }
                }
            }
        }

        return response('Payment failed or data mismatch.', 400);
    }

    public function payFromOttu($installmentId)
    {
        // Retrieve installment item
        $installmentItem = DB::table('installment')->where('id', $installmentId)->first();

        if (!$installmentItem) {
            return response()->json(['error' => 'Installment not found'], 404);
        }

        // Current date
        $time = now();
        $month = $time->format('Y-m-d');
        $sql = "SELECT * FROM installment_months
                WHERE YEAR(FROM_UNIXTIME(date)) = YEAR('$month')
                AND MONTH(FROM_UNIXTIME(date)) = MONTH('$month')
                AND DAY(FROM_UNIXTIME(date)) = DAY('$month')
                AND installment_type != 'first_amount'
                AND status = 'not_done'
                AND installment_id = ?";
        $installmentMonth = DB::select($sql, [$installmentId]);

        if (empty($installmentMonth)) {
            return response()->json(['error' => 'No installment month data found'], 404);
        }

        $installmentMonth = $installmentMonth[0];

        // Update installment months table
        $updateData = [
            'status' => 'done',
            'payment_type' => 'knet',
            'payment_date' => now()->timestamp,
            'hesab_file' => 1,
        ];
        DB::table('installment_months')->where('id', $installmentMonth->id)->update($updateData);

        // If laws are applied, update payment law
        if ($installmentItem->laws == 1) {
            $this->updatePaymentLaw($installmentId, $installmentMonth->amount);
        }

        // If first amount is paid, mark the order as finished
        if ($installmentMonth->installment_type === "first_amount") {
            $order = DB::table('installment')->where('id', $installmentMonth->installment_id)->first();
            if ($order) {
                DB::table('orders')->where('id', $order->order_id)->update(['status' => 'finished']);
            }
        }

        // Add install money entry
        $invoiceUpdate = $this->addInstallMoney($installmentMonth->id, $installmentItem->installment, 'knet', '');

        // Check if all installments are done
        $remainingInstallments = DB::table('installment_months')
            ->where('installment_id', $installmentId)
            ->where('status', 'not_done')
            ->count();

        if ($remainingInstallments === 0) {
            DB::table('installment')->where('id', $installmentId)->update(['finished' => 1]);

            $militaryAffairsItem = DB::table('military_affairs')->where('installment_id', $installmentId)->first();
            if ($militaryAffairsItem) {
                $this->makeMilitaryAffairsFinished($militaryAffairsItem->id);
            }
        }

        // Return result
        if ($invoiceUpdate) {
            return 'done';
        }

        return response()->json(['error' => 'Failed to complete payment process'], 500);
    }
}
