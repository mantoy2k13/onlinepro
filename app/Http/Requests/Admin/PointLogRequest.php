<?php
namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Repositories\PointLogRepositoryInterface;

class PointLogRequest extends BaseRequest
{
    /** @var \App\Repositories\PointLogRepositoryInterface */
    protected $pointLogRepository;

    public function __construct(PointLogRepositoryInterface $pointLogRepository)
    {
        $this->pointLogRepository = $pointLogRepository;
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
            'user_id'      => 'required|numeric',
            'point_amount' => 'required|numeric|not_in:0',
            'type'         => 'required',
        ];
    }

    public function messages()
    {
        return $this->pointLogRepository->messages();
    }
}
