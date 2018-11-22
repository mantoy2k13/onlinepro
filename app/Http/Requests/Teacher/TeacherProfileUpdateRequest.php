<?php
namespace App\Http\Requests\Teacher;

use App\Http\Requests\BaseRequest;
use App\Repositories\TeacherRepositoryInterface;

class TeacherProfileUpdateRequest extends BaseRequest
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
            'name'                => 'required|max:255|min:2',
            'year_of_birth'       => 'required|date_format:Y',
            'gender'              => 'required|max:255|min:2',
            'living_country_code' => 'required|max:255|min:2',
            'living_city_id'      => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required'                => trans('validation.name_required'),
            'name.min'                     => trans('validation.name_min'),
            'name.max'                     => trans('validation.name_max'),
            'year_of_birth.required'       => trans('validation.year_of_birth_required'),
            'year_of_birth.date_format'    => trans('validation.year_of_birth_date_format'),
            'gender.required'              => trans('validation.gender_required'),
            'gender.max'                   => trans('validation.gender_max'),
            'gender.min'                   => trans('validation.gender_min'),
            'living_country_code.required' => trans('validation.living_country_code_required'),
            'living_country_code.max'      => trans('validation.living_country_code_max'),
            'living_country_code.min'      => trans('validation.living_country_code_min'),
            'living_city_id.required'      => trans('validation.living_city_id_required'),
        ];
    }
}
