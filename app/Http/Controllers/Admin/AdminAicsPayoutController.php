<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AicsPayoutHistory;
use App\Models\AicsRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAicsPayoutController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'aics_record_id_payout' => 'required|exists:aics_records,id',
            'aics_family_member_id' => 'nullable|exists:aics_family_members,id',
            'amount' => 'required|numeric|min:1',
            'type' => 'required|string|max:255',
            'claimed_by' => 'required|string|max:255',
        ]);

        $user = Auth::user();

        // Get the AICS record
        $record = AicsRecord::findOrFail($request->aics_record_id_payout);

        // Check if record is eligible
        if ($record->status !== 'Eligible') {
            return response()->json([
                'success' => false,
                'message' => 'This benefeciary is not eligible for payout.',
            ]);
        }

        // Check if payout already exists for this record
        $lastPayout = AicsPayoutHistory::where('aics_record_id_payout', $record->id)
            ->latest()
            ->first();

        if ($lastPayout && $lastPayout->created_at->addMonths(3)->setTimezone('Asia/Manila') > now('Asia/Manila')) {
            $nextPayoutDate = $lastPayout->created_at->addMonths(3)->setTimezone('Asia/Manila');
            $daysRemaining = (int) now('Asia/Manila')->diffInDays($nextPayoutDate);

            return response()->json([
                'success' => false,
                'message' => 'This beneficiary already received a payout.',
                'text' => 'Next payout in ' . $daysRemaining . ' day' . ($daysRemaining > 1 ? 's' : '') . ' (' . $nextPayoutDate->format('F j, Y') . ')',
            ]);
        }

        AicsPayoutHistory::create([
            'aics_record_id_payout' => $request->aics_record_id_payout,
            'amount' => $request->amount,
            'type' => $request->type,
            'claimed_by' => $request->claimed_by,
            'user_id' => $user->id,
            'user_role' => $user->role,
            'user_name' => $user->name,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Payout added successfully.',
        ]);
    }

    public function getData($id)
    {
        $payouts = AicsPayoutHistory::where('aics_record_id_payout',$id)->orderBy('id', 'desc')->get();

        $data = $payouts->map(function ($payout) {
            return [
                'date' => $payout->created_at->format('F j, Y'),
                'amount' => number_format($payout->amount),
                'type' => $payout->type . ' Assistance',
                'claimed_by' => $payout->claimed_by,
            ];
        });

        return response()->json(['data' => $data]);
    }
}