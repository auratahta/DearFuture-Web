<?php
// app/Http/Controllers/Student/PaymentController.php

// namespace App\Http\Controllers\Student;

// use App\Http\Controllers\Controller;
// use App\Models\MentoringSession;
// use App\Models\Payment;
// use App\Services\MidtransService;
// use App\Services\ZoomService;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Log;

// class PaymentController extends Controller
// {
//     protected $midtransService;
//     protected $zoomService;

//     public function __construct(MidtransService $midtransService, ZoomService $zoomService)
//     {
//         $this->midtransService = $midtransService;
//         $this->zoomService = $zoomService;
//     }

//     /**
//      * Show payment page
//      */
//     public function show(MentorSession $session)
//     {
//         // Check authorization
//         if ($session->student_id !== Auth::id()) {
//             abort(403, 'Unauthorized to access this payment.');
//         }

//         if ($session->status !== 'booked') {
//             return redirect()->route('student.sessions.my-sessions')
//                 ->with('error', 'This session is not available for payment.');
//         }

//         $payment = $session->latestPayment;
        
//         if (!$payment || $payment->isExpired()) {
//             return redirect()->route('student.sessions.my-sessions')
//                 ->with('error', 'Payment has expired. Please book the session again.');
//         }

//         return view('student.sessions.payment', compact('session', 'payment'));
//     }

//     /**
//      * Process payment
//      */
//     public function process(Request $request, MentorSession $session)
//     {
//         $request->validate([
//             'payment_method' => 'required|in:bank_transfer,e_wallet,credit_card'
//         ]);

//         // Check authorization
//         if ($session->student_id !== Auth::id()) {
//             abort(403, 'Unauthorized to process this payment.');
//         }

//         $payment = $session->latestPayment;
        
//         if (!$payment || $payment->isExpired()) {
//             return back()->with('error', 'Payment has expired. Please book the session again.');
//         }

//         DB::beginTransaction();
//         try {
//             // Update payment method
//             $payment->update([
//                 'payment_method' => $request->payment_method,
//                 'attempted_at' => now()
//             ]);

//             // Process payment via Midtrans
//             $paymentData = [
//                 'order_id' => $payment->payment_code,
//                 'amount' => $payment->amount,
//                 'customer_details' => [
//                     'first_name' => Auth::user()->name,
//                     'email' => Auth::user()->email,
//                     'phone' => $payment->phone,
//                 ],
//                 'item_details' => [
//                     [
//                         'id' => $session->id,
//                         'price' => $payment->amount,
//                         'quantity' => 1,
//                         'name' => "Mentoring Session - " . $session->subject->name,
//                         'brand' => 'Dear Future',
//                         'category' => 'Education'
//                     ]
//                 ]
//             ];

//             $snapToken = $this->midtransService->createSnapToken($paymentData);

//             if ($snapToken) {
//                 $payment->update([
//                     'provider' => 'midtrans',
//                     'provider_response' => ['snap_token' => $snapToken]
//                 ]);

//                 DB::commit();

//                 return response()->json([
//                     'success' => true,
//                     'snap_token' => $snapToken,
//                     'redirect_url' => route('student.payment.success', $payment)
//                 ]);
//             } else {
//                 throw new \Exception('Failed to create payment token');
//             }

//         } catch (\Exception $e) {
//             DB::rollback();
//             Log::error('Payment processing failed: ' . $e->getMessage());
            
//             return response()->json([
//                 'success' => false,
//                 'message' => 'Payment processing failed. Please try again.'
//             ], 500);
//         }
//     }

//     /**
//      * Payment success page
//      */
//     public function success(Payment $payment)
//     {
//         // Check authorization
//         if ($payment->student_id !== Auth::id()) {
//             abort(403, 'Unauthorized to access this payment.');
//         }

//         $session = $payment->session;
        
//         return view('student.sessions.success', compact('payment', 'session'));
//     }

//     /**
//      * Payment history
//      */
//     public function history()
//     {
//         $payments = Payment::with(['session.subject', 'session.mentor'])
//             ->where('student_id', Auth::id())
//             ->orderBy('created_at', 'desc')
//             ->paginate(10);

//         return view('student.sessions.payment-history', compact('payments'));
//     }

//     /**
//      * Handle Midtrans notification/webhook
//      */
//     public function handleNotification(Request $request)
//     {
//         try {
//             $notification = $this->midtransService->handleNotification($request->all());
            
//             $payment = Payment::where('payment_code', $notification['order_id'])->first();
            
//             if (!$payment) {
//                 Log::error('Payment not found for order_id: ' . $notification['order_id']);
//                 return response()->json(['status' => 'error'], 404);
//             }

//             DB::beginTransaction();

//             // Update payment status based on Midtrans response
//             switch ($notification['transaction_status']) {
//                 case 'capture':
//                 case 'settlement':
//                     $this->handleSuccessfulPayment($payment, $notification);
//                     break;
                    
//                 case 'pending':
//                     $payment->update([
//                         'status' => 'pending',
//                         'provider_transaction_id' => $notification['transaction_id'],
//                         'provider_response' => $notification
//                     ]);
//                     break;
                    
//                 case 'deny':
//                 case 'expire':
//                 case 'cancel':
//                     $this->handleFailedPayment($payment, $notification);
//                     break;
//             }

//             DB::commit();
            
//             return response()->json(['status' => 'success']);

//         } catch (\Exception $e) {
//             DB::rollback();
//             Log::error('Payment notification handling failed: ' . $e->getMessage());
//             return response()->json(['status' => 'error'], 500);
//         }
//     }

//     /**
//      * Handle successful payment
//      */
//     private function handleSuccessfulPayment(Payment $payment, array $notification)
//     {
//         // Update payment
//         $payment->update([
//             'status' => 'paid',
//             'paid_at' => now(),
//             'provider_transaction_id' => $notification['transaction_id'],
//             'provider_response' => $notification
//         ]);

//         // Update session status
//         $session = $payment->session;
//         $session->update(['status' => 'confirmed']);

//         // Generate Zoom meeting link
//         try {
//             $meetingData = [
//                 'topic' => "Mentoring Session - " . $session->subject->name,
//                 'start_time' => $session->date->format('Y-m-d') . 'T' . $session->start_time->format('H:i:s'),
//                 'duration' => $session->getDurationInMinutes(),
//                 'agenda' => "Mentoring session between " . $session->student->name . " and " . $session->mentor->name
//             ];

//             $meetingLink = $this->zoomService->createMeeting($meetingData);
            
//             if ($meetingLink) {
//                 $session->update(['meeting_link' => $meetingLink]);
//             }

//         } catch (\Exception $e) {
//             Log::error('Failed to create Zoom meeting: ' . $e->getMessage());
//             // Don't fail the payment process if Zoom creation fails
//         }

//         // TODO: Send confirmation emails to student and mentor
//         // TODO: Send calendar invites
//     }

//     /**
//      * Handle failed payment
//      */
//     private function handleFailedPayment(Payment $payment, array $notification)
//     {
//         $payment->update([
//             'status' => 'failed',
//             'failed_at' => now(),
//             'provider_transaction_id' => $notification['transaction_id'] ?? null,
//             'provider_response' => $notification
//         ]);

//         // Reset session to available if payment failed
//         $session = $payment->session;
//         $session->update([
//             'student_id' => null,
//             'status' => 'available',
//             'student_notes' => null
//         ]);
//     // }
// }
