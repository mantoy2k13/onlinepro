<?php
namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Repositories\InquiryRepositoryInterface;

class InquiryRequest extends BaseRequest
{
    /** @var \App\Repositories\InquiryRepositoryInterface */
    protected $inquiryRepository;

    public function __construct(InquiryRepositoryInterface $inquiryRepository)
    {
        $this->inquiryRepository = $inquiryRepository;
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
            'type'                => 'required',
            'name'                => 'required',
            'email'               => 'required|email',
            'living_country_code' => 'required',
            'content'             => 'required',
        ];
    }

    public function messages()
    {
        return $this->inquiryRepository->messages();
    }
}
