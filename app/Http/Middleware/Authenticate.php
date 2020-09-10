<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Illuminate\Contracts\Auth\Factory as Auth;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $token = $request->bearerToken() ? $request->bearerToken() : $request->input('token');

        if (!$token) {
            // Unauthorized response if token not there
            return response()->json(format_json(false, 'Token tidak ada.'), 401);
        }
        try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
        } catch (ExpiredException $e) {
            return response()->json(format_json(false, 'Token kadaluarsa.'), 400);
        } catch (\Exception $e) {
            return response()->json(format_json(false, 'Error ketika decoding token.'), 400);
        }

        // dd(JWT::decode($token, env('JWT_SECRET'), ['HS256']));
        $user = User::find($credentials->sub);
        // Now let's put the user in the request class so that you can grab it from there
        $request->auth = $user;
        $request->token = $token;
        return $next($request);
    }
}
