<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Katalog_rs extends Model
{
    protected $table = "katalog_rs";
    protected $primaryKey = 'id_katalog_rs';

    // protected $fillable = [];

    // public $timestamps = false;
    public $incrementing = false;

    public function katalog_rs_detail()
    {
        return $this->belongsToMany('App\Katalog_rs_detail', 'id_katalog_rs', 'id_katalog_rs');
    }
}
