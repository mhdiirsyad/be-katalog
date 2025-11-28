<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class XsrfController extends Controller
{
    /**
     * Return a JSON payload and set the XSRF-TOKEN cookie.
     * Frontend should call this endpoint before any state-changing request
     * when using cookie-based Sanctum authentication.
     */
    public function show(Request $request)
    {
        $token = csrf_token();

        return response()->json([
            'message' => 'CSRF token set',
            'token' => $token,
        ])->cookie('XSRF-TOKEN', $token, 0, '/', null, config('session.secure'), true, false, 'Lax');
    }
}
