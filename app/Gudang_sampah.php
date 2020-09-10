<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gudang_sampah extends Model
{
    protected $table = "gudang_sampah";
    protected $primaryKey = 'id_gudang_sampah';

    // protected $fillable = [];

    // public $timestamps = false;
    public $incrementing = false;
}
