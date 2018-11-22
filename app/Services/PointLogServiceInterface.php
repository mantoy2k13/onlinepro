<?php
namespace App\Services;

interface PointLogServiceInterface extends BaseServiceInterface
{
    public function sendNotification($pointLog);
}
