<?php

use Illuminate\Support\Facades\DB;

function format_json($status = true, $message = null, $data = null, $token = null)
{
    if ($token == null) {
        $json = [
            'status' => $status,
            'message' => $message,
            // 'token' => $token,
            'data' => $data,
        ];
    } else {
        $json = [
            'status' => $status,
            'message' => $message,
            'token' => $token,
            'data' => $data,
        ];
    }
    return $json;
}

function autonumber($tbl, $primary, $prefix)
{
    $q = DB::table($tbl)->select(DB::raw('MAX(RIGHT(' . $primary . ',3)) as kd_max'));
    $prx = $prefix;
    if ($q->count() > 0) {
        foreach ($q->get() as $k) {
            $tmp = ((int)$k->kd_max) + 1;
            $kd = $prx . sprintf("%04s", $tmp);
        }
    } else {
        $kd = $prx . "0001";
    }

    return $kd;
}
