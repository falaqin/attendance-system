<?php
namespace App\Enums;

enum AttendanceStatus : string
{
    case LATE = 'Late';
    case EARLY = 'Early';
    case ONTIME = 'On-time';
}
