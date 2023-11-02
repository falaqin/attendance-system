<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttendanceReport;
use Illuminate\Http\Request;

class AttendanceRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $record = AttendanceReport::with('user')->get();

        return response()->json([
            'message' => 'success',
            'record' => $record
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id, AttendanceReport $attendanceReport)
    {
        return response()->json([
            'message' => 'success',
            'record' => $attendanceReport->find($id)->load('user')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request, AttendanceReport $attendanceReport)
    {
        $attendanceReport = $attendanceReport->find($id);
        $attendanceReport->update($request->only([
            'status',
            'time_clocked_in',
            'time_clocked_out'
        ]));

        return response()->json([
            'message' => 'success',
            'record' => $attendanceReport->load('user')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, AttendanceReport $attendanceReport)
    {
        $attendanceReport = $attendanceReport->find($id);
        $attendanceReport->delete();

        return response()->json([
            'message' => 'success',
            'record' => $attendanceReport->load('user')
        ]);
    }
}
