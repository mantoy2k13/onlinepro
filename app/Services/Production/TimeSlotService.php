<?php
namespace App\Services\Production;

use App\Models\Booking;
use App\Repositories\TimeSlotRepositoryInterface;
use App\Services\TimeSlotServiceInterface;

class TimeSlotService extends BaseService implements TimeSlotServiceInterface
{
    /** @var \App\Repositories\TimeSlotRepositoryInterface */
    protected $timeSlotRepository;

    public function __construct(
        TimeSlotRepositoryInterface     $timeSlotRepository
    ) {
        $this->timeSlotRepository       = $timeSlotRepository;
    }

    public function isAvailable($timeSlotId)
    {
        $now      =  \DateTimeHelper::now();
        $flag     = true;
        /** @var \App\Models\TimeSlot $timeSlot */
        $timeSlot = $this->timeSlotRepository->find($timeSlotId);
        if (empty($timeSlot) || $now->diffInHours($timeSlot->start_at, false) < 2) {
            return false;
        }
        $bookings = $timeSlot->booking;
        foreach ($bookings as $booking) {
            if ($booking['status'] != Booking::TYPE_STATUS_CANCELED) {
                $flag = false;
            }
        }

        return $flag;
    }

    public function closeOpenAllTimeSlot($date, $status, $teacher)
    {
        $timeArray = config('timeslot.timeSlot');
        $nowTime   = \DateTimeHelper::now();
        foreach ($timeArray as $tms) {
            $datetime = $date.' '.$tms;
            $startAt  = \DateTimeHelper::convertToStorageDateTime($datetime);
            $endAt    = \DateTimeHelper::convertToStorageDateTime($datetime);
            $endAt    = $endAt->addMinutes(config('timeslot.start_end_config_in_minute'));
            if ($startAt > $nowTime) {
                $timeSlot = $this->timeSlotRepository->findByStartDate($startAt, $teacher->id);
                if ($status == 'off') {
                    if (!empty($timeSlot)) {
                        if (count($timeSlot->bookingPending) <= 0) {
                            $this->timeSlotRepository->delete($timeSlot);
                        }
                    }
                } else {
                    if (empty($timeSlot)) {
                        $input    = ['teacher_id' => $teacher->id, 'start_at' => $startAt, 'end_at' => $endAt];
                        $timeSlot = $this->timeSlotRepository->create($input);
                    }
                }
            }
        }
    }
}
