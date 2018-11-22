<?php
namespace App\Repositories;

interface TextBookRepositoryInterface extends SingleKeyModelRepositoryInterface
{
    /**
     * @param string $title
     * @param string $level
     * @param string $order
     * @param string $direction
     * @param int    $offset
     * @param int    $limit
     *
     * @return \App\Models\Base[]|\Traversable|array
     */
    public function getEnabledWithConditions($title, $level, $order, $direction, $offset, $limit);

    /**
     * @param string $title
     * @param string $level
     *
     * @return int
     */
    public function countEnabledWithConditions($title, $level);
}
