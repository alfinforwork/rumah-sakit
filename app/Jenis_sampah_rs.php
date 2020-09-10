<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jenis_sampah_rs extends Model
{
    protected $table = "jenis_sampah_rs";
    protected $primaryKey = 'id_jenis_sampah_rs';

    // protected $fillable = [];

    // public $timestamps = false;
    public $incrementing = false;

    public function jenis_sampah()
    {
        return $this->belongsTo(Jenis_sampah::class, 'id_jenis_sampah_rs', 'id_jenis_sampah');
    }
}
