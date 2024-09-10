<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ConfirmablePasswordController extends Controller
{
    // Handle password confirmation
    public function store(Request $request)
    {
        $request->validate([
            'password' => ['required'],
        ]);

        if (!Hash::check($request->password, Auth::user()->password)) {
            return response()->json(['message' => 'Password confirmation failed'], 403);
        }

        return response()->json(['message' => 'Password confirmed'], 200);
    }
}
