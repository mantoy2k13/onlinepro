<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\PersonalityRequest;
use App\Http\Requests\PaginationRequest;
use App\Repositories\PersonalityRepositoryInterface;

class PersonalityController extends Controller
{
    /** @var \App\Repositories\PersonalityRepositoryInterface */
    protected $personalityRepository;

    public function __construct(
        PersonalityRepositoryInterface $personalityRepository
    ) {
        $this->personalityRepository = $personalityRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param \App\Http\Requests\PaginationRequest $request
     *
     * @return \Response
     */
    public function index(PaginationRequest $request)
    {
        $offset = $request->offset();
        $limit  = $request->limit();
        $nameJa = $request->get('name_ja', '');
        $nameEn = $request->get('name_en', '');
        $count  = $this->personalityRepository->countEnabledWithConditions($nameJa, $nameEn);
        $models = $this->personalityRepository->getEnabledWithConditions($nameJa, $nameEn, 'updated_at', 'desc', $offset, $limit);

        return view('pages.admin.personalities.index', [
            'models'  => $models,
            'count'   => $count,
            'offset'  => $offset,
            'limit'   => $limit,
            'nameJa'  => $nameJa,
            'nameEn'  => $nameEn,
            'params'  => [
                'name_ja'  => $nameJa,
                'name_en'  => $nameEn,
            ],
            'baseUrl' => action('Admin\PersonalityController@index'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Response
     */
    public function create()
    {
        return view('pages.admin.personalities.edit', [
            'isNew'       => true,
            'personality' => $this->personalityRepository->getBlankModel(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     *
     * @return \Response
     */
    public function store(PersonalityRequest $request)
    {
        $input = $request->only(['name_en', 'name_ja', 'name_vi', 'name_zh', 'name_ru', 'name_ko', 'order']);
        $model = $this->personalityRepository->create($input);

        if (empty($model)) {
            return redirect()->back()->withErrors(trans('admin.errors.general.save_failed'));
        }

        return redirect()->action('Admin\PersonalityController@index')
            ->with('message-success', trans('admin.messages.general.create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Response
     */
    public function show($id)
    {
        $model = $this->personalityRepository->find($id);
        if (empty($model)) {
            \App::abort(404);
        }

        return view('pages.admin.personalities.edit', [
            'isNew'       => false,
            'personality' => $model,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @param     $request
     *
     * @return \Response
     */
    public function update($id, PersonalityRequest $request)
    {
        /** @var \App\Models\Personality $model */
        $model = $this->personalityRepository->find($id);
        if (empty($model)) {
            \App::abort(404);
        }
        $input = $request->only(['name_en', 'name_ja', 'name_vi', 'name_zh', 'name_ru', 'name_ko', 'order']);
        $this->personalityRepository->update($model, $input);

        return redirect()->action('Admin\PersonalityController@show', [$id])
                    ->with('message-success', trans('admin.messages.general.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Response
     */
    public function destroy($id)
    {
        /** @var \App\Models\Personality $model */
        $model = $this->personalityRepository->find($id);
        if (empty($model)) {
            \App::abort(404);
        }
        $this->personalityRepository->delete($model);

        return redirect()->action('Admin\PersonalityController@index')
                    ->with('message-success', trans('admin.messages.general.delete_success'));
    }
}
