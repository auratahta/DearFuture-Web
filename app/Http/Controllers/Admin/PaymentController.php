<?php
// app/Http/Controllers/Admin/PaymentController.php

// namespace App\Http\Controllers\Admin;

// use App\Http\Controllers\Controller;
// use App\Models\Payment;
// use App\Models\MentoringSession;
// use App\Models\User;
// use Illuminate\Http\Request;
// use Carbon\Carbon;

// class PaymentController extends Controller
// {
//     /**
//      * Display a listing of payments
//      */
//     public function index(Request $request)
//     {
//         $query = Payment::with(['session.student', 'session.mentor', 'session.subject', 'student']);
        
//         // Apply filters
//         if ($request->filled('status')) {
//             $query->where('status', $request->status);
//         }
        
//         if ($request->filled('payment_method')) {
//             $query->where('payment_method', $request->payment_method);
//         }
        
//         if ($request->filled('student_id')) {
//             $query->where('student_id', $request->student_id);
//         }
        
//         if ($request->filled('date_from')) {
//             $query->whereDate('paid_at', '>=', $request->date_from);
//         }
        
//         if ($request->filled('date_to')) {
//             $query->whereDate('paid_at', '<=', $request->date_to);
//         }
        
//         if ($request->filled('search')) {
//             $search = $request->search;
//             $query->where(function($q) use ($search) {
//                 $q->where('payment_code', 'like', "%{$search}%")
//                   ->orWhereHas('student', function($subQ) use ($search) {
//                       $subQ->where('name', 'like', "%{$search}%")
//                            ->orWhere('email', 'like', "%{$search}%");
//                   });
//             });
//         }
        
//         $payments = $query->orderBy('created_at', 'desc')->paginate(15);
        
//         // Get filter options
//         $students = User::students()->orderBy('name')->get();
//         $statuses = [
//             'pending' => 'Pending',
//             'paid' => 'Paid',
//             'failed' => 'Failed',
//             'refunded' => 'Refunded'
//         ];
//         $paymentMethods = [
//             'bank_transfer' => 'Bank Transfer',
//             'e_wallet' => 'E-Wallet',
//             'credit_card' => 'Credit Card',
//             'cash' => 'Cash'
//         ];
        
//         // Get statistics
//         $stats = $this->getPaymentStatistics();
        
//         return view('admin.payments.index', compact(
//             'payments', 'students', 'statuses', 'paymentMethods', 'stats'
//         ));
//     }
    
//     /**
//      * Show payment details
//      */
//     public function show($id)
//     {
//         $payment = Payment::with([
//             'session.student', 'session.mentor', 'session.subject', 'student'
//         ])->findOrFail($id);
        
//         return view('admin.payments.show', compact('payment'));
//     }
    
//     /**
//      * Update payment status
//      */
//     public function updateStatus(Request $request, $id)
//     {
//         $request->validate([
//             'status' => 'required|in:pending,paid,failed,refunded',
//             'notes' => 'nullable|string|max:1000'
//         ]);
        
//         $payment = Payment::findOrFail($id);
//         $oldStatus = $payment->status;
        
//         $updateData = [
//             'status' => $request->status,
//             'provider_response' => array_merge(
//                 $payment->provider_response ?? [],
//                 [
//                     'admin_update' => [
//                         'status' => $request->status,
//                         'notes' => $request->notes,
//                         'updated_by' => auth()->user()->name,
//                         'updated_at' => now()->toISOString()
//                     ]
//                 ]
//             )
//         ];
        
//         // Handle status-specific timestamps
//         if ($request->status === 'paid' && $oldStatus !== 'paid') {
//             $updateData['paid_at'] = now();
//         } elseif ($request->status === 'failed' && $oldStatus !== 'failed') {
//             $updateData['failed_at'] = now();
//         } elseif ($request->status === 'refunded' && $oldStatus !== 'refunded') {
//             $updateData['refunded_at'] = now();
//         }
        
//         $payment->update($updateData);
        
//         // Handle status change logic
//         if ($request->status === 'paid' && $oldStatus !== 'paid') {
//             // Update session status
//             $payment->session->update([
//                 'status' => 'confirmed',
//                 'meeting_link' => $this->generateMeetingLink($payment->session)
//             ]);
            
//         } elseif ($request->status === 'refunded' && $oldStatus !== 'refunded') {
//             $this->processRefund($payment, $request->notes ?? 'Refunded by admin');
            
//         } elseif ($request->status === 'failed') {
//             // Cancel the session if payment failed
//             $payment->session->update([
//                 'status' => 'cancelled',
//                 'cancelled_at' => now(),
//                 'cancellation_reason' => 'Payment failed'
//             ]);
//         }
        
//         return redirect()->back()->with('success', 'Payment status updated successfully.');
//     }
    
//     /**
//      * Process manual refund
//      */
//     public function refund(Request $request, $id)
//     {
//         $request->validate([
//             'refund_reason' => 'required|string|max:500'
//         ]);
        
//         $payment = Payment::findOrFail($id);
        
//         if ($payment->status !== 'paid') {
//             return redirect()->back()->with('error', 'Only paid payments can be refunded.');
//         }
        
//         $this->processRefund($payment, $request->refund_reason);
        
//         return redirect()->back()->with('success', 'Refund processed successfully.');
//     }
    
//     /**
//      * Bulk update payments
//      */
//     public function bulkUpdate(Request $request)
//     {
//         $request->validate([
//             'payment_ids' => 'required|array|min:1',
//             'payment_ids.*' => 'exists:payments,id',
//             'action' => 'required|in:approve,reject,refund'
//         ]);
        
//         $payments = Payment::whereIn('id', $request->payment_ids)->get();
//         $updated = 0;
        
//         foreach ($payments as $payment) {
//             switch ($request->action) {
//                 case 'approve':
//                     if ($payment->status === 'pending') {
//                         $payment->update([
//                             'status' => 'paid',
//                             'paid_at' => now()
//                         ]);
                        
//                         $payment->session->update([
//                             'status' => 'confirmed',
//                             'meeting_link' => $this->generateMeetingLink($payment->session)
//                         ]);
                        
//                         $updated++;
//                     }
//                     break;
                    
//                 case 'reject':
//                     if ($payment->status === 'pending') {
//                         $payment->update([
//                             'status' => 'failed',
//                             'failed_at' => now()
//                         ]);
                        
//                         $payment->session->update([
//                             'status' => 'cancelled',
//                             'cancelled_at' => now(),
//                             'cancellation_reason' => 'Payment rejected'
//                         ]);
                        
//                         $updated++;
//                     }
//                     break;
                    
//                 case 'refund':
//                     if ($payment->status === 'paid') {
//                         $this->processRefund($payment, 'Bulk refund by admin');
//                         $updated++;
//                     }
//                     break;
//             }
//         }
        
//         return redirect()->back()->with('success', "{$updated} payments updated successfully.");
//     }
    
//     /**
//      * Get payment statistics
//      */
//     private function getPaymentStatistics()
//     {
//         $today = Carbon::today();
//         $thisMonth = Carbon::now()->startOfMonth();
//         $lastMonth = Carbon::now()->subMonth()->startOfMonth();
        
//         $totalRevenue = Payment::where('status', 'paid')->sum('amount');
//         $thisMonthRevenue = Payment::where('status', 'paid')
//                                   ->where('paid_at', '>=', $thisMonth)
//                                   ->sum('amount');
//         $lastMonthRevenue = Payment::where('status', 'paid')
//                                   ->whereBetween('paid_at', [$lastMonth, $thisMonth])
//                                   ->sum('amount');
        
//         return [
//             'total_payments' => Payment::count(),
//             'total_revenue' => $totalRevenue,
//             'pending_payments' => Payment::where('status', 'pending')->count(),
//             'pending_amount' => Payment::where('status', 'pending')->sum('amount'),
//             'today_revenue' => Payment::where('status', 'paid')
//                                     ->whereDate('paid_at', $today)
//                                     ->sum('amount'),
//             'this_month_revenue' => $thisMonthRevenue,
//             'last_month_revenue' => $lastMonthRevenue,
//             'revenue_growth' => $lastMonthRevenue > 0 
//                 ? (($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue * 100) 
//                 : 0,
//             'successful_rate' => Payment::count() > 0 
//                 ? (Payment::where('status', 'paid')->count() / Payment::count() * 100) 
//                 : 0,
//             'failed_payments' => Payment::where('status', 'failed')->count(),
//             'refunded_payments' => Payment::where('status', 'refunded')->count(),
//             'this_week_revenue' => Payment::where('status', 'paid')
//                                         ->where('paid_at', '>=', Carbon::now()->startOfWeek())
//                                         ->sum('amount'),
//             'average_payment' => Payment::where('status', 'paid')->avg('amount'),
//         ];
//     }
    
//     /**
//      * Process refund
//      */
//     private function processRefund($payment, $reason)
//     {
//         $payment->update([
//             'status' => 'refunded',
//             'refunded_at' => now(),
//             'notes' => ($payment->notes ? $payment->notes . ' | ' : '') . 'Refund: ' . $reason
//         ]);
        
//         // Update session status
//         $payment->session->update([
//             'status' => 'cancelled',
//             'cancelled_at' => now(),
//             'cancellation_reason' => 'Payment refunded: ' . $reason
//         ]);
//     }
    
//     /**
//      * Generate meeting link
//      */
//     private function generateMeetingLink($session)
//     {
//         // In real implementation, integrate with Zoom/Google Meet API
//         $roomId = 'room_' . str_pad($session->id, 6, '0', STR_PAD_LEFT);
//         return "https://meet.dearfuture.com/join/{$roomId}";
//     }
    
//     /**
//      * Export payments data
//      */
//     public function export(Request $request)
//     {
//         $query = Payment::with(['session.student', 'session.mentor', 'session.subject', 'student']);
        
//         // Apply same filters as index
//         if ($request->filled('status')) {
//             $query->where('status', $request->status);
//         }
        
//         if ($request->filled('date_from')) {
//             $query->whereDate('paid_at', '>=', $request->date_from);
//         }
        
//         if ($request->filled('date_to')) {
//             $query->whereDate('paid_at', '<=', $request->date_to);
//         }
        
//         $payments = $query->orderBy('paid_at', 'desc')->get();
        
//         $filename = 'payments_export_' . date('Y-m-d_H-i-s') . '.csv';
        
//         $headers = [
//             'Content-Type' => 'text/csv',
//             'Content-Disposition' => 'attachment; filename="' . $filename . '"',
//         ];
        
//         $callback = function() use ($payments) {
//             $file = fopen('php://output', 'w');
            
//             // CSV Headers
//             fputcsv($file, [
//                 'Payment Code', 'Student', 'Subject', 'Mentor', 'Amount', 
//                 'Payment Method', 'Status', 'Paid At', 'Provider', 'Phone', 'Created At'
//             ]);
            
//             foreach ($payments as $payment) {
//                 fputcsv($file, [
//                     $payment->payment_code,
//                     $payment->student->name,
//                     $payment->session->subject->name,
//                     $payment->session->mentor->name,
//                     number_format($payment->amount, 2),
//                     ucfirst(str_replace('_', ' ', $payment->payment_method)),
//                     ucfirst($payment->status),
//                     $payment->paid_at ? $payment->paid_at->format('Y-m-d H:i:s') : 'N/A',
//                     $payment->provider ?? 'Manual',
//                     $payment->phone,
//                     $payment->created_at->format('Y-m-d H:i:s')
//                 ]);
//             }
            
//             fclose($file);
//         };
        
//         return response()->stream($callback, 200, $headers);
//     }
// }