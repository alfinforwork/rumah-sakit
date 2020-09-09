<?php

namespace App\Http\Controllers;

use Validator;
use App\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseController;

class AuthController extends BaseController
{
    private $request;

    public function index()
    {
        return response()->json(['hello world']);
    }
    public function me()
    {
        $data = [
            'decode_token' => $this->request->auth,
            'data_user' => User::all(),
        ];
        return response()->json(format_json(true, 'Berhasil menampilkan data', $data, $this->request->token));
    }

    public function __construct(Request $request)
    {
        $this->request = $request;
    }



    public function authenticate(User $user)
    {
        $this->validate($this->request, [
            'no_telp'     => 'required|numeric',
            'password'  => 'required'
        ]);
        // Find the user by no_telp
        $user = User::where('no_telp', $this->request->input('no_telp'))->first();

        if (!$user) {
            return response()->json(format_json(false, 'No. HP salah.'), 400);
        }
        // Verify the password and generate the token
        if (hash('sha256', md5($this->request->input('no_telp')) . $user->password)) {
            $status = true;
            $message = 'Berhasil masuk';
            $token = $this->jwt($user);
            $data = $user;
            return response()->json(format_json($status, $message, $data, $token), 200);
        }
        // Bad Request response
        return response()->json(format_json(false, 'Password salah.'), 400);
    }

    protected function jwt(User $user)
    {
        $payload = [
            'iss' => "lumen-jwt", // Issuer of the token
            'sub' => $user->id_rs, // Subject of the token
            'iat' => time(), // Time when JWT was issued.
            'exp' => time() + 60 * 60 // Expiration time
        ];

        return JWT::encode($payload, env('JWT_SECRET'));
    }
}
