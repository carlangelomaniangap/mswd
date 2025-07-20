<?php

namespace App\Http\Controllers\Pwd;

use App\Http\Controllers\Controller;
use App\Models\PwdRecord;

class PwdDashboardController extends Controller
{
    public function index()
    {
        return view('pages.pwd.dashboard');
    }

    public function fetch()
    {
        $total_beneficiaries = PwdRecord::count();

        $total_beneficiaries_age_8_to_16 = PwdRecord::whereBetween('age', [8, 16])->count();

        $total_beneficiaries_age_17_to_30 = PwdRecord::whereBetween('age', [17, 30])->count();

        $age_31_above_total  = PwdRecord::where('age', '>=', 31)->count();

        $bangkal  = PwdRecord::where('barangay', 'Bangkal')->count();

        $calaylayan  = PwdRecord::where('barangay', 'Calaylayan')->count();

        $capitangan  = PwdRecord::where('barangay', 'Capitangan')->count();

        $gabon  = PwdRecord::where('barangay', 'Gabon')->count();

        $laon  = PwdRecord::where('barangay', 'Laon')->count();

        $mabatang  = PwdRecord::where('barangay', 'Mabatang')->count();

        $omboy  = PwdRecord::where('barangay', 'Omboy')->count();

        $salian  = PwdRecord::where('barangay', 'Salian')->count();

        $wawa  = PwdRecord::where('barangay', 'Wawa')->count();

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