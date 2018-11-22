<?php
namespace App\Http\Requests\User;

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
            'content' => 'required',
            'rating'  => 'required|in:1,2,3,4,5',
        ];
    }

    public function messages()
    {
        return [
            'content.required' => trans('validation.content_required'),
            'rating.required'  => trans('validation.rating_required'),
            'rating.in'        => trans('validation.rating_in'),
        ];
    }
}
