<?php
namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Repositories\ReviewRepositoryInterface;

class ReviewRequest extends BaseRequest
{
    /** @var \App\Repositories\ReviewRepositoryInterface */
    protected $reviewRepository;

    public function __construct(ReviewRepositoryInterface $reviewRepository)
    {
        $this->reviewRepository = $reviewRepository;
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
            'user_id'    => 'required',
            'teacher_id' => 'required',
            'booking_id' => 'required',
            'rating'     => 'required|in:1,2,3,4,5',
        ];
    }

    public function messages()
    {
        return $this->reviewRepository->messages();
    }
}
