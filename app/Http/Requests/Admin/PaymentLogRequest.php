<?php
namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Repositories\PaymentLogRepositoryInterface;

class PaymentLogRequest extends BaseRequest
{
    /** @var \App\Repositories\PaymentLogRepositoryInterface */
    protected $paymentLogRepository;

    public function __construct(PaymentLogRepositoryInterface $paymentLogRepository)
    {
        $this->paymentLogRepository = $paymentLogRepository;
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
            'status'         => 'required',
            'paid_amount'    => 'required|numeric|min:1',
            'teacher_id'     => 'required|numeric|min:0',
            'paid_for_month' => 'required',
            'paid_at'        => 'required|date_format:Y-m-d',
        ];
    }

    public function messages()
    {
        return $this->paymentLogRepository->messages();
    }
}
