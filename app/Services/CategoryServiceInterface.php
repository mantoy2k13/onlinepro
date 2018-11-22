<?php
namespace App\Services;

interface CategoryServiceInterface extends BaseServiceInterface
{
    public function generateSlug($title);
}
