<?php

namespace App\Traits;

use Carbon\Carbon;

trait DateTrait{
    protected function getDates($startDate, $endDate)
    {
        $dates = [];
        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);

        while($startDate->lte($endDate)){
            $dates[] = $startDate->format('Y-m-d');
            $startDate->addDay();
        }

        return $dates;
    }
}
