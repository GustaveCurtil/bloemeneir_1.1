<?php

namespace App\Helpers;

use App\Models\Order;
use Illuminate\Support\Carbon;

class DateFormattingHelper
{
    public static function formatOrderToHours(Order $order, string $locale): string
    {
        Carbon::setLocale($locale);
        $time_start = Carbon::parse($order->takeaway_start_time);

        if ($time_start->minute === 0) {
            $formattedStart = $time_start->format('H') . 'u';
        } else {
            $formattedStart = $time_start->format('H') . 'u' . $time_start->format('i');
        }
        $time_end = Carbon::parse($order->takeaway_end_time);

        if ($time_end->minute === 0) {
            $formattedEnd = $time_end->format('H') . 'u';
        } else {
            $formattedEnd = $time_end->format('H') . 'u' . $time_end->format('i');
        }
        
        return $formattedStart . " tot " . $formattedEnd;
    }
}