<?php

namespace App\Http\Controllers\Senior_Citizen;

use App\Http\Controllers\Controller;
use App\Models\SeniorRequirement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeniorRequirementsController extends Controller
{
    public function update(Request $request, $id) {

        // Validate incoming request for specific allowed values only.
        $validated = $request->validate([
            'valid_id' => 'nullable|in:Complete,Incomplete,Renewal,Denied',
            'birth_certificate' => 'nullable|in:Complete,Incomplete,Renewal,Denied',
            'barangay_certificate' => 'nullable|in:Complete,Incomplete,Renewal,Denied',
        ]);

        // Fetch all SeniorRequirement records linked to the given Senior Citizen record ID.
        $requirements = SeniorRequirement::where('senior_record_id', $id)->get();

        // Get the authenticated user's information.
        $user = Auth::user();

        // Define the columns that need to be processed.
        $columns = ['valid_id', 'birth_certificate', 'barangay_certificate'];

         // Loop through each requirement record.
        foreach ($requirements as $requirement) {
            foreach ($columns as $column) {
                if (array_key_exists($column, $validated)) {
                    $status = $validated[$column];

                    // Check if the value is different before updating
                    if ($requirement->{$column} !== $status) {
                        $requirement->{$column} = $status;
                        $requirement->{$column . '_updated_at'} = now();

                        if ($status === 'Complete') {
                            $currentExpiration = $requirement->{$column . '_expires_at'};
                            $requirement->{$column . '_expires_at'} = ($currentExpiration && $currentExpiration > now())
                                ? now()->parse($currentExpiration)->addMonths(3)
                                : now()->addMonths(3);
                        } else {
                            $requirement->{$column . '_expires_at'} = null;
                        }
                    }
                }
            }

            $requirement->user_id = $user->id;
            $requirement->user_role = $user->role;
            $requirement->user_name = $user->name;
            $requirement->save();
        }

        $now = now()->setTimezone('Asia/Manila');

        $getExpirationInfo = function ($status, $expiresAt) use ($now) {

            // If status is "Incomplete", it's still in progress
            if ($status === 'Incomplete') {
                return "In Progress";
            }

            // If status is "Denied", it's not eligible
            if ($status === 'Denied') {
                return "Not Eligible";
            }

            // Convert expiration date to timestamp
            $expiresDate = strtotime($expiresAt);
            // Get current time as timestamp
            $nowDate = $now->timestamp;

            // Get how many seconds have passed since expiration
            $diffInSeconds = $nowDate - $expiresDate;

            // If already expired
            if ($diffInSeconds > 0) {
                // Get full days since it expired
                $daysOverdue = floor($diffInSeconds / (60 * 60 * 24)); // Calculate days overdue
                // Get full hours after days are removed
                $hoursOverdue = floor(($diffInSeconds % (60 * 60 * 24)) / (60 * 60)); // Calculate remaining hours

                // Return days if overdue by at least 1 day
                if ($daysOverdue > 0) {
                    return "Expired: More than {$daysOverdue} " . ($daysOverdue == 1 ? 'day' : 'days') . " in renewal";
                }

                // Return hours if overdue by at least 1 hour
                if ($hoursOverdue > 0) {
                    return "Expired: More than {$hoursOverdue} " . ($hoursOverdue == 1 ? 'hour' : 'hours') . " in renewal";
                }

                // Get full minutes after hours are removed
                $minutesOverdue = floor(($diffInSeconds % (60 * 60)) / 60);

                // Return minutes if overdue by at least 1 minute
                if ($minutesOverdue > 0) {
                    return "Expired: More than {$minutesOverdue} minute" . ($minutesOverdue == 1 ? '' : 's') . " in renewal";
                }

                // If overdue by less than 1 minute
                return "Expired: Less than a minute ago";
            };

            // If status is "Complete"
            if ($status === 'Complete') {
                // Get date 3 months before expiration
                $updatedDate = strtotime("-3 months", $expiresDate);
                return "Last updated: " . date('F j, Y', $updatedDate);
            }

            // If status is "Renewal"
            if ($status === 'Renewal') {
                return "Expired: " . date('F j, Y', $expiresDate);
            }
        };

        return response()->json([
            'success' => true,
            'message' => 'Requirements updated successfully.',
            'requirement' => [
                'valid_id_expires_at' => $getExpirationInfo($requirement->valid_id, $requirement->valid_id_expires_at, $requirement->valid_id_updated_at),
                'birth_certificate_expires_at' => $getExpirationInfo($requirement->birth_certificate, $requirement->birth_certificate_expires_at, $requirement->birth_certificate_updated_at),
                'barangay_certificate_expires_at' => $getExpirationInfo($requirement->barangay_certificate, $requirement->barangay_certificate_expires_at, $requirement->barangay_certificate_updated_at),
            ]
        ]);
    }
}