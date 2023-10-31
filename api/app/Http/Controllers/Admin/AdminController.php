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
     * Display a listing of the resource.
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
