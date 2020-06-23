<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ManajemenUangModel extends Model
{
    protected $table='dana_operasional';
    protected $primaryKey='id_dana_operasional';
    public $timestamps=true;

    protected $fillable = ['id_user','id_periode','nama_dana','jumlah','penanggung_jawab','keterangan','file','tanggal'];
}
