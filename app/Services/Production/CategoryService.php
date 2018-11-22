<?php
namespace App\Services\Production;

use App\Services\CategoryServiceInterface;

class CategoryService extends BaseService implements CategoryServiceInterface
{
    public function generateSlug($title)
    {
        return str_slug($title);
    }
}
