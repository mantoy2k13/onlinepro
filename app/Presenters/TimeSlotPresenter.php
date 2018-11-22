<?php
namespace App\Presenters;

use Carbon\Carbon;

class TimeSlotPresenter extends BasePresenter
{
    protected $multilingualFields = [];

    protected $imageFields = [];

    public function dateFormatBookingExpert()
    {
        $startAt = \DateTimeHelper::changeToPresentationTimeZone($this->entity->start_at);

        return $startAt->format('m/d');
    }

    public function timeFormatBookingExpert()
    {
        $startAt = \DateTimeHelper::changeToPresentationTimeZone($this->entity->start_at);

        return $startAt->format('H:i');
    }

    public function getDayOfWeek($date)
    {
        $days        = $this->dayOfWeekInLocale(trans('config.locale.time'));
        $date        = date_create($date);
        $dow_numeric = date_format($date, 'w');

        return $days[$dow_numeric];
    }

    public function dayTimeSlot($date)
    {
        $days        = $this->dayOfWeekInLocale(trans('config.locale.time'));
        $date        = date_create($date);
        $dow_numeric = date_format($date, 'w');

        return date_format($date, 'm/d').'('.$days[$dow_numeric].')';
    }

    public function dayTimeSlotCalendar($date)
    {
        $date   = date_create($date);
        $locale = \LocaleHelper::getLocale();
        if ($locale == 'ja') {
            return date_format($date, 'Y').'年'.date_format($date, 'm').'月';
        } else {
            return date_format($date, 'Y').'-'.date_format($date, 'm');
        }
    }

    public function checkIsHad($time, $listTimeSlot)
    {
        if (!empty($listTimeSlot)) {
            foreach ($listTimeSlot as $ts) {
                $timeSl = \DateTimeHelper::convertToStorageDateTime($time);
                if ($ts->start_at == $timeSl) {
                    return true;
                }
            }
        }

        return false;
    }

    public function drawCalendar($year, $month)
    {
        $dateHeader = $this->dayTimeSlotCalendar($year.'-'.$month);
        $calendar   = '<table><caption class="calendarhead"><span class="calendarday">'.$dateHeader.'</span></caption>';

        $headings = $this->dayOfWeekInLocale(trans('config.locale.time'), '1978-01-02T00:00:00');
        $calendar .= '<tr><th class="calendar-day-head">'.implode('</th><th class="calendar-day-head">', $headings).'</th></tr>';

        $runningDay     = date('w', mktime(0, 0, 0, $month, 0, $year));
        $daysInMonth    = date('t', mktime(0, 0, 0, $month, 1, $year));
        $daysInThisWeek = 1;
        $dayCounter     = 0;

        $calendar .= '<tr>';

        for ($x = 0; $x < $runningDay; $x++):
            $calendar .= '<td> </td>';
        $daysInThisWeek++;
        endfor;

        for ($list_day = 1; $list_day <= $daysInMonth; $list_day++):
            $calendar .= '<td>';
        $calendar .= '<a href="'.$year.'-'.$month.'-'.$list_day.'">'.$list_day.'</a>';

        $calendar .= '</td>';
        if ($runningDay == 6):
                $calendar .= '</tr>';
        if (($dayCounter + 1) != $daysInMonth):
                    $calendar .= '<tr>';
        endif;
        $runningDay     = -1;
        $daysInThisWeek = 0;
        endif;
        $daysInThisWeek++;
        $runningDay++;
        $dayCounter++;
        endfor;

        if ($daysInThisWeek < 8):
            for ($x = 1; $x <= (8 - $daysInThisWeek); $x++):
                $calendar .= '<td> </td>';
        endfor;
        endif;

        $calendar .= '</tr>';

        $calendar .= '</caption></table>';

        return $calendar;
    }

    public function dayOfWeekInLocale($locale, $startTime = '1978-01-01T00:00:00')
    {
        $weekdayFormatter = new \IntlDateFormatter(
            $locale,
            \IntlDateFormatter::NONE,
            \IntlDateFormatter::NONE,
            date_default_timezone_get(),
            \IntlDateFormatter::GREGORIAN,
            'EEEEE'
        );

        $timestamp    = intval((new \DateTime($startTime, new \DateTimeZone('UTC')))->format('U'));
        $weekdayNames = [];
        foreach (range(0, 6) as $index) {
            $weekdayNames[] = $weekdayFormatter->format($timestamp);
            $timestamp += 86400;
        }

        return $weekdayNames;
    }

    public function nextMonth($date)
    {
        $lastDate          = date('t', strtotime($date));
        $currentTime       = Carbon::parse($date);
        $nextMonth         = $currentTime->format('m') + 1;
        $lastDateNextMonth = date('t', strtotime($currentTime->format('Y-').$nextMonth.'-01'));
        if ($lastDateNextMonth < $lastDate) {
            return Carbon::parse($currentTime->format('Y-').$nextMonth.'-'.$lastDateNextMonth);
        }

        return Carbon::parse($date)->addMonth();
    }

    public function preMonth($date)
    {
        $lastDate          = date('t', strtotime($date));
        $currentTime       = Carbon::parse($date);
        $lastMonth         = $currentTime->format('m') - 1;
        $lastDateLastMonth = date('t', strtotime($currentTime->format('Y-').$lastMonth.'-01'));
        if ($lastDateLastMonth < $lastDate) {
            return Carbon::parse($currentTime->format('Y-').$lastMonth.'-'.$lastDateLastMonth);
        }

        return Carbon::parse($date)->subMonth();
    }

    public function dateFormatLightBox()
    {
        $startAt = \DateTimeHelper::changeToPresentationTimeZone($this->entity->start_at);

        return $startAt->format('m/d H:i');
    }

    public function actionAble($timeValue)
    {
        $now      =  \DateTimeHelper::now();
        $timeSlot = \DateTimeHelper::convertToStorageDateTime($timeValue);
        if ($timeSlot < $now) {
            return false;
        }

        return true;
    }

    public function startTimeInTimeZone()
    {
        $timeSlot = \DateTimeHelper::changeToPresentationTimeZone($this->entity->start_at);

        return $timeSlot->format('Y-m-d H:i');
    }
}
