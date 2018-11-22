<?php
namespace App\Repositories;

interface LessonRepositoryInterface extends SingleKeyModelRepositoryInterface
{
    /**
     * @param string $nameJa
     * @param string $nameEn
     * @param string $order
     * @param string $direction
     * @param int    $offset
     * @param int    $limit
     *
     * @return mixed
     */
    public function getEnabledWithConditions($nameJa, $nameEn, $order, $direction, $offset, $limit);

    /**
     * @param string $nameJa
     * @param string $nameEn
     *
     * @return mixed
     */
    public function countEnabledWithConditions($nameJa, $nameEn);
}
