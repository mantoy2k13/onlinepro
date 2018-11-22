<?php
/**
 * Created by PhpStorm.
 * User: ironh
 * Date: 3/8/2017
 * Time: 10:40 AM.
 */
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaginationRequest;
use App\Repositories\TextBookRepositoryInterface;

class TextBookController extends Controller
{
    /** @var \App\Repositories\TextBookRepositoryInterface */
    protected $textBookRepository;

    public function __construct(TextBookRepositoryInterface $textBookRepository)
    {
        $this->textBookRepository = $textBookRepository;
    }

    public function index(PaginationRequest $request)
    {
        $offset = $request->offset();
        $limit  = $request->limit();

        $title  = $request->get('title', '');
        $level  = $request->get('level', '');
        $count  = $this->textBookRepository->countEnabledWithConditions($title, $level);
        $models = $this->textBookRepository->getEnabledWithConditions($title, $level, 'order', 'asc', $offset, $limit);

        return view('pages.user.text-books.index', [
            'models'    => $models,
            'count'     => $count,
            'offset'    => $offset,
            'limit'     => $limit,
            'titlePage' => trans('user.pages.title.text_book'),
            'title'     => $title,
            'level'     => $level,
            'params'    => [
                'title'  => $title,
                'level'  => $level,
            ],
            'baseUrl' => action('User\TextBookController@index'),
        ]);
    }
}
