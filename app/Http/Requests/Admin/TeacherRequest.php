<?php
namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Repositories\TeacherRepositoryInterface;

class TeacherRequest extends BaseRequest
{
    /** @var \App\Repositories\TeacherRepositoryInterface */
    protected $teacherRepository;

    public function __construct(TeacherRepositoryInterface $teacherRepository)
    {
        $this->teacherRepository = $teacherRepository;
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
            'name'                     => 'required|max:255|min:2',
            'email'                    => 'required|email',
            'year_of_birth'            => 'required|date_format:Y',
            'gender'                   => 'required|max:255|min:2',
            'living_start_date'        => 'required|before:today',
            'living_country_code'      => 'required|max:255|min:2',
            'living_city_id'           => 'required',
            'nationality_country_code' => 'required',
            'home_province_id'         => 'required',
        ];
    }

    public function messages()
    {
        return $this->teacherRepository->messages();
    }
}
