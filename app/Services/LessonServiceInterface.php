<?php
namespace App\Services;

interface LessonServiceInterface extends BaseServiceInterface
{
    public function generateSlug($title);
}
