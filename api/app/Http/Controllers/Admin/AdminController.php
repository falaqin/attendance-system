<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AdminLoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Enums\HttpStatusCode;

class AdminController extends Controller
{
    /**
     * Create auth JSON for admin.
     * @return JsonResponse
     */
    public function login(AdminLoginRequest $request): JsonResponse
    {
        \Auth::guard('admin')->attempt($request->only('username', 'password'));

        // we create the sanctum auth and return as plain token.
        if (!$admin = \Auth::guard('admin')->user()) {
            return response()->json([
                'message' => 'Unsuccessful'
            ], HttpStatusCode::BAD_REQUEST->value);
        }

        $token = $admin->createToken('admin')->plainTextToken;

        return response()->json(['token' => $token]);
    }

    /**
     * logs out admin from the backend
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'success'
        ], 200);
    }
}
