<?php
namespace App\Repositories;

interface PersonalityRepositoryInterface extends SingleKeyModelRepositoryInterface
{
    /**
     * @param string $nameJa
     * @param string $nameEn
     * @param string $order
     * @param string $direction
     * @param int    $offset
     * @param int    $limit
     *
     * @return \App\Models\Base[]|\Traversable|array
     */
    public function getEnabledWithConditions($nameJa, $nameEn, $order, $direction, $offset, $limit);

    /**
     * @param string $nameJa
     * @param string $nameEn
     *
     * @return int
     */
    public function countEnabledWithConditions($nameJa, $nameEn);
}
