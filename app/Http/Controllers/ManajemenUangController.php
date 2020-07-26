<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PeriodeModel;
use DB;
use Alert;
use Validator;
use App\ManajemenUangModel;
use Storage;
use Image;

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

            $image = $request->file('file');
            $image_name = time() . '.' . $image->getClientOriginalExtension(); 
            $destinationPath = storage_path('app/public/file');
            Image::make($image->getRealPath())->resize(320,440)->save($destinationPath . '/' . $image_name);

            $data = ManajemenUangModel::create([
                'id_user' => $request->input('id_user'),
                'id_periode' => $request->input('id_periode'),
                'nama_dana' => $request->input('nama_dana'),
                'penanggung_jawab' => $request->input('penanggung_jawab'),
                'file' => $image_name,
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
            'jumlah'=> 'required',
            'keterangan'=> 'required',
            'tanggal'=>'required',
        ]);

        if ($validator->fails()) {
            Alert::error('Data Pengeluaran Gagal Disimpan!', 'Isi Formulir Dengan Benar');
            return back();
        }

        elseif($request->hasFile('file')){

            $delete = $request->input('file'); //cari nama file
            Storage::delete('public/file/'.$delete); //hapus file

            $image = $request->file('file');
            $image_name = time() . '.' . $image->getClientOriginalExtension(); 
            $destinationPath = storage_path('app/public/file');
            Image::make($image->getRealPath())->resize(540,660)->save($destinationPath . '/' . $image_name);

            $data->id_user = $request->input('id_user');
            $data->id_periode = $request->input('id_periode');
            $data->nama_dana = $request->input('nama_dana');
            $data->penanggung_jawab = $request->input('penanggung_jawab');
            $data->file = $image_name;
            $data->jumlah = $request->input('jumlah');
            $data->keterangan = $request->input('keterangan');
            $data->tanggal = $request->input('tanggal');

            $data->save();
            Alert::success('Data Pengeluaran Berhasil Diupdate!');
            return back();
        }

        else{
            $data->id_user = $request->input('id_user');
            $data->id_periode = $request->input('id_periode');
            $data->nama_dana = $request->input('nama_dana');
            $data->penanggung_jawab = $request->input('penanggung_jawab');
            $data->file = $request->input('file');
            $data->jumlah = $request->input('jumlah');
            $data->keterangan = $request->input('keterangan');
            $data->tanggal = $request->input('tanggal');
            
            $data->save();
            Alert::success('Data Pengeluaran Berhasil Diupdate!');
            return back();
        }
    }

    public function downloadFile(Request $request)
    {
        $file=$request->input('file');

        return response()->download(storage_path('app/public/file/' . $file));

    }

    public function hapusDataPengeluaran(Request $request, $id)
    {
        $delete = $request->input('file'); //cari nama file
        Storage::delete('public/file/'.$delete); //hapus file

        ManajemenUangModel::find($id)->delete();
        Alert::success('Data Pengeluaran Berhasil Dihapus!', 'Kembali');
        return back();
    }
}
