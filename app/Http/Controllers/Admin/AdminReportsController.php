<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AicsFamilyMember;
use App\Models\AicsPayoutHistory;
use App\Models\AicsRecord;
use App\Models\PwdRecord;
use App\Models\SeniorCitizenRecord;
use App\Models\SeniorFamilyMember;
use App\Models\SoloParentFamilyMember;
use App\Models\SoloParentRecord;
use Illuminate\Http\Request;

class AdminReportsController extends Controller
{
    public function index()
    {
        return view('pages.admin.reports');
    }

    public function print(Request $request, $report)
    {
        $status = $request->query('status');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $data = null;

        if ($report === 'pwd') {
            $data = PwdRecord::query();
        } elseif ($report === 'aics') {
            $data = AicsRecord::query();
        } elseif ($report === 'senior_citizen') {
            $data = SeniorCitizenRecord::query();
        } elseif ($report === 'solo_parent') {
            $data = SoloParentRecord::query();
        } elseif ($report === 'aics_family_member') {
            $data = AicsFamilyMember::with('aicsRecord');
        } elseif ($report === 'senior_citizen_family_member') {
            $data = SeniorFamilyMember::with('seniorCitizenRecord');
        } elseif ($report === 'solo_parent_family_member') {
            $data = SoloParentFamilyMember::with('soloParentRecord');
        } elseif ($report === 'aics_payout') {
            $data = AicsPayoutHistory::with('aicsRecord');
        } else {
            abort(404, 'Report not found.');
        }

        // Apply filters
        if ($status && strtolower($status) !== 'all' && $report !== 'aics_payout') {
            $data->whereRaw('LOWER(REPLACE(status, " ", "_")) = ?', [$status]);
        }
        if ($startDate) {
            $data->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $data->whereDate('created_at', '<=', $endDate);
        }

        $records = $data->get();

        $reportTitle = [
            'pwd' => 'PWD',
            'aics' => 'AICS',
            'senior_citizen' => 'Senior Citizen',
            'solo_parent' => 'Solo Parent',
            'aics_family_member' => 'AICS Family Member',
            'senior_citizen_family_member' => 'Senior Citizen Family Member',
            'solo_parent_family_member' => 'Solo Parent Family Member',
            'aics_payout' => 'AICS Payout History'
        ];

        $title = $reportTitle[$report];

        return view('pages.admin.print_reports', compact('report', 'records', 'title', 'startDate', 'endDate'));
    }
}
