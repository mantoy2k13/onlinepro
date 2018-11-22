<?php
namespace App\Services;

interface TeacherServiceInterface extends AuthenticatableServiceInterface
{
    public function genRatingTeacher($teacherId);

    public function teacherAvail($time, $listTimeSlot);

    /**
     * @param $teacherId
     *
     * @return mixed
     */
    public function updateTeacherRating($teacherId);
}
