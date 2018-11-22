<?php
namespace App\Repositories;

interface ProvinceRepositoryInterface extends SingleKeyModelRepositoryInterface
{
    public function getEnabledWithConditions($nameJa, $nameEn, $countryCode, $order, $direction, $offset, $limit);

    public function countEnabledWithConditions($nameJa, $nameEn, $countryCode);
}
