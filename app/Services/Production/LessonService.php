<?php
namespace App\Services\Production;

use App\Services\LessonServiceInterface;

class LessonService extends BaseService implements LessonServiceInterface
{
    public function generateSlug($title)
    {
        return str_slug($title);
    }
}
