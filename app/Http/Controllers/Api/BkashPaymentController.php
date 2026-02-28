<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Karim007\LaravelBkashTokenize\Facade\BkashPaymentTokenize;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BkashPaymentController extends Controller
{
    public function createPayment(Request $request, $amount, $id)
    {
        try {
            Log::info('Create Payment - Start', ['amount' => $amount, 'id' => $id]);
            
            // Generate a unique token for this payment
            $paymentToken = Str::random(32);
            
            // Create payment_sessions table if not exists
            try {
                DB::table('payment_sessions')->insert([
                    'token' => $paymentToken,
                    'offense_id' => $id,
                    'amount' => $amount,
                    'created_at' => now(),
                    'expires_at' => now()->addHours(1)
                ]);
            } catch (\Exception $e) {
                Log::error('Payment session table error:', ['error' => $e->getMessage()]);
                // If table doesn't exist, we'll use session as fallback
                session()->put('payment_token', $paymentToken);
                session()->put('offense_id', $id);
            }
            
            $inv = 'INV' . time() . rand(100, 999);
            
            // Use full URL for callback with token
            $callbackURL = url('/api/bkash/callback?token=' . $paymentToken);
            
            $paymentData = [
                'mode' => '0011',
                'payerReference' => $inv,
                'callbackURL' => $callbackURL,
                'amount' => (string)$amount,
                'currency' => 'BDT',
                'intent' => 'sale',
                'merchantInvoiceNumber' => $inv
            ];

            Log::info('Payment Data:', $paymentData);

            $response = BkashPaymentTokenize::cPayment(json_encode($paymentData));
            
            Log::info('bKash Response:', $response);

            if (isset($response['bkashURL'])) {
                return response()->json([
                    'success' => true,
                    'bkashURL' => $response['bkashURL'],
                    'paymentID' => $response['paymentID'] ?? null
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => $response['statusMessage'] ?? 'Payment creation failed'
            ], 400);
            
        } catch (\Exception $e) {
            Log::error('Payment Error:', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

   public function callBack(Request $request)
    {
        Log::info('Callback Received - Full Data:', $request->all());

        try {
            $paymentID = $request->paymentID;
            $status = $request->status;
            $token = $request->token;
            
            Log::info('Processing Callback:', [
                'paymentID' => $paymentID,
                'status' => $status,
                'token' => $token
            ]);

            // First execute the payment
            $executeResponse = BkashPaymentTokenize::executePayment($paymentID);
            Log::info('Execute Payment Response:', $executeResponse);
            
            // If execute fails, try query payment
            if (!$executeResponse || (isset($executeResponse['statusCode']) && $executeResponse['statusCode'] != '0000')) {
                $executeResponse = BkashPaymentTokenize::queryPayment($paymentID);
                Log::info('Query Payment Response:', $executeResponse);
            }

            // Check if payment was successful
            if (isset($executeResponse['statusCode']) && $executeResponse['statusCode'] == '0000' && 
                isset($executeResponse['transactionStatus']) && $executeResponse['transactionStatus'] == 'Completed') {
                
                $trxID = $executeResponse['trxID'];
                Log::info('Payment Successful - TrxID: ' . $trxID);
                
                // Get offense_id from token
                $offense_id = null;
                
                // Try to get from payment_sessions table
                try {
                    $paymentSession = DB::table('payment_sessions')
                        ->where('token', $token)
                        ->first();
                    
                    if ($paymentSession) {
                        $offense_id = $paymentSession->offense_id;
                        Log::info('Found offense_id from payment_sessions: ' . $offense_id);
                        
                        // Update offense_list
                        $updateResult = DB::table('offense_list')
                            ->where('id', $offense_id)
                            ->update([
                                'status' => 'paid',
                                'transaction_id' => $trxID,
                                'updated_at' => now()
                            ]);
                        
                        Log::info('Database Update Result:', [
                            'affected_rows' => $updateResult,
                            'offense_id' => $offense_id,
                            'trxID' => $trxID
                        ]);
                        
                        // Delete the session
                        DB::table('payment_sessions')->where('token', $token)->delete();
                        
                        // Return success response
                        return $this->paymentResponse('success', [
                            'trxID' => $trxID,
                            'message' => 'Payment successful'
                        ]);
                    } else {
                        Log::error('Payment session not found for token: ' . $token);
                        
                        // Try session as fallback
                        if (session()->has('offense_id')) {
                            $offense_id = session()->get('offense_id');
                            Log::info('Found offense_id from session: ' . $offense_id);
                            
                            DB::table('offense_list')
                                ->where('id', $offense_id)
                                ->update([
                                    'status' => 'paid',
                                    'transaction_id' => $trxID,
                                    'updated_at' => now()
                                ]);
                            
                            session()->forget('offense_id');
                            
                            return $this->paymentResponse('success', [
                                'trxID' => $trxID,
                                'message' => 'Payment successful'
                            ]);
                        }
                    }
                } catch (\Exception $e) {
                    Log::error('Database Error:', ['error' => $e->getMessage()]);
                }
            } else {
                $errorMsg = $executeResponse['statusMessage'] ?? 'Payment execution failed';
                Log::error('Payment execution failed:', ['error' => $errorMsg]);
            }

            // If we reach here, payment failed
            return $this->paymentResponse('failed', [
                'message' => $executeResponse['statusMessage'] ?? 'Payment failed'
            ]);

        } catch (\Exception $e) {
            Log::error('Callback Exception:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return $this->paymentResponse('error', [
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
        private function paymentResponse($status, $data = [])
    {
        $html = '<!DOCTYPE html>
        <html>
        <head>
            <title>Payment Status</title>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <style>
                * { margin: 0; padding: 0; box-sizing: border-box; }
                body { 
                    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; 
                    background: #f5f5f5;
                    min-height: 100vh;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                }
                .container { 
                    max-width: 400px; 
                    width: 90%;
                    margin: 20px; 
                    padding: 30px 20px; 
                    background: white;
                    border-radius: 16px;
                    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
                    text-align: center;
                }
                .icon { font-size: 64px; margin-bottom: 20px; }
                .success { color: #28a745; }
                .failed, .cancelled, .error { color: #dc3545; }
                h2 { margin-bottom: 15px; font-size: 24px; }
                .message {
                    color: #666;
                    margin: 15px 0;
                    padding: 15px;
                    background: #f8f9fa;
                    border-radius: 8px;
                }
                .trxid {
                    background: #e8f4fd;
                    color: #0066cc;
                    padding: 12px;
                    border-radius: 8px;
                    font-size: 14px;
                    word-break: break-all;
                    margin: 15px 0;
                }
                button {
                    background: #E2136E;
                    color: white;
                    border: none;
                    padding: 15px 30px;
                    border-radius: 8px;
                    font-size: 16px;
                    font-weight: 600;
                    cursor: pointer;
                    width: 100%;
                    margin-top: 20px;
                }
                button:hover { background: #c00e5c; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="icon">' . ($status == 'success' ? '✅' : '❌') . '</div>
                <h2 class="' . $status . '">Payment ' . ucfirst($status) . '</h2>';
        
        if (isset($data['trxID']) && !empty($data['trxID'])) {
            $html .= '<div class="trxid">Transaction ID: ' . $data['trxID'] . '</div>';
        }
        
        $html .= '<div class="message">' . ($data['message'] ?? '') . '</div>
                
                <button onclick="sendToFlutter()" id="returnBtn">
                    Return to App
                </button>
            </div>
            
            <script>
                function sendToFlutter() {
                    var data = {
                        status: "' . $status . '",
                        trxID: "' . ($data['trxID'] ?? '') . '",
                        message: "' . ($data['message'] ?? '') . '"
                    };
                    
                    console.log("Sending to Flutter:", data);
                    
                    // Try all possible channels
                    if (window.FlutterChannel) {
                        window.FlutterChannel.postMessage(JSON.stringify(data));
                    }
                    
                    if (window.ReactNativeWebView) {
                        window.ReactNativeWebView.postMessage(JSON.stringify(data));
                    }
                    
                    // Close after sending
                    setTimeout(function() {
                        window.close();
                    }, 1000);
                }
                
                // Auto send after 2 seconds
                setTimeout(sendToFlutter, 2000);
            </script>
        </body>
        </html>';
        
        return response($html);
    }
}