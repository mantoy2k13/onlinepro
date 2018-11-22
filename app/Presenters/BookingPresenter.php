<?php
namespace App\Presenters;

use App\Models\Booking;
use Carbon\Carbon;

class BookingPresenter extends BasePresenter
{
    protected $multilingualFields = [];

    protected $imageFields = [];

    public function teacherName()
    {
        $value = 'N/A';
        if (!empty($this->entity->teacher)) {
            $value = $this->entity->teacher->name;
        }

        return $value;
    }

    public function userName()
    {
        $value = 'N/A';
        if (!empty($this->entity->user)) {
            $value = $this->entity->user->name;
        }

        return $value;
    }

    public function userEmail()
    {
        $value = 'N/A';
        if (!empty($this->entity->user)) {
            $value = $this->entity->user->email;
        }

        return $value;
    }

    public function teacherEmail()
    {
        $value = 'N/A';
        if (!empty($this->entity->teacher)) {
            $value = $this->entity->teacher->email;
        }

        return $value;
    }

    public function timeSlotStart()
    {
        $value = 'N/A';
        if (!empty($this->entity->timeSlot)) {
            $value = \DateTimeHelper::changeToPresentationTimeZone($this->entity->timeSlot->start_at);
        }

        return $value;
    }

    public function timeSlotEnd()
    {
        $value = 'N/A';
        if (!empty($this->entity->timeSlot)) {
            $value = \DateTimeHelper::changeToPresentationTimeZone($this->entity->timeSlot->end_at);
        }

        return $value;
    }

    public function timeInCheckingAccount()
    {
        $locale = \LocaleHelper::getLocale();
        $value  = '';
        if (!empty($this->entity->timeSlot)) {
            if ($locale == 'ja') {
                $value = $this->dateTimeJapanese($this->entity->timeSlot->start_at);
            } else {
                $value = $this->dateTimeCommon($this->entity->timeSlot->start_at, $locale);
            }
        }

        return $value;
    }

    public function category()
    {
        $value = 'N/A';
        if (!empty($this->entity->category)) {
            $value = $this->entity->category->name_ja;
        }

        return $value;
    }

    public function userAbleCancel()
    {
        $now      = \DateTimeHelper::now();
        $timeSlot = $this->entity->timeSlot->start_at;
        if ($this->entity->status == Booking::TYPE_STATUS_CANCELED) {
            return false;
        }
        if ($timeSlot->subHours(config('timeslot.user_cancel_booking_before')) < $now) {
            return false;
        }

        return true;
    }

    public function teacherAbleCancel()
    {
        $now      = \DateTimeHelper::now();
        $timeSlot = $this->entity->timeSlot->start_at;
        if ($this->entity->status == Booking::TYPE_STATUS_CANCELED) {
            return false;
        }
        if ($timeSlot->subHours(config('timeslot.teacher_cancel_booking_before')) < $now) {
            return false;
        }

        return true;
    }

    public function hasLogByTeacher()
    {
        if (!empty($this->entity->reviewLogByTeacher)) {
            return true;
        }

        return false;
    }

    public function hasMyReview()
    {
        if (!empty($this->entity->reviewByUser)) {
            return true;
        }

        return false;
    }

    public function writeLogAble()
    {
        $now             =  \DateTimeHelper::now();
        $timeSlotStartAt = $this->entity->timeSlot->start_at;
        if ($now->diffInMinutes($timeSlotStartAt, false) > 0) {
            return false;
        }

        return true;
    }

    private function dateTimeCommon($dateTime, $locale)
    {
        Carbon::setLocale($locale);
        $value = 'N/A';
        if (!empty($this->entity->timeSlot)) {
            $date = $dateTime;
            $date->setTimezone('Asia/Tokyo');
            $value = $date->format('Y-m-d h:i');
        }

        return $value;
    }

    private function dateTimeJapanese($dateTime)
    {
        $value = 'N/A';
        if (!empty($this->entity->timeSlot)) {
            $date = $dateTime;
            $date->setTimezone('Asia/Tokyo');
            $value = $date->format('Y');
            $value .= '年';
            $value .= $date->format('m');
            $value .= '月';
            $value .= $date->format('d');
            $value .= '日 ';
            $value .= $date->format('H');
            $value .= '時';

            if ($this->entity->timeSlot->start_at->format('i') > 0) {
                $value .= $date->format('i');
                $value .= '分';
            }
            $value .= '〜';
        }

        return $value;
    }
}
