@extends('layouts.app')

@section('content')
<section id="admin-manajemen-uang-periode">
    <div class="container">
        <div class="background">
            <h2 class="text-center">Manajemen Uang Periode</h2>
            <hr>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card text-center">
                        <h5><b>Total Pengeluaran</b></h5>
                    </div><!--card-->
                </div><!--col-->

                <div class="col-lg-6">
                    <div class="card text-center">
                        <h5><b>Dana Sisa</b></h5>
                    </div><!--card-->
                </div><!--col-->

                <div class="col-lg-6">
                    <div class="card text-center">
                        <h5><b>Dana Awal<b></h5>
                    </div><!--card-->
                </div><!--col-->

            </div><!--row-->
            <hr>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#tambahPengeluaranModal">
                Tambah Pengeluaran
            </button>
            
            <!-- Modal -->
            <div class="modal fade" id="tambahPengeluaranModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Form Tambah Pengeluaran</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div><!-- modal header-->
                        <div class="modal-body">
                            {!!Form::open(['action'=>'ManajemenUangController@storePengeluaran', 'method'=>'POST'])!!}
                                {{Form::label('periode','Periode :')}}
                                {{Form::text('periode','',['class'=>'form-control form-group','placeholder'=>'Periode','required'])}}
                                {{Form::hidden('id_user',Auth::user()->id_user)}}
                                {{Form::submit('Simpan',['class'=>'btn btn-success btn-block'])}}
                            {!!Form::close()!!}
                        </div><!-- modal body-->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div><!--modal footer-->
                    </div><!--modal content-->
                </div><!--modal dialog-->
            </div><!--modal-->
            <hr>
            <table class="table table-sm table-hover table-striped text-center table-responsive-sm table-responsive-md" id="tabel-periode">
                <thead>
                    <th>No.</th>
                    <th>Nama Dana</th>
                    <th>Penanggung Jawab</th>
                    <th>File</th>
                </thead>
                <tbody>
                    @foreach ($dataLaporanManajemenUang as $dtlpmu)
                    <tr>
                        <td></td>
                        <td>{{$dtlpmu->nama_dana}}</td>
                        <td>{{$dtlpmu->penanggung_jawab}}</td>
                        <td>{{$dtlpmu->file}}</td>
                        <td>{{$dtlpmu->keterangan}}</td>
                        <td>
                            <a class="btn btn-success" style="color:#fff;float:center;" data-toggle="modal" 
                            data-target="#periode-edit-modal{{$dtlpmu->id_dana_operasional}}">Edit</a>
                        </td>          
                        <!-- Modal Edit Periode-->
                        <div class="modal fade" id="periode-edit-modal{{$dtlpmu->id_dana_operasional}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h2>Edit Dana Operasional</h2>   
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">                  
                                        {!!Form::open(['action'=>['ManajemenUangController@updatePengeluaran', $dtlpmu->id_dana_operasional], 'method'=>'PUT'])!!}
                                            {{Form::label('periode','Periode :')}}
                                            {{Form::text('periode','',['class'=>'form-control form-group','placeholder'=>'Periode'])}}
                                            {{Form::hidden('_method','PUT')}}
                                            {{Form::submit('Update',['class'=>'btn btn-success btn-block'])}}
                                        {!!Form::close()!!}
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <a class="btn btn-primary mb-5 mb-md-0" href="{{route('admin.home')}}">Kembali ke Home</a>
        </div><!--card-->
    </div><!--container-->
</section>
@endsection

