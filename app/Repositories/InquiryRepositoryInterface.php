<?php
namespace App\Repositories;

interface InquiryRepositoryInterface extends SingleKeyModelRepositoryInterface
{
    /**
     * @param string $type
     * @param string $name
     * @param string $email
     * @param string $livingCountryCode
     * @param string $order
     * @param string $direction
     * @param int    $offset
     * @param int    $limit
     *
     * @return int \App\Models\Base[]|\Traversable|array
     */
    public function getEnabledWithConditions($type, $name, $email, $livingCountryCode, $order, $direction, $offset, $limit);

    /**
     * @param string $type
     * @param string $name
     * @param string $email
     * @param string $livingCountryCode
     *
     * @return int mixed
     */
    public function countEnabledWithConditions($type, $name, $email, $livingCountryCode);
}
