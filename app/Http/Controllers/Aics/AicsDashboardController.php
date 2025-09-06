<?php

namespace App\Http\Controllers\Aics;

use App\Http\Controllers\Controller;
use App\Models\AicsRecord;

class AicsDashboardController extends Controller
{
    public function index()
    {
        return view('pages.aics.dashboard');
    }

    public function fetch()
    {
        $total_beneficiaries = AicsRecord::count();

        $total_beneficiaries_age_8_to_16 = AicsRecord::whereBetween('age', [8, 16])->count();

        $total_beneficiaries_age_17_to_30 = AicsRecord::whereBetween('age', [17, 30])->count();

        $age_31_above_total  = AicsRecord::where('age', '>=', 31)->count();

        $bangkal  = AicsRecord::where('barangay', 'Bangkal')->count();

        $calaylayan  = AicsRecord::where('barangay', 'Calaylayan')->count();

        $capitangan  = AicsRecord::where('barangay', 'Capitangan')->count();

        $gabon  = AicsRecord::where('barangay', 'Gabon')->count();

        $laon  = AicsRecord::where('barangay', 'Laon')->count();

        $mabatang  = AicsRecord::where('barangay', 'Mabatang')->count();

        $omboy  = AicsRecord::where('barangay', 'Omboy')->count();

        $salian  = AicsRecord::where('barangay', 'Salian')->count();

        $wawa  = AicsRecord::where('barangay', 'Wawa')->count();

        $statuses = ['Eligible', 'In Progress', 'Expired', 'Not Eligible'];

        $overall_status = [];

        foreach ($statuses as $status) {
            $overall_status[$status] = AicsRecord::where('status', $status)->count();
        }

        return response()->json( [
            'total_beneficiaries' => $total_beneficiaries,
            'total_beneficiaries_age_8_to_16' => $total_beneficiaries_age_8_to_16,
            'total_beneficiaries_age_17_to_30' => $total_beneficiaries_age_17_to_30,
            'age_31_above_total' => $age_31_above_total,
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