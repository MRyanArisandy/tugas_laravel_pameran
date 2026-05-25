<?php

namespace App\Http\Controllers;

use App\Jobs\LogApiAuthenticationJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

// Fitur 2: Attribute Middleware via HasMiddleware interface
class ApiAuthController extends Controller implements HasMiddleware
{
    /**
     * Middleware yang diterapkan pada controller ini.
     * Hanya method logout yang memerlukan autentikasi.
     *
     * @return array<int, Middleware>
     */
    public static function middleware(): array
    {
        return [
            new Middleware('api.auth', only: ['logout']),
        ];
    }

    /**
     * Handle API Authentication & Login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah.',
            ], 401);
        }

        $user = User::where('email', $credentials['email'])->first();

        // Generate a new token if not present
        if (! $user->api_token) {
            $user->api_token = Str::random(60);
            $user->save();
        }

        // Dispatch Job to the Queue!
        LogApiAuthenticationJob::dispatch($user);

        return response()->json([
            'success' => true,
            'message' => 'Autentikasi berhasil! Log audit sedang diproses di latar belakang.',
            'token'   => $user->api_token,
            'user'    => [
                'name'  => $user->name,
                'email' => $user->email,
            ],
        ]);
    }

    /**
     * Handle API Logout.
     */
    public function logout(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Berhasil keluar (logout).',
        ]);
    }
}
