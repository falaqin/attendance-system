<?php

namespace App\Http\Controllers\Staff;

use App\Enums\AttendanceStatus;
use App\Enums\HttpStatusCode;
use App\Http\Controllers\Controller;
use App\Models\AttendanceReport;
use Carbon\Carbon as CarbonCarbon;
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
     * Get all dashboard dependencies for clock in and clock out
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function dashboard(Request $request) : JsonResponse
    {
        $latestAttendance = $request->user()->getLatestAttendance;

        // If there is no latest attendance available, it means user is new. So we return a response with ability to clock in.
        if (!$latestAttendance) {
            return response()->json([
                'message' => 'Successful',
                'dashboard' => [
                    'can_clock_in' => true,
                    'can_clock_out' => false,
                    'start_time' => $this->start_hour,
                    'end_time' => $this->end_hour,
                    'latest_attendance' => null,
                    'is_today' => false
                ]
            ]);
        }

        // if clock in is today, meaning already clocked in today
        // if clock out is null, meaning haven't clocked out yet.
        // if clock out is today, meaning today is done.

        $can_clock_in = null;
        $can_clock_out = null;

        if ($latestAttendance->time_clocked_in->isToday()) {
            if (!$latestAttendance->time_clocked_out) {
                $can_clock_out = true;
                $can_clock_in = false;
            } else {
                $can_clock_in = false;
                $can_clock_out = false;
            }
        } else if ($latestAttendance->time_clocked_in->isPast()) {
            $can_clock_in = true;
            $can_clock_out = false;
        }

        return response()->json([
            'message' => 'Successful',
            'dashboard' => [
                'can_clock_in' => $can_clock_in,
                'can_clock_out' => $can_clock_out,
                'start_time' => $this->start_hour,
                'end_time' => $this->end_hour,
                'latest_attendance' => $latestAttendance,
                'is_today' => $latestAttendance->time_clocked_in->isToday()
            ]
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attendance = AttendanceReport::where([
            'user_id' => $this->staff->id
        ])
            ->get()
            ->each(function ($att) {
                $att->name = $att->user->name;
            });

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
                ], HttpStatusCode::BAD_REQUEST->value);
            }

            // Usually when staff clocks in now a new date, attendance has not been created yet. So we create a new one.
            $this->staff->attendances()->create($fill);

        } else if ($latestAttendance) {
            $fill['time_clocked_out'] = $clockOut->toDateTimeString();
            $this->staff->getLatestAttendance->update($fill);

        } else {
            return response()->json([
                'message' => 'User has not clocked in yet!'
            ], HttpStatusCode::BAD_REQUEST->value);
        }

        return response()->json([
            'message' => 'Clocked!',
            'record' => $this->staff->getLatestAttendance()->first()
        ]);
    }
}
