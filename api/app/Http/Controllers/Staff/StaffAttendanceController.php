<?php

namespace App\Http\Controllers\Staff;

use App\Enums\AttendanceStatus;
use App\Enums\HttpStatusCode;
use App\Http\Controllers\Controller;
use App\Models\AttendanceReport;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class StaffAttendanceController extends Controller
{
    protected $staff;

    protected $start_hour;

    protected $end_hour;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->staff = \Auth::user();

            return $next($request);
        });

        $this->start_hour = Carbon::parse(app('settings')->get('start_working_hours'));
        $this->end_hour = Carbon::parse(app('settings')->get('end_working_hours'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attendance = AttendanceReport::where([
            'user_id' => $this->staff->id
        ])->get();

        return response()->json([
            'message' => 'success',
            'record' => $attendance
        ]);
    }

    /**
     * Clock in current staff, or clock out. This is not just a store function, but it also acts like an update.
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $clockIn = $clockOut = now();
        $fill = ['user_id' => $this->staff->id];
        $latestAttendance = $this->staff->getLatestAttendance;

        if ($request->clock_in) {
            $fill['time_clocked_in'] = $clockIn->toDateTimeString();
            $fill['status'] = $clockIn->eq($this->start_hour) ?
                AttendanceStatus::ONTIME->value : (
                    $clockIn->gt($this->start_hour) ?
                        AttendanceStatus::LATE->value :
                            AttendanceStatus::EARLY->value
                );

            // make sure the latest attendance record's clock out has been filled.
            if ($latestAttendance and !$latestAttendance->time_clocked_out and $latestAttendance->time_clocked_in->isToday()) {
                return response()->json([
                    'message' => 'User has not clocked out yet!',
                ]);
            }

            // Usually when staff clocks in now a new date, attendance has not been created yet. So we create a new one.
            $this->staff->attendances()->create($fill);

        } else if ($latestAttendance) {
            $fill['time_clocked_out'] = $clockOut->toDateTimeString();
            $this->staff->getLatestAttendance->update($fill);

        } else {
            return response()->json([
                'message' => 'unsuccessful'
            ], HttpStatusCode::BAD_REQUEST->value);
        }

        return response()->json([
            'message' => 'success',
            'record' => $this->staff->getLatestAttendance()->first()
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
