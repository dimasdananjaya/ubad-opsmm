<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PeriodeModel;
use DB;
use Alert;
use Validator;
use App\ManajemenUangModel;
use Storage;

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

        $totalPengeluaran=DB::select(DB::raw("SELECT dana_operasional.jumlah, SUM(jumlah) AS total_pengeluaran from dana_operasional 
        WHERE id_periode=$id_periode"));
        $listPengeluaran=DB::select(DB::raw("SELECT * FROM dana_operasional WHERE id_periode=$id_periode"));

        return view('admin.admin-manajemen-uang-periode')
        ->with('listPengeluaran',$listPengeluaran)
        ->with('totalPengeluaran',$totalPengeluaran)
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
            'keterangan'=> 'required',
            'tanggal'=>'required',
        ]);

        if ($validator->fails()) {
            Alert::error('Data Pengeluaran Gagal Disimpan!', 'Isi Formulir Dengan Benar');
            return back();
        }

        elseif($request->hasFile('file')){

            $file = $request->file('file');
            $name = time() . '.' . $file->getClientOriginalExtension();
            //$destinationPath = public_path('/resources/file');
            $path = $request->file('file')->storeAs(
                'file', $name
            );
            //$file->move($destinationPath, $name);

            $data = ManajemenUangModel::create([
                'id_user' => $request->input('id_user'),
                'id_periode' => $request->input('id_periode'),
                'nama_dana' => $request->input('nama_dana'),
                'penanggung_jawab' => $request->input('penanggung_jawab'),
                'file' => $name,
                'jumlah' => $request->input('jumlah'),
                'keterangan' => $request->input('keterangan'),
                'tanggal' => $request->input('tanggal'),
            ]);

            $data->save();
            Alert::success('Data Pengeluaran Berhasil Disimpan!');
            return back();
        }
    }


    public function updatePengeluaran(Request $request, $id)
    {
        $data=ManajemenUangModel::find($id);

        $validator = Validator::make($request->all(), [
            'id_user'=> 'required',
            'id_periode'=> 'required',
            'nama_dana' => 'required',
            'penanggung_jawab'=> 'required',
            'file'=> 'required',
            'jumlah'=> 'required',
            'keterangan'=> 'required',
            'tanggal'=>'required',
        ]);

        if ($validator->fails()) {
            Alert::error('Data Pengeluaran Gagal Disimpan!', 'Isi Formulir Dengan Benar');
            return back();
        }

        elseif($request->hasFile('file')){

            $file = $request->file('file');
            $name = time() . '.' . $file->getClientOriginalExtension();
            //$destinationPath = public_path('/resources/file');
            $path = $request->file('file')->storeAs(
                'file', $name
            );
            //$file->move($destinationPath, $name);

            $data = ManajemenUangModel::create([
                'id_user' => $request->input('id_user'),
                'id_periode' => $request->input('id_periode'),
                'nama_dana' => $request->input('nama_dana'),
                'penanggung_jawab' => $request->input('penanggung_jawab'),
                'file' => $name,
                'jumlah' => $request->input('jumlah'),
                'keterangan' => $request->input('keterangan'),
                'tanggal' => $request->input('tanggal'),
            ]);

            $data->save();
            Alert::success('Data Pengeluaran Berhasil Disimpan!');
            return back();
        }
    }

    public function downloadFile(Request $request)
    {
        $file=$request->input('file');

        return response()->download(storage_path('app/file/' . $file));

    }
}
