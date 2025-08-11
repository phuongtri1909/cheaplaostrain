<?php

namespace App\Helpers;

use Carbon\Carbon;

class TimezoneHelper
{
    const BUSINESS_TIMEZONE = 'Asia/Vientiane';

    /**
     * Get current date/time in business timezone
     */
    public static function businessNow()
    {
        return Carbon::now(self::BUSINESS_TIMEZONE);
    }

    /**
     * Parse date in business timezone
     */
    public static function parseInBusinessTimezone($date)
    {
        return Carbon::parse($date, self::BUSINESS_TIMEZONE);
    }

    /**
     * Convert UTC to business timezone
     */
    public static function utcToBusinessTime($utcDateTime)
    {
        return Carbon::parse($utcDateTime)->setTimezone(self::BUSINESS_TIMEZONE);
    }

    /**
     * Convert business time to UTC
     */
    public static function businessTimeToUtc($businessDateTime)
    {
        return Carbon::parse($businessDateTime, self::BUSINESS_TIMEZONE)->utc();
    }
}
