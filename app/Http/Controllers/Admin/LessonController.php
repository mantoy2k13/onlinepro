<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\LessonRequest;
use App\Http\Requests\PaginationRequest;
use App\Repositories\ImageRepositoryInterface;
use App\Repositories\LessonRepositoryInterface;
use App\Services\FileUploadServiceInterface;
use App\Services\ImageServiceInterface;
use App\Services\LessonServiceInterface;

class LessonController extends Controller
{
    /** @var \App\Repositories\LessonRepositoryInterface */
    protected $lessonRepository;

    /** @var \App\Services\LessonServiceInterface */
    protected $lessonService;

    /** @var FileUploadServiceInterface $fileUploadService */
    protected $fileUploadService;
    /** @var ImageRepositoryInterface $imageRepository */
    protected $imageRepository;
    /** @var ImageServiceInterface $imageService */
    protected $imageService;

    public function __construct(
        LessonRepositoryInterface $lessonRepository,
        LessonServiceInterface $lessonService,
        FileUploadServiceInterface $fileUploadService,
        ImageRepositoryInterface $imageRepository,
        ImageServiceInterface $imageService
    ) {
        $this->lessonRepository  = $lessonRepository;
        $this->lessonService     = $lessonService;
        $this->imageRepository   = $imageRepository;
        $this->imageService      = $imageService;
        $this->fileUploadService = $fileUploadService;
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
        $count  = $this->lessonRepository->countEnabledWithConditions($nameJa, $nameEn);
        $models = $this->lessonRepository->getEnabledWithConditions($nameJa, $nameEn, 'updated_at', 'desc', $offset, $limit);

        return view('pages.admin.lessons.index', [
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
            'baseUrl' => action('Admin\LessonController@index'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Response
     */
    public function create()
    {
        return view('pages.admin.lessons.edit', [
            'isNew'     => true,
            'lesson'    => $this->lessonRepository->getBlankModel(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     *
     * @return \Response
     */
    public function store(LessonRequest $request)
    {
        $input = $request->only(['name_ja', 'name_en', 'slug', 'description_ja', 'description_en', 'order']);

        if (empty($input['slug'])) {
            $input['slug'] = $this->lessonService->generateSlug($input['name_en']);
        } else {
            $input['slug'] = $this->lessonService->generateSlug($input['slug']);
        }
        $this->validate($request, [
            'slug' => 'unique:lessons,slug',
        ]);
        $model = $this->lessonRepository->create($input);
        if ($request->hasFile('image')) {
            $file      = $request->file('image');
            $mediaType = $file->getClientMimeType();
            $path      = $file->getPathname();
            $image     = $this->fileUploadService->upload('lesson-image', $path, $mediaType, [
                'entityType' => 'lesson',
                'entityId'   => $model->id,
                'title'      => $request->input('name_en', ''),
            ]);
            if (!empty($image)) {
                $this->lessonRepository->update($model, [
                    'image_id' => $image->id,
                ]);
            }
        }

        if (empty($model)) {
            return redirect()->back()->withErrors(trans('admin.errors.general.save_failed'));
        }

        return redirect()->action('Admin\LessonController@index')
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
        $model = $this->lessonRepository->find($id);
        if (empty($model)) {
            abort(404);
        }

        return view('pages.admin.lessons.edit', [
            'isNew'  => false,
            'lesson' => $model,
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
    public function update($id, LessonRequest $request)
    {
        /** @var \App\Models\Lesson $model */
        $model = $this->lessonRepository->find($id);
        if (empty($model)) {
            abort(404);
        }
        $input = $request->only(['name_ja', 'name_en', 'slug', 'description_ja', 'description_en', 'order']);

        if (empty($input['slug'])) {
            $input['slug'] = $this->lessonService->generateSlug($input['name_en']);
        } else {
            $input['slug'] = $this->lessonService->generateSlug($input['slug']);
        }
        $this->validate($request, [
            'slug' => 'unique:lessons,slug,'.$id,
        ]);
        $this->lessonRepository->update($model, $input);
        if ($request->hasFile('image')) {
            $file      = $request->file('image');
            $mediaType = $file->getClientMimeType();
            $path      = $file->getPathname();
            $image     = $this->fileUploadService->upload('lesson-image', $path, $mediaType, [
                'entityType' => 'lesson',
                'entityId'   => $model->id,
                'title'      => $request->input('name_en', ''),
            ]);
            if (!empty($image)) {
                $this->lessonRepository->update($model, [
                    'image_id' => $image->id,
                ]);
                $imageOld = $model->coverImage;
                if (!empty($imageOld)) {
                    $this->fileUploadService->delete($imageOld);
                    $this->imageRepository->delete($imageOld);
                }
            }
        }

        return redirect()->action('Admin\LessonController@show', [$id])
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
        /** @var \App\Models\Lesson $model */
        $model = $this->lessonRepository->find($id);
        if (empty($model)) {
            abort(404);
        }
        $this->lessonRepository->delete($model);

        return redirect()->action('Admin\LessonController@index')
                    ->with('message-success', trans('admin.messages.general.delete_success'));
    }
}
