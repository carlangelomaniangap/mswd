<?php

namespace App\Http\Controllers\Senior_Citizen;

use App\Http\Controllers\Controller;
use App\Models\SeniorCitizenRecord;

class SeniorCitizenDashboardController extends Controller
{
    public function index()
    {
        return view('pages.senior_citizen.dashboard');
    }

    public function fetch()
    {
        $total_beneficiaries = SeniorCitizenRecord::count();

        $total_beneficiaries_age_60_to_69 = SeniorCitizenRecord::whereBetween('age', [60, 69])->count();

        $total_beneficiaries_age_79_to_80 = SeniorCitizenRecord::whereBetween('age', [70, 80])->count();

        $age_81_above_total  = SeniorCitizenRecord::where('age', '>=', 81)->count();

        $bangkal  = SeniorCitizenRecord::where('barangay', 'Bangkal')->count();

        $calaylayan  = SeniorCitizenRecord::where('barangay', 'Calaylayan')->count();

        $capitangan  = SeniorCitizenRecord::where('barangay', 'Capitangan')->count();

        $gabon  = SeniorCitizenRecord::where('barangay', 'Gabon')->count();

        $laon  = SeniorCitizenRecord::where('barangay', 'Laon')->count();

        $mabatang  = SeniorCitizenRecord::where('barangay', 'Mabatang')->count();

        $omboy  = SeniorCitizenRecord::where('barangay', 'Omboy')->count();

        $salian  = SeniorCitizenRecord::where('barangay', 'Salian')->count();

        $wawa  = SeniorCitizenRecord::where('barangay', 'Wawa')->count();

        $statuses = ['Eligible', 'In Progress', 'Expired', 'Not Eligible'];

        $overall_status = [];

        foreach ($statuses as $status) {
            $overall_status[$status] = SeniorCitizenRecord::where('status', $status)->count();
        }

        return response()->json( [
            'total_beneficiaries' => $total_beneficiaries,
            'total_beneficiaries_age_60_to_69' => $total_beneficiaries_age_60_to_69,
            'total_beneficiaries_age_79_to_80' => $total_beneficiaries_age_79_to_80,
            'age_81_above_total' => $age_81_above_total,
            'bangkal' => $bangkal,
            'calaylayan' => $calaylayan,
            'capitangan' => $capitangan,
            'gabon' => $gabon,
            'laon' => $laon,
            'mabatang' => $mabatang,
            'omboy' => $omboy,
            'salian' => $salian,
            'wawa' => $wawa,
            'overall_status' => $overall_status
        ]);
    }
}