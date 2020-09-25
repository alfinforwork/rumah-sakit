<?php

namespace App\Http\Controllers;

use App\Gudang_sampah;
use App\Jenis_sampah;
use App\Jenis_sampah_rs;
use App\Katalog_rs;
use App\Katalog_rs_detail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $data_sampah_terlaris = Katalog_rs::select(DB::raw('count(id_katalog_rs_detail) as jumlah'), 'katalog_rs_detail.id_jenis_sampah_rs', 'jenis_sampah.nama_sampah')
            ->groupBy('katalog_rs_detail.id_jenis_sampah_rs', 'jenis_sampah.id_jenis_sampah')
            ->join('katalog_rs_detail', 'katalog_rs.id_katalog_rs', '=', 'katalog_rs_detail.id_katalog_rs')
            ->join('jenis_sampah_rs', 'katalog_rs_detail.id_jenis_sampah_rs', '=', 'jenis_sampah_rs.id_jenis_sampah_rs')
            ->join('jenis_sampah', 'jenis_sampah_rs.id_jenis_sampah', '=', 'jenis_sampah.id_jenis_sampah')
            ->where('id_status_penjualan_rs', 9)->where('katalog_rs.id_rs', $data_jwt->id_rs)
            ->get();


        // ------------------------------------------------------------------------
        return response()->json(format_json(true, 'Berhasil menampilkan data', $data_sampah_terlaris));
    }

    public function statistik_katalog()
    {
        $data_jwt = request()->auth;
        $data_statistik_katalog = Katalog_rs::select(DB::raw('month(update_at) as bulan'))
            ->groupBy(DB::raw('month(update_at)'))
            ->where('id_status_penjualan_rs', 9)->where('katalog_rs.id_rs', $data_jwt->id_rs)
            ->get();
        return response()->json(format_json(true, 'Berhasil menampilkan data', $data_statistik_katalog));
    }

    public function statistik_gudang()
    {
        $data_statistik_gudang = Gudang_sampah::all();
        return response()->json(format_json(true, 'Berhasil menampilkan data', $data_statistik_gudang));
    }
}
