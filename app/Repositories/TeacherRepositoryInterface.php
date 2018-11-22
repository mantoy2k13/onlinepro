<?php
namespace App\Repositories;

interface TeacherRepositoryInterface extends AuthenticatableRepositoryInterface
{
    /**
     * @param string $name
     * @param string $email
     * @param string $livingCountryCode
     * @param string $status
     * @param int    $livingCityId
     * @param string $order
     * @param string $direction
     * @param int    $offset
     * @param int    $limit
     *
     * @return \App\Models\Base[]|\Traversable|array
     */
    public function getEnabledWithConditions($name, $email, $livingCountryCode, $livingCityId, $status, $order, $direction, $offset, $limit);

    public function getAllEnabledWithConditions($name, $email, $livingCountryCode, $livingCityId, $status, $order, $direction);

    /**
     * @param string $name
     * @param string $email
     * @param string $livingCountryCode
     * @param string $status
     * @param int    $livingCityId
     *
     * @return int
     */
    public function countEnabledWithConditions($name, $email, $livingCountryCode, $livingCityId, $status);

    public function countTeacherFreeWithConditions($livingCountryCode, $personality, $date, $order, $direction);

    public function getTeacherFreeWithConditions($livingCountryCode, $personality, $date, $order, $direction, $offset, $limit);

    public function getFavoriteTeacherByUserId($userId, $order, $direction, $offset, $limit);

    public function AllFavoriteTeacherByUserId($userId, $order, $direction);

    public function countFavoriteTeacherByUserId($userId);
}
