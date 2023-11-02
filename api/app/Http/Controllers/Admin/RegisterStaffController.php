<?php

namespace App\Http\Controllers\Admin;

use App\Enums\HttpStatusCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreStaffRequest;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegisterStaffController extends Controller
{
    /**
     * Create a new staff.
     *
     * @return JsonResponse
     */
    public function store(StoreStaffRequest $request) : JsonResponse
    {
        try {
            $staff = User::create($request->only([
                'name',
                'email',
                'username',
                'password'
            ]));
            // since we created the staff account through admin, we auto mark the email as verified.
            $staff->markEmailAsVerified();
        } catch (QueryException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], HttpStatusCode::BAD_REQUEST->value);
        }

        return response()->json([
            'message' => 'Staff created successfully.',
            'user' => $staff
        ], HttpStatusCode::CREATED->value);
    }

    /**
     * Delete a staff.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id) : JsonResponse
    {
        try {
            $staff = User::findOrFail($id);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], HttpStatusCode::BAD_REQUEST->value);
        }

        // we delete their attendances as well.
        $staff->attendances->each(fn ($attendance) => $attendance->delete());
        $staff->delete();

        return response()->json([
            'message' => 'success'
        ]);
    }

    /**
     * Update a staff.
     *
     * @return JsonResponse
     */
    public function update($id, Request $request) : JsonResponse
    {
        try {
            $staff = User::lockForUpdate()->findOrFail($id);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], HttpStatusCode::BAD_REQUEST->value);
        }

        $staff->fill($request->only(['name', 'username']));

        if ($staff->isDirty()) {
            $staff->save();
            return response()->json([
                'message' => 'Success',
                'user' => $staff
            ]);
        } else {
            return response()->json([
                'message' => 'No changes has been made',
                'user' => $staff
            ]);
        }
    }

    public function show($id)
    {
        try {
            $staff = User::findOrFail($id);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], HttpStatusCode::BAD_REQUEST->value);
        }

        return response()->json([
            'message' => 'success',
            'user' => $staff
        ]);
    }
}
