<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PeriodeModel extends Model
{
    protected $table='periode';
    protected $primaryKey='id_periode';
    public $timestamps=true;

    protected $fillable = ['periode','status'];
}
