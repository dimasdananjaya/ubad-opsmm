<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\PeriodeModel;
use DB;
use Validator;
use RealRashid\SweetAlert\Facades\Alert;

class LaporanController extends Controller
{
    public function pimpinanPilihPeriodeLaporan()
    {
        $dataPeriode=PeriodeModel::all();
        return view('pimpinan.pilih-periode')->with('dataPeriode',$dataPeriode);
    }

    public function laporanManajemenUangPeriode(Request $request)
    {
        $id_periode=$request->input('id_periode');
        $periode = PeriodeModel::where('id_periode', $id_periode)->first();

        $totalPengeluaran=DB::select(DB::raw("SELECT dana_operasional.jumlah, SUM(jumlah) AS total_pengeluaran from dana_operasional 
        WHERE id_periode=$id_periode"));
        $listPengeluaran=DB::select(DB::raw("SELECT * FROM dana_operasional WHERE id_periode=$id_periode"));

        return view('pimpinan.show-laporan')
        ->with('listPengeluaran',$listPengeluaran)
        ->with('totalPengeluaran',$totalPengeluaran)
        ->with('periode',$periode);
    }
}
