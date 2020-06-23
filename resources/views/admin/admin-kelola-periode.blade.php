@extends('layouts.app')

@section('content')
<section id="admin-kelola-periode">
    <div class="container">
        <div class="background">
            <h2 class="text-center">Kelola Periode</h2>
            <hr>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#tambahPeriodeModal">
                Tambah Periode
            </button>
            
            <!-- Modal -->
            <div class="modal fade" id="tambahPeriodeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div><!-- modal header-->
                        <div class="modal-body">
                            {!!Form::open(['action'=>'PeriodeController@store', 'method'=>'POST'])!!}
                                {{Form::label('periode','Periode :')}}
                                {{Form::text('periode','',['class'=>'form-control form-group','placeholder'=>'Periode','required'])}}
                                {{Form::label('dana','Dana :')}}
                                {{Form::number('dana','',['class'=>'form-control form-group','placeholder'=>'Dana','required'])}}
                                {{Form::hidden('status','aktif')}}
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
                    <th>Periode</th>
                    <th>Status</th>
                    <th>Dana</th>
                    <th>Aksi</th>
                </thead>
                <tbody>
                    @foreach ($dataPeriode as $dtprd)
                    <tr>
                        <td>{{$dtprd->periode}}</td>
                        <td>{{$dtprd->status}}</td>
                        <td>Rp. {{ number_format($dtprd->dana, 2, ',', '.') }}</td>
                        <td>
                            <a class="btn btn-success" style="color:#fff;float:center;" data-toggle="modal" data-target="#periode-edit-modal{{$dtprd->id_periode}}">Edit</a>
                        </td>          
                        <!-- Modal Edit Periode-->
                        <div class="modal fade" id="periode-edit-modal{{$dtprd->id_periode}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h2>Edit Periode</h2>   
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">                  
                                        {!!Form::open(['action'=>['PeriodeController@update', $dtprd->id_periode], 'method'=>'PUT'])!!}
                                            {{Form::label('periode','Periode :')}}
                                            {{Form::text('periode',$dtprd->periode,['class'=>'form-control form-group','placeholder'=>'Periode'])}}
                                            {{Form::label('dana','Dana :')}}
                                            {{Form::number('dana',$dtprd->dana,['class'=>'form-control form-group','placeholder'=>'Dana'])}}
                                            {{Form::label('periode','Periode :')}}
                                            <select name="status" class="form-group form-control">
                                                <option value="aktif" class="form-group form-control">Aktif</option>
                                                <option value="non-aktif" class="form-group form-control">Non-Aktif</option>
                                            </select>
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

