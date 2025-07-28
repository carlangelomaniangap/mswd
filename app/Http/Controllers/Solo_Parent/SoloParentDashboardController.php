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

        $total_beneficiaries_age_18_to_24 = SoloParentRecord::whereBetween('age', [18, 24])->count();

        $total_beneficiaries_age_25_to_34 = SoloParentRecord::whereBetween('age', [25, 34])->count();

        $age_35_above_total  = SoloParentRecord::where('age', '>=', 35)->count();

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
            'total_beneficiaries_age_18_to_24' => $total_beneficiaries_age_18_to_24,
            'total_beneficiaries_age_25_to_34' => $total_beneficiaries_age_25_to_34,
            'age_35_above_total' => $age_35_above_total,
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