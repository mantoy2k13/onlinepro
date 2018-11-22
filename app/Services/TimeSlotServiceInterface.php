<?php
namespace App\Services;

interface TimeSlotServiceInterface extends BaseServiceInterface
{
    public function isAvailable($timeSlotId);

    public function closeOpenAllTimeSlot($date, $status, $teacher);
}
