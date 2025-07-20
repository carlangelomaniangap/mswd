<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AicsRecord;
use App\Models\PwdRecord;
use App\Models\SeniorCitizenRecord;
use App\Models\SoloParentRecord;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view("pages.admin.dashboard");
    }
    public function fetch()
    {
        $pwd_count = PwdRecord::count();
        $aics_count = AicsRecord::count();
        $sc_count = SeniorCitizenRecord::count();
        $sp_count = SoloParentRecord::count();

        $pwd_age_count = PwdRecord::whereBetween('age', [8, 16])->count();
        $aics_age_count = AicsRecord::whereBetween('age', [8, 16])->count();
        $sc_age_count = SeniorCitizenRecord::whereBetween('age', [8, 16])->count();
        $sp_age_count = SoloParentRecord::whereBetween('age', [8, 16])->count();

        $pwd_age2_count = PwdRecord::whereBetween('age', [17, 30])->count();
        $aics_age2_count = AicsRecord::whereBetween('age', [17, 30])->count();
        $sc_age2_count = SeniorCitizenRecord::whereBetween('age', [17, 30])->count();
        $sp_age2_count = SoloParentRecord::whereBetween('age', [17, 30])->count();

        $pwd_age3_count  = PwdRecord::where('age', '>=', 31)->count();
        $aics_age3_count = AicsRecord::where('age', '>=', 31)->count();
        $sc_age3_count   = SeniorCitizenRecord::where('age', '>=', 31)->count();
        $sp_age3_count   = SoloParentRecord::where('age', '>=', 31)->count();

        $pwd_bangkal_count  = PwdRecord::where('barangay', 'Bangkal')->count();
        $aics_bangkal_count = AicsRecord::where('barangay', 'Bangkal')->count();
        $sc_bangkal_count   = SeniorCitizenRecord::where('barangay', 'Bangkal')->count();
        $sp_bangkal_count   = SoloParentRecord::where('barangay', 'Bangkal')->count();

        $pwd_calaylayan_count  = PwdRecord::where('barangay', 'Calaylayan')->count();
        $aics_calaylayan_count = AicsRecord::where('barangay', 'Calaylayan')->count();
        $sc_calaylayan_count   = SeniorCitizenRecord::where('barangay', 'Calaylayan')->count();
        $sp_calaylayan_count   = SoloParentRecord::where('barangay', 'Calaylayan')->count();

        $pwd_capitangan_count  = PwdRecord::where('barangay', 'Capitangan')->count();
        $aics_capitangan_count = AicsRecord::where('barangay', 'Capitangan')->count();
        $sc_capitangan_count   = SeniorCitizenRecord::where('barangay', 'Capitangan')->count();
        $sp_capitangan_count   = SoloParentRecord::where('barangay', 'Capitangan')->count();

        $pwd_gabon_count  = PwdRecord::where('barangay', 'Gabon')->count();
        $aics_gabon_count = AicsRecord::where('barangay', 'Gabon')->count();
        $sc_gabon_count   = SeniorCitizenRecord::where('barangay', 'Gabon')->count();
        $sp_gabon_count   = SoloParentRecord::where('barangay', 'Gabon')->count();

        $pwd_laon_count  = PwdRecord::where('barangay', 'Laon')->count();
        $aics_laon_count = AicsRecord::where('barangay', 'Laon')->count();
        $sc_laon_count   = SeniorCitizenRecord::where('barangay', 'Laon')->count();
        $sp_laon_count   = SoloParentRecord::where('barangay', 'Laon')->count();

        $pwd_mabatang_count  = PwdRecord::where('barangay', 'Mabatang')->count();
        $aics_mabatang_count = AicsRecord::where('barangay', 'Mabatang')->count();
        $sc_mabatang_count   = SeniorCitizenRecord::where('barangay', 'Mabatang')->count();
        $sp_mabatang_count   = SoloParentRecord::where('barangay', 'Mabatang')->count();

        $pwd_omboy_count  = PwdRecord::where('barangay', 'Omboy')->count();
        $aics_omboy_count = AicsRecord::where('barangay', 'Omboy')->count();
        $sc_omboy_count   = SeniorCitizenRecord::where('barangay', 'Omboy')->count();
        $sp_omboy_count   = SoloParentRecord::where('barangay', 'Omboy')->count();

        $pwd_salian_count  = PwdRecord::where('barangay', 'Salian')->count();
        $aics_salian_count = AicsRecord::where('barangay', 'Salian')->count();
        $sc_salian_count   = SeniorCitizenRecord::where('barangay', 'Salian')->count();
        $sp_salian_count   = SoloParentRecord::where('barangay', 'Salian')->count();

        $pwd_wawa_count  = PwdRecord::where('barangay', 'Wawa')->count();
        $aics_wawa_count = AicsRecord::where('barangay', 'Wawa')->count();
        $sc_wawa_count   = SeniorCitizenRecord::where('barangay', 'Wawa')->count();
        $sp_wawa_count   = SoloParentRecord::where('barangay', 'Wawa')->count();

        $total_beneficiaries = $pwd_count + $aics_count + $sc_count + $sp_count;

        $total_beneficiaries_age_8_to_16 = $pwd_age_count + $aics_age_count + $sc_age_count + $sp_age_count;

        $total_beneficiaries_age_17_to_30 = $pwd_age2_count + $aics_age2_count + $sc_age2_count + $sp_age2_count;

        $age_31_above_total = $pwd_age3_count + $aics_age3_count + $sc_age3_count + $sp_age3_count;

        $bangkal = $pwd_bangkal_count + $aics_bangkal_count + $sc_bangkal_count + $sp_bangkal_count;

        $calaylayan = $pwd_calaylayan_count + $aics_calaylayan_count + $sc_calaylayan_count + $sp_calaylayan_count;

        $capitangan = $pwd_capitangan_count + $aics_capitangan_count + $sc_capitangan_count + $sp_capitangan_count;

        $gabon = $pwd_gabon_count + $aics_gabon_count + $sc_gabon_count + $sp_gabon_count;

        $laon = $pwd_laon_count + $aics_laon_count + $sc_laon_count + $sp_laon_count;

        $mabatang = $pwd_mabatang_count + $aics_mabatang_count + $sc_mabatang_count + $sp_mabatang_count;

        $omboy = $pwd_omboy_count + $aics_omboy_count + $aics_omboy_count + $sc_omboy_count + $sp_omboy_count;

        $salian = $pwd_salian_count + $aics_salian_count + $sc_salian_count + $sp_salian_count;

        $wawa = $pwd_wawa_count + $aics_wawa_count + $sc_wawa_count + $sp_wawa_count;

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

