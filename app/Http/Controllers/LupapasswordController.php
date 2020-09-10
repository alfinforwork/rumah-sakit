<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class LupapasswordController extends Controller
{
    public function index(Request $request)
    {
        // Mail::raw('Raw string email', function ($msg) {
        //     $msg->to(['alfinforwork@gmail.com']);
        //     $msg->from(['kompisonlinecenter@gmail.com']);
        // });
        Mail::send('email', ['user' => $request->auth], function ($message) use ($request) {
            $message->subject('Email');
            $message->from('kompisonlinecenter@gmail.com', 'Kompis');
            $message->to('alfinforwork@gmail.com');
        });
        return response()->json();
    }
}
