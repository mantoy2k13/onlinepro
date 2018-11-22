<?php
namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Repositories\TeacherNotificationRepositoryInterface;

class TeacherNotificationRequest extends BaseRequest
{
    /** @var \App\Repositories\TeacherNotificationRepositoryInterface */
    protected $teacherNotificationRepository;

    public function __construct(TeacherNotificationRepositoryInterface $teacherNotificationRepository)
    {
        $this->teacherNotificationRepository = $teacherNotificationRepository;
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
        return $this->teacherNotificationRepository->rules();
    }

    public function messages()
    {
        return $this->teacherNotificationRepository->messages();
    }
}
