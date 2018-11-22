<?php
namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Repositories\EmailLogRepositoryInterface;

class EmailLogRequest extends BaseRequest
{
    /** @var \App\Repositories\EmailLogRepositoryInterface */
    protected $emailLogRepository;

    public function __construct(EmailLogRepositoryInterface $emailLogRepository)
    {
        $this->emailLogRepository = $emailLogRepository;
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
            'new_email'       => 'required|email|different:old_email',
            'old_email'       => 'required|email',
            'user_id'         => 'required',
            'status'          => 'required|boolean',
            'validation_code' => 'required',
        ];
    }

    public function messages()
    {
        return $this->emailLogRepository->messages();
    }
}
