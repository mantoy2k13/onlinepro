<?php
namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Repositories\CategoryRepositoryInterface;

class CategoryRequest extends BaseRequest
{
    /** @var \App\Repositories\CategoryRepositoryInterface */
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
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
        return $this->categoryRepository->messages();
    }
}
