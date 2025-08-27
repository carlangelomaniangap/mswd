<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AicsBurialRequirement;
use App\Models\AicsMedicalRequirement;
use App\Models\AicsRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAicsRequirementsController extends Controller
{
    public function update(Request $request, $id)
    {
        $validated = $request->all();
        $user = Auth::user();

        $models = [
            AicsMedicalRequirement::class,
            AicsBurialRequirement::class,
        ];

        $columns = [
            AicsMedicalRequirement::class => [
                'letter_to_the_mayor',
                'medical_certificate',
                'laboratory_or_prescription',
                'barangay_indigency',
                'valid_id',
                'cedula',
                'barangay_certificate_or_marriage_contract',
            ],
            AicsBurialRequirement::class => [
                'letter_to_the_mayor',
                'death_certificate',
                'funeral_contract',
                'barangay_indigency',
                'valid_id',
                'cedula',
                'barangay_certificate_or_marriage_contract',
            ],
        ];

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

        $allRequirements = [];

        foreach ($models as $model) {
            $requirements = $model::where('aics_record_id', $id)->get();

            foreach ($requirements as $requirement) {
                foreach ($columns[$model] as $col) {
                    if (isset($validated[$col])) {
                        $status = $validated[$col];

                        if ($requirement->{$col} !== $status) {
                            $requirement->{$col} = $status;
                            $requirement->{$col . '_updated_at'} = now();

                            $expiresCol = $col . '_expires_at';
                            if ($status === 'Complete') {
                                $requirement->{$expiresCol} = now()->addMonths(3);
                            } else {
                                $requirement->{$expiresCol} = null;
                            }
                        }
                    }
                }

                $requirement->user_id = $user->id;
                $requirement->user_role = $user->role;
                $requirement->user_name = $user->name;
                $requirement->save();

                // Prepare expiration info for response
                $requirementArray = ['nature_of_problem' => $requirement->nature_of_problem];
                foreach ($columns[$model] as $col) {
                    $requirementArray[$col] = $requirement->{$col};
                    $requirementArray[$col . '_expires_at'] = $getExpirationInfo($requirement->{$col}, $requirement->{$col . '_expires_at'});
                }

                $allRequirements[] = $requirementArray;
            }
        }

        $record = AicsRecord::findOrFail($id);

        if ($record->nature_of_problem === 'Medical') {
            $requirement = $record->aicsmedicalRequirement;
            $values = array_map('trim', [
                $requirement->letter_to_the_mayor,
                $requirement->medical_certificate,
                $requirement->laboratory_or_prescription,
                $requirement->barangay_indigency,
                $requirement->valid_id,
                $requirement->cedula,
                $requirement->barangay_certificate_or_marriage_contract,
            ]);
        } elseif ($record->nature_of_problem === 'Burial') {
            $requirement = $record->aicsburialRequirement;
            $values = array_map('trim', [
                $requirement->letter_to_the_mayor,
                $requirement->death_certificate,
                $requirement->funeral_contract,
                $requirement->barangay_indigency,
                $requirement->valid_id,
                $requirement->cedula,
                $requirement->barangay_certificate_or_marriage_contract,
            ]);
        }

        if (!in_array('Incomplete', $values, true) && !in_array('Renewal', $values, true) && !in_array('Denied', $values, true)) {
            $status = 'Eligible';
        } elseif (in_array('Incomplete', $values, true)) {
            $status = 'In Progress';
        } elseif (in_array('Renewal', $values, true)) {
            $status = 'Expired';
        } elseif (in_array('Denied', $values, true)) {
            $status = 'Not Eligible';
        }

        $record->status = $status;
        $record->save();

        return response()->json([
            'success' => true,
            'message' => 'Requirements updated successfully.',
            'requirements' => $allRequirements,
            'status' => $status
        ]);
    }
}