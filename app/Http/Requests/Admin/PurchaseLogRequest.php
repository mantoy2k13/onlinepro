<?php
namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Repositories\PurchaseLogRepositoryInterface;

class PurchaseLogRequest extends BaseRequest
{
    /** @var \App\Repositories\PurchaseLogRepositoryInterface */
    protected $purchaseLogRepository;

    public function __construct(PurchaseLogRepositoryInterface $purchaseLogRepository)
    {
        $this->purchaseLogRepository = $purchaseLogRepository;
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
        return $this->purchaseLogRepository->rules();
    }

    public function messages()
    {
        return $this->purchaseLogRepository->messages();
    }
}
