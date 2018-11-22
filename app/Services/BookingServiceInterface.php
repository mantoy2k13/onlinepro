<?php
namespace App\Services;

interface BookingServiceInterface extends BaseServiceInterface
{
    public function checkUserBooking($userId, $timeSlotId);

    public function listBookingThisMonth($teacher);

    public function booking($user, $booking);

    public function userCancelBooking($user, $booking);

    public function teacherCancelBooking($user, $booking);

    public function bookingReviews($bookings);

    public function adminCancelBooking($booking);

    /**
     * @param int $userId
     *
     * @return bool
     */
    public function bookingAbleToday($userId);

    /**
     * @return mixed
     */
    public function updateBookingFinish();
}
