<?php
namespace App\Repositories\Eloquent;

use App\Models\Article;
use App\Repositories\ArticleRepositoryInterface;

class ArticleRepository extends SingleKeyModelRepository implements ArticleRepositoryInterface
{
    public function getBlankModel()
    {
        return new Article();
    }

    public function rules()
    {
        return [
        ];
    }

    public function messages()
    {
        return [
        ];
    }

    public function findBySlug($slug)
    {
        return Article::whereSlug($slug)->first();
    }
}
