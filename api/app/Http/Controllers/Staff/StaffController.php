<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Enums\HttpStatusCode;

class StaffController extends Controller
{
    /**
     * Create auth JSON for staff.
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        \Auth::attempt($request->only('username', 'password'));

        // we create the sanctum auth and return as plain token.
        if (!$staff = \Auth::user()) {
            return response()->json([
                'message' => 'Unsuccessful'
            ], HttpStatusCode::BAD_REQUEST->value);
        }

        $token = $staff->createToken('staff')->plainTextToken;

        return response()->json(['token' => $token]);
    }

    /**
     * logs out staff from the backend
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'success'
        ], 200);
    }
}
