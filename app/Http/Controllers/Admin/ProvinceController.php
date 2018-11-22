<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\ProvinceRequest;
use App\Http\Requests\PaginationRequest;
use App\Repositories\CountryRepositoryInterface;
use App\Repositories\ProvinceRepositoryInterface;

class ProvinceController extends Controller
{
    /** @var \App\Repositories\ProvinceRepositoryInterface */
    protected $provinceRepository;

    public function __construct(
        ProvinceRepositoryInterface $provinceRepository,
        CountryRepositoryInterface $countryRepository
    ) {
        $this->provinceRepository = $provinceRepository;
        $this->countryRepository  = $countryRepository;
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
        $offset      = $request->offset();
        $limit       = $request->limit();
        $nameJa      = $request->get('name_ja', '');
        $nameEn      = $request->get('name_en', '');
        $countryCode = $request->get('country_code', '');
        $countries   = $this->countryRepository->all('order', 'asc');
        $count       = $this->provinceRepository->countEnabledWithConditions($nameJa, $nameEn, $countryCode);
        $models      = $this->provinceRepository->getEnabledWithConditions($nameJa, $nameEn, $countryCode, 'updated_at', 'desc', $offset, $limit);

        return view('pages.admin.provinces.index', [
            'models'        => $models,
            'count'         => $count,
            'offset'        => $offset,
            'limit'         => $limit,
            'nameJa'        => $nameJa,
            'nameEn'        => $nameEn,
            'countryCode'   => $countryCode,
            'countries'     => $countries,
            'params'        => [
                'name_ja'       => $nameJa,
                'name_en'       => $nameEn,
                'country_code'  => $countryCode,
            ],
            'baseUrl' => action('Admin\ProvinceController@index'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Response
     */
    public function create()
    {
        $countries = $this->countryRepository->all('order', 'asc');

        return view('pages.admin.provinces.edit', [
            'isNew'     => true,
            'countries' => $countries,
            'province'  => $this->provinceRepository->getBlankModel(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     *
     * @return \Response
     */
    public function store(ProvinceRequest $request)
    {
        $input = $request->only(['name_en', 'name_ja', 'country_code', 'order']);
        $model = $this->provinceRepository->create($input);

        if (empty($model)) {
            return redirect()->back()->withErrors(trans('admin.errors.general.save_failed'));
        }

        return redirect()->action('Admin\ProvinceController@index')
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
        $model     = $this->provinceRepository->find($id);
        $countries = $this->countryRepository->all('order', 'asc');
        if (empty($model)) {
            \App::abort(404);
        }

        return view('pages.admin.provinces.edit', [
            'isNew'     => false,
            'countries' => $countries,
            'province'  => $model,
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
    public function update($id, ProvinceRequest $request)
    {
        /** @var \App\Models\Province $model */
        $model = $this->provinceRepository->find($id);
        if (empty($model)) {
            \App::abort(404);
        }
        $input = $request->only(['name_en', 'name_ja', 'country_code', 'order']);
        $this->provinceRepository->update($model, $input);

        return redirect()->action('Admin\ProvinceController@show', [$id])
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
        /** @var \App\Models\Province $model */
        $model = $this->provinceRepository->find($id);
        if (empty($model)) {
            \App::abort(404);
        }
        $this->provinceRepository->delete($model);

        return redirect()->action('Admin\ProvinceController@index')
                    ->with('message-success', trans('admin.messages.general.delete_success'));
    }
}
