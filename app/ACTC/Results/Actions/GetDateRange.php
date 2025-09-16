<?php

declare(strict_types=1);

namespace ACTC\Results\Actions;

use ACTC\Results\ResultCategory;

class GetDateRange
{
    public function __invoke(ResultCategory $item): string
    {
        if (!$item->start_at || !$item->end_at) {
            return '';
        }

        $start = $item->start_at->format('F');
        $startYear = $item->start_at->format('Y');

        $end = $item->end_at->format('F');
        $endYear = $item->end_at->format('Y');

        $differentYears = false;

        if ($startYear !== $endYear) {
            $differentYears = true;
            $start .= ' '.$startYear;
        }

        $dates = [
            $start,
        ];

        if ($end !== $start) {
            if ($differentYears) {
                $end .= ' '.$endYear;
            }
            $dates[] = $end;
        }

        $dateRange = implode('-', $dates);
        if (!$differentYears) {
            $dateRange .= ' '.$startYear;
        }

        return $dateRange;
    }
}
