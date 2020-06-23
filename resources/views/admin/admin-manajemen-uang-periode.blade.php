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
                            @foreach($totalPengeluaran as $tp)
                                <p><b>Rp. {{ number_format($tp->total_pengeluaran, 2, ',', '.') }}</b></p>
                            @endforeach
                        </div>
                    </div><!--card-->

                    <div class="card text-center">
                        <div class="card-header">
                            <h5><b>Sisa Dana</b></h5>
                        </div>
                        <div class="card-body">
                            <img src="{{asset('resources/logo/sisa-dana.svg')}}" class="navbar-logo" alt="Image"/>
                            @foreach ($totalPengeluaran as $tp)
                                <?php
                                    $dana=$periode->dana;
                                    $pengeluaran=$tp->total_pengeluaran;
                                    $sisa_dana = $dana-$pengeluaran;
                                ?>
                                <p><b>Rp. {{ number_format($sisa_dana, 2, ',', '.') }}</b></p>
                            @endforeach
                        </div>
                    </div><!--card-->


                    <div class="card text-center">
                        <div class="card-header">
                            <h5><b>Modal Awal</b></h5>
                        </div>
                        <div class="card-body">
                            <img src="{{asset('resources/logo/modal-awal.svg')}}" class="navbar-logo" alt="Image"/>
                            <p><b>Rp. {{ number_format($periode->dana, 2, ',', '.') }}</b></p>
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
                                {{Form::label('tanggal','Tanggal :')}}
                                {{ Form::text('deadline', null, ['class' => 'form-control', 'id'=>'datetimepicker']) }}
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
                    <th>Tanggal</th>
                    <th>Nama Dana</th>
                    <th>Jumlah</th>
                    <th>Penanggung Jawab</th>
                    <th>Keterangan</th>
                    <th>File</th>
                    <th>Aksi</th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach ($listPengeluaran as $lsp)
                    <tr>
                        <td></td>
                        <td>{{$lsp->tanggal}}</td>
                        <td>{{$lsp->nama_dana}}</td>
                        <td>{{$lsp->jumlah}}</td>
                        <td>{{$lsp->penanggung_jawab}}</td>
                        <td>{{$lsp->keterangan}}</td>
                        <td>
                            {!!Form::open(['action'=>['ManajemenUangController@downloadFile', $lsp->id_dana_operasional], 'method'=>'GET'])!!}
                                {{Form::hidden('file',$lsp->file)}}
                                {{Form::submit('Download File',['class'=>'btn btn-light'])}}
                            {!!Form::close()!!}
                        <td>
                            <a class="btn btn-success" style="color:#fff;float:center;" data-toggle="modal" 
                            data-target="#periode-edit-modal{{$lsp->id_dana_operasional}}">Edit</a>
                        </td>
                        <td></td>          
                        <!-- Modal Edit Periode-->
                        <div class="modal fade" id="periode-edit-modal{{$lsp->id_dana_operasional}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h2>Edit Dana Operasional</h2>   
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">                  
                                        {!!Form::open(['action'=>['ManajemenUangController@updatePengeluaran',$lsp->id_dana_operasional], 'method'=>'PUT','files' => true])!!}
                                            {{Form::label('tanggal','Tanggal :')}}
                                            {{Form::text('tanggal', $lsp->tanggal, ['class' => 'form-control', 'id'=>'datetimepicker']) }}
                                            {{Form::label('nama_dana','Nama Dana :')}}
                                            {{Form::text('nama_dana',$lsp->nama_dana,['class'=>'form-control form-group','required'])}}
                                            {{Form::label('jumlah','Jumlah :')}}
                                            {{Form::number('jumlah',$lsp->jumlah,['class'=>'form-control form-group','required'])}}
                                            {{Form::label('penanggung_jawab','Penanggung Jawab :')}}
                                            {{Form::text('penanggung_jawab',$lsp->penanggung_jawab,['class'=>'form-control form-group','required'])}}
                                            {{Form::label('keterangan','Keterangan :')}}
                                            {{Form::textarea('keterangan',$lsp->keterangan,['class'=>'form-control form-group','required'])}}
                                            {{Form::label('file','File :')}}
                                            {{Form::file('file')}}
                                            {{Form::hidden('id_user',Auth::user()->id_user)}}
                                            {{Form::hidden('id_periode',$periode->id_periode)}}
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

