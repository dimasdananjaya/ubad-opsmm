<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\PeriodeModel;
use DB;
use Validator;
use RealRashid\SweetAlert\Facades\Alert;

class PeriodeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $credential=Auth::user()->status;
        
        if($credential == 'aktif')
        {
            $dataPeriode=PeriodeModel::all();
            return view('admin.admin-kelola-periode')->with('dataPeriode',$dataPeriode);
        }
        else{
            Alert::warning('Warning', 'Unauthorized Access');
            return view('home');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'periode' => 'required|unique:periode|max:255',
            'status'=> 'required',
        ]);

        if ($validator->fails()) {
            Alert::error('Periode Gagal Disimpan!', 'Periode Telah Terdaftar');
            return back();
        }
        else{
            $periode = PeriodeModel::create([
                'periode' => $request->input('periode'),
                'status' => 'aktif',
            ]);

            $periode->save();
            Alert::success('Periode Berhasil Disimpan!');
            return back()->with('success', 'Login Successfully!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $simpan=PeriodeModel::find($id);
        $simpan->periode=$request->input('periode');
        $simpan->status=$request->input('status');   
        
        $validator = Validator::make($request->all(), [
            'periode' => 'required|unique:periode,periode,'.$simpan->id_periode.',id_periode'
        ]);

        if ($validator->fails()) {
            Alert::error('Periode Gagal Disimpan!', 'Kembali');
            return back();
        }

        else{
            DB::select(DB::raw(" 
            UPDATE periode
            SET status='non-aktif'
            WHERE id_periode != $simpan->id_periode "
            ));
            $simpan->save();
            Alert::success('Periode Berhasil Disimpan!', 'Kembali');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('periode')->where('id_periode', '=', $id)->delete();
        alert()->success('Data Terhapus !', '');
        return back();
    }

    //this function is for admin-pilih-periode page
    public function adminPilihPeriodeLaporan()
    {
        $dataPeriode=PeriodeModel::all();
        return view('admin.admin-pilih-periode')->with('dataPeriode',$dataPeriode);
    }

    //this function is for dosen-pilih-periode page
    public function dosenPilihPeriodeLaporan()
    {
        $dataPeriode=PeriodeModel::all()->where('status','aktif');
        return view('dosen.dosen-pilih-periode')->with('dataPeriode',$dataPeriode);
    }
}
