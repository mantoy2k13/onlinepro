<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\TextBookRequest;
use App\Http\Requests\PaginationRequest;
use App\Repositories\ImageRepositoryInterface;
use App\Repositories\TextBookRepositoryInterface;
use App\Services\FileUploadServiceInterface;
use App\Services\ImageServiceInterface;

class TextBookController extends Controller
{
    /** @var \App\Repositories\TextBookRepositoryInterface */
    protected $textBookRepository;

    /** @var FileUploadServiceInterface $fileUploadService */
    protected $fileUploadService;
    /** @var ImageRepositoryInterface $imageRepository */
    protected $imageRepository;
    /** @var ImageServiceInterface $imageService */
    protected $imageService;

    public function __construct(
        TextBookRepositoryInterface $textBookRepository,
        FileUploadServiceInterface $fileUploadService,
        ImageRepositoryInterface $imageRepository,
        ImageServiceInterface $imageService
    ) {
        $this->textBookRepository = $textBookRepository;
        $this->fileUploadService  = $fileUploadService;
        $this->imageRepository    = $imageRepository;
        $this->imageService       = $imageService;
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

        $title  = $request->get('title', '');
        $level  = $request->get('level', '');
        $count  = $this->textBookRepository->countEnabledWithConditions($title, $level);
        $models = $this->textBookRepository->getEnabledWithConditions($title, $level, 'updated_at', 'desc', $offset, $limit);

        return view('pages.admin.text-books.index', [
            'models'  => $models,
            'count'   => $count,
            'offset'  => $offset,
            'limit'   => $limit,
            'title'   => $title,
            'level'   => $level,
            'params'  => [
                'title'    => $title,
                'name_en'  => $level,
            ],
            'baseUrl' => action('Admin\TextBookController@index'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Response
     */
    public function create()
    {
        return view('pages.admin.text-books.edit', [
            'isNew'     => true,
            'textBook'  => $this->textBookRepository->getBlankModel(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     *
     * @return \Response
     */
    public function store(TextBookRequest $request)
    {
        $input = $request->only(['title', 'level', 'content', 'order']);

        $model = $this->textBookRepository->create($input);
        if ($request->hasFile('file-pdf')) {
            $file       = $request->file('file-pdf');
            $mediaType  = $file->getClientMimeType();
            $path       = $file->getPathname();
            $fileUpload = $this->fileUploadService->upload('textbook-file', $path, $mediaType, [
                'entityType' => 'textbook',
                'entityId'   => $model->id,
                'title'      => $request->input('title', ''),
            ]);
            if (!empty($fileUpload)) {
                $this->textBookRepository->update($model, [
                    'file_id' => $fileUpload->id,
                ]);
            }
        }

        if (empty($model)) {
            return redirect()->back()->withErrors(trans('admin.errors.general.save_failed'));
        }

        return redirect()->action('Admin\TextBookController@index')
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
        $model = $this->textBookRepository->find($id);
        if (empty($model)) {
            abort(404);
        }

        return view('pages.admin.text-books.edit', [
            'isNew'    => false,
            'textBook' => $model,
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
    public function update($id, TextBookRequest $request)
    {
        /** @var \App\Models\TextBook $model */
        $model = $this->textBookRepository->find($id);
        if (empty($model)) {
            abort(404);
        }
        $input = $request->only(['title', 'level', 'content', 'order']);

        $this->textBookRepository->update($model, $input);
        if ($request->hasFile('file-pdf')) {
            $file       = $request->file('file-pdf');
            $mediaType  = $file->getClientMimeType();
            $path       = $file->getPathname();
            $fileUpload = $this->fileUploadService->upload('textbook-file', $path, $mediaType, [
                'entityType' => 'textbook',
                'entityId'   => $model->id,
                'title'      => $request->input('title', ''),
            ]);
            if (!empty($fileUpload)) {
                $oldFile = $model->file;
                if (!empty($oldFile)) {
                    $this->fileUploadService->delete($oldFile);
                }
                $this->textBookRepository->update($model, [
                    'file_id' => $fileUpload->id,
                ]);
            }
        }

        return redirect()->action('Admin\TextBookController@show', [$id])
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
        /** @var \App\Models\TextBook $model */
        $model = $this->textBookRepository->find($id);
        if (empty($model)) {
            abort(404);
        }
        $this->textBookRepository->delete($model);

        return redirect()->action('Admin\TextBookController@index')
                    ->with('message-success', trans('admin.messages.general.delete_success'));
    }
}
