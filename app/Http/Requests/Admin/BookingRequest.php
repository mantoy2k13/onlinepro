<?php
namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Repositories\BookingRepositoryInterface;

class BookingRequest extends BaseRequest
{
    /** @var \App\Repositories\BookingRepositoryInterface */
    protected $bookingRepository;

    public function __construct(BookingRepositoryInterface $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
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
        return $this->bookingRepository->rules();
    }

    public function messages()
    {
        return $this->bookingRepository->messages();
    }
}
