<?php

namespace App\Http\Controllers;

use App\Gudang_sampah;
use App\Jenis_sampah;
use App\Jenis_sampah_rs;
use App\Katalog_rs;
use App\User;
use Illuminate\Http\Request;


class DashboardController extends Controller
{
    public function index()
    {
        $data_jwt = request()->auth;
        $user = User::all();
        $jenis_sampah = Jenis_sampah::where('active', 1)->where('remove', 1)->get();
        $jenis_sampah_rs = Jenis_sampah_rs::where('id_rs', $data_jwt->id_rs)->where('active', 1)->where('remove', 1)->get();
        $gudang_sampah = Gudang_sampah::where('id_rs', $data_jwt->id_rs)->get();
        $katalog_rs = Katalog_rs::where('id_rs', $data_jwt->id_rs)->where('id_status_penjualan_rs', 9)->get();
        // ------------------------------------------------------------------------
        $data_jenis_sampah = [];
        foreach ($jenis_sampah as $k) {
            $k->jenis_sampah_rs[] = $k->jenis_sampah_rs();
            $data_jenis_sampah[] = $k;
        }
        // ------------------------------------------------------------------------
        $json = [
            'jumlah_user'           => count($user),
            'jumlah_jenis_sampah'   => count($jenis_sampah),
            'jumlah_jenis_sampah_rs' => count($jenis_sampah_rs),
            'jumlah_gudang_sampah'  => count($gudang_sampah),
            'katalog_rs'            => count($katalog_rs),
            'data_jenis_sampah'     => $data_jenis_sampah,
            'data_jenis_sampah_rs'  => $jenis_sampah_rs
        ];
        return response()->json(format_json(true, 'Berhasil menampilkan data', $json));
    }

    public function sampah_terlaris()
    {
        $data_jwt = request()->auth;
        $katalog_rs = Katalog_rs::all(); //where('id_rs', $data_jwt->id_rs)->where('id_status_penjualan_rs', 9)->get();
        // ------------------------------------------------------------------------
        $data_katalog_rs = [];
        foreach ($katalog_rs as $k) {
            foreach ($k->katalog_rs_detail() as $l) {
                $k->jenis_sampah_rs[] = $k->katalog_rs_detail()->jenis_sampah_rs();
            }
            $k->katalog_rs_detail[] = $k->katalog_rs_detail();
            $data_katalog_rs[] = $k;
        }
        // ------------------------------------------------------------------------
        $json = [
            'data_sampah_terlaris' => $data_katalog_rs,
        ];
        return response()->json(format_json(true, 'Berhasil menampilkan data', $json));
    }
}
