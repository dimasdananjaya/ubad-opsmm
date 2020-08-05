@extends('layouts.app')

@section('content')
<section id="admin-manajemen-uang-periode">
    <div class="container">
        <div class="background">
        <h2 class="text-center">Laporan Pengeluaran Periode {{$periode->periode}}</h2>
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
            
            <table id="tabel" class="table table-sm table-hover table-striped text-center table-responsive-sm table-responsive-md">
                <thead>
                    <th>No.</th>
                    <th>Tanggal</th>
                    <th>Nama Dana</th>
                    <th>Jumlah</th>
                    <th>Penanggung Jawab</th>
                    <th>Keterangan</th>
                    <th>File</th>
                </thead>
                <tbody>
                    @foreach ($listPengeluaran as $lsp)
                    <tr>
                        <td></td>
                        <td>{{$lsp->tanggal}}</td>
                        <td>{{$lsp->nama_dana}}</td>
                        <td>Rp. {{ number_format($lsp->jumlah, 2, ',', '.') }}</td>
                        <td>{{$lsp->penanggung_jawab}}</td>
                        <td>{{$lsp->keterangan}}</td>
                        <td><img src="{{ asset('storage/file/'.$lsp->file) }}" alt="{{$lsp->file}}"></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            <a class="btn btn-primary mb-5 mb-md-0 mt-4" href="{{route('pimpinan.periode')}}">Kembali ke Pilih Periode</a>
        </div><!--background-->
    </div><!--container-->
</section>

<script>
$(document).ready(function() {
    var table = $('#tabel').DataTable( {
        lengthChange: false,
        buttons: [ 'excel', 'pdf', 'colvis' ]
    } );
 
    table.buttons().container()
        .appendTo( '#tabel_wrapper .col-md-6:eq(0)' );

    table.on( 'order.dt search.dt', function () {
        table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
} );
</script>
@endsection

