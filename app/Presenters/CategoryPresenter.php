<?php
namespace App\Presenters;

class CategoryPresenter extends BasePresenter
{
    protected $multilingualFields = ['name', 'description'];

    protected $imageFields = [];

    public function getDayOfWeekNameByDate($datetime, $locale = 'ja_JP')
    {
        $weekdayFormatter = new \IntlDateFormatter(
            $locale,
            \IntlDateFormatter::NONE,
            \IntlDateFormatter::NONE,
            date_default_timezone_get(),
            \IntlDateFormatter::GREGORIAN,
            'EEEEE'
        );

        return $weekdayFormatter->format($datetime);
    }
}
