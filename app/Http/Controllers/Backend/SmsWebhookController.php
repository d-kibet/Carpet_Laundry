<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SmsLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SmsWebhookController extends Controller
{
    /**
     * Handle SMS delivery reports from Roberms
     *
     * Roberms sends delivery reports to this endpoint when SMS delivery status changes
     */
    public function handleDeliveryReport(Request $request)
    {
        try {
            // Log the incoming webhook data for debugging
            Log::info('Roberms Delivery Report Received', [
                'data' => $request->all()
            ]);

            // Extract delivery report data from Roberms
            // Roberms typically sends: unique_identifier, status, phone_number, delivered_at, error_code, etc.
            $uniqueIdentifier = $request->input('unique_identifier') ?? $request->input('message_id');
            $deliveryStatus = $request->input('status') ?? $request->input('delivery_status');
            $phoneNumber = $request->input('phone_number') ?? $request->input('destination');
            $deliveredAt = $request->input('delivered_at') ?? $request->input('timestamp');
            $networkStatus = $request->input('network_code') ?? $request->input('error_code');
            $errorMessage = $request->input('error_message') ?? $request->input('message');

            // Find the SMS log entry by unique identifier or phone number
            $smsLog = null;

            if ($uniqueIdentifier) {
                $smsLog = SmsLog::where('unique_identifier', $uniqueIdentifier)->first();
            }

            // If not found by identifier, try phone number + recent timestamp
            if (!$smsLog && $phoneNumber) {
                $smsLog = SmsLog::where('phone_number', $phoneNumber)
                    ->whereNull('delivered_at')
                    ->orderBy('created_at', 'desc')
                    ->first();
            }

            if (!$smsLog) {
                Log::warning('SMS Log not found for delivery report', [
                    'unique_identifier' => $uniqueIdentifier,
                    'phone_number' => $phoneNumber
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'SMS log not found'
                ], 404);
            }

            // Map Roberms status to our delivery status
            $mappedStatus = $this->mapDeliveryStatus($deliveryStatus);

            // Update the SMS log with delivery information
            $smsLog->update([
                'delivery_status' => $mappedStatus,
                'network_status' => $networkStatus,
                'delivered_at' => $deliveredAt ? now() : null,
                'delivery_report' => json_encode($request->all()),
            ]);

            // If delivery failed, also update error message
            if (in_array($mappedStatus, ['failed', 'undelivered', 'rejected', 'expired'])) {
                $smsLog->update([
                    'error_message' => $errorMessage ?? 'Delivery failed',
                    'status' => 'failed'
                ]);
            } elseif ($mappedStatus === 'delivered') {
                $smsLog->update([
                    'status' => 'sent'
                ]);
            }

            Log::info('SMS Delivery Status Updated', [
                'id' => $smsLog->id,
                'phone' => $smsLog->phone_number,
                'delivery_status' => $mappedStatus
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Delivery report processed successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Error processing Roberms delivery report', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error processing delivery report'
            ], 500);
        }
    }

    /**
     * Map Roberms delivery status codes to our status codes
     */
    private function mapDeliveryStatus($robermsStatus)
    {
        // Map various Roberms status codes to our standard statuses
        $statusMap = [
            // Successful delivery
            'delivered' => 'delivered',
            'DELIVRD' => 'delivered',
            'success' => 'delivered',
            '0' => 'delivered',

            // Submitted to network
            'submitted' => 'submitted',
            'sent' => 'submitted',
            'ACCEPTD' => 'submitted',
            '1' => 'submitted',

            // Failed delivery
            'failed' => 'failed',
            'UNDELIV' => 'undelivered',
            'undelivered' => 'undelivered',
            '2' => 'failed',

            // Rejected by network
            'rejected' => 'rejected',
            'REJECTD' => 'rejected',
            '3' => 'rejected',

            // Expired
            'expired' => 'expired',
            'EXPIRED' => 'expired',
            '4' => 'expired',

            // Pending
            'pending' => 'pending',
            'PENDING' => 'pending',
        ];

        $status = strtolower(trim($robermsStatus ?? ''));

        return $statusMap[$status] ?? $statusMap[strtoupper($robermsStatus)] ?? 'pending';
    }

    /**
     * Check delivery status for a specific SMS
     * This can be used to manually check status via API call
     */
    public function checkDeliveryStatus($uniqueIdentifier)
    {
        $smsLog = SmsLog::where('unique_identifier', $uniqueIdentifier)->first();

        if (!$smsLog) {
            return response()->json([
                'success' => false,
                'message' => 'SMS not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'unique_identifier' => $smsLog->unique_identifier,
                'phone_number' => $smsLog->phone_number,
                'status' => $smsLog->status,
                'delivery_status' => $smsLog->delivery_status,
                'network_status' => $smsLog->network_status,
                'sent_at' => $smsLog->sent_at,
                'delivered_at' => $smsLog->delivered_at,
                'error_message' => $smsLog->error_message,
            ]
        ]);
    }
}
