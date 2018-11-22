<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\CategoryRequest;
use App\Http\Requests\PaginationRequest;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\ImageRepositoryInterface;
use App\Services\CategoryServiceInterface;
use App\Services\FileUploadServiceInterface;
use App\Services\ImageServiceInterface;

class CategoryController extends Controller
{
    /** @var \App\Repositories\CategoryRepositoryInterface */
    protected $categoryRepository;

    /** @var FileUploadServiceInterface $fileUploadService */
    protected $fileUploadService;
    /** @var ImageRepositoryInterface $imageRepository */
    protected $imageRepository;
    /** @var ImageServiceInterface $imageService */
    protected $imageService;

    /** @var CategoryServiceInterface $categoryService */
    protected $categoryService;

    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        FileUploadServiceInterface $fileUploadService,
        ImageRepositoryInterface $imageRepository,
        ImageServiceInterface $imageService,
        CategoryServiceInterface $categoryService
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->fileUploadService  = $fileUploadService;
        $this->imageRepository    = $imageRepository;
        $this->imageService       = $imageService;
        $this->categoryService    = $categoryService;
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
        $count  = $this->categoryRepository->countEnabledWithConditions($nameJa, $nameEn);
        $models = $this->categoryRepository->getEnabledWithConditions($nameJa, $nameEn, 'updated_at', 'desc', $offset, $limit);

        return view('pages.admin.categories.index', [
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
            'baseUrl' => action('Admin\CategoryController@index'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Response
     */
    public function create()
    {
        return view('pages.admin.categories.edit', [
            'isNew'     => true,
            'category'  => $this->categoryRepository->getBlankModel(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     *
     * @return \Response
     */
    public function store(CategoryRequest $request)
    {
        $input = $request->only(['name_ja', 'name_en', 'slug', 'description_ja', 'description_en', 'order']);

        if (empty($input['slug'])) {
            $input['slug'] = $this->categoryService->generateSlug($input['name_en']);
        } else {
            $input['slug'] = $this->categoryService->generateSlug($input['slug']);
        }
        $this->validate($request, [
            'slug' => 'unique:categories,slug',
        ]);
        $model = $this->categoryRepository->create($input);
        if ($request->hasFile('image')) {
            $image = $model->coverImage;
            if (!empty($image)) {
                $this->fileUploadService->delete($image);
                $this->imageRepository->delete($image);
            }
            $file      = $request->file('image');
            $mediaType = $file->getClientMimeType();
            $path      = $file->getPathname();
            $image     = $this->fileUploadService->upload('category-image', $path, $mediaType, [
                'entityType' => 'category',
                'entityId'   => $model->id,
                'title'      => $request->input('name_en', ''),
            ]);
            if (!empty($image)) {
                $this->countryRepository->update($model, [
                    'image_id' => $image->id,
                ]);
            }
        }
        if (empty($model)) {
            return redirect()->back()->withErrors(trans('admin.errors.general.save_failed'));
        }

        return redirect()->action('Admin\CategoryController@index')
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
        $model = $this->categoryRepository->find($id);
        if (empty($model)) {
            \App::abort(404);
        }

        return view('pages.admin.categories.edit', [
            'isNew'    => false,
            'category' => $model,
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
    public function update($id, CategoryRequest $request)
    {
        /** @var \App\Models\Category $model */
        $model = $this->categoryRepository->find($id);
        if (empty($model)) {
            \App::abort(404);
        }
        $input = $request->only(['name_ja', 'name_en', 'slug', 'description_ja', 'description_en', 'order']);
        if (empty($input['slug'])) {
            $input['slug'] = $this->categoryService->generateSlug($input['name_en']);
        } else {
            $input['slug'] = $this->categoryService->generateSlug($input['slug']);
        }
        $this->validate($request, [
            'slug' => 'unique:categories,slug,'.$id,
        ]);
        $this->categoryRepository->update($model, $input);
        if ($request->hasFile('image')) {
            $file      = $request->file('image');
            $mediaType = $file->getClientMimeType();
            $path      = $file->getPathname();
            $image     = $this->fileUploadService->upload('category-image', $path, $mediaType, [
                'entityType' => 'category',
                'entityId'   => $model->id,
                'title'      => $request->input('name_en', ''),
            ]);
            if (!empty($image)) {
                $this->categoryRepository->update($model, [
                    'image_id' => $image->id,
                ]);
            }
        }

        return redirect()->action('Admin\CategoryController@show', [$id])
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
        /** @var \App\Models\Category $model */
        $model = $this->categoryRepository->find($id);
        if (empty($model)) {
            \App::abort(404);
        }
        $this->categoryRepository->delete($model);

        return redirect()->action('Admin\CategoryController@index')
                    ->with('message-success', trans('admin.messages.general.delete_success'));
    }
}
