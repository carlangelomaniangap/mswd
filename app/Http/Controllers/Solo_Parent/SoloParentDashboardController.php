<?php

namespace App\Http\Controllers\Solo_Parent;

use App\Http\Controllers\Controller;
use App\Models\SoloParentRecord;

class SoloParentDashboardController extends Controller
{
    public function index()
    {
        return view('pages.solo_parent.dashboard');
    }

    public function fetch()
    {
        $total_beneficiaries = SoloParentRecord::count();

        $total_beneficiaries_age_8_to_16 = SoloParentRecord::whereBetween('age', [8, 16])->count();

        $total_beneficiaries_age_17_to_30 = SoloParentRecord::whereBetween('age', [17, 30])->count();

        $age_31_above_total  = SoloParentRecord::where('age', '>=', 31)->count();

        $bangkal  = SoloParentRecord::where('barangay', 'Bangkal')->count();

        $calaylayan  = SoloParentRecord::where('barangay', 'Calaylayan')->count();

        $capitangan  = SoloParentRecord::where('barangay', 'Capitangan')->count();

        $gabon  = SoloParentRecord::where('barangay', 'Gabon')->count();

        $laon  = SoloParentRecord::where('barangay', 'Laon')->count();

        $mabatang  = SoloParentRecord::where('barangay', 'Mabatang')->count();

        $omboy  = SoloParentRecord::where('barangay', 'Omboy')->count();

        $salian  = SoloParentRecord::where('barangay', 'Salian')->count();

        $wawa  = SoloParentRecord::where('barangay', 'Wawa')->count();

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
            'wawa' => $wawa
        ]);
    }
}