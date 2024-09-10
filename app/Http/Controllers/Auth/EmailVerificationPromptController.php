<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class EmailVerificationPromptController extends Controller
{
    public function __invoke()
    {
        return response()->json(['message' => 'Please verify your email'], 403);
    }
}
