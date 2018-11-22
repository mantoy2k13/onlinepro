<?php
namespace App\Presenters;

use Carbon\Carbon;

class TeacherPresenter extends BasePresenter
{
    protected $multilingualFields = [];

    protected $imageFields = ['profile_image'];

    public function yearOfBith()
    {
        return date_format(date_create($this->entity->date_of_birth), 'Y');
    }

    public function getListPersonality()
    {
        $personalities = '';
        foreach ($this->entity->personalities as $key => $personality) {
            $personalities .= $key ? (', '.$personality->present()->name) : $personality->present()->name;
        }

        return $personalities;
    }

    public function getAverageRating()
    {
        $average = 3;
        $count   = 1;
        foreach ($this->entity->reviews as $key => $review) {
            if ($review['target'] == 'teacher') {
                $average += $review['rating'];
                $count += 1;
            }
        }

        return $count ? round($average / $count, 0, PHP_ROUND_HALF_UP) : 3;
    }

    public function livingCountry()
    {
        $value = 'N/A';
        if (!empty($this->entity->livingCountry)) {
            $value = $this->entity->livingCountry->name_ja;
        }

        return $value;
    }

    public function livingCity()
    {
        $value = 'N/A';
        if (!empty($this->entity->livingCity)) {
            $value = $this->entity->livingCity->name_ja;
        }

        return $value;
    }

    public function homeProvince()
    {
        $value = 'N/A';
        if (!empty($this->entity->homeProvince)) {
            $value = $this->entity->homeProvince->name_ja;
        }

        return $value;
    }

    public function nationalityCountry()
    {
        $value = 'N/A';
        if (!empty($this->entity->nationalityCountry)) {
            $value = $this->entity->nationalityCountry->name_ja;
        }

        return $value;
    }

    public function livingTimeInYear()
    {
        $nowTime    = \DateTimeHelper::now();
        $livingYear = $nowTime->format('Y') - (int) $this->entity->living_start_date->format('Y');
        $country    = '';
        if (!empty($this->entity->livingCountry)) {
            $country = $this->entity->livingCountry->name_ja;
        }
        if ($livingYear <= 1) {
            $value = '（'.$country.'在住1年目）';
        } else {
            $value = '（'.$country.'在住'.$livingYear.'年目）';
        }

        return $value;
    }

    public function bookable($timeValue)
    {
        $now      =  \DateTimeHelper::changeToPresentationTimeZone(\DateTimeHelper::now());
        $timeSlot = Carbon::parse($timeValue);
        if ($timeSlot < $now) {
            return false;
        }

        return true;
    }

    public function ageInRange()
    {
        $year       = $this->entity->year_of_birth;
        $now        = \DateTimeHelper::now();
        $thisYear   = $now->year;
        $base       = intval(($thisYear - $year) / 10) * 10;
        $rangeStart = $base < 20 ? 10 :
            ($base > 50 ? 50 : $base);
        $rangeEnd = $rangeStart == 50 ? '' : $rangeStart + 10;

        return sprintf('%s - %s', $rangeStart, $rangeEnd);
    }

    public function isFavoriteByUser($userId)
    {
        $favorites = $this->entity->favorites;
        foreach ($favorites as $favorite) {
            if ($favorite->user_id == $userId) {
                return true;
            }
        }

        return false;
    }

    public function status()
    {
        $status = '';
        if (!empty($this->entity->deleted_at)) {
            $status = 'deleted';
        }

        return $status;
    }
}
