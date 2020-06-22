@extends('layouts.app')

@section('content')
<section id="admin-manajemen-uang-periode">
    <div class="container">
        <div class="background">
        <h2 class="text-center">Manajemen Uang Periode {{$periode->periode}}</h2>
            <hr>
            <div class="carousel">

                    <div class="card text-center">
                        <div class="card-header">
                            <h5><b>Total Pengeluaran</b></h5>
                        </div>
                        <div class="card-body">
                            <img src="{{asset('resources/logo/total-pengeluaran.svg')}}" class="navbar-logo" alt="Image"/>
                            <p><b>Rp. 15.000.000</b></p>
                        </div>
                    </div><!--card-->

                    <div class="card text-center">
                        <div class="card-header">
                            <h5><b>Sisa Dana</b></h5>
                        </div>
                        <div class="card-body">
                            <img src="{{asset('resources/logo/sisa-dana.svg')}}" class="navbar-logo" alt="Image"/>
                            <p><b>Rp. 15.000.000</b></p>
                        </div>
                    </div><!--card-->


                    <div class="card text-center">
                        <div class="card-header">
                            <h5><b>Modal Awal</b></h5>
                        </div>
                        <div class="card-body">
                            <img src="{{asset('resources/logo/modal-awal.svg')}}" class="navbar-logo" alt="Image"/>
                            <p><b>Rp. 15.000.000</b></p>
                        </div>
                    </div><!--card-->
            </div><!--carousel-->
            
            <h3 class="mt-4">Detail Pengeluaran</h3>
            
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
                            {!!Form::open(['action'=>'ManajemenUangController@storePengeluaran', 'method'=>'POST','files' => true])!!}
                                {{Form::label('nama_dana','Nama Dana :')}}
                                {{Form::text('nama_dana','',['class'=>'form-control form-group','required'])}}
                                {{Form::label('jumlah','Jumlah :')}}
                                {{Form::number('jumlah','',['class'=>'form-control form-group','required'])}}
                                {{Form::label('penanggung_jawab','Penanggung Jawab :')}}
                                {{Form::text('penanggung_jawab','',['class'=>'form-control form-group','required'])}}
                                {{Form::label('keterangan','Keterangan :')}}
                                {{Form::textarea('keterangan','',['class'=>'form-control form-group','required'])}}
                                {{Form::label('file','File :')}}
                                {{Form::file('file')}}
                                {{Form::hidden('id_user',Auth::user()->id_user)}}
                                {{Form::hidden('id_periode',$periode->id_periode)}}
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
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-success mb-4" data-toggle="modal" data-target="#tambahPengeluaranModal">
                Tambah Pengeluaran
            </button>
            <table id="tabel" class="table table-sm table-hover table-striped text-center table-responsive-sm table-responsive-md">
                <thead>
                    <th>No.</th>
                    <th>Nama Dana</th>
                    <th>Jumlah</th>
                    <th>Penanggung Jawab</th>
                    <th>Keterangan</th>
                    <th>File</th>
                    <th>Aksi</th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach ($dataLaporanManajemenUang as $dtlpmu)
                    <tr>
                        <td></td>
                        <td>{{$dtlpmu->nama_dana}}</td>
                        <td>{{$dtlpmu->jumlah}}</td>
                        <td>{{$dtlpmu->penanggung_jawab}}</td>
                        <td>{{$dtlpmu->keterangan}}</td>
                        <td>
                            {!!Form::open(['action'=>['ManajemenUangController@downloadFile', $dtlpmu->id_dana_operasional], 'method'=>'GET'])!!}
                                {{Form::hidden('file',$dtlpmu->file)}}
                                {{Form::submit('Download File',['class'=>'btn btn-light'])}}
                            {!!Form::close()!!}
                        <td>
                            <a class="btn btn-success" style="color:#fff;float:center;" data-toggle="modal" 
                            data-target="#periode-edit-modal{{$dtlpmu->id_dana_operasional}}">Edit</a>
                        </td>
                        <td></td>          
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
        </div><!--background-->
    </div><!--container-->
</section>

<script>
    $(document).ready(function() {
        var t = $('#tabel').DataTable( {
            "columnDefs": [ {
                "searchable": false,
                "orderable": false,
                "targets": 0
            } ],
            "order": [[ 1, 'asc' ]]
        } );
    
        t.on( 'order.dt search.dt', function () {
            t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
    } );
</script>
@endsection

