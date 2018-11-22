<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\InquiryRequest;
use App\Http\Requests\PaginationRequest;
use App\Repositories\CountryRepositoryInterface;
use App\Repositories\InquiryRepositoryInterface;

class InquiryController extends Controller
{
    /** @var \App\Repositories\InquiryRepositoryInterface */
    protected $inquiryRepository;

    /** @var \App\Repositories\CountryRepositoryInterface */
    protected $countryRepository;

    public function __construct(
        InquiryRepositoryInterface $inquiryRepository,
        CountryRepositoryInterface $countryRepository
    ) {
        $this->inquiryRepository = $inquiryRepository;
        $this->countryRepository = $countryRepository;
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
        $offset            = $request->offset();
        $limit             = $request->limit();
        $type              = $request->get('type', '');
        $name              = $request->get('name', '');
        $livingCountryCode = $request->get('living_country_code', '');
        $email             = $request->get('email', '');
        $countries         = $this->countryRepository->all('order', 'asc');
        $count             = $this->inquiryRepository->countEnabledWithConditions($type, $name, $email, $livingCountryCode);
        $models            = $this->inquiryRepository->getEnabledWithConditions($type, $name, $email, $livingCountryCode, 'updated_at', 'desc', $offset, $limit);

        return view('pages.admin.inquiries.index', [
            'models'              => $models,
            'count'               => $count,
            'offset'              => $offset,
            'limit'               => $limit,
            'type'                => $type,
            'name'                => $name,
            'livingCountryCode'   => $livingCountryCode,
            'email'               => $email,
            'countries'           => $countries,
            'params'              => [
                'type'                 => $type,
                'name'                 => $name,
                'living_country_code'  => $livingCountryCode,
                'email'                => $email,
            ],
            'baseUrl' => action('Admin\InquiryController@index'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Response
     */
    public function create()
    {
        return view('pages.admin.inquiries.edit', [
            'isNew'      => true,
            'countries'  => $this->countryRepository->all('order', 'asc'),
            'inquiry'    => $this->inquiryRepository->getBlankModel(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     *
     * @return \Response
     */
    public function store(InquiryRequest $request)
    {
        $input = $request->only([]);

        $model = $this->inquiryRepository->create($input);

        if (empty($model)) {
            return redirect()->back()->withErrors(trans('admin.errors.general.save_failed'));
        }

        return redirect()->action('Admin\InquiryController@index')
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
        $model = $this->inquiryRepository->find($id);
        if (empty($model)) {
            abort(404);
        }

        return view('pages.admin.inquiries.edit', [
            'isNew'      => false,
            'countries'  => $this->countryRepository->all('order', 'asc'),
            'inquiry'    => $model,
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
    public function update($id, InquiryRequest $request)
    {
        /** @var \App\Models\Inquiry $model */
        $model = $this->inquiryRepository->find($id);
        if (empty($model)) {
            abort(404);
        }
        $input = $request->only([
            'type',
            'user_id',
            'name',
            'email',
            'living_country_code',
            'content',
        ]);

        $this->inquiryRepository->update($model, $input);

        return redirect()->action('Admin\InquiryController@show', [$id])
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
        /** @var \App\Models\Inquiry $model */
        $model = $this->inquiryRepository->find($id);
        if (empty($model)) {
            abort(404);
        }
        $this->inquiryRepository->delete($model);

        return redirect()->action('Admin\InquiryController@index')
                    ->with('message-success', trans('admin.messages.general.delete_success'));
    }
}
