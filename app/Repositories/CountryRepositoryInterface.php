<?php
namespace App\Repositories;

interface CountryRepositoryInterface extends SingleKeyModelRepositoryInterface
{
    /**
     * @param string $nameJa
     * @param string $nameEn
     * @param string $countryCode
     * @param string $order
     * @param string $direction
     * @param int    $offset
     * @param int    $limit
     *
     * @return \App\Models\Base[]|\Traversable|array
     */
    public function getEnabledWithConditions($nameJa, $nameEn, $countryCode, $order, $direction, $offset, $limit);

    /**
     * @param string $nameJa
     * @param string $nameEn
     * @param string $countryCode
     *
     * @return int
     */
    public function countEnabledWithConditions($nameJa, $nameEn, $countryCode);
}
