<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PeriodeModel;
use DB;
use Alert;
use Validator;

class ManajemenUangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function pilihPeriode()
    {
        $dataPeriode=PeriodeModel::all()->sortBy('periode');

        return view('admin.admin-pilih-periode')->with('dataPeriode',$dataPeriode);
    }

    public function showManajemenUangPeriode(Request $request)
    {
        $id_periode=$request->input('id_periode');
        $periode = PeriodeModel::where('id_periode', $id_periode)->first();
        $dataTotalLaporanManajemenUang=DB::select(DB::raw("SELECT dana_operasional.jumlah, SUM(jumlah) AS total_pengeluaran from dana_operasional WHERE id_periode=$id_periode GROUP BY $id_periode"));
        $dataLaporanManajemenUang=DB::select(DB::raw("SELECT * FROM dana_operasional WHERE id_periode=$id_periode"));

        return view('admin.admin-manajemen-uang-periode')
        ->with('dataLaporanManajemenUang',$dataLaporanManajemenUang)
        ->with('dataTotalLaporanManajemenUang',$dataTotalLaporanManajemenUang)
        ->with('periode',$periode);
    }

    public function storePengeluaran(Request $request){
        $validator = Validator::make($request->all(), [
            'id_user'=> 'required',
            'id_periode'=> 'required',
            'nama_dana' => 'required',
            'penanggung_jawab'=> 'required',
            'file'=> 'required',
            'jumlah'=> 'required',
        ]);

        if ($validator->fails()) {
            Alert::error('Data BAP Gagal Disimpan!', 'Isi Formulir Dengan Benar');
            return back();
        }
        else{
            $data = BAPModel::create([
                'id_user' => $request->input('id_user'),
                'id_periode' => $request->input('id_periode'),
                'nama_dana' => $request->input('nama_dana'),
                'penanggung_jawab' => $request->input('penanggung_jawab'),
                'file' => $request->input('file'),
                'jumlah' => $request->input('materi'),
            ]);

            $data->save();
            Alert::success('Data Pengeluaran Berhasil Disimpan!');
            return back();
        }
    }


    public function updatePengeluaran(Request $request, $id)
    {
        $bap=BAPModel::find($id);

        $validator = Validator::make($request->all(), [
            'id_user'=> 'required',
            'id_periode'=> 'required',
            'tanggal' => 'required',
            'mata_kuliah'=> 'required',
            'jam'=> 'required',
            'sks'=> 'required',
            'materi'=> 'required',
        ]);

        if ($validator->fails()) {
            Alert::error('Data BAP Gagal Disimpan!', 'Kembali');
            return back();
        }

        else{  
            $bap->id_user=$request->input('id_user');
            $bap->id_periode=$request->input('id_periode');
            $bap->tanggal=$request->input('tanggal');
            $bap->mata_kuliah=$request->input('mata_kuliah');
            $bap->jam=$request->input('jam');
            $bap->sks=$request->input('sks');
            $bap->materi=$request->input('materi');
            $bap->save();
            Alert::success('Data BAP Berhasil Disimpan!');
            return back();
        }
    }
}
