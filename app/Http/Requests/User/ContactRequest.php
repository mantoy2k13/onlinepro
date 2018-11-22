<?php
namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;
use App\Repositories\InquiryRepositoryInterface;

class ContactRequest extends BaseRequest
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
        $rules = [
            'name'                  => 'required',
            'living_country_code'   => 'required',
            'email'                 => 'required|email',
            'type'                  => 'required',
            'content'               => 'required',
        ];

        return $rules;
    }

    public function messages()
    {
        return $this->inquiryRepository->messages();
    }
}
