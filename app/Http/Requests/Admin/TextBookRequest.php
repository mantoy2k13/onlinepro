<?php
namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Repositories\TextBookRepositoryInterface;

class TextBookRequest extends BaseRequest
{
    /** @var \App\Repositories\TextBookRepositoryInterface */
    protected $textBookRepository;

    public function __construct(TextBookRepositoryInterface $textBookRepository)
    {
        $this->textBookRepository = $textBookRepository;
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
        return $this->textBookRepository->rules();
    }

    public function messages()
    {
        return $this->textBookRepository->messages();
    }
}
