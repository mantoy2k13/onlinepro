<?php
namespace App\Repositories;

interface TimeSlotRepositoryInterface extends SingleKeyModelRepositoryInterface
{
    public function getByStartDate($date, $teacherId);

    public function findByStartDate($date, $teacherId);

    public function getEnabledWithConditions($teacherId, $dateFrom, $notStatus, $order, $direction, $offset, $limit);

    public function countEnabledWithConditions($teacherId, $dateFrom, $notStatus);

    public function allAvailByConditions($teacherId, $date);

    public function getByUserdWithConditions($userId, $order, $direction, $offset, $limit);

    public function countByUserWithConditions($userId);
}
