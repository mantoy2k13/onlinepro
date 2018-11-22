<?php
namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Repositories\LessonRepositoryInterface;

class LessonRequest extends BaseRequest
{
    /** @var \App\Repositories\LessonRepositoryInterface */
    protected $lessonRepository;

    public function __construct(LessonRepositoryInterface $lessonRepository)
    {
        $this->lessonRepository = $lessonRepository;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name_en' => 'required|max:255|min:2',
            'name_ja' => 'required|max:255|min:2',
            'order'   => 'required|numeric',
        ];
    }

    public function messages()
    {
        return $this->lessonRepository->messages();
    }
}
