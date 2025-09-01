<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Template;
use App\Services\DuitkuService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    protected $duitkuService;

    public function __construct(DuitkuService $duitkuService)
    {
        $this->duitkuService = $duitkuService;
    }

    /**
     * Show checkout page
     */
    public function checkout(Template $template)
    {
        return view('payment.checkout', compact('template'));
    }

    /**
     * Create payment invoice
     */
    public function createInvoice(Request $request)
    {
        $request->validate([
            'template_id' => 'required|exists:templates,id',
            'customer_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $template = Template::findOrFail($request->template_id);
            $orderId = 'ORDER-' . time() . '-' . Str::random(6);
            
            // Calculate amount (price - discount)
            $originalPrice = $template->price;
            $discount = $template->discount ?? 0;
            $finalAmount = $originalPrice - ($originalPrice * $discount / 100);

            // Create payment record
            $payment = Payment::create([
                'transaction_id' => $orderId,
                'status' => Payment::STATUS_PENDING,
                'payment_type' => 'duitku',
                'gross_amount' => $finalAmount,
                'currency' => 'IDR',
                'transaction_time' => now(),
                'transaction_status' => 'pending',
                'user_id' => Auth::id(),
                'template_id' => $template->id,
            ]);

            // Prepare data for Duitku
            $duitkuData = [
                'amount' => $finalAmount,
                'order_id' => $orderId,
                'product_details' => $template->name,
                'customer_name' => $request->customer_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'address' => $request->address ?? '',
                'city' => $request->city ?? '',
                'postal_code' => $request->postal_code ?? '',
                'items' => [
                    [
                        'name' => $template->name,
                        'price' => $finalAmount,
                        'quantity' => 1
                    ]
                ]
            ];

            // Create invoice with Duitku
            $result = $this->duitkuService->createInvoice($duitkuData);

            if ($result['success']) {
                $duitkuResponse = $result['data'];
                
                // Update payment with Duitku response
                $payment->update([
                    'payment_code' => $duitkuResponse['reference'] ?? '',
                    'va_number' => $duitkuResponse['vaNumber'] ?? '',
                    'qr_url' => $duitkuResponse['qrString'] ?? '',
                ]);

                DB::commit();

                return response()->json([
                    'success' => true,
                    'payment_id' => $payment->id,
                    'duitku_reference' => $duitkuResponse['reference'],
                    'payment_url' => $duitkuResponse['paymentUrl'] ?? null,
                ]);
            } else {
                DB::rollback();
                return response()->json([
                    'success' => false,
                    'message' => $result['message']
                ], 400);
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Payment creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Payment creation failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle Duitku callback
     */
    public function callback(Request $request)
    {
        Log::info('Duitku Callback Received', $request->all());

        try {
            // Verify callback signature
            if (!$this->duitkuService->verifyCallback($request->all())) {
                Log::error('Invalid callback signature', $request->all());
                return response('Invalid signature', 400);
            }

            $merchantOrderId = $request->merchantOrderId;
            $resultCode = $request->resultCode;
            $amount = $request->amount;
            $statusCode = $request->statusCode;
            $statusMessage = $request->statusMessage;

            // Find payment by transaction_id
            $payment = Payment::where('transaction_id', $merchantOrderId)->first();

            if (!$payment) {
                Log::error('Payment not found', ['order_id' => $merchantOrderId]);
                return response('Payment not found', 404);
            }

            // Update payment status based on result code
            $status = Payment::STATUS_PENDING;
            $transactionStatus = 'pending';

            if ($resultCode == '00') {
                $status = Payment::STATUS_SUCCESS;
                $transactionStatus = 'settlement';
            } elseif ($resultCode == '01') {
                $status = Payment::STATUS_FAILED;
                $transactionStatus = 'failed';
            } elseif ($resultCode == '02') {
                $status = Payment::STATUS_CANCELLED;
                $transactionStatus = 'cancelled';
            }

            $payment->update([
                'status' => $status,
                'transaction_status' => $transactionStatus,
                'status_code' => $statusCode,
                'message' => $statusMessage,
                'settlement_time' => $status === Payment::STATUS_SUCCESS ? now() : null,
            ]);

            Log::info('Payment updated successfully', [
                'payment_id' => $payment->id,
                'status' => $status
            ]);

            return response('OK', 200);
        } catch (\Exception $e) {
            Log::error('Callback processing failed', [
                'error' => $e->getMessage(),
                'request' => $request->all()
            ]);

            return response('Internal Server Error', 500);
        }
    }

    /**
     * Handle return from payment
     */
    public function return(Request $request)
    {
        $merchantOrderId = $request->merchantOrderId;
        $resultCode = $request->resultCode;

        $payment = Payment::where('transaction_id', $merchantOrderId)->first();

        if (!$payment) {
            return redirect()->route('dashboard')->with('error', 'Payment not found');
        }

        if ($resultCode == '00') {
            return redirect()->route('payment.success', $payment->id)
                ->with('success', 'Payment completed successfully!');
        } else {
            return redirect()->route('payment.failed', $payment->id)
                ->with('error', 'Payment failed or was cancelled.');
        }
    }

    /**
     * Show payment success page
     */
    public function success(Payment $payment)
    {
        return view('payment.success', compact('payment'));
    }

    /**
     * Show payment failed page
     */
    public function failed(Payment $payment)
    {
        return view('payment.failed', compact('payment'));
    }

    /**
     * Show payment status
     */
    public function status(Payment $payment)
    {
        return response()->json([
            'payment_id' => $payment->id,
            'status' => $payment->status,
            'transaction_status' => $payment->transaction_status,
            'amount' => $payment->gross_amount,
            'currency' => $payment->currency,
        ]);
    }
}