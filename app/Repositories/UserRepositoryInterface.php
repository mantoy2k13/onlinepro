<?php
namespace App\Repositories;

interface UserRepositoryInterface extends AuthenticatableRepositoryInterface
{
    /**
     * @param string $name
     * @param string $email
     * @param string $skypeId
     * @param string $status
     * @param string $order
     * @param string $direction
     * @param int    $offset
     * @param int    $limit
     *
     * @return \App\Models\Base[]|\Traversable|array
     */
    public function getEnabledWithConditions($name, $email, $skypeId, $status, $order, $direction, $offset, $limit);

    /**
     * @param string $name
     * @param string $email
     * @param string $status
     * @param string $skypeId
     *
     * @return int
     */
    public function countEnabledWithConditions($name, $email, $skypeId, $status);

    /**
     * @param string $name
     * @param string $email
     * @param string $skypeId
     * @param string $status
     * @param string $order
     * @param string $direction
     *
     * @return \App\Models\Base[]|\Traversable|array
     */
    public function getAllEnabledWithConditions($name, $email, $skypeId, $status, $order, $direction);

    public function getUserByValidationCode($validationCode);
}
