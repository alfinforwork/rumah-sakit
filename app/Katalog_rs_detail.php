<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Katalog_rs_detail extends Model
{
    protected $table = "katalog_rs_detail";
    protected $primaryKey = 'id_katalog_rs_detail';

    // protected $fillable = [];

    // public $timestamps = false;
    public $incrementing = false;

    public function katalog_rs()
    {
        return $this->hasMany(Katalog_rs::class, 'id_katalog_rs', 'id_katalog_rs');
    }
    public function jenis_sampah_rs()
    {
        return $this->hasOne(Jenis_sampah_rs::class, 'id_jenis_sampah_rs', 'id_jenis_sampah_rs');
    }
}
