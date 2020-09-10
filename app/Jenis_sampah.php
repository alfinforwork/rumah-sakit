<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jenis_sampah extends Model
{
    protected $table = "jenis_sampah";
    protected $primaryKey = 'id_jenis_sampah';

    // protected $fillable = [];

    // public $timestamps = false;
    public $incrementing = false;

    public function jenis_sampah_rs()
    {
        return $this->hasMany(Jenis_sampah_rs::class, 'id_jenis_sampah', 'id_jenis_sampah');
    }
}
